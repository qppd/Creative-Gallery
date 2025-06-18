<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use App\Models\User;
use App\Models\Art;
use App\Models\Category;
use App\Models\Bidding;
use App\Models\Payment;

use App\Mail\PaymentMailer;
use App\Mail\RejectMailer;
use Illuminate\Support\Facades\Mail;


class PaymentController extends Controller
{
    public function createPaymentLink()
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'amount' => 10000,
                            'description' => 'Creative Gallery Subscription',
                            'remarks' => 'paid by ' . session('name'),
                            'email' => 'sajedhm@gmail.com'
                        ]
                    ]
                ]),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_API_KEY') . ':'),
                    'content-type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            // Extract the checkout_url from the response
            $checkoutUrl = $data['data']['attributes']['checkout_url'];

            $user = User::find(Auth::id());
            $user->subscription_status = 1;
            $user->save();

            // Redirect to the checkout URL
            return redirect()->away($checkoutUrl);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function acceptOffer($id)
    {

        $bidding = Bidding::find($id);
        $bidding->status = 1;
        $bidding->save();

        $payment = new Payment();
        $payment->bidding_id = $id;
        $payment->save();

        $bidding = Bidding::select(
            'users.id AS enthusiast_id',
            'users.name AS enthusiast_name',
            'users.email',
            'art.name AS art_name',
            'biddings.offer as bidding_offer',
        )
            ->join('users', 'users.id', '=', 'biddings.enthusiast_id')
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->where('biddings.id', $id)
            ->first();

        Mail::to($bidding->email)->send(new PaymentMailer($bidding->art_name, $bidding->bidding_offer, "https://creative-gallery.online/pay/" . $id, session('name'), session('contact')));

        return redirect()->back()->with(
            'success',
            'Offer accepted! An email has been sent to the winner!'
        );

    }

    public function rejectOffer($id)
    {

        $bidding = Bidding::find($id);
        $bidding->status = 2;
        $bidding->save();

        $bidding = Bidding::select(
            'artist.id AS artist_id',
            'artist.name AS artist_name',
            'enthusiast.email AS enthusiast_email',
            'art.name AS art_name',
            'biddings.offer as bidding_offer',
        )
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('users AS enthusiast', 'enthusiast.id', '=', 'biddings.enthusiast_id')
            ->join('users AS artist', 'artist.id', '=', 'art.user_id')
            ->where('biddings.id', $id)
            ->first();

        Mail::to($bidding->enthusiast_email)->send(new RejectMailer($bidding->art_name));

        return redirect()->back()->with(
            'success',
            'Offer rejected!'
        );

    }

    public function pay($id)
    {
        $bidding = Bidding::select(
            'users.id AS enthusiast_id',
            'users.name AS enthusiast_name',
            'users.email',
            'art.id AS art_id',
            'art.name AS art_name',
            'biddings.offer as bidding_offer',
            'payments.id AS payment_id',
        )
            ->join('users', 'users.id', '=', 'biddings.enthusiast_id')
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('payments', 'payments.bidding_id', '=', 'biddings.id')
            ->where('biddings.id', $id)
            ->first();

        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'amount' => $bidding->bidding_offer * 100,
                            'description' => 'Payment for ' . $bidding->art_name,
                            'remarks' => 'paid by ' . $bidding->enthusiast_name,
                            'metadata' => [
                                'email' => 'sajedhm@gmail.com',
                            ],
                        ]
                    ]
                ]),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_API_KEY') . ':'),
                    'content-type' => 'application/json',
                ],
            ]);

            

            echo $response->getBody();

            $body = $response->getBody();
            $data = json_decode($body, true);

            // Extract the checkout_url from the response
            $checkoutUrl = $data['data']['attributes']['checkout_url'];
            $checkoutReference = $data['data']['attributes']['reference_number'];

            $art = Art::find($bidding->art_id);
            $art->status = 3;
            $art->save();

            $payment = Payment::find($bidding->payment_id);
            $payment->reference_id = $checkoutReference;
            $payment->url = $checkoutUrl;
            $payment->status = 1;
            $payment->save();

            // Redirect to the checkout URL
            return redirect()->away($checkoutUrl);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }


    }
}
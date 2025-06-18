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

use App\Mail\PaidMailer;
use App\Mail\PaymentMailer;
use App\Mail\RejectMailer;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function createPaymentLink()
    {
        $client = new Client();
        $userId = Auth::id();
        $user = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.contact',
        )
            ->where('users.id', $userId)
            ->first();

        

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'billing' => [
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => $user->contact,
                            ],
                            'send_email_receipt' => false,
                            'show_description' => true,
                            'show_line_items' => true,
                            'billing_information_fields_editable' => false,
                            'line_items' => [
                                [
                                    'currency' => 'PHP',
                                    'amount' => 24900,
                                    'description' => 'Creative Gallery Subscription',
                                    'name' => 'Creative Gallery Subscription',
                                    'quantity' => 1
                                ]
                            ],
                            'description' => 'Creative Gallery Subscription',
                            'payment_method_types' => ['gcash']
                        ]
                    ]
                ]),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_API_KEY') . ':'),
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            // Extract the checkout_url from the response
            $checkoutUrl = $data['data']['attributes']['checkout_url'];
            //$checkoutUrl = $data['data']['attributes']['reference'];

            $user = User::find(Auth::id());
            $user->subscription_status = 1;
            $user->save();

            Mail::to($user->email)->send(new PaidMailer($user->name, $user->email, $user->contact, "249.00"));
            //private $name, private $email, private $contact, private $reference, private $amount
            
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
            'users.name AS enthusiast_contact',
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

    public function rejectOffer(Request $request)
    {

        if (empty($request->reason)) {
            return redirect()->back()->withErrors([
                'message' => 'Enter the reason for declining the offer!',
            ]);
        }

        $bidding = Bidding::find($request->id);
        $bidding->status = 2;
        $bidding->reason = $request->reason;
        $bidding->save();

        $bidding = Bidding::select(
            'artist.id AS artist_id',
            'artist.name AS artist_name',
            'enthusiast.email AS enthusiast_email',
            'art.name AS art_name',
            'biddings.offer as bidding_offer',
            'biddings.reason',
        )
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('users AS enthusiast', 'enthusiast.id', '=', 'biddings.enthusiast_id')
            ->join('users AS artist', 'artist.id', '=', 'art.user_id')
            ->where('biddings.id', $request->id)
            ->first();

        Mail::to($bidding->enthusiast_email)->send(new RejectMailer($bidding->art_name, $bidding->reason));

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
            'users.contact AS enthusiast_contact',
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
            
            $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'billing' => [
                                'name' => $bidding->enthusiast_name,
                                'email' => $bidding->email,
                                'phone' => $bidding->enthusiast_contact, 
                            ],
                            'send_email_receipt' => false,
                            'show_description' => true,
                            'show_line_items' => true,
                            'line_items' => [
                                [
                                    'currency' => 'PHP',
                                    'amount' => $bidding->bidding_offer * 100,
                                    'description' => 'Payment for ' . $bidding->art_name,
                                    'name' => $bidding->art_name,
                                    'quantity' => 1
                                ]
                            ],
                            'description' => 'Payment for ' . $bidding->art_name,
                            'payment_method_types' => ['gcash']
                        ]
                    ]
                ]),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_API_KEY') . ':'),
                ],
            ]);

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

            Mail::to($bidding->email,)->send(new PaidMailer($bidding->enthusiast_name, $bidding->email, 
            $bidding->enthusiast_contact, $bidding->bidding_offer));

            // Redirect to the checkout URL
            return redirect()->away($checkoutUrl);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

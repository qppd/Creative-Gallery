<?php
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\FaceController;
use App\Http\Controllers\Administrator\CommentController;
use App\Http\Controllers\Administrator\LoginController as LoginController;

use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\AccountController;
use App\Http\Controllers\Administrator\CategoryController;
use App\Http\Controllers\Administrator\PaymentController;
use App\Http\Controllers\Administrator\BiddingController;
use App\Http\Controllers\Administrator\VerificationController;

use App\Http\Controllers\User\LoginController as SignInController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\BiddingController as BidController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\ArtController;
use App\Http\Controllers\User\OfferController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PaymentController as PayController;

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('/administrator/login');
})->name('login');
Route::post("/admin/login", [LoginController::class, 'login']);


// administrator dashboard routes
Route::get("/admin/dashboard", [DashboardController::class, 'view'])->middleware('auth');

// administrator comments routes
Route::get("/admin/dashboard/comments", [CommentController::class, 'view'])->middleware('auth');

// administrator posts routes
Route::get("/admin/dashboard/posts", [APostController::class, 'view'])->middleware('auth');


// administrator user routes
Route::get("/admin/accounts", [AccountController::class, 'view'])->middleware('auth');
Route::get("/admin/account/deactivate/{id}", [AccountController::class, 'deactivate']);
Route::get("/admin/account/activate/{id}", [AccountController::class, 'activate']);

// administrator bidding request routes
Route::get("/admin/bidding/requests", [BiddingController::class, 'requests'])->middleware('auth');
Route::get("/admin/bidding/request/approve/{id}", [BiddingController::class, 'approve'])->middleware('auth');
Route::get("/admin/bidding/request/reject/{id}", [BiddingController::class, 'reject'])->middleware('auth');

// administrator biddings routes
Route::get("/admin/biddings", [BiddingController::class, 'biddings'])->middleware('auth');

// administrator sold routes
Route::get("/admin/bidding/sold", [BiddingController::class, 'solds'])->middleware('auth');

// administrator verification routes
Route::get("/admin/verification", [VerificationController::class, 'view'])->middleware('auth');
Route::get("/admin/verification/approve/{id}", [VerificationController::class, 'approve'])->middleware('auth');
Route::get("/admin/verification/reject/{id}", [VerificationController::class, 'reject'])->middleware('auth');

// administrator category routes
Route::get("/admin/categories", [CategoryController::class, 'view'])->middleware('auth');
Route::post("/admin/category/add", [CategoryController::class, 'add']);
Route::post("/admin/category/edit", [CategoryController::class, 'edit']);
Route::get("/admin/category/delete/{id}", [CategoryController::class, 'delete']);

// administrator payment routes
Route::get("/admin/payments", [PaymentController::class, 'view'])->middleware('auth');

// administrator logout route
Route::get('/admin/logout', function () {
    if (session()->has('administrator')) {
        session()->pull('administrator');
        session()->flush();

    }
    return redirect('/admin');
});


//=========================================================================================
//=========================================================================================
//=========================================================================================


// user landing routes
Route::get("/", [ArtController::class, 'fetchArts']);
Route::get("/not-verified", [ArtController::class, 'fetchArts2']);

// user signin routes
Route::get('/signin', function () {
    return view('user/login');
})->name('login');
Route::post("/login", [SignInController::class, 'login']);

// user sign up routes
Route::get("/signup", [RegistrationController::class, 'view']);
Route::post("/signup/add", [RegistrationController::class, 'register']);

Route::get("/notifications", [NotificationController::class, 'getNotifications']);

// user home routes
Route::get("/home", [HomeController::class, 'view'])->middleware('auth');
Route::post('/home/offer', [BidController::class, 'offer']);
Route::post('/home/offers', [BidController::class, 'offers']);

// user messages routes
Route::get("/messages", [ChatController::class, 'view'])->middleware('auth');
Route::post('/message/user-info', [ChatController::class, 'getUserInfo'])->name('chat.loadUser');
Route::post('/message/user-messages', [ChatController::class, 'getUserChats'])->name('chat.loadChats');
Route::post('/message/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
Route::post('/message/get-chats', [ChatController::class, 'getChatsWithUser'])->name('chat.fetchMessages');

// user offers routes
Route::get("/offers", [OfferController::class, 'view'])->middleware('auth');
Route::get("/artworks", [OfferController::class, 'artworks'])->middleware('auth');
Route::get("/artworks/sold", [OfferController::class, 'artworksSold'])->middleware('auth');
Route::get("/artworks/available", [OfferController::class, 'artworksAvailable'])->middleware('auth');

// user artist upload art
Route::post("/artwork/add", [ArtController::class, 'store']);



// user logout route
Route::get('/logout', function () {
    if (session()->has('user')) {
        session()->pull('user');
        session()->flush();
    }
    return redirect('/signin');
});

//user payment routes
Route::get('/create-payment-link', [PayController::class, 'createPaymentLink']);
Route::get('/accept-offer/{id}', [PayController::class, 'acceptOffer']);
Route::post('/reject-offer', [PayController::class, 'rejectOffer']);

Route::get('/pay/{id}', [PayController::class, 'pay']);

Route::get('/search', [ArtController::class, 'search'])->name('search');

// Route::get('/not-verified', function () {
//     return view('user.not_verified');
// });
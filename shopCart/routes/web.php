<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Mail\OrderMail;
use App\Mail\WelecomeMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('home','home');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('login',[LoginController::class,'show'])->name('login');
Route::post('login',[LoginController::class,'login']);
Route::get('logout',[LoginController::class,'logout'])->name('logout');
Route::view('signUp','signUp')->name('signUp');
Route::post('signUp',[LoginController::class,'signUp']);

Route::prefix('admin')->middleware('AdminAuth')->group(function () {
    Route::view('center','admin.center')->name('admin.center');
    Route::view('users','admin.users')->name('admin.users');
    Route::view('news','admin.news')->name('admin.news');
    Route::view('orders','admin.orders')->name('admin.orders');
    Route::view('products','admin.products')->name('admin.products');
    Route::get('newsJson',[NewsController::class,"newsJson"])->name('newsJson');
    Route::get('newsJson/{id}',[NewsController::class,"newJson"])->name('newJson');
});

Route::prefix('user')->middleware('auth')->group(function () {
    Route::view('order','user.order')->name('user.order');
    Route::view('profile','user.profile')->name('user.profile');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


Route::apiResource('api/user',UserController::class);
Route::apiResource('news',NewsController::class);
Route::get("/hotNews",[NewsController::class,"sortByViewsOfArticle"]);
Route::apiResource('api/product',ProductController::class)->middleware('auth');

Route::get("product",[ProductController::class,"showPage"])->name('product');

Route::apiResource('api/order',OrderController::class);
Route::get('orders/{user_id}',[OrderController::class,'showFromUser']);

Route::get('/publish', function () {
    Redis::publish('test-channel', json_encode([
        'name' => 'Adam Wathan'
    ]));
});


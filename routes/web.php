<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TariffController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot'); // to show forgot password view
    Route::Post('/forgot', [AuthController::class, 'forgot_password'])->name('password.email');
    Route::Post('/reset_password', [AuthController::class, 'reset_password'])->name('password.update');
    Route::get('/Register', [AuthController::class, 'create'])->name('Registration');
    Route::post('Authorization', [AuthController::class, 'Authorization'])->name('Authorization');
    Route::resource('/auth', AuthController::class);

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

// Fallback route
Route::fallback(function () {
    // Define fallback logic here
});

// Protected routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['admin'])->group(function () {
        Route::resource('/admin', MainController::class);
        Route::get('/user', [MainController::class, 'users'])->name('user');
        Route::resource('/client', ClientController::class);
        Route::delete('/dependent/{id}', [ClientController::class, 'Dependentdestroy'])->name('dependent.destroy');
        Route::patch('/claim_request/{id}', [RequestController::class, 'Claimupdate'])->name('claim.update');
        Route::PATCH('/approval/{id}', [RequestController::class, 'update'])->name('approval');
        Route::POST('/addDx', [TariffController::class, 'dxAdd'])->name('dxAdd');
        Route::delete('/destroy_dx/{id}', [TariffController::class, 'destroy_dx'])->name('destroy_dx');
        Route::PATCH('/update_diagnosis/{id}', [TariffController::class, 'update_dx'])->name('update_dx');
        Route::GET('/edit_dx/{id}', [TariffController::class, 'edit_dx'])->name('edit_dx');
        Route::GET('/diagnosis_index', [TariffController::class, 'diagnosis_index'])->name('diagnosis_index');
    });
    Route::resource('/client', ClientController::class);
    Route::get('/UsersDashboard', [MainController::class, 'UsersDashboard'])->name('UsersDashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Client routes
    Route::get('/eligibility', [ClientController::class, 'check'])->name('client.check');
    Route::get('/view', [ClientController::class, 'ViewCheck'])->name('client.view');
    Route::post('/Dependentstore', [ClientController::class, 'Dependentstore'])->name('Dependentstore');
    Route::get('/Dependentshow/{id}', [ClientController::class, 'Dependentshow'])->name('Dependentshow');


    // Request routes
    Route::resource('/request', RequestController::class);
    // Route::get('/make/request{queue_id}', [RequestController::class, 'edit'])->name('request.send');
    Route::get('/queue', [RequestController::class, 'create'])->name('request.queue');
    Route::get('/pre-authorization', [RequestController::class, 'authorization'])->name('pre-authorization');
    Route::post('/saveRequests', [RequestController::class, 'saveRequests'])->name('saveRequests');
    Route::get('/getPrice', [RequestController::class, 'getPrice'])->name('getPrice');
    Route::get('/claims', [RequestController::class, 'claims'])->name('claims');
    Route::post('/claims', [RequestController::class, 'claimSubmit'])->name('claims.store');
    Route::get('/batch_request/{batch_id}', [RequestController::class, 'batch_request'])->name('batch_request');


    // Tariff routes
    Route::resource('/tariff', TariffController::class);


    // Search routes
    Route::get('/Search/tariff', [SearchController::class, 'tariff'])->name('search.tariff');
    Route::get('/Search/diagnosis', [SearchController::class, 'tariff_diagnosis'])->name('search.diagnosis');
    Route::get('/Search/client', [SearchController::class, 'client'])->name('search.client');
    Route::get('/Search/dependents', [SearchController::class, 'eligibility2'])->name('search.dependent');
    Route::get('/Search/principal', [SearchController::class, 'eligibility'])->name('search.principal');
    Route::get('/auth_view', [SearchController::class, 'auth_view'])->name('auth_view');
    Route::get('/encounter_view', [SearchController::class, 'encounter_view'])->name('encounter_view');
    Route::get('/queue_view', [SearchController::class, 'queue_view'])->name('queue_view');


    //queue list

    Route::post('/queue', [MainController::class, 'store'])->name('queue');
});

Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email content', function ($message) {
            $message->to('chinweokwu727@gmail.com')
                ->subject('Test Email');
        });
        return 'Mail sent successfully!';
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
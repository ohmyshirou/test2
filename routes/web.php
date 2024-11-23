<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ListAndRecordController;
use App\Http\Controllers\MyProposalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk homepage atau welcome page
Route::get('/', function () {
    return view('welcome');
});

// Route untuk login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Group route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Route untuk dashboard user biasa
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.user');
    Route::get('/my-proposal', [MyProposalController::class, 'index'])->name('my-proposal');
    Route::get('/list-record', [ListAndRecordController::class, 'index'])->name('list-record');

    // Message Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{receiver}', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/user-info/{userId}', [ChatController::class, 'fetchUserInfo']);

    // Proposal Submission Routes
    Route::get('/proposal-submission', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/proposal-submission', [ProposalController::class, 'store'])->name('proposal.store');
});

// Group route untuk admin (admin, warek, dekan, bkal)
Route::middleware(['auth', 'ensureUserHasRole'])
    ->prefix('admin')
    ->group(function () {
        // Dashboard untuk Admin
        Route::get('/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard.admin');
        Route::get('/proposal-approval', [ProposalController::class, 'proposalApproval'])->name('admin.proposal-approval');

        // Proposal Routes
        Route::prefix('proposal')->group(function () {
            Route::get('/approval', [ProposalController::class, 'proposalApproval'])->name('proposal.approval');
            Route::post('/approve/{id}', [ProposalController::class, 'approveProposal'])->name('proposal.approve');
            Route::post('/reject/{id}', [ProposalController::class, 'rejectProposal'])->name('proposal.reject');
            Route::get('/add-signature/{id}', [ProposalController::class, 'addSignature'])->name('proposal.addSignature');
            Route::get('/history/{id}', [ProposalController::class, 'viewHistory'])->name('proposal.history');
            Route::get('/approval-sheet/{id}', [ProposalController::class, 'downloadApprovalSheet'])->name('proposal.downloadApprovalSheet');
        });
    });

    Route::get('/debug', function () {
        return response()->json([
            'Auth::check' => Auth::check(),
            'Auth::id' => Auth::id(),
            'Auth::user' => Auth::user(),
        ]);
    });
    
    

// Route untuk logout
Route::middleware('auth')
    ->post('/logout', [AuthController::class, 'logout'])
    ->name('logout.submit');

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Controllers Admin
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;

// Controllers User
use App\Http\Controllers\User\SubmissionController as UserSubmissionController;

// ============================================================
// ROUTE PUBLIK
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// EMAIL VERIFICATION
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ============================================================
// DASHBOARD — redirect sesuai role setelah login
// ============================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.courses.index');
        }
        return redirect()->route('user.submissions.index');
    })->name('dashboard');
});

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Courses
    Route::resource('courses', AdminCourseController::class);

    // Assignments (nested dalam course)
    Route::resource('courses.assignments', AdminAssignmentController::class)
        ->shallow();

    // Submissions — admin hanya bisa lihat & beri nilai
    Route::get('submissions', [AdminSubmissionController::class, 'index'])
        ->name('submissions.index');
    Route::get('submissions/{submission}', [AdminSubmissionController::class, 'show'])
        ->name('submissions.show');
    Route::patch('submissions/{submission}/grade', [AdminSubmissionController::class, 'grade'])
        ->name('submissions.grade');
});

// ============================================================
// USER ROUTES
// ============================================================
Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

    // Lihat daftar tugas
    Route::get('assignments', [UserSubmissionController::class, 'index'])
        ->name('submissions.index');

    // Detail tugas + form submit
    Route::get('assignments/{assignment}', [UserSubmissionController::class, 'show'])
        ->name('submissions.show');

    // Kumpulkan tugas
    Route::post('assignments/{assignment}/submit', [UserSubmissionController::class, 'store'])
        ->name('submissions.store');

    // Edit submission (jika masih pending)
    Route::get('submissions/{submission}/edit', [UserSubmissionController::class, 'edit'])
        ->name('submissions.edit');
    Route::patch('submissions/{submission}', [UserSubmissionController::class, 'update'])
        ->name('submissions.update');

    // Hapus submission (jika masih pending)
    Route::delete('submissions/{submission}', [UserSubmissionController::class, 'destroy'])
        ->name('submissions.destroy');
});

// ============================================================
// BREEZE AUTH ROUTES (login, register, logout, forgot password)
// ============================================================
require __DIR__.'/auth.php';
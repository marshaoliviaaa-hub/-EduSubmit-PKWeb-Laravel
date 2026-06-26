<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Policies\CoursePolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\SubmissionPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class     => CoursePolicy::class,
        Assignment::class => AssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        // Rate limiter untuk login — maksimal 5 kali percobaan per menit per IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('email') . '|' . $request->ip()
            );
        });
    }
}
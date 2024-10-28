<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::view("/", "home");

Route::view("/contact", "contact");

Route::get('/jobs', function () {
    return view('jobs', [
        'jobs' => Job::all()
    ]);
});

Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    if (!$job) {
        abort(404);
    }

    return view('job', ['job' => $job]);
});

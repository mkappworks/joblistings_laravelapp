<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::view("/", "home");

Route::view("/contact", "contact");

Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(7);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    if (!$job) {
        abort(404);
    }

    return view('jobs.show', ['job' => $job]);
});

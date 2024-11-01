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

Route::post('/jobs', function () {
    // validation

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1,
    ]);

    return redirect('/jobs');
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    if (!$job) {
        abort(404);
    }

    return view('jobs.show', ['job' => $job]);
});

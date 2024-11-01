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

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1,
    ]);

    return redirect('/jobs');
});

Route::get('/jobs/{job}', function (Job $job) {
    return view('jobs.show', ['job' => $job]);
});


Route::get('/jobs/{job}/edit', function (Job $job) {
    return view('jobs.edit', [
        'job' => $job
    ]);
});

Route::patch('/jobs/{job}', function (Job $job) {
    //TODO:: authorize

    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    return redirect('/jobs/' . $job->id);
});


Route::delete('/jobs/{job}', function (Job $job) {
    //TODO:: authorize

    $job->delete();

    return redirect('/jobs');
});

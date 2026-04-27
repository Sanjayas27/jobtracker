<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('company', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->paginate(10);

        $stats = [
            'total'     => JobApplication::where('user_id', Auth::id())->count(),
            'applied'   => JobApplication::where('user_id', Auth::id())->where('status', 'applied')->count(),
            'interview' => JobApplication::where('user_id', Auth::id())->where('status', 'interview')->count(),
            'offer'     => JobApplication::where('user_id', Auth::id())->where('status', 'offer')->count(),
            'rejected'  => JobApplication::where('user_id', Auth::id())->where('status', 'rejected')->count(),
        ];

        return view('jobs.index', compact('applications', 'stats'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company'      => 'required|string|max:255',
            'role'         => 'required|string|max:255',
            'status'       => 'required|in:applied,interview,offer,rejected',
            'applied_date' => 'required|date',
            'job_url'      => 'nullable|url',
            'location'     => 'nullable|string|max:255',
            'salary'       => 'nullable|numeric',
            'notes'        => 'nullable|string',
        ]);

        JobApplication::create([
            ...$request->only(['company', 'role', 'status', 'applied_date', 'job_url', 'location', 'salary', 'notes']),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('jobs.index')->with('success', 'Application added successfully!');
    }

    public function edit(JobApplication $job)
    {
        abort_if((int)$job->user_id !== (int)Auth::id(), 403);
        return view('jobs.edit', ['jobApplication' => $job]);
    }

    public function update(Request $request, JobApplication $job)
    {
        abort_if((int)$job->user_id !== (int)Auth::id(), 403);

        $request->validate([
            'company'      => 'required|string|max:255',
            'role'         => 'required|string|max:255',
            'status'       => 'required|in:applied,interview,offer,rejected',
            'applied_date' => 'required|date',
            'job_url'      => 'nullable|url',
            'location'     => 'nullable|string|max:255',
            'salary'       => 'nullable|numeric',
            'notes'        => 'nullable|string',
        ]);

        $job->update($request->only(['company', 'role', 'status', 'applied_date', 'job_url', 'location', 'salary', 'notes']));

        return redirect()->route('jobs.index')->with('success', 'Application updated successfully!');
    }

    public function destroy(JobApplication $job)
    {
        abort_if((int)$job->user_id !== (int)Auth::id(), 403);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Application deleted.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['user', 'assignment.course'])
            ->latest()
            ->paginate(15);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        $submission->load('user', 'assignment.course');
        return view('admin.submissions.show', compact('submission'));
    }

    public function grade(Request $request, Submission $submission)
    {
        $request->validate([
            'grade'    => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'grade'    => $request->grade,
            'feedback' => $request->feedback,
            'status'   => 'graded',
        ]);

        return redirect()->route('admin.submissions.show', $submission)
            ->with('success', 'Nilai berhasil diberikan.');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['course', 'submissions' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->whereHas('course', fn($q) => $q->where('status', 'active'))
            ->latest()
            ->paginate(10);

        return view('user.submissions.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('user.submissions.show', compact('assignment', 'submission'));
    }

    public function store(StoreSubmissionRequest $request, Assignment $assignment)
    {
        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mengumpulkan tugas ini.');
        }

        if (now()->isAfter($assignment->due_date)) {
            return back()->with('error', 'Deadline tugas sudah lewat.');
        }

        $file     = $request->file('file');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('submissions', $filename, 'private');

        Submission::create([
            'assignment_id'     => $assignment->id,
            'user_id'           => auth()->id(),
            'file_path'         => $path,
            'original_filename' => $file->getClientOriginalName(),
            'notes'             => $request->notes,
        ]);

        return redirect()->route('user.submissions.show', $assignment)
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function edit(Submission $submission)
    {
        abort_if($submission->user_id !== auth()->id(), 403);
        abort_if($submission->status !== 'pending', 403, 'Tugas sudah dinilai, tidak bisa diedit.');

        return view('user.submissions.edit', compact('submission'));
    }

    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        abort_if($submission->user_id !== auth()->id(), 403);
        abort_if($submission->status !== 'pending', 403, 'Tugas sudah dinilai, tidak bisa diedit.');

        $data = ['notes' => $request->notes];

        if ($request->hasFile('file')) {
            Storage::disk('private')->delete($submission->file_path);

            $file     = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('submissions', $filename, 'private');

            $data['file_path']         = $path;
            $data['original_filename'] = $file->getClientOriginalName();
        }

        $submission->update($data);

        return redirect()->route('user.submissions.show', $submission->assignment)
            ->with('success', 'Submission berhasil diperbarui.');
    }

    public function destroy(Submission $submission)
    {
        abort_if($submission->user_id !== auth()->id(), 403);
        abort_if($submission->status !== 'pending', 403, 'Tugas sudah dinilai, tidak bisa dihapus.');

        Storage::disk('private')->delete($submission->file_path);
        $submission->delete();

        return redirect()->route('user.submissions.index')
            ->with('success', 'Submission berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Course $course)
    {
        $assignments = $course->assignments()->latest()->paginate(10);
        return view('admin.assignments.index', compact('course', 'assignments'));
    }

    public function create(Course $course)
    {
        return view('admin.assignments.create', compact('course'));
    }

    public function store(StoreAssignmentRequest $request, Course $course)
    {
        $data = [
            'course_id'   => $course->id,
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
        ];

        // File upload security
        if ($request->hasFile('attachment')) {
            $file     = $request->file('attachment');
            $filename = \Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('assignments', $filename, 'private');

            $data['attachment_path']          = $path;
            $data['attachment_original_name'] = $file->getClientOriginalName();
        }

        Assignment::create($data);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('course', 'submissions.user');
        return view('admin.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        return view('admin.assignments.edit', compact('assignment'));
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
        ];

        if ($request->hasFile('attachment')) {
            // Hapus file lama
            if ($assignment->attachment_path) {
                Storage::disk('private')->delete($assignment->attachment_path);
            }

            $file     = $request->file('attachment');
            $filename = \Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('assignments', $filename, 'private');

            $data['attachment_path']          = $path;
            $data['attachment_original_name'] = $file->getClientOriginalName();
        }

        $assignment->update($data);

        return redirect()->route('admin.assignments.show', $assignment)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->attachment_path) {
            Storage::disk('private')->delete($assignment->attachment_path);
        }

        $assignment->delete();

        return redirect()->route('admin.courses.show', $assignment->course)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
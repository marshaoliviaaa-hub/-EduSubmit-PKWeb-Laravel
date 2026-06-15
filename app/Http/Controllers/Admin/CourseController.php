<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('creator')
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        Course::create([
            'created_by'  => auth()->id(),
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        $course->load('assignments');
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|min:3|max:200',
            'description' => 'nullable|string|max:5000',
            'due_date'    => 'required|date',
            'attachment'  => 'nullable|file|mimes:pdf,docx,doc,zip|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul tugas wajib diisi.',
            'due_date.required' => 'Deadline wajib diisi.',
            'attachment.mimes' => 'File harus berformat PDF, DOCX, DOC, atau ZIP.',
            'attachment.max'   => 'Ukuran file maksimal 10MB.',
        ];
    }
}
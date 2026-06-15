<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && ! auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'notes' => 'nullable|string|max:1000',
            'file'  => 'nullable|file|mimes:pdf,docx,doc,zip|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'File harus berformat PDF, DOCX, DOC, atau ZIP.',
            'file.max'   => 'Ukuran file maksimal 10MB.',
        ];
    }
}
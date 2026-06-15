<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|min:3|max:150',
            'description' => 'nullable|string|max:2000',
            'status'      => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nama course wajib diisi.',
            'title.min'      => 'Nama course minimal 3 karakter.',
            'status.in'      => 'Status tidak valid.',
        ];
    }
}
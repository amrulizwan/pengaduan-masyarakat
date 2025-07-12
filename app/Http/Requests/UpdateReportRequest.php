<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'response_note' => 'nullable|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status value',
            'response_note.min' => 'Response note must be at least 5 characters',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCutiStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'name' => 'required|max:100|min:3',
            'jenis_cuti' => 'required|string',
            'tanggal_pengajuan' => 'date_format:Y-m-d\TH:i',
            'tanggal_mulai' => 'date_format:Y-m-d\TH:i',
            'tanggal_selesai' => 'date_format:Y-m-d\TH:i',
            'alasan' => 'required|string|max:255',
            'status' => 'required|string',
            'file' => 'nullable|mimes:pdf',
        ];
    }
}

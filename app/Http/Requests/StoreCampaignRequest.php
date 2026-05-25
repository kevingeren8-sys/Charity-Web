<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:Kesehatan,Pendidikan,Bencana Alam,Sosial'],
            'description' => ['required', 'string'],
            'target_amount' => ['required', 'decimal', 'min:1000'],
            'campaigner_fee_percentage' => ['required', 'decimal', 'min:0', 'max:10']
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title_en' => [
                'required', Rule::unique('article_translations', 'title')
                    ->where(fn (Builder $query) => $query->where('language_code', 'en'))
            ],
            'title_ar' => [
                'required', Rule::unique('article_translations', 'title')
                    ->where(fn (Builder $query) => $query->where('language_code', 'ar'))
            ],
            'title_ja' => [
                'required', Rule::unique('article_translations', 'title')
                    ->where(fn (Builder $query) => $query->where('language_code', 'ja'))
            ],
            'text_en' => 'required|min:20',
            'text_ar' => 'required|min:20',
            'text_ja' => 'required|min:20'
        ];
    }
}

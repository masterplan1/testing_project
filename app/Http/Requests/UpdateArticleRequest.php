<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareTranslationId($lang)
    {
        $translations = $this->route()->parameter('article')->translations;
        $translation = $translations->firstWhere('language_code', $lang);
        // print_r($translations);exit;
        return $translation->id;
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
                Rule::unique('article_translations', 'title')->ignore($this->prepareTranslationId('en'))
                    ->where(fn (Builder $query) => $query->where('language_code', 'en'))
            ],
            'title_ar' => [
                Rule::unique('article_translations', 'title')->ignore($this->prepareTranslationId('ar'))
                    ->where(fn (Builder $query) => $query->where('language_code', 'ar'))
            ],
            'title_ja' => [
                Rule::unique('article_translations', 'title')->ignore($this->prepareTranslationId('ja'))
                    ->where(fn (Builder $query) => $query->where('language_code', 'ja'))
            ],
            'text_en' => 'min:20',
            'text_ar' => 'min:20',
            'text_ja' => 'min:20'
        ];
    }
}

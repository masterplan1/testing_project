<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleTranslation;

class TranslationService
{
  private const LANGS = ['en', 'ar', 'ja'];

  public function make(Article $article, array $data)
  {
    foreach ($this->prepareInputData($data) as $lang => $dataByLang) {
      ArticleTranslation::updateOrCreate(
        ['article_id' => $article->id, 'language_code' => $lang],
        ['title' => $dataByLang['title'], 'text' => $dataByLang['text']]
      );
    }
  }

  private function prepareInputData(array $data): array
  {
    $result = [];
    foreach (self::LANGS as $lang) {
      $result[$lang] = ['title' => $data['title_' . $lang], 'text' => $data['text_' . $lang]];
    }
    return $result;
  }
}

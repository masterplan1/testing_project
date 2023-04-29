<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleTranslation;

class TranslationService
{
  private const LANGS = ['en', 'ar', 'ja'];

  public function make(Article $article) {
    foreach(self::LANGS as $lang){

      $translatedBody = $this->translateBody($lang, $article);
      $translatedTitle = $this->translateTitle($lang, $article);

      ArticleTranslation::updateOrCreate(
        ['article_id' => $article->id, 'language_code' => $lang], 
        ['title' => $translatedTitle, 'text' => $translatedBody]
      );
    }
  }

  private function translateBody($lang, $article){
    // some translation logic
    return fake()->text();
  }

  private function translateTitle($lang, $article){
    // some translation logic
    return fake()->name();
  }
}
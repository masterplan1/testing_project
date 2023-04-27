<?php

namespace App\Helpers;

use App\Models\Article;

class Translate
{
  public static function translate(Article $article): array {
    // translation ...
    return [
      'en' => ['title' => 'some title','text' => 'some translated EN text'],
      'ar' => ['title' => 'some title','text' => 'some translated AR text'],
      'ja' => ['title' => 'some title','text' => 'some translated JA text'],
    ];
  }
}
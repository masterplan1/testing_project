<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
  public function store(): Article
  {
    $article = Article::create([]);
    return $article;
  }

  public function update(Article $article): Article
  {
    $article->update([]);
    return $article;
  }
}

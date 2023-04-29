<?php 

namespace App\Services;

use App\Models\Article;

class ArticleService
{
  public function store(array $articleData): Article
  {
    $article = Article::create($articleData);

    return $article;
  }

  public function update(array $articleData, Article $article): Article
  {
    $article->update($articleData);
    return $article;
  }
}
<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Translate;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentLang = app()->getLocale();

        $articles = Article::query()->select([
                'articles.id AS a_id',
                'articles.created_at AS a_created_at',
                'articles.updated_at as a_updated_at',
                'at.*'
            ])
            ->join('article_translations AS at', 'article_id', '=', 'articles.id')
            ->where('at.language_code', $currentLang)
            ->orderBy('articles.created_at', 'desc')
            ->paginate();

        return $articles;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $article = Article::create([]);

        // translation process
        $trnslatedArticle = Translate::translate($article);

        foreach($trnslatedArticle as $lang => $body){
            ArticleTranslation::create([
                'article_id' => $article->id, 
                'title' => $body['title'], 
                'text' => $body['text'], 
                'language_code' => $lang
            ]);
        }
        return $article;
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return [$article, $article->translations];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        // translation process
        $trnslatedArticle = Translate::translate($article);

        $translations = $article->translations;

        foreach($translations as $translation){
            $translation->update([
                'title' => $trnslatedArticle[$translation->language_code]['title'], 
                'text' => $trnslatedArticle[$translation->language_code]['text'], 
            ]);
        }
        return $article;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }

    
}

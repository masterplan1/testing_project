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

        $articles = Article::query()->with('translations', function($query) use ($currentLang) {
            return $query->where('language_code', $currentLang);
        })->orderBy('articles.created_at', 'desc')->paginate(Article::PAGINATION_PER_PAGE);

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
    public function show(string $id)
    {
        return Article::where('id', $id)->with('translations')->get();
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
    public function destroy(string $ids)
    {
        // on frontend side should be something like this:
        // var query_string = '../api/articles/1,2,3...'
        $ids = explode(',', $ids);
        DB::table('articles')->whereIn('id', $ids)->delete(); 
        return response('');
    }

    
}

<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Translate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleTranslation;
use App\Services\ArticleService;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleService $articleService,
        private TranslationService $translationService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentLang = app()->getLocale();

        $articles = Article::query()->with('translations', function ($query) use ($currentLang) {
            return $query->where('language_code', $currentLang);
        })->orderBy('articles.created_at', 'desc')->paginate(Article::PAGINATION_PER_PAGE);

        return $articles;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        DB::beginTransaction();
        $article = $this->articleService->store();
        $this->translationService->make($article, $request->validated());
        DB::commit();

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
    public function update(UpdateArticleRequest $request, Article $article)
    {
        DB::beginTransaction();
        $this->articleService->update($article);
        $this->translationService->make($article, $request->validated());
        DB::commit();
        $article->refresh();
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

        DB::transaction(function () use ($ids) {
            DB::table('article_translations')->whereIn('article_id', $ids)->delete();
            DB::table('articles')->whereIn('id', $ids)->delete();
        });

        return response('');
    }
}

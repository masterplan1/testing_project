<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public const PAGINATION_PER_PAGE = 10;

    public function translations()
    {
        return $this->hasMany(ArticleTranslation::class);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteArticlesController extends Controller
{
    public function massDelete(Request $request){
        // 
        $articlesToDelete = $request->all('ids');
        DB::table('articles')->whereIn('id', $articlesToDelete)->delete(); 
        return response();
    }
}

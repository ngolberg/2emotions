<?php

namespace App\Http\Controllers;

use App\Word;
use App\Http\Resources\Word as WordResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        $words = Word::where('word', 'like', '%' . request()->input('searchTerm') . '%')
                    ->limit(10)
                    ->get();

        return WordResource::collection($words);
    }
}

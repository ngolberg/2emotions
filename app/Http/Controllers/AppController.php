<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Word as WordResource;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index', ['title' => $this->getTitle(), 'isAdmin' => Auth::check()?(request()->user()->isAdmin()?'true':'false'):'false']);
    }

    private function getTitle() {
        $result = 'Love or hate? | 2emotions';
        $url = \Request::getRequestUri();
        if (preg_match("(^/(word)/(\d+)$)i", $url, $matches)) {
            $word_id = $matches[2];
            try {
                $word = new WordResource(Word::find($word_id));
                $l = __('I love you!');
                $result = $word->word . ', ' . ($word->type == Word::$loveType ? __('I love you!') : __('fuck off!'));
            }
            catch (\Exception $e) {
                return $result;
            }

            return $result;
        }

        return $result;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Auth\NativeUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Word extends Model
{
    protected $guarded = [];

    public static $loveType = 0;
    public static $fuckType = 1;

    public function path()
    {
        return '/word/' . $this->id;
    }

    public function liked(Request $request)
    {
        $user = new NativeUserController($request);
        if ($user->check()) {
            $like = DB::table('likes')->where('user_id', $user->user()->id)->where('word_id', $this->id)->get();
            if (isset($like[0])) {
                return true;
            }
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

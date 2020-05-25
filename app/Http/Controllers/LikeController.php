<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
  public function store()
  {
    $this->authorize('create', Like::class);

    $like = request()->user()->likes()->create($this->validateData());

    return $like;
  }

  public function destroy(int $word_id)
  {
    $this->authorize('delete', Like::class);

    DB::table('likes')->where('user_id', Auth::id())->where('word_id', $word_id)->delete();

    return response([], Response::HTTP_NO_CONTENT);
  }

  private function validateData()
  {
    return request()->validate([
      'word_id' =>  'integer',
    ]);
  }
}

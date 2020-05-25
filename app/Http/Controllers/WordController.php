<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Http\Resources\Word as WordResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class WordController extends Controller
{
    private $perPage = 25;

    private function getList(string $sortField, int $type = null, int $user_id = null, int $page = 1)
    {
        $query = Word::query();
        if ($type !== null) {
            $query->where('type', $type);
        }
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
        if ($page > 1) {
            $query->offset($this->perPage * $page);
        }
        $query->orderBy($sortField, 'desc')->limit($this->perPage);

        return  WordResource::collection($query->get());
    }

    public function index(int $page = 1)
    {
        return $this->getList('id', null, null, $page);
    }

    public function topLaved(int $page = 1)
    {
        return $this->getList('rate', Word::$loveType, null, $page);
    }

    public function topHated(int $page = 1)
    {
        return $this->getList('rate', Word::$fuckType, null, $page);
    }

    public function myList(int $page = 1)
    {
        $this->authorize('viewOwn', Word::class);

        return $this->getList('id', null, Auth::id(), $page);
    }

    public function store()
    {
        $this->authorize('create', Word::class);

        if (filter_var(request()->input('word'), FILTER_VALIDATE_URL)) {
            $response = json_encode(["message" => "The given data was invalid.", "errors" => ["word" => ["URLs are not allowed."]]]);

            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $existingWord = DB::table('words')->where('type', request()->input('type'))
                                                ->where('word', request()->input('word'))->first();
        if (!empty($existingWord)) {
            $response = json_encode(["message" => "The given data was invalid.", "errors" => ["word" => ["Such a word already exists."]]]);

            return response($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $word = request()->user()->words()->create($this->validateData());

        return (new WordResource($word))
          ->response()
          ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Word $word)
    {

        return new WordResource($word);
    }

    public function update(Word $word)
    {
        $this->authorize('update', $word);

        $word->update($this->validateData());

        return (new WordResource($word))
          ->response()
          ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Word $word)
    {
        $this->authorize('delete', $word);

        $word->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData()
    {
        return request()->validate([
          'word' =>  'required|string|min:3|max:32',
          'type' =>  'integer'
        ]);
    }
}

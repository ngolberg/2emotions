<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NativeUserController extends Controller
{
    public $user;

    public function __construct(Request $request)
    {
        if (!empty($request->input('api_token'))) {
            $this->user = DB::table('users')->select('id', 'name', 'email')->where('api_token', $request->input('api_token'))->get();

            if (isset($this->user[0])) {
                $this->user = $this->user[0];
            }
        }

        return $this->user;
    }

    public function check()
    {
        if (isset($this->user->id)) {
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->user;
    }
}

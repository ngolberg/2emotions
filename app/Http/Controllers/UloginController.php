<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UloginController extends RegisterController
{
    public function auth(Request $request)
    {
        $data = file_get_contents('http://ulogin.ru/token.php?token=' . $request->input('token') . '&host=' . $_SERVER['HTTP_HOST']);
        $user = json_decode($data, true);

        $error = '';
        if (empty($user)) {
            $error .= 'Data was not received. ';
        }
        if (empty($user['email'])) {
            $error .= 'Email was not received. ';
        }
        if (empty($user['identity'])) {
            $error .= 'Identity was not received. ';
        }
        if (empty($user['network'])) {
            $error .= 'Network was not received. ';
        }
        if (empty($user['first_name'])) {
            $error .= 'First Name was not received. ';
        }

        if (!empty($error)) {
            $response = json_encode(["message" => $error]);

            return response($response, Response::HTTP_NOT_ACCEPTABLE);
        }

        $password = $user['identity'] . env("ULOGIN_SALT");
        $existed_users = DB::table('users')->where('identity', $user['identity'])->get();
        if (!isset($existed_users[0])) {
            User::create([
                'name' => $user['first_name'],
                'email' => $user['email'],
                'identity' => $user['identity'],
                'password' => Hash::make($password),
                'api_token' => Str::random(32),
            ]);
        }

        if (Auth::attempt(['email'=>$user['email'], 'password' => $password], true)) {
            $url = '/';
            if (isset($_COOKIE['redirect']) && filter_var($_COOKIE['redirect'], FILTER_VALIDATE_URL)) {
                $url = $_COOKIE['redirect'];
            }
            return redirect()->intended($url);
        } else {
            $response = json_encode(["message" => "The attempt to sign in has been failed."]);

            return response($response, Response::HTTP_FORBIDDEN);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\IssueTokenTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;

class RegisterController extends Controller
{
    use IssueTokenTrait;
    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:254',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:254 '
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        return $this->issueToken($request, 'password');
    }
}

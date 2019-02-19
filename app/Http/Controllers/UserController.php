<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;

class UserController extends Controller
{
    public function generateToken(Request $req) {
        $user = User::find(1);
        $token = $user->createToken('accessToken')->accessToken;
        $groups = Group::all();
        return json_encode(['token' => $token]);

    }

    public function testMasuk(Request $req) {

        return $req->user();
    }
}

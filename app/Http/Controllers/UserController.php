<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Google_Client;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function generateToken(Request $req) {
        // $user = User::find(1)->first();
        // $token = $user->createToken('accessToken')->accessToken;
        // return json_encode(['token' => $token]);
        if ($req->has('tokenGoogle')) {
            $client = new Google_Client(['client_id' => env('GOOGLE_SIGN_IN_KEY')]);  // Specify the CLIENT_ID of the app that accesses the backend
            $payload = $client->verifyIdToken($req->tokenGoogle);
            if ($payload) {
                $userid = $payload['sub'];
                $user = User::where('google_id', $userid)->first();
                if ($user) {
                    // Found
                    $token = $user->createToken('accessToken')->accessToken;
                    return json_encode([
                        'user' => $user->toArray(),
                        'token' => $token
                    ]);
                } else {
                    // Not Found 
                    $user = User::create([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $userid,
                    ]);
                    $token = $user->createToken('accessToken')->accessToken;
                    return json_encode([
                        'user' => $user->toArray(),
                        'token' => $token
                    ]);
                }
            } else {
                // Invalid ID token
                return response(json_encode([
                    'err' => ['Invalid Token: Bad Request']
                ]), 400);
            }
        } else {
            return response(json_encode([
                'err' => ['Invalid Token: Bad Request']
            ]), 400);
        }
    }

    public function testMasukAuthAPI(Request $req) {
        return $req->user();
    }

    public function logOut(Request $req) {
        $user = $req->user();
        $user->token()->revoke();
        return response(json_encode([
            'msg' => ['Log Out Success']
        ]), 200);
    }
}

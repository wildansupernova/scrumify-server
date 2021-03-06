<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;

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
                    $user['token'] = $token;
                    return json_encode([
                        'data' => $user->toArray(),
                        'statusMessage'=> "success",
                    ]);
                } else {
                    // Not Found 
                    DB::beginTransaction();
                    $user = User::create([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                        'google_id' => $userid,
                    ]);
                    $token = $user->createToken('accessToken')->accessToken;
                    DB::commit();
                    $user['token'] = $token;
                    return json_encode([
                        'data' => $user->toArray(),
                        'statusMessage'=> "success",
                    ]);
                }
            } else {
                // Invalid ID token
                return response(json_encode([
                    'data' => NULL,
                    'statusMessage'=> "error",
                ]), 400);
            }
        } else {
            return response(json_encode([
                'data' => NULL,
                'statusMessage'=> "error",            
            ]), 400);
        }
    }

    public function logOut(Request $req) {
        $user = $req->user();
        $user->token()->revoke();
        return response(json_encode([
            'data' => NULL,
            'statusMessage'=> "success",
        ]), 200);
    }

    public function getId($userEmail) {
        $user = User::where('email', $userEmail)->first();

        if ($user) {
            return response($user['id']);
        } else {
            return -1;
        }
    }

    public function getGroups($userId) {
        return response(json_encode([
            'data' => User::getGroups($userId)->toArray(),
            'statusMessage'=> "success",
        ]), 200);
    }

    public function getUserByEmail($email) {
        $user = User::where('email',$email)->first();

        if ($user) {
            $user['token'] = NULL;
            return response(json_encode([
                'statusMessage'=> "success",
                'data' => $user->toArray()
            ]),200);
        } else {
            return response(json_encode([
                'statusMessage'=> "success",
                'data' => NULL
            ]),404);           
        }
    }
}

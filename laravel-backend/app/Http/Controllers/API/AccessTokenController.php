<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessToken;
use App\Http\Requests\StoreAccessTokenRequest; 

class AccessTokenController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $accessTokens = AccessToken::where('user_id', $user->id)->get();
        return response()->json($accessTokens, 200);
    }

    public function store(StoreAccessTokenRequest $request)
    {
        $accessToken = AccessToken::create(array_merge(
            $request->validated(),
            [
                'user_id' => $request->user()->id,
                'status' => 'valid',
            ]
        ));

        return response()->json(['accessTok$accessToken' => $accessToken], 200);
    }

    public function destroy(accessToken $accessToken)
    {
        $accessToken->delete();

        return response()->json([], 200);
    }
}

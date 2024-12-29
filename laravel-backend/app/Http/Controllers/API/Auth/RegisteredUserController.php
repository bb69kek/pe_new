<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Requests\StoreUserRequest; 

class RegisteredUserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $google2fa = new Google2FA();

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create(array_merge(
            $data,
            ['totp' => $google2fa->generateSecretKey()]
        ));

        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }
    
}

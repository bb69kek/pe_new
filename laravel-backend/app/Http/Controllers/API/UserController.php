<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Endroid\QrCode\QrCode;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChangePasswordRequest; 

class UserController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();
        // Check if the current password matches
        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(
                [
                    'message' => 'Current password is incorrect',
                    'errors' => [
                        'current_password' => ['Password incorrect'],
                    ],
                ], 400);
        }

        // Update the password
        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function notifications(Request $request)
    {
        $user = auth()->user();

        $user->notifs = $request->notifs;
        $user->save();

        return response()->json(['message' => 'notifications updated.']);
    }

    public function update(UpdateUserRequest $request,$id)
    {

        $user = user::where('id', $id)->update($request->validated());
        return response()->json(['user' => $user], 201);
    }

    public function getUser() {
        return auth()->user();
    }

    public function getQRCode(): JsonResponse
    {
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $user = auth()->user();
        
        $secret = $user->totp; 
        $issuer = 'MyApp'; 
        $username = $user->email; 
    

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $issuer,
            $username,
            $secret
        );
    
        return response()->json(['qr_code' => $qrCodeUrl, 'secret' => $secret]);
    }

    public function verifyTOTP(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        $google2fa = new Google2FA();
        $user = auth()->user();
        $secret = $user->totp;

        if ($google2fa->verifyKey($secret, $request->code)) {
            if(!$user->twoFA) {
                $user->update(["twoFA" => true]);
            }
            return response()->json(['message' => 'Verification successful']);
        } else {
            return response()->json(['message' => 'Invalid code'], 422);
        }
    }

    public function disable2FA()
    {
        $user = auth()->user();
        $user->update(["twoFA" => null]);

        return 200;
    }
}

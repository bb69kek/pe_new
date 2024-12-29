<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Http\Requests\StoreWalletRequest; 

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $wallets = Wallet::where('user_id', $user->id)->get();
        return response()->json($wallets, 200);
    }

    public function store(StoreWalletRequest $request)
    {
        $wallet = Wallet::create([
            'user_id' => $request->user()->id,
            'address' => $request->address,
            'status' => 'pending',
        ]);
        return response()->json(['wallet' => $wallet], 200);
    }

    public function setDefault($wallet) {
        Wallet::query()->update(['default' => null]);
        $wallet = Wallet::where('id', $wallet)->update(['default' => 'true']);
        return response()->json(['wallet' => $wallet], 200);
    }

    public function destroy(wallet $wallet)
    {
        $wallet->delete();
        return response()->json([], 200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payout;
use App\Http\Requests\StorePayoutRequest; 

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $payouts = Payout::where('user_id', $user->id)->get();
        return response()->json($payouts, 200);
    }

    public function store(StorePayoutRequest $request)
    {
        $payout = Payout::create([
            'user_id' => $request->user()->id,
            'ammount' => $request->ammount,
            'dataUsed' => $request->dataUsed,
            'seconds' => $request->seconds,
            'wallet' => $request->wallet,
        ]);
        return response()->json(['payout' => $payout], 200);
    }

    public function destroy(payout $payout)
    {
        $payout->delete();
        return response()->json([], 200);
    }
}

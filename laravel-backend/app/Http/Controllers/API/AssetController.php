<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssetRequest; 

class AssetController extends Controller
{

    public function index()
    {
        $assets = auth()->user()->assets;
        return response()->json($assets, 200);
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create(array_merge(
            $request->validated(),
            [
                'user_id' => $request->user()->id,
                'status' => 'pending',
            ]
        ));


        return response()->json(['asset' => $asset], 200);
    }

    public function show(asset $asset)
    {
        return response()->json(['halt' => $halt], 200);
    }


    public function destroy(asset $asset)
    {
        $asset->delete();

        return response()->json([], 200);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Halt;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHaltRequest; 
use Carbon\Carbon;

class HaltController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $search = $request->input('search');
        $status = $request->input('s');
        $all = $request->boolean('all');
        $currentPage = $request->input('page', 1);
    
        // Base query
        $query = halt::where('user_id', $user->id);
    
        // Apply search filter
        if ($search) {
            $fields = [
                'name', 'method', 'slots', 'day', 'hour', 'dataSent', 'target', 
                'port', 'duration', 'status', 'mode', 'type', 'haltStart', 
                'haltEnd', 'lastDown'
            ];
    
            $query->where(function ($subQuery) use ($fields, $search) {
                foreach ($fields as $field) {
                    $subQuery->orWhere($field, 'LIKE', '%' . $search . '%');
                }
            });
        }
    
        // Apply status filter
        if ($status) {
            if ($status === 'upcoming') {
                $query->where(function ($subQuery) {
                    $subQuery->whereIn('status', ['upcoming', 'Approved', 'Pending']);
                });
            } else {
                $query->where('status', $status);
            }
        }
    
        // Fetch results
        if ($all) {
            $results = $query->get();
            return response()->json(['data' => $results]);
        }
    
        $results = $query->paginate(20, ['*'], 'page', $currentPage);
    
        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'per_page' => $results->perPage(),
            'total' => $results->total(),
            'total_pages' => $results->lastPage(),
        ]);
    }
    

    public function stop(halt $halt) {
        $now = Carbon::now();

        $halt->update(['status' => 'finished', 'haltEnd' => $now->format('h:i A, d/m/Y')]);
        return 200;
    }

    public function store(StoreHaltRequest $request)
    {

        $validatedData = $request->validated();

        $halt = Halt::create(array_merge($validatedData, [
            'user_id' => $request->user()->id,
            'status' => 'approved',
        ]));

        return response()->json(['halt' => $halt], 200);
    }

    public function show(halt $halt)
    {
        return response()->json(['halt' => $halt], 200);
    }

    public function destroy(halt $halt)
    {
        $halt->delete();
        return response()->json([], 200);
    }
}

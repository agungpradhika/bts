<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shopping;
use App\Http\Resources\ShoppingResource;

class ShoppingController extends Controller
{
    public function store(Request $request) {

        $shop = Shopping::create([
            'name' => $request->name,
         ]);
        
        return response()->json(['Shop created successfully.', new ShoppingResource($shop)]);
    }

    public function index()
    {
        return Shopping::all();
    }

    public function update(Request $request, $id) {        
        $name = $request->name;

        $shop = Shopping::find($id);

        if (is_null($shop)) {
            return response()->json('Data not found', 404); 
        }

        $shop->name = $name;
        $shop->save();

        return response()->json(['Shop updated successfully.', new ShoppingResource($shop)]);
    }

    public function show($id)
    {
        $shop = Shopping::find($id);

        if (is_null($shop)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new ShoppingResource($shop)]);
    }

    public function destroy($id) {
        $shop = Shopping::find($id);
        $shop->delete();

        return response()->json(['Data deleted successfully.', new ShoppingResource($shop)]);
    }
}

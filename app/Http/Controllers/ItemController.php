<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function manageVue()
    {
        return view('manage-vue');
    }

    public function index(Request $request)
    {
        $items = Item::latest()->paginate(10);

        $response = [
            'pagination' => [
                'total'        => $items->total(),
                'per_page'     => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'from'         => $items->firstItem(),
                'to'           => $items->lastItem()
            ],
            'data'       => $items
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required'
        ]);

        $createdItem = Item::create($request->all());

        return response()->json($createdItem);
    }

    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required'
        ]);

        $edit = $item->update($request->all());

        return response()->json($edit);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(['done']);
    }
}

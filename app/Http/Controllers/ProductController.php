<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $photo = $request->photo;
        $name = 'product_' . time() . '.' . $photo->getClientOriginalExtension();
        $request->photo->storeAs('public/upload', $name);
        $urlPhoto = URL::asset('storage/upload/' . $name);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $urlPhoto,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json([
            'product' => $product
        ], 200);
    }
}

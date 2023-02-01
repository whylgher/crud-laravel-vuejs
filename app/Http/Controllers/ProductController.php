<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

    public function show(Product $product)
    {
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function store(Request $request)
    {
        $photo = $request->photo;
        if ($photo) {
            $name = 'product_' . time() . '.' . $photo->getClientOriginalExtension();
            $request->photo->storeAs('public/upload', $name);
            $urlPhoto = 'storage/upload/' . $name;
        }

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

    public function update(
        Request $request,
        Product $product,
    ) {
        $photo = $request->photo;
        $urlPhoto = '';
        if ($photo && $photo != 'null') {
            $name = 'product_' . time() . '.' . $photo->getClientOriginalExtension();
            $request->photo->storeAs('public/upload', $name);
            $urlPhoto = 'storage/upload/' . $name;

            $old_photo = $product->photo;
            if (File::exists($old_photo)) {
                File::delete($old_photo);
            }
        } else {
            $urlPhoto = $product->photo;
        }
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $urlPhoto,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);
        return response()->json("Product updated");
    }

    public function destroy(Product $product)
    {
        $photo = $product->photo;
        if (File::exists($photo)) {
            File::delete($photo);
        };

        $product->delete();

        return response()->json("Product delete");
    }
}

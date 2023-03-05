<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Audit;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductMail;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products =  new ProductCollection(Product::all());

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $request['person'] = Auth::user()->name;

        $data['name'] = $request['name'];
        $data['price'] = $request['price'];
        $data['person'] = Auth::user()->name;
        $data['type'] = $request['type'];

        $product = Product::create($data);

        // $product = Product::create($request->validated());

        Mail::send('productMail.productMail',array('data' => $product), function($message)
        {
            $message->to(Auth::user()->email, 'John Smith')->subject('Welcome Product has been created!');
        });

        $productDetails = Product::with('audits')->where('id',$product->id)->get();

        $person = $productDetails[0]->audits[count($productDetails[0]->audits)-1];

        $data = json_decode($person, true);

        Log::info($data);

        return response()->json("Product Created");
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        $productDetails = Product::with('audits')->where('id',$product->id)->get();

        $person = $productDetails[0]->audits[count($productDetails[0]->audits)-1];

        $data = json_decode($person, true);

        Log::info($data);

        return response()->json("Product Updated");
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $productDetails = Audit::where('auditable_id',$product->id)->get();

        $person = $productDetails[count($productDetails)-1];

        $data = json_decode($person, true);

        Log::info($data);

        return response()->json("Product Deleted");
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::with(['brand','category','productImage'])->orderBy('id','desc')->get();
        // $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'vat' => 'required',
            'discount' => 'required',
            'image' => 'image',
        ]);
        try {
            $filename ='';
            if ($request->has('image')) {
                $file = $request->file('image');
                $filename = date('Ymdhis').'.'.$file->getClientOriginalExtension();            
                $file->storeAs('/uploads/product', $filename);
            }
            $product = Product::create([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'price' => $request->price,
                'vat' => $request->vat,
                'discount' => $request->discount,
                'description' => $request->description,
                'image' => $filename,
            ]);
            if ($request->has('images')) {
                foreach ($request->images as $key => $value) {
                    $file = $value;
                    $filename = date('Ymdhis').'.'.$file->getClientOriginalExtension();
                    $file->storeAs('/uploads/product',$filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'=>$filename
                    ]);
                }
                
            }
            return response()->json('product created');
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        
    }

    public function update(Request $request,$id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $filename =$product->image;
                if ($request->has('image')) {
                    $file = $request->file('image');
                    $filename = date('Ymdhis').'.'.$file->getClientOriginalExtension();            
                    $file->storeAs('/uploads/product', $filename);
                }
                $product->update([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'vat' => $request->vat,
                    'discount' => $request->discount,
                    'description' => $request->description,
                    'image' => $filename,
                ]);
                return response()->json('product updated');
            }
        } catch (\Throwable $th) {
            return response()->json($th);
        }
        
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $images = ProductImage::where('product_id',$id)->get();
            foreach ($images as $key => $value) {
                $value->delete();
            }
            $product->delete();
            return response()->json('product deleted');
        }
    }
}

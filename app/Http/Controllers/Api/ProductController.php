<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
class ProductController extends Controller
{
 public function index()
 {
 $products = Product::with('category')->get();
 return response()->json($products);
 }
public function show(Product $product)
 {
 $product->load('category');
 return response()->json($product);
 }
}

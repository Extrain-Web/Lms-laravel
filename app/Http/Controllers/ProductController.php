<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    // হোম পেজে অ্যাক্টিভ ড্রিংকস এবং সাইট সেটিংস পাঠানো
    public function home(): Response
    {
        $products = Product::where('is_active', true)->get();
        $settings = SiteSetting::first();

        return Inertia::render('Welcome', [
            'products' => $products,
            'settings' => $settings,
        ]);
    }

    // এবাউট পেজে সাইট সেটিংস পাঠানো
    public function about(): Response
    {
        $settings = SiteSetting::first();

        return Inertia::render('About', [
            'settings' => $settings,
        ]);
    }

    // আওয়ার ড্রিংকস পেজে সব ড্রিংক ও সেটিংস পাঠানো
    public function index(): Response
    {
        $products = Product::where('is_active', true)->get();
        $settings = SiteSetting::first();

        return Inertia::render('OurDrinks', [
            'products' => $products,
            'settings' => $settings,
        ]);
    }

    // প্রোডাক্ট ডিটেইলস পেজে নির্দিষ্ট প্রোডাক্ট এবং রিলেটেড প্রোডাক্ট পাঠানো
    public function show(string $slug): Response
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        if (is_string($product->ingredients)) {
            $product->ingredients = json_decode($product->ingredients, true) ?? [];
        }
        if (is_string($product->benefits)) {
            $product->benefits = json_decode($product->benefits, true) ?? [];
        }
        
        $relatedProducts = Product::where('is_active', true)->where('id', '!=', $product->id)->take(3)->get();
        $settings = SiteSetting::first();

        return Inertia::render('ProductDetails', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'settings' => $settings,
        ]);
    }
}
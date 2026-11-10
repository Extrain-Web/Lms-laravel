<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryItem::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->get();
        $categories = GalleryItem::select('category')->distinct()->pluck('category')->filter()->values();
        if ($categories->isEmpty()) {
            $categories = collect(['Computer Labs', 'Workshops & Trades', 'Campus Events', 'Graduation Ceremonies']);
        }

        return view('gallery.index', compact('items', 'categories'));
    }
}

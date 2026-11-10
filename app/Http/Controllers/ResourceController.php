<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $resources = $query->latest()->paginate(15)->withQueryString();
        $categories = ['Notices', 'Syllabus', 'Forms', 'Books', 'Question Bank'];

        return view('resources.index', compact('resources', 'categories'));
    }
}

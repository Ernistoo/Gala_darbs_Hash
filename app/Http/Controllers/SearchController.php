<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function ajax(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([
                'users' => [],
                'categories' => []
            ]);
        }

        $users = User::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'username', 'profile_photo']);

            $categories = Category::query()
            ->where('name', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'image']);

        return response()->json([
            'users' => $users,
            'categories' => $categories,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowAllCategoryController extends Controller
{
    public function __invoke(Request $request) {
        $categories = Category::all();

        return Inertia::render("Category/Index", [
            'categories' => $categories,
        ]);
    }
}

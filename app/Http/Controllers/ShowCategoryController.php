<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowCategoryController extends Controller
{
    public function __invoke(Request $request, Category $category){
        return Inertia::render("Category/Show", [
            'category' => $category,
        ]);
    }
}

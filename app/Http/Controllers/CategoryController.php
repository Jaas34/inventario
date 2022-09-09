<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Get categories list
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::query()->get(['id', 'name']);
        return $this->successResponse('Acción realizada con éxito', ['data' => $categories]);
    }
}

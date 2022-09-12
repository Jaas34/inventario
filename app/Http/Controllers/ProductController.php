<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Get a product list
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::query()->orderBy('id')->paginate(50);
        return $this->successResponse('Acción realizada con éxito', ['data' => $products]);
    }

    /**
     * Store a new Product
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validateRequest($data, Product::$rules);

        DB::transaction(function () use ($data) {
            $product = Product::query()->create($data);
            $product->categories()->attach($data['category_id']);
        });

        return $this->successResponse('Acción realizada con éxito');
    }

    /**
     * Get a existing product
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->successResponse('Acción realizada con éxito', ['data' => $product]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete product
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->successResponse('Acción realizada con éxito');
    }

    /**
     * Change availability of a product in stock
     * if the stock change to false the quantity sill be zero
     * @param Product $product
     * @return JsonResponse
     */
    public function setWithoutExistence(Product $product)
    {
        if ($product->stock == false)
            return $this->successResponse('El producto se encuentra sin inventario');

        $product->stock = !$product->stock;
        $product->quantity = 0;
        $product->save();

        return $this->successResponse('Acción realizada con éxito', ['data' => $product]);
    }

    /**
     * Set a rating to a product
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     */
    public function setRating(Product $product, Request $request)
    {
        $this->validateRequest($request->all(), [
            'rating' => 'required|numeric|min:1|max:5'
        ]);

        DB::transaction(function () use ($request, $product) {
            ProductRating::query()->create([
                'product_id' => $product->id,
                'rating' => $request->get('rating')
            ]);
        });

        return $this->successResponse('Acción realizada con éxito');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get a product list
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::query()->paginate(50);
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
        $this->validateRequest($data, [
            'sku'           => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required|numeric|min:0',
            'quantity'      => 'required|numeric|min:0',
            'stock'         => 'required',
        ]);

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

    public function destroy($id)
    {
        //
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        $stock = fake()->boolean();
        return [
            'sku'           => fake()->uuid(),
            'name'          => 'Producto '.fake()->words(2, true),
            'description'   => fake()->paragraph(),
            'price'         => fake()->numberBetween(0, 500),
            'quantity'      => $stock ? fake()->numberBetween(0, 500) : 0,
            'stock'         => $stock,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\item;
use Illuminate\Database\Eloquent\Factories\Factory;

class itemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'deskripsi' => $this->faker->name(),
            'berat' => $this->faker->numberBetween(1, 10),
            'harga' => $this->faker->numberBetween(50000, 10000000),
            'url_gambar' => $this->faker->name(),
            'id_kategori' => $this->faker->numberBetween(1, \App\Models\kategori::count()),
            'id_brand' => $this->faker->numberBetween(1, \App\Models\Brand::count()),
            'id_subkategori' => $this->faker->numberBetween(1, \App\Models\Subcategory::count()),
        ];
    }
}

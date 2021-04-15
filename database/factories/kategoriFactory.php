<?php

namespace Database\Factories;

use App\Models\kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class kategoriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = kategori::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $nama = $this->faker->name();
        return [
            'nama' => $nama,
            'url' => Str::slug($nama)
        ];
    }
}

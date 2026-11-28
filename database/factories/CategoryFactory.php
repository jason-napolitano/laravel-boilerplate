<?php

namespace Database\Factories {

    use App\Models\Category;
    use Illuminate\Database;

    class CategoryFactory extends Database\Eloquent\Factories\Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'name' => fake()->categoryName(),
            ];
        }
    }
}

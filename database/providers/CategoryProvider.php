<?php

namespace Database\Providers {

    use Faker\Provider\Base;

    class CategoryProvider extends Base
    {
        protected static array $categories = [
            'Electronics',
            'Computers & Laptops',
            'Mobile Phones',
            'Audio & Headphones',
            'Cameras & Photography',
            'Home & Garden',
            'Furniture',
            'Kitchen & Dining',
            'Home Decor',
            'Lighting',
            'Clothing',
            'Men\'s Fashion',
            'Women\'s Fashion',
            'Shoes & Footwear',
            'Accessories',
            'Jewelry & Watches',
            'Beauty & Personal Care',
            'Skincare',
            'Hair Care',
            'Health & Wellness',
            'Sports & Outdoors',
            'Fitness Equipment',
            'Camping & Hiking',
            'Cycling',
            'Automotive',
            'Car Accessories',
            'Tools & Hardware',
            'Building Materials',
            'Books & Literature',
            'Movies & Entertainment',
            'Music & Instruments',
            'Video Games',
            'Toys & Games',
            'Baby & Kids',
            'Pet Supplies',
            'Food & Beverages',
            'Coffee & Tea',
            'Snacks & Confectionery',
            'Office Supplies',
            'Art & Crafts',
            'Hobbies & Collectibles',
            'Travel & Luggage',
            'Outdoor Living',
            'Gardening Supplies',
            'Cleaning Supplies',
            'Storage & Organization',
            'Smart Home',
            'Software & Applications',
            'Industrial Equipment',
            'Business & Professional',
        ];

        public function categoryName(): string
        {
            return static::randomElement(static::$categories);
        }
    }
}

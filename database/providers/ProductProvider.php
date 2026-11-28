<?php

namespace Database\Providers {

    use Faker\Provider\Base;

    class ProductProvider extends Base
    {
        protected static array $products = [
            'Wireless Bluetooth Headphones',
            'Portable Bluetooth Speaker',
            'Smart LED Light Bulb',
            'Wireless Charging Pad',
            'USB-C Fast Charging Cable',
            'Mechanical Gaming Keyboard',
            'Wireless Optical Mouse',
            '27-Inch 4K Monitor',
            'External SSD 1TB',
            'Portable Power Bank',
            'Stainless Steel Water Bottle',
            'Insulated Travel Mug',
            'Ceramic Coffee Mug',
            'Nonstick Frying Pan',
            'Stainless Steel Cookware Set',
            'Digital Air Fryer',
            'Programmable Coffee Maker',
            'Cordless Vacuum Cleaner',
            'Air Purifier',
            'LED Desk Lamp',
            'Ergonomic Office Chair',
            'Adjustable Standing Desk',
            'Memory Foam Pillow',
            'Queen Size Comforter Set',
            'Cotton Bath Towel Set',
            'Leather Wallet',
            'Canvas Messenger Bag',
            'Classic Denim Jeans',
            'Cotton Crew Neck T-Shirt',
            'Lightweight Hooded Sweatshirt',
            'Waterproof Running Jacket',
            'Men\'s Running Shoes',
            'Women\'s Athletic Sneakers',
            'Stainless Steel Wristwatch',
            'Polarized Sunglasses',
            'Leather Crossbody Bag',
            'Adjustable Dumbbell Set',
            'Resistance Band Set',
            'Yoga Exercise Mat',
            'Insulated Camping Tent',
            'Portable Camping Lantern',
            'Stainless Steel Pocket Knife',
            'Cordless Power Drill',
            'Professional Socket Wrench Set',
            'Automotive LED Headlight Bulbs',
            'Portable Tire Inflator',
            'Car Phone Mount',
            'Synthetic Motor Oil 5W-30',
            'Automatic Pet Feeder',
            'Interactive Cat Toy',
        ];

        public function productName(): string
        {
            return static::randomElement(static::$products);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Hozmi Cola',
                'slug' => 'hozmi-cola',
                'tagline' => 'Natural Digestive Botanical Soda',
                'price' => 'Tk 10',
                'net_volume' => '200ml',
                'image' => '/images/hozmi-cola.jpeg',
                'short_description' => 'Crafted with roasted cumin, rock salt, ginger root, and traditional gut-friendly herbs. Relieves bloating and acidity after heavy meals instantly.',
                'category' => 'digestive',
                'ingredients' => [
                    ['name' => 'Roasted Cumin', 'desc' => 'Stimulates digestion & relieves bloating'],
                    ['name' => 'Ginger Root', 'desc' => 'Natural metabolism & gut soother'],
                    ['name' => 'Black Salt (Bit Lobon)', 'desc' => 'Essential minerals & tangy digestive punch'],
                    ['name' => 'Ajwain Extracts', 'desc' => 'Instant gastric & acidity relief'],
                ],
                'benefits' => [
                    'Accelerates gut digestion after heavy or oily meals',
                    'Prevents post-meal bloating and stomach heaviness',
                    '100% chemical-free natural botanical refreshment',
                    'Restores essential electrolytes naturally',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Pudina Drink',
                'slug' => 'pudina-drink',
                'tagline' => 'Cool Mint & Raw Mango Summer Tonic',
                'price' => 'Tk 10',
                'net_volume' => '200ml',
                'image' => '/images/pudina-drink.jpeg',
                'short_description' => 'Crushed garden mint and raw mango electrolytes blended for intense summer heat relief, hydration, and long-lasting freshness.',
                'category' => 'refreshing',
                'ingredients' => [
                    ['name' => 'Fresh Mint Leaves', 'desc' => 'Cooling menthol for natural refreshment'],
                    ['name' => 'Raw Green Mango', 'desc' => 'Rich in Vitamin C and electrolytes'],
                    ['name' => 'Rock Salt', 'desc' => 'Restores electrolyte balance in heat'],
                    ['name' => 'Lemon Zest', 'desc' => 'Bright citrus flavor and daily vitality'],
                ],
                'benefits' => [
                    'Provides instant cooling relief during intense summer heat',
                    'Hydrates body with natural fruit-based electrolytes',
                    'Freshens breath and soothes throat naturally',
                    'Zero artificial food colors or synthetic syrups',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Citrus Boost',
                'slug' => 'citrus-boost',
                'tagline' => 'High-Potency Daily Immunity Tonic',
                'price' => 'Tk 10',
                'net_volume' => '200ml',
                'image' => '/images/tetul-drinks.jpg',
                'short_description' => 'A powerhouse Vitamin C citrus blend made from fresh lemons, amla, and organic ginger designed for active daily immunity.',
                'category' => 'immunity',
                'ingredients' => [
                    ['name' => 'Fresh Lemon Juice', 'desc' => 'Pure Vitamin C & instant alkalinity'],
                    ['name' => 'Amla (Gooseberry)', 'desc' => 'Ancient superfood for natural immunity'],
                    ['name' => 'Green Ginger', 'desc' => 'Anti-inflammatory & throat soother'],
                    ['name' => 'Organic Honey Extract', 'desc' => 'Smooth natural sweetness and energy'],
                ],
                'benefits' => [
                    'Strengthens daily immune system with natural Vitamin C',
                    'Natural detox drink for everyday energy and freshness',
                    'Soothes morning lethargy and keeps body active',
                    'Contains no refined white sugar or preservatives',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Green Detox',
                'slug' => 'green-detox',
                'tagline' => 'Cleanse and revitalize your body with the power of greens',
                'price' => 'Tk 10',
                'net_volume' => '200ml',
                'image' => '/images/lemon-drinks.jpg',
                'short_description' => 'This unique green drink is made with a selection of natural green leaves and vegetables, specifically blended to help clean and revitalize your body.',
                'category' => 'refreshing',
                'ingredients' => [
                    ['name' => 'Spinach Extract', 'desc' => 'Rich in vitamins and minerals'],
                    ['name' => 'Cucumber Juice', 'desc' => 'Hydrating and promotes digestion'],
                    ['name' => 'Green Apple Juice', 'desc' => 'Adds a natural sweetness and tartness'],
                    ['name' => 'Mint Leaves', 'desc' => 'For a refreshing finish'],
                ],
                'benefits' => [
                    'Supports the body\'s natural detoxification process.',
                    'Packed with vitamins and minerals for energy and vitality.',
                    'Promotes healthy digestion.',
                    'A healthy and delicious way to get your daily green intake.',
                ],
                'is_active' => true,
            ],
        ];

        Product::truncate(); // আগের ভুল ডাটা মুছে ফ্রেশ ডাটা বসাবে

        foreach ($products as $item) {
            Product::create($item);
        }
    }
}
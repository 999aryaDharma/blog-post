<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;

class CategoryPost extends ChartWidget
{
    protected static ?string $heading = 'Category Post Chart';

    protected function getData(): array
    {
        // Ambil data jumlah post per kategori
        $data = Post::selectRaw('categories.name as category_name, count(posts.id) as aggregate')
            ->join('category_post', 'category_post.post_id', '=', 'posts.id')
            ->join('categories', 'categories.id', '=', 'category_post.category_id')
            ->groupBy('categories.name')
            ->get()
            ->mapWithKeys(fn ($category) => [
                $category->category_name => $category->aggregate,
            ])
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Posts per category',
                    'data' => array_values($data), // Ambil nilai hitungan per kategori
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', 
                        '#FF9F40', '#FFCD56', '#C9CBCF', '#F7464A', '#46BFBD'
                    ], // Warna opsional untuk tiap kategori
                ],
            ],
            'labels' => array_keys($data), // Nama kategori
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}

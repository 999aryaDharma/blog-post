<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class PostsPerMonth extends ChartWidget
{
    protected static ?string $heading = 'Post PerMonth Chart';


    protected function getData(): array
    {
       $data = Trend::model(Post::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->dateColumn('created_at')
        ->count();
 
        return [
        'datasets' => [
            [
                'label' => 'Blog posts',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

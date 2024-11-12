<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PostStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Posts', Post::count()),
        ];
    }
}

<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
// use App\Filament\Resources\PostResource\Widgets\PostsPerMonth;

class ListPosts extends ListRecords
{
    // protected function getFooterWidgets(): array {
    //     return [
    //         PostsPerMonth::class,
    //     ];
    // }
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->successRedirectUrl('/admin/posts'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(), // Tambahkan label yang jelas
            'this Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subWeek()))
                ->badge(Post::query()->where('created_at', '>=', now()->subWeek())->count()),
            'this month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year))
                ->badge(Post::query()
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count()), // Hanya entri bulan ini
        ];
    }
}

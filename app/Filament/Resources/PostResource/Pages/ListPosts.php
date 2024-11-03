<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(), // Tambahkan label yang jelas
            'this Week' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subWeek())
            ),
            'this month' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)), // Hanya entri bulan ini
        ];
    }
}

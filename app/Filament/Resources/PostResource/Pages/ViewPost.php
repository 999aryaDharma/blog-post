<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Actions\NextAction;
use App\Filament\Resources\Actions\PreviousAction;
use App\Filament\Resources\Pages\Concerns\CanPaginateViewRecord;

class ViewPost extends ViewRecord
{   
    use CanPaginateViewRecord;
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            PreviousAction::make(),
            NextAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()->maxLength(150)
                    ->live(debounce: 1000)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Generate slug automatically based on title if slug is empty
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')->required()->unique()->maxLength(150),
                Select::make('color')
                    ->required()
                    ->options([
                        'red' => 'Red',
                        'green' => 'Green',
                        'blue' => 'Blue',
                        'yellow' => 'Yellow',
                        'pink' => 'Pink',
                        'gray' => 'Gray',
                        'indigo' => 'Indigo',
                        'purple' => 'Purple',
                        'orange' => 'Orange',
                        'teal' => 'Teal',
                        'slate' => 'Slate',
                        'lime' => 'Lime',
                        'fuchsia' => 'Fuchsia',
                        'emerald' => 'Emerald',
                        'amber' => 'Amber',
                        'cyan' => 'Cyan',
                        'sky' => 'Sky',
                        'violet' => 'Violet',
                        'rose' => 'Rose',
                    ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable(),
                    TextColumn::make('posts_count')->sortable()
                        ->counts('posts') // Menghitung jumlah post yang memiliki kategori ini
                        ->label('Posts Count'),
                TextColumn::make('slug')->sortable(),
                TextColumn::make('color')
            ])
            ->filters([
                //
            ])
            ->actions([
                // CreateAction::make()
                //     ->successRedirectUrl('/admin/categories'),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

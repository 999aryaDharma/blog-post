<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use App\Http\Controllers\PostController;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Resources\Components\Tab;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Posts';
    protected static ?string $slug = 'posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('author_id')
                ->relationship('author', 'name')
                ->required()
                ->preload()
                ->default(auth()->id()), // Mengatur nilai default ke ID pengguna yang sedang login
                // ->hidden(), // Jika Anda ingin menyembunyikan dropdown agar tidak dapat diubah

                TextInput::make('title')
                    ->required()->maxLength(150)
                    ->live(debounce: 1000)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Generate slug automatically based on title if slug is empty
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')->required()->maxLength(150)->unique(),
                TextInput::make('excerpt')->required()->maxLength(200),
                FileUpload::make('thumbnail')->image()->disk('public')->directory('images/thumbnails')->required()->columnSpanFull(),
                RichEditor::make('body')->required()->fileAttachmentsDirectory('images/content')->columnSpanFull(),
                BelongsToManyMultiSelect::make('categories')->relationship('categories', 'name')->preload(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tambahkan kolom untuk aksi edit di bagian depan
                ImageColumn::make('thumbnail')->label('Thumbnail'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('categories')
                    ->label('Categories')
                    ->getStateUsing(function (Post $record) {
                        return $record->categories->pluck('name')->implode(', ');
                    })
                    ->sortable(),
                TextColumn::make('author.name')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('author_id')->relationship('author', 'name'),
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    

   public static function store(array $data): void
    {
        $controller = new PostController();
        $request = new \Illuminate\Http\Request($data); // Buat request baru dengan data yang diinput
        $controller->store($request); // Panggil method store di controller Anda
    }
}

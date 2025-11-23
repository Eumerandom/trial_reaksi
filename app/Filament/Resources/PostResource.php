<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1)
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $set('slug', \Illuminate\Support\Str::slug($state));
                                    })
                                    ->live(true),
                                Forms\Components\Hidden::make('slug')
                                    ->dehydrated(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'unpublished' => 'Unpublished',
                                    ])
                                    ->required()
                                    ->default('draft')
                                    ->columnSpan(1),
                                FileUpload::make('thumbnail')
                                    ->columnSpan(2)
                                    ->image()
                                    ->disk('public')
                                    ->directory('thumbnail_berita')
                                    ->preserveFilenames(),
                                MarkdownEditor::make('content')
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\Hidden::make('author')
                                    ->default(fn () => Auth::id()),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $livewire) {
                        $perPage = (int) $livewire->getTableRecordsPerPage();
                        $page = (int) $livewire->getTablePage();
                        $index = $livewire->getTableRecords()->search($record) + 1;

                        return ($page - 1) * $perPage + $index;
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('content')
                //     ->limit(30),
                Tables\Columns\TextColumn::make('authorUser.name') // diambil berdasarkan relasi di model Post
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn ($state) => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'unpublished' => 'warning',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
    public static function convertThumbnailToWebp(?string $path): ?string
    {
        if (blank($path)) {
            return $path;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path) || Str::endsWith(strtolower($path), '.webp')) {
            return $path;
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $webpPath = $extension
            ? Str::of($path)->replaceLast('.'.$extension, '.webp')->toString()
            : $path.'.webp';

        $imageDriver = config('media-library.image_driver', 'gd');

        Image::useImageDriver($imageDriver)
            ->loadFile($disk->path($path))
            ->format('webp')
            ->quality(85)
            ->save($disk->path($webpPath));

        $disk->delete($path);

        return $webpPath;
    }
}

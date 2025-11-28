<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
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

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'content', 'authorUser.name'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Penulis' => $record->authorUser?->name,
            'Dibuat' => $record->created_at?->format('d M Y'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['authorUser']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1)
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->live(true),
                                Hidden::make('slug')
                                    ->dehydrated(),
                                Select::make('status')
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
                                Hidden::make('author')
                                    ->default(fn () => Auth::id()),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $livewire) {
                        $perPage = (int) $livewire->getTableRecordsPerPage();
                        $page = (int) $livewire->getTablePage();
                        $index = $livewire->getTableRecords()->search($record) + 1;

                        return ($page - 1) * $perPage + $index;
                    }),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('content')
                //     ->limit(30),
                TextColumn::make('authorUser.name') // diambil berdasarkan relasi di model Post
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
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

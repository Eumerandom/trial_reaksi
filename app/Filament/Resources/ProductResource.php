<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
use App\Support\StatusLevel;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'description', 'company.name', 'company.symbol', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Perusahaan' => $record->company?->name,
            'Kategori' => $record->category?->name,
            'Status' => StatusLevel::label($record->status),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['company', 'category']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General Information')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (callable $set, $state) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->disabled()
                                    ->required(),
                                TextInput::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('source')
                                    ->url()
                                    ->required(),
                            ]),

                        Tab::make('Association')
                            ->schema([
                                Select::make('status')
                                    ->label('Status Boikot')
                                    ->required()
                                    ->options(StatusLevel::options())
                                    ->default(StatusLevel::DIRECT_SUPPORT),
                                Select::make('company_id')
                                    ->relationship('company', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('categories_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload(),
                                Toggle::make('local_product')
                                    ->label('Local Product')
                                    ->default(false),
                            ]),

                        Tab::make('Media')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('product_images')
                                    ->label('Upload Image (tersimpan di storage)')
                                    ->collection('product_images')
                                    ->image()
                                    ->disk('public')
                                    ->imageEditor()
                                    ->maxSize(5120)
                                    ->columnSpanFull(),
                                TextInput::make('image')
                                    ->label('External Image URL (opsional)')
                                    ->helperText('Gunakan jika gambar tersedia di CDN atau sumber lain.')
                                    ->url()
                                    ->columnSpanFull(),
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

                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('company.name')->sortable()->searchable(),
                TextColumn::make('category.name')->sortable()->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => StatusLevel::label($state))
                    ->color(fn (?string $state): string => StatusLevel::filamentColor($state)),

                IconColumn::make('local_product')->boolean(),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->square()
                    ->defaultImageUrl('https://placehold.co/200x200'),
                TextColumn::make('updated_at')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(StatusLevel::options()),
                SelectFilter::make('company')->relationship('company', 'name'),
                SelectFilter::make('category')->relationship('category', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                ExportBulkAction::make()
                    ->exporter(ProductExporter::class)
                    ->label('Export Terpilih'),
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}

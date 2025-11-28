<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProductExporter;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'description', 'company.name', 'company.symbol', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Perusahaan' => $record->company?->name,
            'Kategori' => $record->category?->name,
            'Status' => $record->status === 'affiliated' ? 'Afiliasi' : 'Tidak Afiliasi',
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
                                    ->required()
                                    ->options([
                                        'affiliated' => 'Affiliated',
                                        'unaffiliated' => 'Unaffiliated',
                                    ])
                                    ->default('unaffiliated'),
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
                                FileUpload::make('image')
                                    ->label('Upload Image (opsional, atau isi URL di bawah)')
                                    ->image()
                                    ->directory('product_images')
                                    ->disk('public')
                                    ->preserveFilenames(),
                                TextInput::make('image')
                                    ->label('CDN Image URL (opsional, atau upload file di atas)')
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
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'affiliated' => 'danger',
                        'unaffiliated' => 'success',
                        default => 'danger',
                    }),

                IconColumn::make('local_product')->boolean(),
                ImageColumn::make('image')->square(),
                TextColumn::make('updated_at')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'affiliated' => 'Affiliated',
                    'unaffiliated' => 'Unaffiliated',
                ]),
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

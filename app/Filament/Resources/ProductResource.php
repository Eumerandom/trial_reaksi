<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Components\Tabs\Tab::make('General Information')
                            ->schema([
                                Components\TextInput::make('name')
                                    ->required()
                                    ->live(onBlur:true)
                                    ->afterStateUpdated(fn (callable $set, $state) => $set('slug', Str::slug($state))),
                                Components\TextInput::make('slug')
                                    ->disabled()
                                    ->required(),
                                Components\TextInput::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Components\TextInput::make('source')
                                    ->url()
                                    ->required(),
                            ]),

                        Components\Tabs\Tab::make('Association')
                            ->schema([
                                Components\Select::make('status')
                                    ->required()
                                    ->options([
                                        'affiliated' => 'Affiliated',
                                        'unaffiliated' => 'Unaffiliated'
                                    ])
                                    ->default('unaffiliated'),
                                Components\Select::make('company_id')
                                    ->relationship('company', 'name')
                                    ->required(),
                                Components\Select::make('categories_id')
                                    ->relationship('category', 'name')
                                    ->required(),
                                Components\Toggle::make('local_product')
                                    ->label('Local Product')
                                    ->default(false),
                            ]),

                        Components\Tabs\Tab::make('Media')
                            ->schema([
                                Components\FileUpload::make('image')
                                    ->required()
                                    ->image()
                                    ->directory('product_images')
                                    ->disk('public')
                                    ->preserveFilenames(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $livewire) {
                        $perPage = $livewire->getTableRecordsPerPage();
                        $page = $livewire->getTablePage();
                        $index = $livewire->getTableRecords()->search($record) + 1;
                        return ($page - 1) * $perPage + $index;
                    }),
                Columns\TextColumn::make('name')->sortable()->searchable(),
                Columns\TextColumn::make('company.name')->sortable()->searchable(),
                Columns\TextColumn::make('category.name')->sortable()->searchable(),

                Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'affiliated' => 'danger',
                        'unaffiliated' => 'success',
                        default => 'danger',
                    }),

                Columns\IconColumn::make('local_product')->boolean(),
                Columns\ImageColumn::make('image')->square(),
                Columns\TextColumn::make('updated_at')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'affiliated' => 'Affiliated',
                    'unaffiliated' => 'Unaffiliated'
                ]),
                SelectFilter::make('company')->relationship('company', 'name'),
                SelectFilter::make('category')->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

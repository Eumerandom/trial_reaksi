<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Category')
                            ->afterStateUpdated(function (callable $set, $state) {
                                // afterStateUpdated -> callback yang dijalankan setelah nilai state pada field diperbarui oleh pengguna
                                // function callable $state, $status
                                // -> $set (setter): mengubah atau mengisi field lain (slug) dalam form berdasarkan input name (tergantung $set yang diatur)
                                // -> $state: nilai terkini dari input field
                                $set('slug', \Illuminate\Support\Str::slug($state));
                                // set ini yang menjadi acuan nilai pada $state hendak diapakan
                                // \Illuminate\Support\Str::slug($state) -> mengubah nilai name menjadi slug
                            })
                            ->live(true),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->unique()
                            ->dehydrated(), // nonaktifkan agar slug tidak dapat diubah secara manual, dia bakal keisi otomatis kok
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            CategoryResource\RelationManagers\ProductsRelationManager::class,
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

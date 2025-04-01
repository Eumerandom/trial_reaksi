<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
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
                // ini aku ambil dari kode thithis, hehe
                // id menjadi nomor urut berdasarkan id terkecil hingga terbesar, nggak bolong juga semisal 1 ke 3 kalo 2 dihapus
                // ini sekadar di table filamentnya, pada database tetap sesuai dengan id yang tersimpan dan terhapus
                Tables\Columns\TextColumn::make('id')
                    ->label('No') // Ini kayak fieldnya, untuk memudahkan pengguna mengidentifikasi data
                    ->getStateUsing(fn($record) => Category::orderBy('id')->pluck('id')
                    ->search($record->id) + 1),
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

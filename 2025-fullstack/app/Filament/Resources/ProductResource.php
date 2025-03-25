<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Components\Card::make() // membuat kartu untuk Order Information
                // ->schema([

                Components\Section::make('Association')
                    ->schema([
                        Components\Grid::make(2)
                            ->schema([
                                Components\Select::make('status_id') // menghasilkan dropdown untuk memilih data berdasarkan FK status_id
                                    ->required()
                                    ->relationship('status', 'name'), // mengambil field name dari tabel status 
                                Components\Select::make('categories_id') // menghasilkan dropdown untuk memilih data berdasarkan FK categories_id
                                    ->relationship('category', 'name')
                                    ->required(),
                                Components\DatePicker::make('updated_at')
                                    ->required(),
                                Components\Toggle::make('local_product')
                                    ->required()
                                    ->label('Local Product')
                                    ->default(false),
                            ]),
                    ]),

                Components\Section::make('Product Information')
                    ->schema([
                        Components\Grid::make(3)
                            ->schema([
                                Components\TextInput::make('name')
                                    ->required()
                                    ->columnSpan(2)
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        // afterStateUpdated -> callback yang dijalankan setelah nilai state pada field diperbarui oleh pengguna
                                        // function callable $state, $status
                                        // -> $set (setter): mengubah atau mengisi field lain (slug) dalam form berdasarkan input name (tergantung $set yang diatur)
                                        // -> $state: nilai terkini dari input field
                                        $set('slug', \Illuminate\Support\Str::slug($state));
                                        // set ini yang menjadi acuan nilai pada $state hendak diapakan
                                        // \Illuminate\Support\Str::slug($state) -> mengubah nilai name menjadi slug
                                    })
                                    ->live(true), // biar dia kalo lagi ngetik nggak kereload" terus nungguin slugnya
                                Components\TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->dehydrated()
                                    ->columnSpan(1), // nonaktifkan agar slug tidak dapat diubah secara manual, dia bakal keisi otomatis kok,
                            ])->columns(3),

                        Components\TextInput::make('description')
                            ->label('Company')
                            ->required(),
                        Components\TextInput::make('source')
                            ->required()
                            ->label('Link')
                            // ->placeholder('Link for Button')
                            ->url(), // memastikan input berupa URL
                        Components\FileUpload::make('image')
                            ->required()
                            ->image()
                            ->directory('product_image'),
                        // folder penyimpanan di storage/app/public/[product_image]
                    ]),
                // ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ini aku ambil dari kode thithis, hehe
                // id menjadi nomor urut berdasarkan id terkecil hingga terbesar, nggak bolong juga semisal 1 ke 3 kalo 2 dihapus
                // ini sekadar di table filamentnya, pada database tetap sesuai dengan id yang tersimpan dan terhapus
                Columns\TextColumn::make('id')
                    ->label('No') // Ini kayak fieldnya, untuk memudahkan pengguna mengidentifikasi data
                    ->getStateUsing(fn($record) => Product::orderBy('id')->pluck('id')
                        ->search($record->id) + 1),
                Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('status.name')
                    // ->getStateUsing(fn ($record) => "{$record->status->name}")
                    // untuk menampiklan data yang  tidak ada di database secara langsung, tetapi berasal dari relasi  
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                // Columns\TextColumn::make('category')
                //     ->getStateUsing(fn ($record) => "{$record->category->name}")
                //     // untuk menampiklan data yang  tidak ada di database secara langsung, tetapi berasal dari relasi
                //     ->sortable()
                //     ->searchable(),
                Columns\IconColumn::make('local_product')
                    ->boolean(),
                Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->relationship('status', 'name'),

                SelectFilter::make('category')
                    ->relationship('category', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

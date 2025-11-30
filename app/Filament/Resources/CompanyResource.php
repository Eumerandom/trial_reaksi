<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages\CreateCompany;
use App\Filament\Resources\CompanyResource\Pages\EditCompany;
use App\Filament\Resources\CompanyResource\Pages\ListCompanies;
use App\Filament\Resources\CompanyResource\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\ParentRelationManager;
use App\Filament\Resources\CompanyResource\RelationManagers\ShareholdingsRelationManager;
use App\Models\Company;
use App\Support\StatusLevel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'symbol'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Simbol' => $record->symbol,
            'Jumlah Produk' => $record->products()->count(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Company Details')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(true)
                                            ->afterStateUpdated(fn (callable $set, $state) => $set('slug', Str::slug($state))),

                                        Hidden::make('slug'),

                                        TextInput::make('symbol')
                                            ->label('Ticker Symbol')
                                            ->maxLength(20)
                                            ->helperText('Contoh: MSFT')
                                            ->formatStateUsing(fn ($state) => is_string($state) ? strtoupper($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? strtoupper($state) : $state),

                                        Select::make('parent_id')
                                            ->relationship('parent', 'name')
                                            ->placeholder('Induk Perusahaan'),

                                        Select::make('status')
                                            ->label('Status Boikot')
                                            ->options(StatusLevel::options())
                                            ->default(StatusLevel::DIRECT_SUPPORT)
                                            ->required(),
                                    ]),
                            ]),

                        Tab::make('Media')
                            ->schema([
                                FileUpload::make('logo')
                                    ->label('Company Logo')
                                    ->image()
                                    ->directory('comapny_logos')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->getStateUsing(function ($record, $livewire) {
                        $perPage = (int) $livewire->getTableRecordsPerPage();
                        $page = (int) $livewire->getTablePage();
                        $index = $livewire->getTableRecords()->search($record) + 1;

                        return ($page - 1) * $perPage + $index;
                    }),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('symbol')
                    ->label('Symbol')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('parent.name')
                    ->sortable()
                    ->label('Induk Perusahaan'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => StatusLevel::label($state))
                    ->color(fn (?string $state): string => StatusLevel::filamentColor($state)),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(StatusLevel::options()),
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
            ParentRelationManager::class,
            ChildrenRelationManager::class,
            ShareholdingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'edit' => EditCompany::route('/{record}/edit'),
        ];
    }
}

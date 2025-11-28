<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Throwable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use App\Filament\Resources\ShareholderEntityResource\Pages\ListShareholderEntities;
use App\Filament\Resources\ShareholderEntityResource\Pages\CreateShareholderEntity;
use App\Filament\Resources\ShareholderEntityResource\Pages\EditShareholderEntity;
use App\Filament\Resources\ShareholderEntityResource\Pages;
use App\Filament\Resources\ShareholderEntityResource\RelationManagers\PositionsRelationManager;
use App\Models\ShareholderEntity;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ShareholderEntityResource extends Resource
{
    protected static ?string $model = ShareholderEntity::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Shareholder';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Entity Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'institution' => 'Institution',
                                'fund' => 'Fund',
                                'insider' => 'Insider',
                            ])
                            ->native(false)
                            ->placeholder('Unknown'),
                        Select::make('status')
                            ->options([
                                'unknown' => 'Unknown',
                                'affiliated' => 'Affiliated',
                                'unaffiliated' => 'Unaffiliated',
                                'blocked' => 'Blocked',
                            ])
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Telemetry')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Placeholder::make('normalized_name')
                            ->label('Normalized Key')
                            ->content(fn (?ShareholderEntity $record): string => $record?->normalized_name ?? '-'),
                        Placeholder::make('last_seen_at')
                            ->label('Last Seen')
                            ->content(function (?ShareholderEntity $record): string {
                                $timestamp = Arr::get($record?->meta ?? [], 'last_seen_at');

                                if (! is_string($timestamp) || $timestamp === '') {
                                    return '-';
                                }

                                try {
                                    return Carbon::parse($timestamp)->timezone(config('app.timezone'))->format('d M Y H:i');
                                } catch (Throwable) {
                                    return $timestamp;
                                }
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn (?string $state): string => $state ? ucfirst($state) : 'Unknown')
                    ->color(fn (?string $state) => match ($state) {
                        'institution' => 'info',
                        'fund' => 'success',
                        'insider' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state) => match ($state) {
                        'affiliated' => 'success',
                        'unaffiliated' => 'gray',
                        'blocked' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('companies_count')
                    ->counts('companies')
                    ->label('Companies')
                    ->sortable(),
                TextColumn::make('meta->last_seen_at')
                    ->label('Last Seen')
                    ->formatStateUsing(function ($state) {
                        if (! is_string($state) || $state === '') {
                            return '-';
                        }

                        try {
                            return Carbon::parse($state)->timezone(config('app.timezone'))->format('d M Y H:i');
                        } catch (Throwable) {
                            return $state;
                        }
                    })
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'institution' => 'Institution',
                        'fund' => 'Fund',
                        'insider' => 'Insider',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'unknown' => 'Unknown',
                        'affiliated' => 'Affiliated',
                        'unaffiliated' => 'Unaffiliated',
                        'blocked' => 'Blocked',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            PositionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShareholderEntities::route('/'),
            'create' => CreateShareholderEntity::route('/create'),
            'edit' => EditShareholderEntity::route('/{record}/edit'),
        ];
    }
}

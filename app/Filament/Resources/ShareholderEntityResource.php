<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShareholderEntityResource\Pages;
use App\Filament\Resources\ShareholderEntityResource\RelationManagers\PositionsRelationManager;
use App\Models\ShareholderEntity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ShareholderEntityResource extends Resource
{
    protected static ?string $model = ShareholderEntity::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Shareholder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Entity Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->options([
                                'institution' => 'Institution',
                                'fund' => 'Fund',
                                'insider' => 'Insider',
                            ])
                            ->native(false)
                            ->placeholder('Unknown'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'unknown' => 'Unknown',
                                'affiliated' => 'Affiliated',
                                'unaffiliated' => 'Unaffiliated',
                                'blocked' => 'Blocked',
                            ])
                            ->required()
                            ->native(false),
                    ]),
                Forms\Components\Section::make('Telemetry')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('normalized_name')
                            ->label('Normalized Key')
                            ->content(fn (?ShareholderEntity $record): string => $record?->normalized_name ?? '-'),
                        Forms\Components\Placeholder::make('last_seen_at')
                            ->label('Last Seen')
                            ->content(function (?ShareholderEntity $record): string {
                                $timestamp = Arr::get($record?->meta ?? [], 'last_seen_at');

                                if (! is_string($timestamp) || $timestamp === '') {
                                    return '-';
                                }

                                try {
                                    return Carbon::parse($timestamp)->timezone(config('app.timezone'))->format('d M Y H:i');
                                } catch (\Throwable) {
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
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
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state) => match ($state) {
                        'affiliated' => 'success',
                        'unaffiliated' => 'gray',
                        'blocked' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('companies_count')
                    ->counts('companies')
                    ->label('Companies')
                    ->sortable(),
                Tables\Columns\TextColumn::make('meta->last_seen_at')
                    ->label('Last Seen')
                    ->formatStateUsing(function ($state) {
                        if (! is_string($state) || $state === '') {
                            return '-';
                        }

                        try {
                            return Carbon::parse($state)->timezone(config('app.timezone'))->format('d M Y H:i');
                        } catch (\Throwable) {
                            return $state;
                        }
                    })
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'institution' => 'Institution',
                        'fund' => 'Fund',
                        'insider' => 'Insider',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'unknown' => 'Unknown',
                        'affiliated' => 'Affiliated',
                        'unaffiliated' => 'Unaffiliated',
                        'blocked' => 'Blocked',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListShareholderEntities::route('/'),
            'create' => Pages\CreateShareholderEntity::route('/create'),
            'edit' => Pages\EditShareholderEntity::route('/{record}/edit'),
        ];
    }
}

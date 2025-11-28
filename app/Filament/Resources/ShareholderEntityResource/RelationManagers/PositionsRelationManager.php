<?php

namespace App\Filament\Resources\ShareholderEntityResource\RelationManagers;

use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PositionsRelationManager extends RelationManager
{
    protected static string $relationship = 'positions';

    protected static ?string $recordTitleAttribute = 'id';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Company Positions')
            ->columns([
                TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('relationship_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => $state ? ucfirst($state) : 'Unknown'),
                TextColumn::make('percent_held')
                    ->label('% Held')
                    ->alignRight()
                    ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state * 100, 2).'%' : '-'),
                TextColumn::make('market_value')
                    ->label('Market Value')
                    ->alignRight()
                    ->formatStateUsing(fn ($state) => $state !== null ? 'USD '.number_format((float) $state, 2) : '-'),
                TextColumn::make('report_date')
                    ->date()
                    ->label('Report Date')
                    ->sortable(),
                TextColumn::make('shareholding.fetched_at')
                    ->label('Fetched At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('report_date', 'desc')
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

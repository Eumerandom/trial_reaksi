<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PostList extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Postingan Terakhir';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return PostResource::getEloquentQuery();
            })
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $livewire) {
                        $perPage = $livewire->getTableRecordsPerPage();
                        $page = $livewire->getTablePage();
                        $index = $livewire->getTableRecords()->search($record) + 1;

                        return ($page - 1) * $perPage + $index;
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('content')
                //     ->limit(30),
                Tables\Columns\TextColumn::make('authorUser.name') // diambil berdasarkan relasi di model Post
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn ($state) => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'unpublished' => 'warning',
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

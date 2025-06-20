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
            ->query( function () {
                return PostResource::getEloquentQuery();
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->getStateUsing(fn($record) => Post::orderBy('id')->pluck('id')
                        ->search($record->id) + 1),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
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
                    ->color(fn($state) => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'unpublished' => 'warning',
                    }),
            ]);
    }
}

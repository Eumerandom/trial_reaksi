<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use App\Services\CompanyShareholdingService;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Throwable;

class ShareholdingsRelationManager extends RelationManager
{
    protected static string $relationship = 'shareholdings';

    protected static ?string $title = 'Shareholdings';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Data Shareholding')
            ->recordTitleAttribute('symbol')
            ->columns([
                Tables\Columns\TextColumn::make('fetched_at')
                    ->label('Diambil Pada')
                    ->dateTime('d M Y H:i'),
                // Tables\Columns\TextColumn::make('payload->symbol')
                //     ->label('Symbol')
                //     ->badge()
                //     ->alignCenter(),
                // Tables\Columns\TextColumn::make('payload->institutionOwnership->ownershipList')
                //     ->label('Institutional Holders')
                //     ->formatStateUsing(fn ($state) => $this->formatCount($state)),
                // Tables\Columns\TextColumn::make('payload->fundOwnership->ownershipList')
                //     ->label('Fund Holders')
                //     ->formatStateUsing(fn ($state) => $this->formatCount($state)),
                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->color('success')
                    ->label('Sumber'),
            ])
            ->defaultSort('fetched_at', 'desc')
            ->headerActions([
                Tables\Actions\Action::make('fetchShareholding')
                    ->label('Ambil Data Terbaru')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function () {
                        $company = $this->getOwnerRecord();

                        if (! $this->canFetchShareholding($company)) {
                            Notification::make()
                                ->title('Symbol belum tersedia')
                                ->body('Tambahkan symbol perusahaan terlebih dahulu sebelum mengambil data shareholding.')
                                ->danger()
                                ->send();

                            return;
                        }

                        try {
                            app(CompanyShareholdingService::class)->fetchAndStore($company);

                            $company->refresh();

                            Notification::make()
                                ->title('Data shareholding diperbarui')
                                ->success()
                                ->body('Data terbaru berhasil diambil dari Yahoo Finance.')
                                ->send();
                        } catch (Throwable $exception) {
                            report($exception);

                            Notification::make()
                                ->title('Gagal mengambil data shareholding')
                                ->danger()
                                ->body($exception->getMessage())
                                ->send();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('viewShareholding')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('secondary')
                    ->modalHeading('Detail Shareholding')
                    ->modalWidth('3xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function ($record) {
                        return view('filament.shareholdings.detail-modal', [
                            'record' => $record,
                            'institutional' => Arr::get($record->payload, 'institutionOwnership.ownershipList', []),
                            'funds' => Arr::get($record->payload, 'fundOwnership.ownershipList', []),
                            'summary' => Arr::get($record->payload, 'summaryDetail', []),
                            'price' => Arr::get($record->payload, 'price', []),
                            'major' => Arr::get($record->payload, 'majorHoldersBreakdown', []),
                        ]);
                    }),
            ])
            ->emptyStateHeading('Belum ada data shareholding')
            ->emptyStateDescription('Gunakan tombol "Ambil Data Terbaru" untuk mengambil data pertama kali.')
            ->paginated(false);
    }

    private function canFetchShareholding(Model $company): bool
    {
        return filled($company->symbol);
    }

    private function formatCount($state): string
    {
        if (! is_array($state)) {
            return '-';
        }

        $count = count($state);

        return $count === 0 ? 'Tidak ada data' : "{$count} entri";
    }
}

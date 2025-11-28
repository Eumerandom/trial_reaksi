<?php

namespace App\Filament\Imports;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('Contoh Produk ABC')
                ->guess(['nama', 'product_name', 'nama_produk', 'title'])
                ->helperText('Nama produk yang akan ditampilkan'),

            ImportColumn::make('slug')
                ->rules(['max:255'])
                ->example('contoh-produk-abc')
                ->guess(['url', 'url_slug', 'permalink'])
                ->helperText('Slug URL (kosongkan untuk auto-generate dari nama)'),

            ImportColumn::make('description')
                ->requiredMapping()
                ->rules(['required'])
                ->example('Deskripsi lengkap tentang produk ini')
                ->guess(['deskripsi', 'desc', 'keterangan', 'detail'])
                ->helperText('Deskripsi lengkap produk'),

            ImportColumn::make('company')
                ->relationship(resolveUsing: function (string $state): ?Company {
                    // Cari berdasarkan nama atau slug atau symbol
                    return Company::query()
                        ->where('name', $state)
                        ->orWhere('slug', Str::slug($state))
                        ->orWhere('symbol', strtoupper($state))
                        ->first();
                })
                ->requiredMapping()
                ->rules(['required'])
                ->example('PT Contoh Company')
                ->guess(['perusahaan', 'company_name', 'nama_perusahaan', 'emiten', 'issuer'])
                ->helperText('Nama/simbol perusahaan (contoh: BBCA, Bank Central Asia)'),

            ImportColumn::make('category')
                ->relationship(resolveUsing: function (string $state): ?Category {
                    // Cari berdasarkan nama atau slug
                    return Category::query()
                        ->where('name', $state)
                        ->orWhere('slug', Str::slug($state))
                        ->first();
                })
                ->rules(['nullable'])
                ->example('Makanan & Minuman')
                ->guess(['kategori', 'category_name', 'jenis', 'tipe', 'type'])
                ->helperText('Nama kategori produk'),

            ImportColumn::make('status')
                ->rules(['in:affiliated,unaffiliated'])
                ->example('unaffiliated')
                ->guess(['afiliasi', 'affiliation', 'status_afiliasi'])
                ->helperText('Status afiliasi: affiliated atau unaffiliated')
                ->castStateUsing(function (?string $state): string {
                    if (blank($state)) {
                        return 'unaffiliated';
                    }

                    $state = strtolower(trim($state));

                    // Handle various input formats
                    if (in_array($state, ['affiliated', 'afiliasi', 'ya', 'yes', '1', 'true'])) {
                        return 'affiliated';
                    }

                    return 'unaffiliated';
                }),

            ImportColumn::make('local_product')
                ->label('Produk Lokal')
                ->boolean()
                ->rules(['boolean'])
                ->example('Ya')
                ->guess(['lokal', 'produk_lokal', 'local', 'is_local', 'dalam_negeri'])
                ->helperText('Apakah produk lokal? (Ya/Tidak, 1/0, true/false)'),

            ImportColumn::make('source')
                ->requiredMapping()
                ->rules(['required', 'url', 'max:255'])
                ->example('https://example.com/product-source')
                ->guess(['sumber', 'url', 'link', 'referensi', 'website'])
                ->helperText('URL sumber informasi produk'),

            ImportColumn::make('image')
                ->rules(['nullable', 'max:255'])
                ->example('https://example.com/image.jpg')
                ->guess(['gambar', 'foto', 'picture', 'img', 'image_url'])
                ->helperText('URL gambar produk (opsional)'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        // Jika opsi updateExisting aktif, cari berdasarkan slug
        if ($this->options['updateExisting'] ?? false) {
            $slug = $this->data['slug'] ?? Str::slug($this->data['name'] ?? '');

            if ($slug) {
                return Product::firstOrNew(['slug' => $slug]);
            }
        }

        return new Product();
    }

    protected function beforeFill(): void
    {
        // Auto-generate slug jika tidak diisi
        if (blank($this->data['slug'] ?? null) && ! blank($this->data['name'] ?? null)) {
            $this->data['slug'] = Str::slug($this->data['name']);
        }
    }

    protected function beforeSave(): void
    {
        // Set default values
        if (blank($this->record->status)) {
            $this->record->status = 'unaffiliated';
        }

        if (is_null($this->record->local_product)) {
            $this->record->local_product = false;
        }

        // Auto-generate slug jika masih kosong
        if (blank($this->record->slug) && ! blank($this->record->name)) {
            $this->record->slug = Str::slug($this->record->name);
        }
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Checkbox::make('updateExisting')
                ->label('Update produk yang sudah ada')
                ->helperText('Jika dicentang, produk dengan slug yang sama akan diupdate. Jika tidak, produk baru akan dibuat.')
                ->default(false),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import produk selesai! ' . Number::format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diimport.';
        }

        return $body;
    }
}

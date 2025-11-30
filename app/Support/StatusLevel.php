<?php

namespace App\Support;

use Illuminate\Support\Str;

class StatusLevel
{
    public const DIRECT_SUPPORT = 'direct_support';

    public const INDIRECT_SUPPORT = 'indirect_support';

    public const PUBLIC_COMPANY = 'public_company';

    public const LOCAL_INDEPENDENT = 'local_independent';

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function definitions(): array
    {
        return [
            self::DIRECT_SUPPORT => [
                'label' => 'Terlibat Langsung',
                'cta' => 'Wajib Boikot',
                'description' => 'Brand yang jelas mendukung Israel secara langsung atau memiliki relasi bisnis aktif.',
                'level' => 1,
                'tone' => 'red',
                'filament_color' => 'danger',
            ],
            self::INDIRECT_SUPPORT => [
                'label' => 'Terlibat Tidak Langsung',
                'cta' => 'Sangat Disarankan Boikot',
                'description' => 'Brand dengan koneksi finansial atau kemitraan yang menguntungkan entitas pro-Israel.',
                'level' => 2,
                'tone' => 'orange',
                'filament_color' => 'warning',
            ],
            self::PUBLIC_COMPANY => [
                'label' => 'Aman Tapi Perusahaan Tbk.',
                'cta' => 'Boleh Beli / Tidak',
                'description' => 'Perusahaan nasional terbuka tanpa afiliasi langsung, tetapi saham minoritas bisa dimiliki investor asing.',
                'level' => 3,
                'tone' => 'amber',
                'filament_color' => 'info',
            ],
            self::LOCAL_INDEPENDENT => [
                'label' => 'Lokal, UMKM, dan Bebas Israel',
                'cta' => 'Aman Banget Dibeli',
                'description' => 'Produk lokal atau UMKM tanpa keterkaitan finansial dengan entitas pro-Israel.',
                'level' => 4,
                'tone' => 'green',
                'filament_color' => 'success',
            ],
        ];
    }

    public static function values(): array
    {
        return array_keys(self::definitions());
    }

    public static function definition(?string $status): array
    {
        return self::definitions()[$status] ?? [
            'label' => 'Belum Terkategorikan',
            'cta' => 'Perlu Ditinjau',
            'description' => 'Status produk belum dikurasi.',
            'level' => null,
            'tone' => 'gray',
            'filament_color' => 'gray',
        ];
    }

    public static function label(?string $status): string
    {
        return self::definition($status)['label'];
    }

    public static function callToAction(?string $status): string
    {
        return self::definition($status)['cta'];
    }

    public static function description(?string $status): string
    {
        return self::definition($status)['description'];
    }

    public static function tone(?string $status): string
    {
        return self::definition($status)['tone'];
    }

    public static function filamentColor(?string $status): string
    {
        return self::definition($status)['filament_color'];
    }

    public static function level(?string $status): ?int
    {
        return self::definition($status)['level'];
    }

    public static function options(): array
    {
        return collect(self::definitions())
            ->mapWithKeys(fn ($definition, $value) => [
                $value => $definition['label'].' ('.$definition['cta'].')',
            ])->toArray();
    }

    public static function dropdownItems(): array
    {
        return collect(self::definitions())
            ->map(fn ($definition, $value) => [
                'id' => $value,
                'name' => $definition['label'],
                'cta' => $definition['cta'],
                'description' => $definition['description'],
                'level' => $definition['level'],
            ])->values()->all();
    }

    public static function normalize(?string $input): ?string
    {
        if (blank($input)) {
            return null;
        }

        $normalized = Str::of($input)
            ->lower()
            ->replace(['-', '.', ' '], '_')
            ->trim('_')
            ->__toString();

        $map = [
            'level1' => self::DIRECT_SUPPORT,
            'level_1' => self::DIRECT_SUPPORT,
            'l1' => self::DIRECT_SUPPORT,
            'direct' => self::DIRECT_SUPPORT,
            'direct_support' => self::DIRECT_SUPPORT,
            'terlibat_langsung' => self::DIRECT_SUPPORT,
            'wajib_boikot' => self::DIRECT_SUPPORT,
            'level2' => self::INDIRECT_SUPPORT,
            'level_2' => self::INDIRECT_SUPPORT,
            'l2' => self::INDIRECT_SUPPORT,
            'indirect' => self::INDIRECT_SUPPORT,
            'indirect_support' => self::INDIRECT_SUPPORT,
            'tidak_langsung' => self::INDIRECT_SUPPORT,
            'sangat_disarankan_boikot' => self::INDIRECT_SUPPORT,
            'level3' => self::PUBLIC_COMPANY,
            'level_3' => self::PUBLIC_COMPANY,
            'l3' => self::PUBLIC_COMPANY,
            'tbk' => self::PUBLIC_COMPANY,
            'public_company' => self::PUBLIC_COMPANY,
            'aman_tapi_perusahaan_tbk' => self::PUBLIC_COMPANY,
            'boleh_beli_tidak' => self::PUBLIC_COMPANY,
            'level4' => self::LOCAL_INDEPENDENT,
            'level_4' => self::LOCAL_INDEPENDENT,
            'l4' => self::LOCAL_INDEPENDENT,
            'lokal' => self::LOCAL_INDEPENDENT,
            'umkm' => self::LOCAL_INDEPENDENT,
            'bebas_israel' => self::LOCAL_INDEPENDENT,
            'aman_banget_dibeli' => self::LOCAL_INDEPENDENT,
        ];

        if (isset($map[$normalized])) {
            return $map[$normalized];
        }

        return array_key_exists($normalized, self::definitions()) ? $normalized : null;
    }

    public static function ensure(?string $input, ?string $fallback = null): string
    {
        return self::normalize($input) ?? ($fallback ?? self::DIRECT_SUPPORT);
    }

    public static function safeValues(): array
    {
        return [self::PUBLIC_COMPANY, self::LOCAL_INDEPENDENT];
    }
}

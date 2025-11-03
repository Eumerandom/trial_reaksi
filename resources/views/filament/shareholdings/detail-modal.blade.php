@php
    $summary = is_array($summary) ? $summary : [];
    $price = is_array($price) ? $price : [];
    $major = is_array($major) ? $major : [];
    $institutional = collect(is_array($institutional) ? $institutional : []);
    $funds = collect(is_array($funds) ? $funds : []);
@endphp

<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-100">
            {{ $record->symbol ?? '-' }} — {{ $record->company->name ?? '-' }}
        </h3>
        <p class="text-sm text-gray-400">
            Diambil pada {{ optional($record->fetched_at)->timezone(config('app.timezone'))->format('d M Y H:i') }}
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-filament::card>
            <x-slot name="heading">Ringkasan Harga</x-slot>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <dt class="text-gray-400">Harga Pasar</dt>
                    <dd class="font-semibold text-gray-100">{{ data_get($price, 'regularMarketPrice') ? number_format(data_get($price, 'regularMarketPrice'), 2) : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400">Perubahan Harian</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($price, 'regularMarketChangePercent') ? number_format(data_get($price, 'regularMarketChangePercent') * 100, 2).'%' : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400">High / Low</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($price, 'regularMarketDayHigh') ? number_format(data_get($price, 'regularMarketDayHigh'), 2) : '-' }}
                        /
                        {{ data_get($price, 'regularMarketDayLow') ? number_format(data_get($price, 'regularMarketDayLow'), 2) : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400">Volume</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($price, 'regularMarketVolume') ? number_format(data_get($price, 'regularMarketVolume')) : '-' }}
                    </dd>
                </div>
            </dl>
        </x-filament::card>

        <x-filament::card>
            <x-slot name="heading">Major Holders</x-slot>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <dt class="text-gray-400">Insiders</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($major, 'insidersPercentHeld') ? number_format(data_get($major, 'insidersPercentHeld') * 100, 2).'%' : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400">Institusi</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($major, 'institutionsPercentHeld') ? number_format(data_get($major, 'institutionsPercentHeld') * 100, 2).'%' : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400">Institusi (Float)</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($major, 'institutionsFloatPercentHeld') ? number_format(data_get($major, 'institutionsFloatPercentHeld') * 100, 2).'%' : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400">Jumlah Institusi</dt>
                    <dd class="font-semibold text-gray-100">
                        {{ data_get($major, 'institutionsCount') ? number_format(data_get($major, 'institutionsCount')) : '-' }}
                    </dd>
                </div>
            </dl>
        </x-filament::card>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-filament::card>
            <x-slot name="heading">Institutional Holders</x-slot>

            @if ($institutional->isEmpty())
                <p class="text-sm text-gray-400">Tidak ada data.</p>
            @else
                <ul class="space-y-4 text-sm">
                    @foreach ($institutional as $holder)
                        <li>
                            <p class="font-semibold text-gray-100">{{ data_get($holder, 'organization', '-') }}</p>
                            <p class="text-gray-400">
                                <span>Kepemilikan: {{ data_get($holder, 'pctHeld.fmt', '-') }}</span> •
                                <span>Posisi: {{ data_get($holder, 'position.fmt') ?? data_get($holder, 'position.longFmt', '-') }}</span> •
                                <span>Nilai: {{ data_get($holder, 'value.fmt', '-') }}</span>
                            </p>
                            <p class="text-gray-500 text-xs">
                                Perubahan: {{ data_get($holder, 'pctChange.fmt', '-') }} •
                                Periode: {{ data_get($holder, 'reportDate.fmt', '-') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-filament::card>

        <x-filament::card>
            <x-slot name="heading">Fund Holders</x-slot>

            @if ($funds->isEmpty())
                <p class="text-sm text-gray-400">Tidak ada data.</p>
            @else
                <ul class="space-y-4 text-sm">
                    @foreach ($funds as $holder)
                        <li>
                            <p class="font-semibold text-gray-100">{{ data_get($holder, 'organization', '-') }}</p>
                            <p class="text-gray-400">
                                <span>Kepemilikan: {{ data_get($holder, 'pctHeld.fmt', '-') }}</span> •
                                <span>Posisi: {{ data_get($holder, 'position.fmt') ?? data_get($holder, 'position.longFmt', '-') }}</span> •
                                <span>Nilai: {{ data_get($holder, 'value.fmt', '-') }}</span>
                            </p>
                            <p class="text-gray-500 text-xs">
                                Perubahan: {{ data_get($holder, 'pctChange.fmt', '-') }} •
                                Periode: {{ data_get($holder, 'reportDate.fmt', '-') }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-filament::card>
    </div>
</div>

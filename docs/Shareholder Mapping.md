# Shareholder Data Mapping

## Tabel dan Kolom

### shareholder_entities

| Column | Source |
| --- | --- |
| `id` | Auto increment |
| `name` | `organization` |
| `normalized_name` | Normalisasi `organization` (lowercase, trim, filter) |
| `type` | `institutionOwnership` → `institution`, `fundOwnership` → `fund` (fallback null) |
| `status` | Manual (default `unknown`) |
| `meta` | JSON (`last_seen_at`) |
| `created_at` / `updated_at` | Timestamp |

### company_shareholder_positions

| Column | Source |
| --- | --- |
| `id` | Auto increment |
| `company_id` | Relasi ke `companies` |
| `shareholder_entity_id` | Relasi ke `shareholder_entities` |
| `company_shareholding_id` | Snapshot terakhir (`company_shareholdings.id`) |
| `relationship_type` | `institution` / `fund` dari path payload |
| `percent_held` | `pctHeld.raw` |
| `position` | `position.raw` |
| `market_value` | `value.raw` |
| `percent_change` | `pctChange.raw` |
| `report_date` | `reportDate.raw` (fallback `reportDate.fmt`) |
| `meta` | JSON berisi key format (`pct_held_fmt`, `position_fmt`, `value_fmt`, `pct_change_fmt`, `report_date_fmt`, `max_age`, dll) |
| `created_at` / `updated_at` | Timestamp Laravel |

### company_shareholdings

| Column | Source |
| --- | --- |
| `id` | Auto increment |
| `company_id` | Relasi ke `companies` (perusahaan yang diminta) |
| `symbol` | Simbol ticker yang diminta (input request / `companies.symbol`) |
| `payload` | JSON penuh respon Yahoo Finance `/stock/get-major-holders` |
| `source` | Sumber data (`yahoo_finance`, `rapidapi`, dll) |
| `cache_store` | Store cache yang digunakan saat fetch (opsional) |
| `cache_key` | Cache key yang digunakan saat fetch (opsional) |
| `fetched_at` | Timestamp pengambilan data |
| `created_at` / `updated_at` | Timestamp Laravel |

## Payload API Yahoo Finance (ownershipList)

| Key | Deskripsi | Disimpan ke |
| --- | --- | --- |
| `organization` | Nama pemegang | `shareholder_entities.name` / `company_shareholder_positions.relationship_type` |
| `pctHeld.raw` | Persentase kepemilikan (float) | `company_shareholder_positions.percent_held` |
| `pctHeld.fmt` | Persentase (format string) | `company_shareholder_positions.meta->pct_held_fmt` |
| `position.raw` | Jumlah saham | `company_shareholder_positions.position` |
| `position.fmt` / `position.longFmt` | Jumlah saham (format) | `company_shareholder_positions.meta->position_fmt` / `meta->position_long_fmt` |
| `value.raw` | Nilai pasar | `company_shareholder_positions.market_value` |
| `value.fmt` / `value.longFmt` | Nilai pasar (format) | `company_shareholder_positions.meta->value_fmt` / `meta->value_long_fmt` |
| `pctChange.raw` | Persentase perubahan | `company_shareholder_positions.percent_change` |
| `pctChange.fmt` | Persentase perubahan (format) | `company_shareholder_positions.meta->pct_change_fmt` |
| `reportDate.raw` / `reportDate.fmt` | Tanggal laporan | `company_shareholder_positions.report_date` |
| `maxAge` | Usia data | `company_shareholder_positions.meta->max_age` |
| `ownershipList` lainnya | Disimpan dalam `company_shareholder_positions.meta` bila ada |

## Derived Attributes

- `normalized_name` (hasil normalisasi `organization`) → `shareholder_entities.normalized_name`
- `type` (`institution` / `fund`) → `shareholder_entities.type`
- `status` manual (default `unknown`) → `shareholder_entities.status`

iLazer's condition Rn: (×﹏×)

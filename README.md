## System Requirement

- PHP ^8.2
- Composer
- Node.js & npm/pnpm
- MySQL

## Setup Local Development

1. **Clone repository**
   ```bash
   git clone https://github.com/Eumerandom/trial_reaksi.git
   cd trial_reaksi
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   # atau
   pnpm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Setup database**
   ```bash
   # Konfigurasi .env untuk database
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   # atau untuk development
   npm run dev
   ```

## Menjalankan Aplikasi

### Development Server
```bash
composer run dev
```
### Production Build
```bash
composer run build
```

## Code Quality

Proyek ini menggunakan Laravel Pint untuk PHP dan Prettier untuk Blade templates.
**PENTING:** Selalu jalankan format kode sebelum commit dan push. Ini memastikan semua kode PHP dan Blade template mengikuti standar coding yang konsisten.

### Format Kode
```bash
# Format hanya Blade
composer run format

# Format hanya PHP
composer run pint

# Chek format
composer run lint

```
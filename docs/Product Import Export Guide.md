# Panduan Import & Export Produk

## 📥 Import Produk

### Cara Import
1. Buka halaman **Products** di Filament Admin Panel
2. Klik tombol **Import Produk** (hijau) di header
3. Upload file CSV/Excel
4. Mapping kolom CSV ke field yang sesuai
5. Centang **Update produk yang sudah ada** jika ingin update data existing (berdasarkan slug)
6. Klik **Import**

### Struktur File CSV untuk Import

| Kolom | Wajib | Contoh | Keterangan |
|-------|-------|--------|------------|
| `name` | ✅ Ya | Contoh Produk ABC | Nama produk |
| `slug` | ❌ Tidak | contoh-produk-abc | URL slug (auto-generate jika kosong) |
| `description` | ✅ Ya | Deskripsi lengkap | Deskripsi produk |
| `company` | ✅ Ya | PT Contoh Company / BBCA | Nama/simbol perusahaan |
| `category` | ❌ Tidak | Makanan & Minuman | Nama kategori |
| `status` | ❌ Tidak | affiliated / unaffiliated | Status afiliasi (default: unaffiliated) |
| `local_product` | ❌ Tidak | Ya / Tidak / 1 / 0 | Produk lokal (default: Tidak) |
| `source` | ✅ Ya | https://example.com | URL sumber informasi |
| `image` | ❌ Tidak | https://example.com/img.jpg | URL gambar produk |

### Contoh File CSV

```csv
name,description,company,category,status,local_product,source,image
"Mie Instant Goreng","Mie instant dengan rasa gurih dan lezat","Indofood","Makanan & Minuman","unaffiliated","Ya","https://indofood.com/product/mie","https://cdn.example.com/mie.jpg"
"Air Mineral 600ml","Air mineral berkualitas","AQUA","Makanan & Minuman","unaffiliated","Ya","https://aqua.co.id/product","https://cdn.example.com/aqua.jpg"
"Smartphone X Pro","Smartphone dengan kamera 108MP","Samsung Electronics","Elektronik","affiliated","Tidak","https://samsung.com/product","https://cdn.example.com/phone.jpg"
```

### Tips Import

1. **Nama Perusahaan**: Bisa menggunakan:
   - Nama lengkap: "Bank Central Asia"
   - Simbol: "BBCA"
   - Slug: "bank-central-asia"

2. **Status Afiliasi**: 
   - `affiliated`, `afiliasi`, `ya`, `yes`, `1`, `true` → Affiliated
   - Lainnya → Unaffiliated

3. **Produk Lokal**:
   - `ya`, `yes`, `1`, `true` → Ya
   - Lainnya → Tidak

4. **Update Data Existing**: Centang opsi ini jika ingin update produk dengan slug yang sama

---


## 🔄 Workflow Import untuk Data Baru

### 1. Persiapan
- Pastikan **Company** dan **Category** sudah ada di database
- Jika belum, buat terlebih dahulu atau import company/category dulu

### 2. Buat File CSV
- Download template dari sistem
- Isi data sesuai format
- Pastikan nama company/category sesuai dengan yang ada di database

### 3. Import
- Upload file
- Mapping kolom
- Proses import

### 4. Review
- Cek notifikasi untuk hasil import
- Download file "Failed Rows" jika ada yang gagal
- Perbaiki data yang error dan import ulang

---

## ⚠️ Troubleshooting

### Error "Company tidak ditemukan"
- Pastikan nama/simbol company yang diinput sesuai dengan database
- Cek typo atau spasi berlebih

### Error "Category tidak ditemukan"  
- Pastikan nama category sesuai dengan yang ada di database
- Category bersifat opsional, bisa dikosongkan

### Error "URL tidak valid"
- Pastikan kolom `source` berisi URL yang valid (dimulai dengan http:// atau https://)

### Data Duplicate
- Centang "Update produk yang sudah ada" untuk update bukan duplicate
- Sistem menggunakan `slug` untuk identifikasi produk existing

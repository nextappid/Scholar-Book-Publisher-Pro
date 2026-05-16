# Panduan Cepat Scholar Book Publisher Pro (Bahasa Indonesia)

## 🚀 Instalasi Cepat

### Langkah 1: Upload Plugin
1. Login ke WordPress Admin
2. Klik **Plugin → Tambah Baru**
3. Klik **Upload Plugin**
4. Pilih file `scholar-book-publisher-pro.zip`
5. Klik **Instal Sekarang**
6. Klik **Aktifkan**

### Langkah 2: Pengaturan Awal (PENTING!)
1. Buka **Pengaturan → Tautan Permanen**
2. Pilih struktur **Nama Pos** (/%postname%/)
3. Klik **Simpan Perubahan**

### Langkah 3: Verifikasi HTTPS
- Pastikan situs Anda memiliki SSL (https://)
- Jika belum, hubungi penyedia hosting Anda

✅ **Selesai!** Plugin siap digunakan.

---

## 📖 Menambahkan Buku Pertama

### Data Wajib Diisi:

**1. Judul Buku**
```
Contoh: Dasar-Dasar Pembelajaran Mesin
```

**2. Penulis** (klik "+ Tambah Penulis")
- Nama Depan: `Budi`
- Nama Belakang: `Santoso`
- Format sitasi otomatis: Santoso, Budi ✅

**3. Nama Penerbit**
```
Contoh: Penerbit Erlangga
```

**4. Kota Penerbit**
```
Contoh: Jakarta
```

**5. Tanggal Terbit**
- Pilih tanggal resmi penerbitan
- Format: YYYY-MM-DD

**6. ISBN** (13 digit)
```
Contoh: 978-979-123-456-7
```

**7. DOI** (Opsional tapi Disarankan)
```
Contoh: 10.1234/contoh.buku.2026
```

---

## 📄 Menambahkan PDF (Opsional tapi Sangat Disarankan)

### Opsi A: Upload ke WordPress

**Kapan menggunakan:**
- File PDF < 5MB
- Storage server mencukupi

**Cara:**
1. Centang ☑️ "Buku ini memiliki PDF"
2. Pilih ⚫ "Skema 1: Upload ke Media Library WordPress"
3. Klik **📤 Upload PDF File**
4. Pilih atau upload PDF Anda
5. Pastikan ukuran < 5MB
6. Klik **Gunakan PDF ini**

**Peringatan:**
- Jika > 5MB, Google Scholar mungkin tidak mengindeks
- Kompres PDF jika terlalu besar

---

### Opsi B: Link dari Google Drive (DIREKOMENDASIKAN)

**Kapan menggunakan:**
- File PDF > 5MB (walau tidak ideal untuk indexing)
- Storage server terbatas
- Banyak buku yang akan dipublikasi

**Keuntungan:**
- ✅ Tidak menggunakan storage server WordPress
- ✅ Storage unlimited (Google Drive)
- ✅ Mudah diupdate
- ✅ Tetap bisa di-crawl Google Scholar

**Langkah Detail:**

#### 1. Upload PDF ke Google Drive
1. Buka https://drive.google.com
2. Login dengan akun Google
3. Klik **+ Baru** → **Upload File**
4. Pilih file PDF Anda
5. Tunggu sampai selesai upload

#### 2. Atur Izin Berbagi (SANGAT PENTING!)
1. Klik kanan pada file PDF
2. Pilih **Bagikan** atau **Share**
3. Klik **Ubah ke siapa saja yang memiliki link**
4. Pastikan muncul: **"Siapa saja yang memiliki link"** + **"Viewer"**
5. Klik **Salin link** atau **Copy link**

Link akan berbentuk:
```
https://drive.google.com/file/d/1ABCdefGHIjklMNOpqrSTUVwxyz123456/view?usp=sharing
```

**⚠️ KESALAHAN UMUM:** Membiarkan "Terbatas" - Google Scholar tidak bisa akses!

#### 3. Masukkan Link ke WordPress
1. Di editor buku WordPress, centang ☑️ "Buku ini memiliki PDF"
2. Pilih ⚫ "Skema 2: Link dari Google Drive"
3. Paste link Google Drive di kolom **"Google Drive Share Link"**

#### 4. Validasi Link
1. Klik tombol **🔍 Validate & Extract Google Drive ID**
2. Plugin akan otomatis:
   - Mengekstrak File ID dari link
   - Membuat direct download link
   - Menampilkan pesan sukses

Anda akan melihat:
```
✅ Berhasil! File ID terekstrak: 1ABCdefGHIjklMNOpqrSTUVwxyz123456

Direct Download Link:
https://drive.google.com/uc?export=download&id=1ABCdefGHIjklMNOpqrSTUVwxyz123456
```

#### 5. Test Download
1. Klik tombol **🧪 Test Download Link**
2. Browser harus mulai download PDF
3. Jika tidak:
   - Cek lagi pengaturan berbagi (Langkah 2)
   - Pastikan file tidak corrupt
   - Coba browser lain

#### 6. Masukkan Ukuran File (Opsional)
1. Cari ukuran file PDF:
   - Klik kanan PDF di Google Drive → Detail
   - Konversi ke MB (contoh: 2.5 MB)
2. Masukkan di kolom **"PDF File Size (MB)"**
3. Plugin akan beri peringatan jika > 5MB

#### 7. Simpan
Klik **Update** atau **Terbitkan**.

---

## ✅ Checklist Sebelum Terbitkan

```
☐ Judul dan subjudul sudah diisi
☐ Minimal 1 penulis ditambahkan (format: Belakang, Depan)
☐ Nama penerbit dan kota diisi
☐ Tanggal terbit valid
☐ ISBN 13 digit diisi
☐ DOI ditambahkan (jika ada)
☐ PDF di-upload ATAU link Google Drive ditambahkan
☐ Ukuran PDF < 5MB (sangat disarankan)
☐ PDF bisa dicari (searchable, bukan scan gambar)
☐ Deskripsi/abstrak ditulis (min 150 kata)
☐ Gambar unggulan (cover buku) ditambahkan
☐ Kategori/tag ditambahkan
```

---

## 🔍 Verifikasi Meta Tags

Setelah menerbitkan:

1. Klik **Lihat Buku** untuk melihat halaman publik
2. Klik kanan → **Lihat Sumber Halaman** (atau tekan `Ctrl+U`)
3. Tekan `Ctrl+F` dan cari: `citation_`

Anda harus melihat:
```html
<meta name="citation_title" content="Dasar-Dasar Pembelajaran Mesin">
<meta name="citation_author" content="Santoso, Budi">
<meta name="citation_publisher" content="Penerbit Erlangga">
<meta name="citation_publisher_place" content="Jakarta">
<meta name="citation_isbn" content="978-979-123-456-7">
<meta name="citation_pdf_url" content="https://...">
```

**Jika tidak ada:**
- Hapus cache (jika pakai plugin caching)
- Cek apakah plugin aktif
- Cek kompatibilitas tema

---

## 🎯 Optimasi Google Scholar

### Persyaratan Wajib:
1. ✅ Situs menggunakan HTTPS (SSL)
2. ✅ PDF dapat diakses publik (tanpa login)
3. ✅ Metadata lengkap dan benar
4. ✅ PDF searchable (bukan scan gambar)
5. ✅ Ukuran file < 5MB (sangat disarankan)

### Timeline Indexing:
- **Crawl pertama:** 4-12 minggu
- **Indexing awal:** 2-6 bulan
- **Indexing penuh:** 6-9 bulan
- **Update:** 2x per tahun

### Cek Status Indexing:
Cari di Google Scholar:
```
site:namasitus.com "Judul Buku"
```

---

## 🛠️ Troubleshooting Umum

### Masalah: PDF Tidak Bisa Di-upload

**Solusi:**
1. Periksa ukuran file (harus < limit upload)
2. Cek di **Media → Tambah Baru** untuk melihat "Maximum upload file size"
3. Jika terlalu kecil, hubungi hosting atau gunakan Google Drive
4. Kompres PDF dengan https://www.ilovepdf.com/compress_pdf

### Masalah: Link Google Drive Tidak Ekstrak ID

**Solusi:**
1. Pastikan format link benar:
   - Benar: `https://drive.google.com/file/d/1ABC.../view?usp=sharing`
   - Salah: `https://drive.google.com/open?id=1ABC...`
2. Ekstrak manual:
   - Link Anda: `https://drive.google.com/file/d/1ABCdefGHI/view`
   - File ID: `1ABCdefGHI` (antara `/d/` dan `/view`)
   - Paste langsung di kolom "Extracted File ID"

### Masalah: Meta Tags Tidak Muncul

**Solusi:**
1. Hapus semua cache:
   - Plugin cache WordPress
   - CDN cache (Cloudflare, dll)
   - Cache browser (Ctrl+Shift+R)
2. Periksa tema memanggil `wp_head()` di header.php
3. Nonaktifkan sementara plugin cache untuk testing

### Masalah: Buku Tidak Muncul di Frontend (Error 404)

**Solusi:**
1. Pergi ke **Pengaturan → Tautan Permanen**
2. Klik **Simpan Perubahan** (flush rewrite rules)
3. Coba akses buku lagi

---

## 📊 Perbandingan Skema PDF

| Aspek | WordPress Upload | Google Drive Link |
|-------|------------------|-------------------|
| **Storage** | Server Anda | Google Drive |
| **Kapasitas** | Terbatas hosting | 15GB gratis, bisa upgrade |
| **Setup** | Mudah | Butuh akun Google |
| **Update** | Upload ulang | Ganti file di Drive |
| **Kecepatan** | Server Anda | Server Google (cepat) |
| **Crawlable** | ✅ Ya | ✅ Ya |
| **Rekomendasi** | File < 5MB | File besar, banyak buku |

---

## 💡 Tips & Best Practices

### 1. Persiapan PDF
- ✅ Kompres PDF sebelum upload (target < 5MB)
- ✅ Pastikan PDF searchable (bisa copy-paste teks)
- ✅ Embed metadata di PDF properties
- ✅ Gunakan nama file yang deskriptif: `judul-buku.pdf`

### 2. Metadata Berkualitas
- ✅ Nama penulis konsisten di semua buku
- ✅ Nama penerbit resmi dan konsisten
- ✅ ISBN valid (cek di https://www.isbn-international.org/)
- ✅ DOI dari CrossRef atau DataCite

### 3. Konten Akademis
- ✅ Tulis abstrak komprehensif (min 150 kata)
- ✅ Konten harus scholarly/akademis
- ✅ Tidak ada typo di metadata
- ✅ Kategori dan tag relevan

### 4. Publikasi Rutin
- ✅ Tambahkan buku secara berkala (1-2 buku/bulan)
- ✅ Jangan upload semua sekaligus
- ✅ Google Scholar lebih suka situs yang aktif

### 5. Monitoring
- ✅ Cek indexing setelah 6 bulan
- ✅ Monitor sitasi di Google Scholar
- ✅ Update metadata jika perlu
- ✅ Perbaiki broken links

---

## 🔗 Resource Berguna

### Tools Kompres PDF:
- https://www.ilovepdf.com/compress_pdf
- https://smallpdf.com/compress-pdf
- Adobe Acrobat Pro

### Validasi ISBN:
- https://www.isbn-international.org/

### Google Scholar:
- Panduan Inklusi: https://scholar.google.com/intl/en/scholar/inclusion.html
- Help Center: https://scholar.google.com/intl/en/scholar/help.html

### WordPress:
- Forum Dukungan: https://id.wordpress.org/support/
- Dokumentasi: https://codex.wordpress.org/

---

## 📞 Bantuan & Dukungan

**Pertanyaan Umum:**
Lihat bagian FAQ di INSTALLATION-GUIDE.md (English)

**Melaporkan Bug:**
1. Cek panduan ini dulu
2. Cari di GitHub issues
3. Buat issue baru dengan detail lengkap

**Kontribusi:**
Proyek open-source, kontribusi diterima:
- Perbaikan kode
- Terjemahan
- Dokumentasi
- Laporan bug

---

## ✨ Kesimpulan

Plugin Scholar Book Publisher Pro memudahkan Anda:
- ✅ Mengelola buku akademis di WordPress
- ✅ Optimasi otomatis untuk Google Scholar
- ✅ Fleksibilitas PDF (WordPress atau Google Drive)
- ✅ Metadata lengkap dan terstruktur
- ✅ Tidak perlu coding

**Langkah Selanjutnya:**
1. Install plugin ✅
2. Tambahkan buku pertama ✅
3. Tunggu indexing Google Scholar (6-9 bulan)
4. Monitor dan perbaiki sesuai kebutuhan

**Selamat menerbitkan! 📚**

---

**Versi:** 1.0.0  
**Terakhir Diperbarui:** Februari 2026  
**Plugin:** Scholar Book Publisher Pro

Untuk versi terbaru panduan ini dalam bahasa Inggris, lihat: INSTALLATION-GUIDE.md

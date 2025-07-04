# Temperance - Aplikasi Manajemen Tujuan dan Tugas

![Temperance Logo](public/favicon.ico)

Temperance adalah aplikasi manajemen tujuan dan tugas yang komprehensif, dirancang untuk membantu pengguna melacak dan mencapai tujuan mereka dengan lebih efektif. Aplikasi ini memungkinkan pengguna untuk membuat kategori, menetapkan tujuan, membagi tujuan menjadi tugas-tugas yang lebih kecil, dan melacak kemajuan mereka secara real-time.

## Fitur Utama

- **Manajemen Kategori**: Kelompokkan tujuan Anda berdasarkan kategori dengan kode warna untuk organisasi yang lebih baik
- **Penetapan Tujuan**: Buat tujuan dengan deskripsi, tanggal mulai/akhir, prioritas, dan status
- **Manajemen Tugas**: Bagi tujuan menjadi tugas-tugas yang lebih kecil dan terkelola
- **Pelacakan Kemajuan**: Perbarui dan lacak kemajuan tujuan dan tugas secara real-time
- **Riwayat Kemajuan**: Lihat riwayat lengkap pembaruan kemajuan untuk tujuan dan tugas
- **Dashboard**: Dapatkan gambaran umum tentang tujuan, tugas, dan kemajuan Anda

## Teknologi yang Digunakan

- **Framework**: Laravel 10
- **Database**: PostgreSQL
- **Frontend**: Blade Templates, Tailwind CSS
- **Autentikasi**: Laravel's built-in authentication

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Database PostgreSQL 14

## Instalasi

### Mengkloning Proyek dengan Manajemen Branch

Proyek ini menggunakan model manajemen branch di mana setiap kontributor bekerja di branch personal mereka sendiri, dan kemudian melakukan merge ke branch utama (main) untuk integrasi.

#### 1. Kloning Repositori

```bash
# Kloning repositori
git clone https://github.com/username/temperance.git
cd temperance
```

#### 2. Membuat Branch Personal

Setiap kontributor harus membuat branch personal mereka sendiri untuk bekerja:

```bash
# Buat branch personal baru (ganti 'nama-anda' dengan nama atau username Anda)
git checkout -b nama-anda
```

#### 3. Instalasi Dependensi

```bash
# Instalasi dependensi PHP
composer install

# Instalasi dependensi Node.js
npm install
npm run dev
```

#### 4. Konfigurasi Lingkungan

```bash
# Salin file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan pengaturan database:

```
DB_CONNECTION=postgresql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=temperance
DB_USERNAME=your_postgres_username
DB_PASSWORD=your_postgres_password
```

Atau untuk SQLite:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

#### 6. Migrasi dan Seeding Database

```bash
# Jalankan migrasi database
php artisan migrate

# (Opsional) Jalankan seeder untuk data contoh
php artisan db:seed
```

#### 7. Menjalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000` atau `http://127.0.0.1:8000`

### Alur Kerja Git

#### Bekerja di Branch Personal

1. Selalu pastikan branch personal Anda up-to-date dengan branch main:

```bash
# Pastikan Anda berada di branch personal Anda
git checkout nama-anda

# Ambil perubahan terbaru dari branch main
git fetch origin
git merge origin/main
```

2. Lakukan perubahan dan commit ke branch personal Anda:

```bash
# Tambahkan perubahan
git add .

# Commit perubahan dengan pesan yang deskriptif
git commit -m "Deskripsi perubahan yang dilakukan"

# Push ke branch personal Anda di remote
git push origin nama-anda
```

#### Merge ke Branch Main

Setelah fitur atau perbaikan selesai dan teruji dengan baik di branch personal Anda, ikuti langkah-langkah berikut untuk merge ke branch main:

1. Pastikan branch personal Anda up-to-date dengan branch main:

```bash
git checkout nama-anda
git fetch origin
git merge origin/main
```

2. Selesaikan konflik jika ada, lalu push branch personal Anda:

```bash
git push origin nama-anda
```

3. Pindah ke branch main dan merge branch personal Anda:

```bash
git checkout main
git merge nama-anda
```

4. Push perubahan ke branch main di remote:

```bash
git push origin main
```

5. Kembali ke branch personal Anda untuk melanjutkan pengembangan:

```bash
git checkout nama-anda
```

## Struktur Database

Aplikasi ini menggunakan beberapa tabel utama:

- **users**: Menyimpan informasi pengguna
- **categories**: Kategori untuk mengelompokkan tujuan
- **goals**: Tujuan yang ingin dicapai pengguna
- **tasks**: Tugas-tugas yang terkait dengan tujuan
- **progress**: Catatan kemajuan untuk tujuan dan tugas


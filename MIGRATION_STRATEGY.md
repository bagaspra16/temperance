# Strategi Migrasi PostgreSQL ke MySQL - Temperance

## Ringkasan Perubahan

Aplikasi Temperance telah dikonversi dari PostgreSQL ke MySQL dengan perubahan berikut:

### 1. Konfigurasi Database
- **Default Connection**: Diubah dari `sqlite` ke `mysql`
- **Charset**: `utf8mb4` dengan collation `utf8mb4_unicode_ci`
- **Engine**: `InnoDB` untuk mendukung foreign keys dan transactions

### 2. Perubahan Migrasi
- **UUID Columns**: `uuid()` → `char(36)` (otomatis oleh Laravel)
- **JSON Columns**: Tetap menggunakan `json()` (kompatibel dengan MySQL 5.7+)
- **Indexes**: Ditambahkan index komposit untuk performa MySQL
- **Foreign Keys**: Tetap sama, kompatibel dengan MySQL

### 3. Perubahan Kode
- **Raw Queries**: `EXTRACT(DOW FROM date)` → `DAYOFWEEK(date)`
- **Day Numbering**: PostgreSQL (0=Sunday) → MySQL (1=Sunday)
- **Database Detection**: Dihapus, langsung menggunakan MySQL syntax

## Langkah-langkah Migrasi Data

### Tahap 1: Persiapan
```bash
# 1. Backup database PostgreSQL
pg_dump -h localhost -U your_username -d temperance > temperance_backup.sql

# 2. Buat database MySQL baru
mysql -u root -p -e "CREATE DATABASE temperance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=temperance
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Tahap 2: Migrasi Schema
```bash
# 1. Jalankan migrasi untuk membuat struktur tabel
php artisan migrate:fresh

# 2. Verifikasi struktur tabel
php artisan migrate:status
```

### Tahap 3: Migrasi Data

#### Opsi A: Menggunakan pgloader (Recommended)
```bash
# Install pgloader
# Ubuntu/Debian: sudo apt-get install pgloader
# macOS: brew install pgloader

# Jalankan migrasi data
pgloader postgresql://username:password@localhost/temperance \
         mysql://root:password@localhost/temperance
```

#### Opsi B: Manual Export/Import
```bash
# 1. Export data dari PostgreSQL ke CSV
psql -h localhost -U your_username -d temperance -c "
COPY users TO '/tmp/users.csv' WITH CSV HEADER;
COPY categories TO '/tmp/categories.csv' WITH CSV HEADER;
COPY goals TO '/tmp/goals.csv' WITH CSV HEADER;
COPY tasks TO '/tmp/tasks.csv' WITH CSV HEADER;
COPY progress TO '/tmp/progress.csv' WITH CSV HEADER;
COPY journals TO '/tmp/journals.csv' WITH CSV HEADER;
COPY achievements TO '/tmp/achievements.csv' WITH CSV HEADER;
"

# 2. Import ke MySQL
mysql -u root -p temperance -e "
LOAD DATA INFILE '/tmp/users.csv' INTO TABLE users FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/categories.csv' INTO TABLE categories FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/goals.csv' INTO TABLE goals FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/tasks.csv' INTO TABLE tasks FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/progress.csv' INTO TABLE progress FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/journals.csv' INTO TABLE journals FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
LOAD DATA INFILE '/tmp/achievements.csv' INTO TABLE achievements FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
"
```

#### Opsi C: Menggunakan Laravel Artisan Command
```bash
# Buat custom command untuk migrasi data
php artisan make:command MigrateDataFromPostgres

# Implementasi command untuk membaca dari PostgreSQL dan menulis ke MySQL
```

### Tahap 4: Validasi dan Testing

#### 1. Verifikasi Data
```bash
# Cek jumlah record di setiap tabel
php artisan tinker
>>> User::count()
>>> Category::count()
>>> Goal::count()
>>> Task::count()
>>> Progress::count()
>>> Journal::count()
>>> Achievement::count()
```

#### 2. Test Relationships
```bash
# Test foreign key relationships
php artisan tinker
>>> $user = User::first()
>>> $user->categories->count()
>>> $user->goals->count()
>>> $user->tasks->count()
>>> $user->journals->count()
```

#### 3. Test JSON Columns
```bash
# Test JSON functionality
php artisan tinker
>>> $journal = Journal::first()
>>> $journal->tags
>>> $journal->tags = ['work', 'important']
>>> $journal->save()
```

#### 4. Test UUID Generation
```bash
# Test UUID generation
php artisan tinker
>>> $user = new User(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password'])
>>> $user->save()
>>> $user->id // Should be UUID
```

### Tahap 5: Performance Optimization

#### 1. Analyze Tables
```sql
-- Di MySQL
ANALYZE TABLE users, categories, goals, tasks, progress, journals, achievements;
```

#### 2. Check Index Usage
```sql
-- Cek penggunaan index
SHOW INDEX FROM users;
SHOW INDEX FROM journals;
```

#### 3. Optimize Queries
```sql
-- Cek slow queries
SHOW VARIABLES LIKE 'slow_query_log';
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

## Troubleshooting

### Masalah Umum

#### 1. UUID Format Issues
```bash
# Jika ada masalah dengan UUID format
php artisan tinker
>>> User::truncate() // Hapus semua data
>>> User::factory(10)->create() // Buat data baru dengan UUID yang benar
```

#### 2. JSON Column Issues
```bash
# Jika ada masalah dengan JSON columns
php artisan tinker
>>> Journal::whereRaw("JSON_VALID(tags) = 0")->get() // Cek invalid JSON
```

#### 3. Foreign Key Issues
```bash
# Cek foreign key constraints
php artisan tinker
>>> DB::select("SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME IS NOT NULL")
```

#### 4. Day of Week Issues
```bash
# Test day of week calculation
php artisan tinker
>>> Journal::selectRaw('DAYOFWEEK(date) as day_of_week, COUNT(*) as count')->groupBy('day_of_week')->get()
```

## Rollback Plan

Jika ada masalah, rollback ke PostgreSQL:

```bash
# 1. Restore .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=temperance
DB_USERNAME=your_postgres_username
DB_PASSWORD=your_postgres_password

# 2. Restore database
psql -h localhost -U your_username -d temperance < temperance_backup.sql

# 3. Revert code changes
git checkout HEAD~1
```

## Post-Migration Checklist

- [ ] Semua tabel terbuat dengan benar
- [ ] Semua foreign key constraints berfungsi
- [ ] UUID generation berfungsi
- [ ] JSON columns berfungsi
- [ ] Day of week calculations benar
- [ ] Semua relationships berfungsi
- [ ] Performance acceptable
- [ ] Backup MySQL database
- [ ] Update dokumentasi
- [ ] Update deployment scripts
- [ ] Test semua fitur aplikasi

## Monitoring

Setelah migrasi, monitor:

1. **Query Performance**: Cek slow query log
2. **Memory Usage**: Monitor MySQL memory usage
3. **Connection Count**: Monitor active connections
4. **Error Logs**: Cek Laravel dan MySQL error logs
5. **Application Logs**: Monitor aplikasi untuk error

## Support

Jika ada masalah dengan migrasi:

1. Cek Laravel logs: `storage/logs/laravel.log`
2. Cek MySQL logs: `/var/log/mysql/error.log`
3. Cek database connection: `php artisan tinker` → `DB::connection()->getPdo()`
4. Test basic queries: `php artisan tinker` → `User::count()`

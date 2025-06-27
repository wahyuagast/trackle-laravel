# Trackle - Aplikasi Manajemen Proyek Laravel

Trackle adalah aplikasi manajemen proyek berbasis web yang dibangun menggunakan Laravel. Aplikasi ini mendukung fitur login/register, manajemen proyek, komentar, notifikasi, dan pengelolaan user berbasis role sederhana.

## Fitur Utama

- **Autentikasi**: Login & register user.
- **Manajemen Proyek**: Tambah, edit, hapus, dan lihat detail proyek.
- **Komentar**: Tambah komentar pada proyek.
- **Notifikasi**: Notifikasi sederhana untuk user terkait proyek.
- **Dashboard**: Ringkasan proyek mendatang, berjalan, dan selesai.
- **Manajemen User**: Setiap proyek memiliki PIC (Person In Charge).
- **Dukungan AJAX**: Form proyek dan komentar menggunakan AJAX (fetch API).
- **Dukungan Cloudflare Tunnel**: Bisa diakses dari internet menggunakan Cloudflare Tunnel.

## Instalasi

1. **Clone repository**
   ```
   git clone <repo-url>
   cd trackle-laravel
   ```

2. **Install dependency**
   ```
   composer install
   npm install && npm run build
   ```

3. **Copy file environment**
   ```
   cp .env.example .env
   ```

4. **Atur konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=trackle-server
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate key**
   ```
   php artisan key:generate
   ```

6. **Migrasi database**
   ```
   php artisan migrate
   php artisan db:seed
   ```

7. **(Opsional) Buat symlink storage**
   ```
   php artisan storage:link
   ```

8. **Jalankan server**
   ```
   php artisan serve
   ```

9. **(Opsional) Jalankan Cloudflare Tunnel**
   ```
   cloudflared tunnel --url http://localhost:8000
   ```
   Pastikan `APP_URL` di `.env` sesuai dengan domain tunnel jika menggunakan Cloudflare.

## Struktur Folder Penting

- `app/Http/Controllers` - Controller web & API
- `app/Models` - Model Eloquent
- `resources/views` - Blade template (login, dashboard, proyek, dsb)
- `public/js/script.js` - Script utama frontend (AJAX)
- `routes/web.php` & `routes/api.php` - Routing aplikasi

## Catatan Penggunaan

- Jika menggunakan Cloudflare Tunnel, pastikan:
  - `APP_URL` di `.env` sesuai domain tunnel.
  - `SESSION_DOMAIN` dikosongkan.
  - Jalankan `php artisan config:clear` setelah mengubah `.env`.
- Untuk development, gunakan `SESSION_DRIVER=file` jika ada masalah session di tunnel.

## Kontribusi

Pull request dan issue sangat diterima! Silakan fork dan buat PR untuk fitur/bugfix.

## Lisensi

MIT License.
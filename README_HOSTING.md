# PANDUAN DEPLOYMENT & HOSTING BACMS
**BULAVA Archery Club Management System**

Dokumen ini berisi panduan lengkap untuk mengunggah (*hosting*) aplikasi BACMS ke server produksi (Shared Hosting/cPanel atau VPS), mengonfigurasi email Gmail SMTP, serta panduan alur kerja Git & GitHub untuk pembaruan sistem di masa mendatang.

---

## 📋 PERSYARATAN SERVER (SYSTEM REQUIREMENTS)
Sebelum melakukan hosting, pastikan server tujuan memenuhi spesifikasi berikut:
*   **PHP 8.2 atau 8.3** (Rekomendasi PHP 8.3+)
*   **Ekstensi PHP Wajib**: `BCMath`, `Ctype`, `Fileinfo`, `GD` (untuk Intervention Image), `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`.
*   **MySQL 8.0+** atau **MariaDB 10.4+**
*   **Composer** (jika menggunakan VPS/Terminal cPanel)
*   **Akses SSH** (opsional, sangat direkomendasikan)

---

## 📦 ISI PAKET RELEASE (`bacms_release.zip`)
File zip rilis berisi struktur sistem bersih tanpa menyertakan file kredensial lokal dan modul berat:
*   `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `tests/` (Kode program utama).
*   `composer.json` & `composer.lock` (Daftar pustaka PHP yang diperlukan).
*   `artisan` (CLI Laravel).
*   `.env.example` (Template konfigurasi server).
*   **Dikecualikan**: Folder `vendor/` (akan diunduh di server), `.env` lokal, `.git/`, `.gemini/` (file sementara AI).

---

## 🚀 LANGKAH DEPLOYMENT DI SHARED HOSTING / cPANEL

### Langkah 1: Unggah dan Ekstrak File
1.  Masuk ke **cPanel** Anda -> buka **File Manager**.
2.  Unggah file `bacms_release.zip` ke folder utama di luar `public_html` (misal: di folder `/home/username/bacms`).
    > [!IMPORTANT]
    > Menaruh file Laravel di luar `public_html` adalah standar keamanan terbaik agar file konfigurasi sensitif seperti `.env` tidak dapat diakses secara publik lewat browser.
3.  Ekstrak file `bacms_release.zip` di folder tersebut.
4.  Pindahkan seluruh isi dari folder **`public`** (dari hasil ekstrak tadi) ke dalam folder **`public_html`** hosting Anda.
5.  Edit file **`public_html/index.php`**, temukan baris berikut dan sesuaikan jalurnya:
    ```php
    // Ganti baris ini:
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Menjadi seperti ini (sesuaikan dengan nama folder di luar public_html Anda):
    require __DIR__.'/../bacms/vendor/autoload.php';
    $app = require_once __DIR__.'/../bacms/bootstrap/app.php';
    ```

### Langkah 2: Buat Database dan Kredensial
1.  Di cPanel, cari menu **MySQL Database Wizard**.
2.  Buat database baru (misal: `bulava_bacms`).
3.  Buat user database baru dan buat password yang kuat.
4.  Hubungkan user tersebut ke database dengan memberikan semua hak akses (**All Privileges**).

### Langkah 3: Konfigurasi File `.env` di Server
1.  Kembali ke File Manager -> masuk ke folder utama tempat Anda mengekstrak file tadi (misal: `/home/username/bacms`).
2.  Ubah nama file `.env.example` menjadi **`.env`** (klik kanan -> Rename).
3.  Edit file `.env` tersebut dan isi data koneksi database baru Anda:
    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://domainanda.com

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_yang_dibuat
    DB_USERNAME=nama_user_database_yang_dibuat
    DB_PASSWORD=password_user_database_yang_dibuat
    ```

### Langkah 4: Install Dependencies & Run Database Migration
1.  Buka menu **Terminal** di cPanel Anda (jika tidak ada, Anda bisa meminta bantuan CS Hosting untuk mengaktifkan akses Terminal/SSH).
2.  Masuk ke direktori folder Laravel Anda:
    ```bash
    cd ~/bacms
    ```
3.  Jalankan instalasi pustaka Laravel (tanpa paket development):
    ```bash
    composer install --no-dev --optimize-autoloader
    ```
4.  Generate kunci aplikasi baru:
    ```bash
    php artisan key:generate
    ```
5.  Jalankan migrasi database dan isi data awal (seed):
    ```bash
    php artisan migrate --seed
    ```
6.  Buat tautan pintas untuk folder penyimpanan foto profil:
    ```bash
    php artisan storage:link
    ```
    *(Jika di cPanel tautan tidak berjalan otomatis, Anda bisa membuat symlink manual lewat PHP script atau Terminal: `ln -s /home/username/bacms/storage/app/public /home/username/public_html/storage`)*

---

## 🛠️ CARA MENYETEL SMTP GMAIL PADA PRODUCTION
Agar fitur Lupa Password bisa mengirimkan email asli ke inbox atlet:
1.  Masuk ke Akun Google Anda -> **Keamanan** -> Aktifkan **Verifikasi 2 Langkah**.
2.  Masuk ke menu **Sandi Aplikasi (App Passwords)**. Buat sandi baru untuk aplikasi web Anda, salin **16-digit kode** yang diberikan.
3.  Edit file `.env` di server hosting Anda:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME="email_anda@gmail.com"
    MAIL_PASSWORD="16_digit_sandi_aplikasi_google"
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="email_anda@gmail.com"
    MAIL_FROM_NAME="BULAVA - BACMS"
    ```
4.  Bersihkan cache config agar pengaturan baru diterapkan:
    ```bash
    php artisan config:cache
    ```

---

## 🐈 PANDUAN PUSH PROYEK KE GITHUB
Untuk mengunggah kode proyek Anda ke GitHub untuk pertama kali:

### Prasyarat
1.  Pastikan Anda sudah mengunduh dan menginstal **Git** di komputer Anda ([git-scm.com](https://git-scm.com/)).
2.  Buat akun di **GitHub** ([github.com](https://github.com/)).

### Langkah-langkah Push ke GitHub
1.  **Buka Terminal / Git Bash / PowerShell** di komputer lokal Anda, lalu masuk ke folder proyek `bulava`.
2.  **Inisialisasi repositori Git lokal**:
    ```bash
    git init
    ```
3.  **Tambahkan semua file ke area staging**:
    ```bash
    git add .
    ```
    *(Folder `vendor`, `.env`, dan file log lainnya secara otomatis diabaikan karena sudah terdaftar di file `.gitignore`).*
4.  **Lakukan commit pertama**:
    ```bash
    git commit -m "Initial Commit - BACMS Laravel 12 Bootstrap 5"
    ```
5.  **Buka GitHub di Browser**:
    *   Klik tombol **New** untuk membuat repositori baru.
    *   Beri nama repositori (misal: `bulava-bacms`).
    *   Biarkan pilihan lainnya default (jangan centang "Add a README", karena kita sudah memilikinya).
    *   Klik **Create repository**.
6.  **Hubungkan repositori lokal ke GitHub**:
    *   Salin alamat URL repositori Anda (misal: `https://github.com/username/bulava-bacms.git`).
    *   Jalankan perintah berikut di terminal Anda:
    ```bash
    git branch -M main
    git remote add origin https://github.com/username/bulava-bacms.git
    ```
7.  **Push kode Anda**:
    ```bash
    git push -u origin main
    ```
    *(Jika diminta otentikasi, login menggunakan akun GitHub Anda atau gunakan GitHub Token).*

---

## 🔄 CARA UPDATE WEBSITE SETELAH ONLINE (ALUR GITHUB)
Setelah website online, jika Anda melakukan perubahan kode di komputer lokal dan ingin menerapkannya di server hosting:

1.  **Di Komputer Lokal**:
    *   Simpan semua perubahan kode Anda.
    *   Buka terminal di folder proyek lokal Anda, jalankan:
    ```bash
    git add .
    git commit -m "Penjelasan singkat fitur baru/perbaikan yang dibuat"
    git push origin main
    ```
2.  **Di Server Hosting (cPanel / VPS via SSH)**:
    *   Buka terminal SSH Anda, masuk ke folder aplikasi:
    ```bash
    cd ~/bacms
    ```
    *   Tarik pembaruan kode terbaru dari GitHub:
    ```bash
    git pull origin main
    ```
    *   Jalankan migrasi database jika ada penambahan tabel/kolom baru:
    ```bash
    php artisan migrate
    ```
    *   Hapus cache sistem agar kode dan rute baru segera aktif:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
    *Update selesai dalam hitungan detik!*

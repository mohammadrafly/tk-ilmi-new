# Proyek Laravel

## Dokumentasi Instalasi dan Setup

### Clone Repositori

Clone repositori proyek menggunakan Git:

    git clone https://github.com/mohammadrafly/tk-ilmi-new.git
    cd repository

Gantilah `username` dan `repository` dengan nama pengguna dan repositori yang sesuai.

### Instal Dependensi

**Instal Dependensi Composer**

Instal dependensi PHP menggunakan Composer:

    composer install

**Instal Dependensi npm**

Instal dependensi JavaScript menggunakan npm:

    npm install

### Konfigurasi Proyek

**Menyalin File Konfigurasi**

Salin file konfigurasi `.env.example` ke `.env`:

    cp .env.example .env

**Generate Key Aplikasi**

Generate key aplikasi Laravel:

    php artisan key:generate

**Menautkan Storage**

Buat symbolic link dari `storage` ke `public`:

    php artisan storage:link

### Migrasi dan Seeding

**Migrasi Database**

Jalankan migrasi database untuk membuat tabel yang diperlukan:

    php artisan migrate

**Seeding Database**

Jika ada seeders yang perlu dijalankan, gunakan perintah ini untuk mengisi data awal:

    php artisan db:seed

### Menjalankan Proyek

**Menjalankan Server Pengembangan**

Jalankan server frontend:

    npm run dev

Jalankan server pengembangan Laravel:

    php artisan serve

Akses aplikasi di browser melalui `http://localhost:8000`.

---

Jika Anda mengalami masalah atau memiliki pertanyaan lebih lanjut, jangan ragu untuk mencari bantuan di [dokumentasi Laravel](https://laravel.com/docs) atau [komunitas Laravel](https://laracasts.com/).

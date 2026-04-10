# PANDUAN LENGKAP: Membuat Project Inventory (Laravel 12 + Tailwind 4)

Panduan ini ditujukan untuk kamu yang ingin berlatih membuat ulang sistem Inventory dari nol di project baru.

---

## 1. Persiapan Software (Instalasi)
Sebelum memulai, pastikan software berikut sudah terinstall di Windows kamu:

*   **PHP (v8.2 ke atas)**: Download di [windows.php.net](https://windows.php.net/download/). Masukkan path `C:\php` ke Environment Variables.
*   **Composer**: Dependency manager untuk PHP. Download dan install dari [getcomposer.org](https://getcomposer.org/).
*   **Node.js & NPM**: Untuk build tools frontend (Vite/Tailwind). Download di [nodejs.org](https://nodejs.org/).
*   **Code Editor**: Sangat disarankan menggunakan **VS Code**.

---

## 2. Membuat Project Baru
Buka Terminal atau PowerShell, masuk ke folder tempat kamu ingin menyimpan project, lalu jalankan:

```powershell
# Buat project baru dengan nama 'latihan-inventory'
composer create-project laravel/laravel latihan-inventory

# Masuk ke folder project
cd latihan-inventory
```

---

## 3. Konfigurasi Database (SQLite)
Laravel 11 & 12 menggunakan **SQLite** secara default. Ini sangat mudah karena kamu tidak perlu install XAMPP/MySQL.

1.  Buka file `.env`, pastikan settingan database seperti ini:
    ```env
    DB_CONNECTION=sqlite
    # DB_HOST, DB_PORT, dll bisa dihapus/di-comment
    ```
2.  Jalankan perintah ini untuk membuat key dan database awal:
    ```powershell
    php artisan key:generate
    php artisan migrate
    ```

---

## 4. Setup Tampilan (Tailwind CSS 4)
Kita akan menggunakan Tailwind CSS versi 4 yang sangat cepat dengan Vite.

1.  **Install Tailwind & Vite Plugin**:
    ```powershell
    npm install tailwindcss @tailwindcss/vite vite
    ```
2.  **Konfigurasi Vite**: Buka file `vite.config.js` dan tambahkan plugin Tailwind:
    ```javascript
    import { defineConfig } from 'vite';
    import laravel from 'laravel-vite-plugin';
    import tailwindcss from '@tailwindcss/vite'; // <--- Tambah ini

    export default defineConfig({
        plugins: [
            tailwindcss(), // <--- Tambah ini
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
    });
    ```
3.  **Import Tailwind**: Buka `resources/css/app.css` dan ganti isinya dengan:
    ```css
    @import "tailwindcss";
    ```

---

## 5. Membuat Fitur (Pola Kerja)
Setiap kali kamu membuat fitur baru (misal: Barang), ikuti pola **"M-C-V-R"**:

### A. Model & Migration (M)
Buat tabel dan tempat menyimpan data.
```powershell
php artisan make:model Item -m
```
*Edit file `database/migrations/..._create_items_table.php` untuk menambah kolom (nama, stok, dll).*

### B. Controller (C)
Buat logika pengolah data.
```powershell
php artisan make:controller ItemController
```

### C. Route (R)
Daftarkan alamat URL di `routes/web.php`.
```php
use App\Http\Controllers\ItemController;
Route::get('/items', [ItemController.class, 'index']);
```

### D. View (V)
Buat tampilan Blade di `resources/views/items/index.blade.php`.

---

## 6. Fitur Spesial di Project Ini
Untuk meniru project yang sekarang, kamu butuh dua library ini:

1.  **Sistem Role (Admin/Staff)**:
    ```powershell
    composer require spatie/laravel-permission
    ```
2.  **Export/Import Excel**:
    ```powershell
    composer require maatwebsite/excel
    ```

---

## 7. Menjalankan Website
Kamu butuh dua terminal yang berjalan bersamaan:

*   **Terminal 1 (Backend)**:
    ```powershell
    php artisan serve
    ```
*   **Terminal 2 (Frontend/Vite)**:
    ```powershell
    npm run dev
    ```

Buka browser di: `http://127.0.0.1:8000`

---
**Tips**: Fokuslah satu per satu. Mulai dari membuat tabel barang dulu, baru pelajari cara menampilkannya di halaman. Semangat!


## Instalasi

1. **Clone repository**
   ```sh
   git clone https://github.com/rezadwi13/EduTrack.git
   cd EduTrack
   ```
2. **Install dependency**
   ```sh
   composer install
   npm install
   npm run build
   ```
3. **Konfigurasi environment**
   - Copy file `.env.example` menjadi `.env`
   - Atur konfigurasi database di file `.env`
4. **Generate key aplikasi**
   ```sh
   php artisan key:generate
   ```
5. **Migrasi dan seeder database**
   ```sh
   php artisan migrate --seed
   ```
6. **Jalankan aplikasi**
   ```sh
   php artisan serve
   ```
   Akses aplikasi di [http://localhost:8000](http://localhost:8000)

## Login

- **Admin:**  Username/email & password default bisa dilihat di seeder `UserSeeder.php` atau database.
- **Guru/Siswa:**  Data login juga bisa dilihat di database setelah seeder dijalankan.

## Fitur Utama

- **Manajemen Siswa:** Tambah, edit, hapus, dan lihat data siswa.
- **Manajemen Guru:** Tambah, edit, hapus, dan lihat data guru.
- **Manajemen Nilai:** Input, edit, hapus, dan lihat nilai siswa (role-based: admin/guru/siswa).
- **Jadwal Pelajaran:** Atur jadwal pelajaran per kelas.
- **Ekstrakurikuler:** Manajemen kegiatan ekstrakurikuler.
- **Galeri:** Upload dan kelola foto galeri sekolah.
- **Pengumuman:** Buat dan kelola pengumuman.
- **Manajemen User & Role:** Admin dapat mengelola user dan hak akses.
- **Export Data:** Export nilai ke Excel/PDF.
- **Autentikasi & Hak Akses:** Login, dan pembatasan akses berdasarkan role.

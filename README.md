# EduTrack

EduTrack adalah aplikasi manajemen data sekolah berbasis web...

## Fitur Utama

- Manajemen Siswa: tambah, edit, hapus, dan lihat data siswa
- Manajemen Guru: tambah, edit, hapus, dan lihat data guru
- Manajemen Nilai: input, edit, hapus, dan lihat nilai siswa (admin/guru/siswa)
- Jadwal Pelajaran: atur jadwal pelajaran per kelas
- Ekstrakurikuler: manajemen kegiatan ekstrakurikuler
- Galeri: upload dan kelola foto galeri sekolah
- Pengumuman: buat dan kelola pengumuman
- Manajemen User & Role: admin dapat mengelola user dan hak akses
- Export Data: export nilai ke Excel/PDF
- Autentikasi & Hak Akses: login, register, dan pembatasan akses berdasarkan role

## Instruksi Instalasi

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

## Login Default

- **Admin:** Username/email & password default dapat dilihat di seeder `UserSeeder.php` atau database.
- **Guru/Siswa:** Data login juga dapat dilihat di database setelah seeder dijalankan.

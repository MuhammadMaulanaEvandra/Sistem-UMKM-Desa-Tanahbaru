# Laporan Perbaikan Bug "Pratinjau Dokumen" & Fitur Terkait

Tugas perbaikan untuk masalah "Pratinjau Dokumen" UMKM dan fitur verifikasi telah selesai dikerjakan sesuai dengan instruksi yang diberikan. Berikut adalah rincian sesuai dengan output yang Anda inginkan:

## 1. Penjelasan Penyebab Bug
Penyebab utama gambar "Pratinjau Dokumen" tidak muncul (broken image) adalah karena sistem frontend (JavaScript) mengompresi gambar KTP, NIB, dan Lokasi menggunakan elemen Canvas, mengubahnya menjadi format string **Base64** (Data URL), dan mengirimkannya melalui payload JSON ke backend. 

Di sisi backend (`api.php`), string Base64 tersebut disimpan secara utuh ke kolom `ktp_path`, `nib_path`, dan `lokasi_path` pada tabel `umkm`. Karena struktur database mengatur tipe kolom tersebut sebagai `VARCHAR(255)`, string Base64 yang panjangnya bisa mencapai ribuan karakter otomatis **terpotong** oleh MySQL saat disimpan. Akibatnya, path yang dikirim kembali ke frontend saat Admin membuka detail UMKM menjadi string Base64 yang tidak valid/rusak, sehingga tag `<img>` gagal memuat gambar tersebut. Selain itu, cara ini juga tidak mengunggah file aktual ke folder manapun di server.

## 2. Daftar File yang Diubah
1. `api.php`
2. `public/js/main.js`
3. `pages/auth/register.php`
4. `pages/modals/detail_umkm_admin.php`
5. `includes/body_start.php`

## 3. Penjelasan Setiap Perubahan yang Dilakukan
- **`api.php`**: Mengubah fungsi pembaca payload `read_json` agar mengutamakan pengecekan array superglobal `$_POST`. Menambahkan penanganan upload file nyata (menggunakan `move_uploaded_file`) dari `$_FILES` dengan validasi ekstensi (`jpg`, `png`, `pdf`), validasi ukuran (< 5MB), pembuatan folder `uploads` jika tidak ada, dan penyimpanan nama unik (dengan `uniqid()`) ke server. Database kini menyimpan path file yang valid (contoh: `uploads/ktp_12345.jpg`).
- **`public/js/main.js`**: 
  - Mengubah cara `handleRegisterFileSelect` menampung file dari proses konversi canvas Base64 menjadi objek `File` murni.
  - Memodifikasi pengiriman payload dari JSON menjadi format `FormData` menggunakan `fetch()`.
  - Mengubah alur render UI "Pratinjau Dokumen" (`viewAdminUmkmDetail` & `openDocLightbox`) untuk merender `iframe` jika dokumen berupa file `.pdf`, merender gambar jika `.jpg/.png`, dan memunculkan pesan "Dokumen belum diunggah" atau "File tidak ditemukan" jika terjadi error atau path kosong.
  - Menghapus tombol "Setujui" dan "Tolak" dari baris di fungsi `renderAdminPendingTable`, menyisakan "Tinjau Berkas" saja. Tombol eksekusi tetap ada di dalam *pop-up* Tinjau Berkas.
- **`register.php`**: Mengubah atribut `accept="image/*"` menjadi `accept="image/jpeg, image/png, image/jpg, application/pdf"` untuk memvalidasi limitasi tipe file secara bawaan HTML.
- **`detail_umkm_admin.php`**: Mengubah kerangka kontainer gambar KTP, NIB, dan Lokasi dengan menambahkan tag `<iframe>` (tersembunyi secara default) untuk PDF, tag `<img>` dengan *event listener* `onerror`, serta div container pesan peringatan jika gambar/file tidak valid.
- **`body_start.php`**: Menambahkan elemen `iframe` untuk lightbox ketika admin memperbesar tampilan pratinjau dokumen bertipe PDF.

## 4. Pastikan fitur "Pratinjau Dokumen" Berfungsi
Kode saat ini sudah dapat menangani unggahan secara normal di localhost maupun saat dihosting, menciptakan folder `uploads/` secara dinamis, menyimpan gambar dan pdf dengan benar, lalu Admin Dashboard dapat secara langsung merender dokumen yang sesuai menggunakan `<img>` (untuk gambar) atau `<iframe>` (untuk file PDF).

*(Kode lengkap dan detail diff dapat dilihat langsung pada source code file-file yang telah dimodifikasi).*

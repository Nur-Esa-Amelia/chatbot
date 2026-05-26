-- SQL Query Examples untuk Chatbot Diskominfo

-- ============================================
-- INSERT SAMPLE FAQ DATA
-- ============================================

-- Replace wp_ dengan prefix database anda jika berbeda

INSERT INTO wp_chatbot_faq (keyword, jawaban) VALUES 

-- FAQ 1: Jam Kerja
('jam kerja, jam buka, jam operasional, pukul berapa buka', 
'Jam kerja kami adalah Senin-Jumat pukul 08:00-17:00 WIB (istirahat 12:00-13:00).
Kami tutup pada hari Sabtu, Minggu, dan hari-hari libur nasional.

Terima kasih telah menghubungi kami!'),

-- FAQ 2: Kontak
('kontak, telepon, nomor hp, wa, whatsapp, hubungi kami, email, alamat email', 
'Anda bisa menghubungi kami melalui beberapa cara:

📞 Telepon: (021) 1234567
📱 WhatsApp: 0812-3456-7890
✉️ Email: info@diskominfo.id
🏢 Kantor: Jl. Sudirman No. 123, Jakarta Pusat

Tim kami siap membantu Anda!'),

-- FAQ 3: Lokasi Kantor
('lokasi, alamat, di mana, tempat, kantor mana', 
'Kantor kami berlokasi di:

Diskominfo
Jl. Sudirman No. 123
Jakarta Pusat 12190

Sudah dekat dengan stasiun MRT atau bisa naik bus beberapa rute utama.
Tersedia tempat parkir untuk kendaraan roda empat.'),

-- FAQ 4: Layanan
('layanan apa saja, apa layanannya, jenis layanan, layanan apa, services', 
'Kami menyediakan berbagai layanan:

1. 📋 Informasi Publik - Data dan informasi umum tentang pemerintah
2. 🖊️ Konsultasi - Bantuan konsultasi untuk berbagai kebutuhan
3. 📜 Perizinan - Proses dan konsultasi perizinan
4. 📊 Statistik - Data dan laporan statistik resmi
5. 🎓 Edukasi - Program edukasi dan sosialisasi

Silakan hubungi kami untuk detail layanan yang Anda butuhkan.'),

-- FAQ 5: Proses Perizinan
('izin, perizinan, cara mengurus izin, proses izin, dokumen apa, berapa lama', 
'Untuk mengurus izin, berikut langkah-langkahnya:

1. Datang ke Bagian Perizinan dengan membawa KTP/identitas
2. Isi formulir permohonan
3. Serahkan dokumen pendukung sesuai jenis izin
4. Bayar biaya administrasi (jika ada)
5. Tunggu proses (biasanya 3-7 hari kerja)
6. Ambil izin yang sudah jadi

Untuk detail dokumen yang dibutuhkan, hubungi: (021) 1234567 ext 5'),

-- FAQ 6: Jam Pelayanan Pengaduan
('pengaduan, keluhan, lapor, komplain, ada masalah', 
'Kami terbuka untuk menerima masukan dan pengaduan dari masyarakat.

Anda bisa melaporkan pengaduan melalui:
1. 💬 Chat Bot ini - pilih menu "📢 Pengaduan"
2. 📞 Telepon: (021) 1234567 ext 1
3. 📧 Email: pengaduan@diskominfo.id
4. 🏢 Datang langsung ke kantor

Tim kami akan menindaklanjuti pengaduan Anda dalam waktu maksimal 5 hari kerja.'),

-- FAQ 7: Persyaratan Umum
('syarat, persyaratan, requirements, apa yang perlu, dokumen apa', 
'Secara umum, untuk layanan kami perlu menyiapkan:

✓ Identitas (KTP/SIM/Paspor)
✓ Formulir permohonan (bisa ambil di kantor)
✓ Bukti domisili (jika diperlukan)
✓ Dokumen pendukung sesuai jenis layanan
✓ Tanda setoran biaya (jika ada biaya)

Untuk layanan spesifik, persyaratan mungkin berbeda. Hubungi kami untuk detail lebih lanjut.'),

-- FAQ 8: Biaya Layanan
('biaya, harga, berapa biaya, gratis, tarif, cost, price', 
'Biaya layanan berbeda-beda tergantung jenis layanan:

📋 Informasi Publik: GRATIS
🖊️ Konsultasi: GRATIS
📜 Perizinan: Rp 50.000 - 500.000 (tergantung jenis)
📊 Statistik/Data: GRATIS
🎓 Edukasi: GRATIS

Untuk detail biaya perizinan spesifik, silakan hubungi kami.'),

-- FAQ 9: Waktu Pemrosesan
('berapa lama, lama, waktu, proses berapa hari, expired, kadaluarsa', 
'Waktu pemrosesan setiap layanan:

📋 Informasi Publik: 1-3 hari kerja
🖊️ Konsultasi: 2-5 hari kerja (tergantung topik)
📜 Perizinan Umum: 3-7 hari kerja
📜 Perizinan Kompleks: 7-14 hari kerja

Izin berlaku setidaknya 1 tahun (tergantung jenis).
Perpanjangan bisa dilakukan sebelum izin expired.'),

-- FAQ 10: Cara Perpanjang Izin
('perpanjang, renew, extend, diperpanjang, expired, sudah habis', 
'Untuk memperpanjang izin yang sudah ada:

1. Datang ke kantor sebelum izin expired
2. Bawa izin yang lama dan KTP
3. Isi formulir perpanjangan
4. Bayar biaya perpanjangan
5. Serahkan dokumen pendukung (jika diperlukan)
6. Tunggu 2-3 hari kerja
7. Ambil izin baru Anda

⚠️ PENTING: Jangan tunggu sampai izin expired. Perpanjang sebelumnya!');

-- ============================================
-- VIEW SEMUA FAQ YANG SUDAH TERSIMPAN
-- ============================================

-- Uncomment untuk melihat semua FAQ:
-- SELECT * FROM wp_chatbot_faq;

-- ============================================
-- SEARCH FAQ BERDASARKAN KEYWORD
-- ============================================

-- Contoh: Cari FAQ tentang "jam kerja"
-- SELECT * FROM wp_chatbot_faq WHERE keyword LIKE '%jam kerja%';

-- ============================================
-- UPDATE FAQ
-- ============================================

-- Contoh: Update jawaban FAQ dengan ID 1
-- UPDATE wp_chatbot_faq SET jawaban = 'Jawaban baru di sini' WHERE id = 1;

-- ============================================
-- DELETE FAQ
-- ============================================

-- Contoh: Hapus FAQ dengan ID 5
-- DELETE FROM wp_chatbot_faq WHERE id = 5;

-- ============================================
-- VIEW PENGADUAN YANG MASUK
-- ============================================

-- Lihat semua pengaduan yang status pending:
-- SELECT * FROM wp_pengaduan WHERE status = 'pending' ORDER BY tanggal_buat DESC;

-- Lihat semua pengaduan yang sudah selesai:
-- SELECT * FROM wp_pengaduan WHERE status = 'selesai' ORDER BY tanggal_buat DESC;

-- Lihat pengaduan dari email tertentu:
-- SELECT * FROM wp_pengaduan WHERE email_pelapor = 'user@example.com' ORDER BY tanggal_buat DESC;

-- ============================================
-- UPDATE STATUS PENGADUAN MANUAL (jika perlu)
-- ============================================

-- Update status pengaduan dengan ID 1 menjadi selesai:
-- UPDATE wp_pengaduan SET status = 'selesai', jawaban_admin = 'Masalah sudah ditangani' WHERE id = 1;

-- ============================================
-- STATISTIK PENGADUAN
-- ============================================

-- Hitung total pengaduan:
-- SELECT COUNT(*) as total_pengaduan FROM wp_pengaduan;

-- Hitung pengaduan by status:
-- SELECT status, COUNT(*) as total FROM wp_pengaduan GROUP BY status;

-- Hitung pengaduan per email (most complainer):
-- SELECT email_pelapor, COUNT(*) as total FROM wp_pengaduan GROUP BY email_pelapor ORDER BY total DESC LIMIT 10;

-- ============================================
-- BACKUP / EXPORT DATA
-- ============================================

-- Buat backup FAQ ke file CSV:
-- Tools → Export → pilih tabel wp_chatbot_faq → CSV

-- ============================================
-- NOTES
-- ============================================

-- 1. Ganti prefix wp_ dengan prefix database anda jika berbeda
-- 2. Jalankan INSERT query di atas untuk menambahkan sample FAQ
-- 3. Keyword dipisahkan dengan koma (,) untuk multiple keyword matching
-- 4. Jawaban bisa menggunakan newline (\n) untuk format yang lebih bagus
-- 5. Email address harus valid format
-- 6. Status pengaduan hanya bisa: 'pending' atau 'selesai'

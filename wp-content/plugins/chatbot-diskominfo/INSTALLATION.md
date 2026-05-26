# Setup & Installation Guide

## Instalasi Plugin

### Step 1: Upload Plugin
File plugin sudah tersedia di:
```
/wp-content/plugins/chatbot-diskominfo/
```

### Step 2: Aktifkan Plugin
1. Login ke WordPress Admin
2. Pergi ke **Plugins** → **Installed Plugins**
3. Cari "Chatbot Diskominfo"
4. Klik tombol **"Activate"**

**PENTING**: Saat plugin diaktifkan, 2 tabel otomatis akan dibuat:
- `wp_chatbot_faq` - untuk menyimpan pertanyaan & jawaban
- `wp_pengaduan` - untuk menyimpan laporan pengaduan

### Step 3: Setup FAQ Data
Anda perlu mengisi data pertanyaan & jawaban ke tabel `wp_chatbot_faq` agar chatbot bisa merespons.

#### Cara 1: Via Database (PhpMyAdmin)
1. Buka PhpMyAdmin
2. Pilih database WordPress anda
3. Pergi ke tabel `wp_chatbot_faq`
4. Klik **Insert** dan masukkan data:
   - **keyword**: Kata kunci/topik (pisahkan dengan koma jika ada multiple keyword)
   - **jawaban**: Jawaban untuk keyword tersebut

#### Contoh Data:
```
keyword: "jam kerja, jam buka, jam operasional"
jawaban: "Jam kerja kami adalah Senin-Jumat pukul 08:00-17:00 WIB. Libur pada hari Sabtu, Minggu, dan hari nasional."

keyword: "kontak, telepon, nomor hp, wa"
jawaban: "Anda bisa menghubungi kami di:
- Telepon: (021) 1234567
- WhatsApp: 0812-3456-7890
- Email: info@diskominfo.id"

keyword: "lokasi, alamat, tempat"
jawaban: "Alamat kami: Jl. Sudirman No. 123, Jakarta Pusat"
```

#### Cara 2: Via SQL Query
Copy & paste query di bawah ini ke PhpMyAdmin → SQL tab:

```sql
INSERT INTO wp_chatbot_faq (keyword, jawaban) VALUES 
('jam kerja, jam buka, jam operasional', 'Jam kerja kami adalah Senin-Jumat pukul 08:00-17:00 WIB. Libur pada hari Sabtu, Minggu, dan hari nasional.'),
('kontak, telepon, nomor hp, wa', 'Anda bisa menghubungi kami di:\n- Telepon: (021) 1234567\n- WhatsApp: 0812-3456-7890\n- Email: info@diskominfo.id'),
('lokasi, alamat, tempat', 'Alamat kami: Jl. Sudirman No. 123, Jakarta Pusat'),
('layanan apa saja', 'Kami menyediakan layanan informasi publik, konsultasi, dan perizinan. Silakan hubungi kami untuk detail lebih lanjut.'),
('cara mengurus izin', 'Untuk mengurus izin, silakan datang ke kantor kami atau hubungi Bagian Perizinan di (021) 1234567.');
```

### Step 4: Verifikasi Setup
1. Buka website Anda di browser
2. Klik tombol chatbot di sudut kanan bawah
3. Klik tombol **"❓ Pertanyaan"**
4. Coba tanyakan sesuatu seperti "jam kerja" atau "kontak"
5. Chatbot seharusnya menampilkan jawaban dari FAQ

---

## Konfigurasi Email (Untuk Pengaduan)

Agar email pengaduan bisa terkirim ke user, pastikan WordPress email configuration sudah benar.

### Step 1: Install & Aktivasi Plugin SMTP
Anda perlu install plugin SMTP untuk mengirim email. Rekomendasi:
- **WP Mail SMTP** (gratis dan mudah)
- **Post SMTP** (alternatif)

### Step 2: Setup SMTP Plugin
1. Install plugin SMTP pilihan anda
2. Pergi ke pengaturan plugin
3. Masukkan kredensial SMTP (ambil dari email provider anda)
4. Test koneksi untuk memastikan bekerja

### Step 3: Test Email
Trigger test dengan membuat pengaduan sampai tahap final, admin akan otomatis mengirim email percobaan.

---

## Testing

### Test 1: Mode Pertanyaan
1. Buka website
2. Klik chatbot button
3. Klik "❓ Pertanyaan"
4. Tanya: "jam kerja"
5. **Expected**: Chatbot menampilkan jawaban dari FAQ

### Test 2: Mode Pengaduan
1. Buka website
2. Klik chatbot button
3. Klik "📢 Pengaduan"
4. Input keluhan: "Layanan anda sangat lambat"
5. Input email: "user@example.com"
6. **Expected**: Pesan sukses tampil

### Test 3: Admin Balas Pengaduan
1. Login ke admin WordPress
2. Pergi ke menu "Pengaduan Chatbot"
3. Klik "Edit & Balas" pada pengaduan
4. Tulis jawaban: "Kami akan segera memperbaiki layanan kami"
5. Pilih status "Selesai"
6. Klik "Simpan & Kirim Email"
7. **Expected**: 
   - Pesan success tampil
   - Email terkirim ke user@example.com dengan jawaban dari admin

### Test 4: Validasi Email
1. Coba submit pengaduan dengan email invalid: "notanemail"
2. **Expected**: Error message "Email tidak valid"

---

## Troubleshooting

### Problem 1: Chatbot tidak muncul
**Solution**:
- Clear browser cache (Ctrl+F5)
- Pastikan plugin sudah diaktifkan
- Check console browser (F12) untuk JS error

### Problem 2: FAQ tidak menemukan jawaban
**Solution**:
- Verifikasi keyword di tabel `wp_chatbot_faq` sudah benar
- Keyword harus sesuai dengan pertanyaan user
- Contoh: keyword "jam kerja" akan match dengan "jam kerja berapa?"

### Problem 3: Email tidak terkirim
**Solution**:
- Install & setup plugin SMTP (recommended)
- Check `wp-content/debug.log` untuk error messages
- Verify email server configuration di WordPress

### Problem 4: Pengaduan tidak tersimpan
**Solution**:
- Check browser console (F12) untuk AJAX error
- Verify database connection
- Pastikan tabel `wp_pengaduan` sudah ada (check via PhpMyAdmin)

---

## FAQ Setup

### Q: Bagaimana format keyword yang benar?
A: Keyword bisa multiple, pisahkan dengan koma. Contoh:
```
"jam kerja, jam buka, jam operasional" → akan match semua keyword ini
```

### Q: Berapa maksimal karakter jawaban?
A: Tidak ada limit, tapi recommended maksimal 500 karakter untuk UX yang baik.

### Q: Bisa edit jawaban yang sudah ada?
A: Ya, pergi ke PhpMyAdmin → tabel `wp_chatbot_faq` → edit/update data.

### Q: Bagaimana jika email pelapor typo?
A: Jawaban admin tidak akan terkirim. Admin perlu edit email di halaman admin dan klik ulang "Simpan & Kirim Email".

---

## Maintenance

### Regular Backup
Backup database secara regular agar data FAQ dan pengaduan tidak hilang.

### Monitor Pengaduan
Check menu "Pengaduan Chatbot" secara berkala untuk memastikan tidak ada pengaduan yang pending terlalu lama.

### Update FAQ
Update FAQ secara berkala sesuai pertanyaan yang sering ditanyakan user.

---

## Support & Contact

Untuk pertanyaan lebih lanjut atau laporan bug, hubungi tim development.

---

**Last Updated**: May 2026  
**Plugin Version**: 2.0

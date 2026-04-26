# Blueprint Revisi Koperasi Sembako (E-Commerce Lanjutan)

Dokumen ini merupakan pembaruan arsitektur dan cetak biru (blueprint) untuk sistem E-Commerce Koperasi Sembako. Pembaruan ini fokus pada peningkatan kenyamanan pelanggan, transparansi pengiriman, resolusi masalah, dan integrasi Customer Service berbasis AI (Grok), dengan batasan tegas **tanpa gamifikasi** dan **tanpa sistem poin/reward**.

---

## 1. PEMBARUAN DOMAIN & MODULE

### 1.1 Module Pengiriman & Pelacakan (Shipments & Tracking)
*   **Tanggung Jawab:** Mengelola status fisik barang setelah pesanan diproses hingga tiba di tangan pelanggan.
*   **Entity Utama:** `Shipment`, `TrackingEvent`
*   **Relasi:** Terhubung langsung dengan `Order` (1-to-1) dan `User` (Customer).
*   **Alur Utama:** Seller menginput nomor resi/kurir -> Status order menjadi `shipped` -> Sistem mencatat `TrackingEvent` -> Customer melacak di halaman pesanan.
*   **Risiko Teknis:** Keterlambatan sinkronisasi status pengiriman dengan kurir eksternal.
*   **Solusi Pragmatis:** Untuk MVP, seller menginput status secara manual ("Dikemas", "Diperjalanan", "Terkirim"). Tersedia placeholder struktur API untuk integrasi kurir (RajaOngkir/BiteShip) di masa depan.

### 1.2 Module Pembatalan (Cancellations)
*   **Tanggung Jawab:** Menangani permintaan pembatalan dari pelanggan sebelum barang dikirim, atau penolakan pesanan oleh seller.
*   **Entity Utama:** `CancellationRequest` (Bisa di-embed di `Order` atau collection terpisah).
*   **Relasi:** Milik `Order`.
*   **Alur Utama:** Customer klik "Batalkan" -> Jika status `pending`, langsung batal & stok kembali. Jika `processing`, butuh persetujuan seller. Jika `shipped`, pembatalan ditolak.
*   **Risiko Teknis:** Race condition antara seller mengirim barang dan customer membatalkan.
*   **Solusi Pragmatis:** Validasi ketat di sisi backend: Jika status sudah `shipped`, tombol cancel hilang.

### 1.3 Module Ulasan (Reviews & Ratings)
*   **Tanggung Jawab:** Mengumpulkan feedback nyata dari pelanggan setelah pesanan berstatus `completed`.
*   **Entity Utama:** `Review`
*   **Relasi:** Milik `Product`, `User`, dan `Order`.
*   **Alur Utama:** Pesanan `completed` -> Customer diminta memberi rating 1-5 dan teks -> Rating terpublikasi (dengan label "Pembelian Terverifikasi").
*   **Risiko Teknis:** Spam review atau kata-kata kasar.
*   **Solusi Pragmatis:** Hanya memperbolehkan review jika ada `order_id` yang valid dengan status `completed` (Verified Buyer only).

### 1.4 Module AI Customer Support (Grok Integration)
*   **Tanggung Jawab:** Membantu navigasi pengguna, menjawab FAQ, dan memberikan troubleshooting dasar menggunakan LLM (Grok).
*   **Entity Utama:** `SupportSession`, `SupportMessage`
*   **Relasi:** Terikat pada `User` (opsional jika guest) dan `Order` (jika konteks chat tentang pesanan).
*   **Alur Utama:** User buka widget chat -> Ketik masalah -> Backend merakit *prompt* beserta konteks (histori pesanan user) -> Kirim ke API Grok -> Grok merespons -> Tampilkan ke user. Jika gagal, arahkan ke kontak WhatsApp CS.
*   **Risiko Teknis:** Halusinasi AI (memberi janji refund palsu), latency API, dan penyalahgunaan (abuse/spam).
*   **Solusi Pragmatis:** *System Prompt* yang sangat ketat ("Anda adalah asisten Koperasi Sembako. Anda TIDAK BISA melakukan refund. Arahkan pengguna ke halaman X"). Terapkan *Rate Limiting* (contoh: max 10 pesan/menit).

---

## 2. PEMBARUAN ARSITEKTUR DATABASE (MongoDB)

Skema dokumen akan diperluas secara *schema-less* tapi tetap terstruktur di model Eloquent:

### 2.1 Collection: `orders` (Revisi)
Ditambahkan tracking pengiriman dan pembatalan langsung di dalam order untuk mengurangi query join.
```json
{
  "_id": "ObjectId",
  "order_number": "KS-20240424-ABCDE",
  "status": "shipped", // pending -> processing -> shipped -> completed / cancelled
  "cancellation": {
    "requested_at": "2024-04-24T10:00:00Z",
    "reason": "Salah pilih alamat",
    "status": "approved", // requested, approved, rejected
    "rejected_reason": ""
  },
  "shipment": {
    "courier": "JNE Reguler",
    "tracking_number": "JNEXXX123456",
    "estimated_delivery": "2024-04-27T00:00:00Z",
    "tracking_events": [
       { "status": "Manifested", "location": "Jakarta", "timestamp": "2024-04-24T12:00:00Z" }
    ]
  }
}
```

### 2.2 Collection: `reviews` (Perluasan)
```json
{
  "_id": "ObjectId",
  "product_id": "ObjectId",
  "user_id": "ObjectId",
  "order_id": "ObjectId", // Memastikan pembelian terverifikasi
  "rating": 5, // 1-5
  "comment": "Berasnya pulen banget, pengiriman cepat.",
  "images": ["path/to/image1.jpg"], // Opsional
  "seller_reply": "Terima kasih atas ulasannya kak!",
  "is_verified_buyer": true,
  "created_at": "2024-04-24T10:00:00Z"
}
```

### 2.3 Collection: `support_sessions` (Baru)
Untuk log interaksi AI Grok guna keperluan audit dan peralihan ke manusia.
```json
{
  "_id": "ObjectId",
  "user_id": "ObjectId",
  "status": "active", // active, closed, escalated
  "escalated_at": null,
  "messages": [
    {
       "role": "user",
       "content": "Gimana cara lacak pesanan saya?",
       "timestamp": "2024-04-24T10:00:00Z"
    },
    {
       "role": "assistant",
       "content": "Anda bisa melacak pesanan melalui menu 'Pesanan Saya' lalu klik nomor pesanan Anda.",
       "timestamp": "2024-04-24T10:00:02Z"
    }
  ]
}
```

---

## 3. PEMBARUAN HALAMAN & UI UX

### 3.1 Customer App
1.  **Product Detail (Revisi):**
    *   Tampilan *Star Rating* di bawah judul produk.
    *   Estimasi pengiriman ke alamat *default* user ("Tiba kira-kira besok").
    *   Section *Reviews* dengan distribusi bintang (progress bar) dan daftar ulasan berlabel "Pembelian Terverifikasi".
2.  **Order Detail (Revisi):**
    *   **Shipment Tracker:** Visual timeline vertikal/horizontal (Diproses -> Dikirim -> Diterima).
    *   Tombol **"Lacak Paket"** jika menggunakan kurir eksternal.
    *   Tombol **"Batalkan Pesanan"** (Hanya muncul jika status `pending`).
    *   Tombol **"Beli Lagi (Reorder)"** jika pesanan sudah `completed`.
3.  **Halaman Pembatalan (Baru):**
    *   Formulir alasan pembatalan (Dropdown: Salah alamat, Berubah pikiran, Menemukan harga lebih murah, dll).
    *   Peringatan dampak pembatalan (Contoh: "Uang akan dikembalikan ke limit dalam 1x24 jam").
4.  **AI Customer Service Widget (Baru):**
    *   *Floating Action Button* (FAB) di pojok kanan bawah ("Chat Bantuan").
    *   Tampilan chat antarmuka modern yang menyambut dengan, *"Halo [Nama], saya Asisten Koperasi. Ada yang bisa saya bantu terkait pesanan Anda?"*

### 3.2 Seller Dashboard
1.  **Seller Order Detail (Revisi):**
    *   Input form untuk memasukkan Nama Kurir dan Nomor Resi.
    *   Tombol untuk "Terima Pembatalan" atau "Tolak Pembatalan" (dengan alasan).
2.  **Seller Reviews Insight (Baru):**
    *   Daftar ulasan yang masuk.
    *   Fitur membalas ulasan (*Seller Reply*).
    *   Indikator peringatan jika produk mendapat rating di bawah 3 bintang berturut-turut.

---

## 4. ARSITEKTUR INTEGRASI AI (GROK)

Integrasi Grok dirancang aman dan tidak merusak data (*Read-Only* context).

1.  **Frontend (Livewire / Alpine.js):** Widget chat melayang di seluruh aplikasi. Mengirim pesan via request Livewire `sendMessage()`.
2.  **Backend Controller/Service (`GrokSupportService`):**
    *   Menerima input user.
    *   **Context Injection:** Backend mengambil data krusial user seperti (Daftar 3 pesanan terakhir, Nama, Status Keranjang) dan memasukkannya ke *System Prompt*.
    *   **System Prompt:** *"Anda adalah CS Koperasi Sembako. Nama user adalah {name}. Pesanan terbarunya adalah {order_number} status {status}. Jangan buat data palsu. Jangan janjikan refund. Beri jawaban pendek dan ramah."*
3.  **API Call:** Mengirim *Prompt* via HTTP request ke API Grok (xAI).
4.  **Escalation Flow:** Jika user mengetik sentimen marah ("kecewa", "hubungi manusia", "komplain", "rusak"), AI akan merespons: *"Mohon maaf atas kendala ini. Silakan klik tombol di bawah ini untuk terhubung langsung dengan Agen CS kami via WhatsApp."* (Status session berubah menjadi `escalated`).

---

## 5. FITUR PENDUKUNG E-COMMERCE MATANG

Fitur-fitur esensial (tanpa gimmick) yang ditambahkan ke roadmap:
*   **Beli Lagi (Reorder):** Tombol di halaman Order History untuk menyalin semua item lama ke keranjang baru secara instan.
*   **Sticky Order Summary:** Ringkasan pembayaran yang melayang saat user men-scroll formulir checkout yang panjang.
*   **Invoice/Receipt Page:** Halaman khusus dengan tampilan bersih yang bisa langsung di-print atau diunduh PDF.
*   **Catatan Penjual (Packing Notes):** Seller bisa mencetak struk internal dengan catatan khusus dari pembeli ("Tolong dibungkus plastik tebal").
*   **Out-of-Stock Handling:** Jika barang habis saat di keranjang, beri tanda visual merah muda dan matikan tombol checkout sampai item dihapus.
*   **Recently Viewed:** Menyimpan ID produk di *Session/Cookie* untuk menampilkan section "Terakhir Dilihat".

---

## 6. ALUR BISNIS YANG DIPERBARUI

### Alur Pembatalan (Cancellation Flow)
1.  **Status Pending (Belum diproses):** Customer klik Batal -> Langsung batal (`cancelled`) -> Stok produk dikembalikan (+1).
2.  **Status Processing (Sedang dipacking):** Customer klik Batal -> Masuk antrean `cancellation.requested` -> Seller dapat notifikasi -> Seller klik Setuju (batal & stok kembali) ATAU Seller Tolak (misal kurir sudah jalan).
3.  **Status Shipped:** Tombol Batal hilang. Customer hanya bisa mengajukan komplain setelah barang tiba.

### Alur Pelacakan (Shipment Flow)
1.  Seller memproses order (`processing`).
2.  Seller memasukkan resi JNE: `JNEXXX` -> Order menjadi `shipped`.
3.  Sistem merekam event `Dikirim oleh Seller` ke array `tracking_events`.
4.  *(Di masa depan: CronJob mengecek API JNE setiap 6 jam untuk update `tracking_events`).*

---

## 7. PRIORITAS & URUTAN IMPLEMENTASI (ROADMAP)

Saya membagi fitur tambahan ini menjadi dua fase prioritas agar pengembangannya efisien:

### Fase 1: Wajib untuk MVP Lanjutan (Immediate Priority)
*Fondasi operasional yang tidak boleh ditinggalkan.*
1.  **Shipment Tracking Manual:** Mengubah status order jadi `shipped` dan input resi (Collection updates).
2.  **Order Cancellation Flow:** Fungsionalitas membatalkan pesanan bagi customer dan pengembalian stok (Mencegah kerugian).
3.  **Rating & Review (Basic):** Form rating bintang 1-5 setelah pesanan selesai, dan menampilkannya di Product Detail.
4.  **Reorder & Out-of-Stock Handling:** Mengunci checkout jika barang tiba-tiba habis.

### Fase 2: Setelah MVP Stabil (Secondary Priority)
*Peningkatan kecanggihan aplikasi.*
1.  **AI Grok Support Widget:** Membangun antarmuka chat dan menyambungkan ke API xAI. (Butuh API Key dan tuning prompt).
2.  **Invoice PDF Generator:** Menyediakan cetak struk profesional.
3.  **Seller Review Insight & Reply:** UI untuk seller membalas komentar pelanggan.
4.  **Recently Viewed Products.**

---

## 8. PROMPT LANJUTAN (NEXT ACTIONS)

Pilih salah satu prompt di bawah ini, copas dan kirimkan kembali kepada saya untuk mengeksekusi generasinya kodenya secara berurutan:

*   **Pilihan 1 (Pelacakan Pengiriman):**
    > *"Laksanakan Fase 1: Buat logika dan UI untuk Seller memasukkan nomor resi, ubah status pesanan menjadi shipped, dan buat tampilan tracking timeline di halaman order detail customer."*

*   **Pilihan 2 (Pembatalan Pesanan):**
    > *"Laksanakan Fase 1: Buat fitur pembatalan pesanan. Tambahkan tombol batal di order detail customer beserta modal alasan. Buat logika pengembalian stok (restock) secara otomatis jika status masih pending."*

*   **Pilihan 3 (Sistem Rating & Ulasan):**
    > *"Laksanakan Fase 1: Buat sistem Rating & Review. Buat form ulasan bagi pesanan yang sudah completed, dan tampilkan rata-rata bintang di halaman detail produk."*

*   **Pilihan 4 (Customer Service AI Grok):**
    > *"Laksanakan Fase 2: Buat widget chat AI Customer Service menggunakan Livewire Volt. Buat backend service untuk memanggil API Grok dengan memberikan konteks nama user dan pesanan terakhirnya."*

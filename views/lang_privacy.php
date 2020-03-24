<?php
if(empty($this->input->post('lang', TRUE))){
    $lang = 'eng';
}
else{
    $lang = $this->input->post('lang', TRUE);
}
$ind = '
<div id="ind" class="content">
<div class="header" style="position:relative; margin:auto; max-width:800px;">
    <h1 style="font-size: 24px; text-align:center; padding:18px; padding-top:32px;">Kebijakan Privasi</h1>
    <div style="background:rgba(100,100,100,0.5); padding:6px; position:absolute; bottom:-27px; right:16px; width:auto; text-align:right; cursor:pointer; z-index:3;">
    <div>
    	<div class="flag-icon flag-icon-gb" onclick="change(\'eng\')">
		<span style="background:rgba(100,100,100,0.5); position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>&nbsp;&nbsp;
		<div class="flag-icon flag-icon-id" onclick="change(\'ind\')">
		<span style="position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>
    </div>
    </div>
</div>
<div style="border: solid 1px #ddd; padding:12px; border-radius:12px; max-width:800px; margin:auto; background:#fff; max-height:600px; overflow-y:scroll; position:relative;">

<ol type="a" style="padding:0px 12px; padding-inline-start:26px; margin-top:0px;">
<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pendahuluan</h2>
    <p></p>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Tentang kebijakan ini</h2>
    <p>
    Adanya Kebijakan Privasi ini adalah komitmen nyata dari waterplus.com untuk menghargai dan
melindungi setiap informasi pribadi Pengguna situs waterplus.com ini. Kebijakan ini menjadi acuan
yang mengatur dan melindungi penggunaan data dan informasi penting para pengguna situs toko
online ini, yang telah dikumpulkan pada saat mendaftar, mengakses dan menggunakan layanan ini,
seperti alamat e-mail, nomor telepon, foto, gambar, dan lain-lain.
    </p>
    <h3>Kebijakan privasi kami :</h3>
    <ul>
        <li>
        Seluruh informasi pribadi yang Anda berikan kepada waterplus.com hanya akan digunakan
        dan dilindungi oleh waterplus.com. Setiap informasi yang Anda berikan terbatas untuk
        tujuan proses yang berkaitan dengan waterplus.com dan tanpa tujuan lainnya.
        </li>
        <li>
        Kami dapat mengubah Kebijakan Privasi ini dari waktu ke waktu dengan melakukan
        pengurangan ataupun penambahan ketentuan pada halaman ini. Anda dianjurkan untuk
        membaca Kebijakan Privasi ini secara berkala agar mengetahui perubahan-perubahan
        terbaru.
        </li>
        <li>
        Kami sangat memperhatikan betul keamanan dan privasi pelanggan kami, dan kami hanya
        akan mengumpulkan informasi pribadi Anda yang hanya kami perlukan untuk kepentingan
        internal kami saja. Perlindungan data dan informasi pelanggan merupakan privasi yang
        harus kami jaga penuh untuk menjaga kepercayaan Anda terhadap kami.
        </li>
        <li>
        Kami hanya akan menggunakan data dan informasi Anda sebagaimana yang dinyatakan
        dalam Kebijakan Privasi berikut. Kami hanya akan mengumpulkan dan menggunakan
        informasi yang berhubungan dengan transaksi kami dengan Anda.
        </li>
        <li>
        waterplus.com tidak bertanggung jawab atas pertukaran data yang dilakukan sendiri di
        antara pengguna situs
        </li>
        <li>
        Kami hanya akan menyimpan informasi privasi Anda sepanjang kami diwajibkan oleh
        hukum atau selama informasi tersebut masih berhubungan dengan tujuan awal pengumpulan
        informasi tersebut.
        </li>
    </ul>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Informasi apa yang kami kumpulkan</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pemesanan bisa Anda lakukan untuk tujuan pengiriman ke seluruh wilayah yang terlayani oleh
pihak jasa ekspedisi yang kami tunjuk. Untuk mempercepat proses pemesanan, silakan konfirmasi
ke Customer Service kami setelah Anda melakukan pemesanan.</li>
        <li>Keterangan mengenai produk dan cara belanja di waterplus.com kami anggap telah Anda pelajari
terlebih dahulu.</li>
        <li>Kami meng-update informasi produk hanya pada produk yang harus diupdate. Tetapi, jika ada
kesalahan teknis yang menyebabkan harga, stok, atau informasi lainnya menjadi tidak benar dan
Anda terlanjur melakukan pemesanan, maka kami akan menginformasikan dan memberi pilihan
kepada Anda untuk tetap memesan produk tersebut atau membatalkannya.</li>
        <li>Kami memberikan batas waktu pembayaran selama 1x24 jam sejak Anda menyelesaikan transaksi
pembelian. Apabila Anda belum melakukan pembayaran setelah batas waktu tersebut, maka kami
dapat membatalkan pesanan Anda.</li>
        <li>Pembatalan pesanan dapat Anda lakukan sebelum pembayaran. Jika Anda telah melakukan
pembayaran, pesanan tidak dapat Anda batalkan. Anda hanya diperbolehkan melakukan penukaran
pesanan dengan produk lain sesuai jumlah pembayaran yang Anda tunaikan. Penukaran pesananakan diproses melalui transaksi offline. Silakan hubungi Customer Service kami melalui telepon
atau email.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pembayaran</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Mata uang yang dipakai untuk pembayaran adalah Rupiah (Rp).</li>
        <li>Pembayaran bisa melalui transfer ke rekening bank yang kami informasikan kepada Anda.</li>
        <li>Pembayaran dianggap lunas jika uang telah kami terima sesuai dengan jumlah yang harus
dibayarkan. Segera lakukan konfirmasi kepada kami melalui fitur Konfirmasi Pembayaran yang
tersedia di waterplus.com.</li>
        <li>Keterlambatan proses transfer antarbank bukan tanggung jawab kami.</li>
        <li>Kelalaian penulisan rekening dan informasi lainnya atau kelalaian pihak bank pada saat Anda melakukan pembayaran bukan tanggung jawab kami.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pengiriman</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pesanan Anda akan kami kirim segera setelah pembayaran lunas. Status pengiriman / nomor resi akan kami informasikan melalui fitur "order->view invoice" di waterplus.com. Jika diperlukan, nomor resi pengiriman dapat kami informasikan melalui email Anda.</li>
        <li>Pesanan Anda akan kami kirim ke alamat yang Anda berikan saat transaksi pemesanan.</li>
        <li>Kesalahan Anda dalam memberikan alamat pengiriman sehingga menyebabkan paket kiriman
        tidak sampai atau tidak Anda terima bukan tanggung jawab kami.</li>
        <li>Pengiriman dilakukan oleh pihak jasa ekspedisi yang kami tunjuk sebagaimana telah kami
        tampilkan saat Anda melakukan transaksi pemesanan. Biaya pengiriman ditanggung oleh pembeli.</li>
        <li>Lama waktu pengiriman menyesuaikan paket ekspedisi yang Anda pilih saat transaksi pemesanan. Jaminan kepastian waktu pengiriman sepenuhnya menjadi tanggung jawab pihak jasa ekspedisi. Konpensasi atas keterlambatan dan atau kehilangan barang sepenuhnya tunduk pada peraturan pihak jasa ekspedisi.</li>
        <li>Anda dapat memantau status pengiriman melalui layanan “tracking” pada website dan Call
        Center pihak jasa ekspedisi yang bersangkutan. Anda juga dapat meminta bantuan kami untuk
        mengetahui status pengiriman pesanan Anda.</li>
        <li>Setelah paket kiriman Anda terima, segera konfirmasikan kepada kami melalui layanan "Hubungi Kami" atau informasi kontak kami (telp/email) yang tersedia di Tokoalvabet.com. Apabila Anda tidak melakukan konfirmasi penerimaan barang setelah 7 (tujuh) hari dari batas waktu perkiraan kiriman sampai di tujuan, maka kami anggap kiriman tersebut telah Anda terima.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Penukaran Produk</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Kami pastikan pesanan Anda telah kami cek ulang sesuai data pesanan serta kami kemas dengan baik sebelum kami kirim. Pada saat menerima paket kiriman, Anda wajib melakukan pengecekan terhadap kondisi produk.</li>
        <li>Jika produk yang Anda terima tidak sesuai data pesanan atau terdapat cacat produksi, maka produk tersebut dapat ditukarkan dengan produk yang sama kepada kami.</li>
        <li>Biaya pengiriman/pengembalian produk tidak sesuai pesanan atau cacat produksi kepada kami ditanggung oleh pembeli, sedangkan biaya pengiriman produk pengganti kepada Anda ditanggung oleh kami.</li>
        <li>Pemberitahuan penerimaan produk tidak sesuai pesanan atau cacat produksi kami layani paling lambat 7 (tujuh) hari sejak produk Anda terima. Jika dalam batas waktu tersebut tidak ada pemberitahuan, maka produk yang kami kirimkan dianggap telah sesuai dengan data pesanan Anda dan tidak cacat produksi.</li>
        <li>Produk pengganti akan kami kirimkan kepada Anda segera setelah kami menerima dan
        memverifikasi pengembalian produk tidak sesuai pesanan atau cacat produksi dari Anda.
        Cantumkan keterangan mengenai produk yang Anda kirimkan kembali kepada kami untuk
        memudahkan kami melakukan verifikasi.</li>
        <li>Jika stok produk pengganti tidak tersedia di gudang, kami akan mengirimkannya setelah stok produk kembali tersedia. Dan jika stok produk pengganti telah habis, Anda dapat menukarnya dengan produk lain yang harganya sama (atau setara) atau Anda dapat meminta pengembalian uang sesuai jumlah yang telah Anda bayarkan kepada kami.</li>
        <li>Produk yang Anda beli di luar waterplus.com tidak dapat dikembalikan/ditukarkan kepada kami.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pengembalian Uang (Refund)</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pengembalian uang (refund) hanya berlaku untuk produk yang Anda tukarkan dan kami tidak dapat mengirimkan kembali produk pengganti kepada Anda karena stok habis.</li>
        <li>Pengembalian uang dilakukan dalam waktu 10 hari kerja, terhitung sejak tanggal kesepakatan refund.</li>
        <li>Besarnya uang yang dikembalikan sesuai dengan jumlah yang tertera pada invoice untuk produk tersebut, ditambah ongkos kirim penukaran/pengembalian dari Anda kepada kami; sedangkan ongkos pengiriman produk dari kami kepada Anda tidak dapat diminta kembali.</li>
        <li>Pengembalian uang dilakukan melalui transfer ulang ke rekening Anda.</li>
        <li>Kami akan memberikan konfirmasi kepada Anda dalam bentuk email bahwa pengembalian uang
        telah kami lakukan.</li>
    </ol>
</li>
</ol>

</div>
<br><br>
</div>';

$eng = '
<div id="ind" class="content">
<div class="header" style="position:relative; margin:auto; max-width:800px;">
    <h1 style="font-size: 24px; text-align:center; padding:18px; padding-top:32px;">Kebijakan Privasi</h1>
    <div style="background:rgba(100,100,100,0.5); padding:6px; position:absolute; bottom:-27px; right:16px; width:auto; text-align:right; cursor:pointer; z-index:3;">
    <div>
    	<div class="flag-icon flag-icon-gb" onclick="change(\'eng\')">
		<span style="background:rgba(100,100,100,0.5); position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>&nbsp;&nbsp;
		<div class="flag-icon flag-icon-id" onclick="change(\'ind\')">
		<span style="position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>
    </div>
    </div>
</div>
<div style="border: solid 1px #ddd; padding:12px; border-radius:12px; max-width:800px; margin:auto; background:#fff; max-height:600px; overflow-y:scroll; position:relative;">

<ol type="a" style="padding:0px 12px; padding-inline-start:26px; margin-top:0px;">
<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pendahuluan</h2>
    <p></p>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Tentang kebijakan ini</h2>
    <p>
    Adanya Kebijakan Privasi ini adalah komitmen nyata dari waterplus.com untuk menghargai dan
melindungi setiap informasi pribadi Pengguna situs waterplus.com ini. Kebijakan ini menjadi acuan
yang mengatur dan melindungi penggunaan data dan informasi penting para pengguna situs toko
online ini, yang telah dikumpulkan pada saat mendaftar, mengakses dan menggunakan layanan ini,
seperti alamat e-mail, nomor telepon, foto, gambar, dan lain-lain.
    </p>
    <h3>Kebijakan privasi kami :</h3>
    <ul>
        <li>
        Seluruh informasi pribadi yang Anda berikan kepada waterplus.com hanya akan digunakan
        dan dilindungi oleh waterplus.com. Setiap informasi yang Anda berikan terbatas untuk
        tujuan proses yang berkaitan dengan waterplus.com dan tanpa tujuan lainnya.
        </li>
        <li>
        Kami dapat mengubah Kebijakan Privasi ini dari waktu ke waktu dengan melakukan
        pengurangan ataupun penambahan ketentuan pada halaman ini. Anda dianjurkan untuk
        membaca Kebijakan Privasi ini secara berkala agar mengetahui perubahan-perubahan
        terbaru.
        </li>
        <li>
        Kami sangat memperhatikan betul keamanan dan privasi pelanggan kami, dan kami hanya
        akan mengumpulkan informasi pribadi Anda yang hanya kami perlukan untuk kepentingan
        internal kami saja. Perlindungan data dan informasi pelanggan merupakan privasi yang
        harus kami jaga penuh untuk menjaga kepercayaan Anda terhadap kami.
        </li>
        <li>
        Kami hanya akan menggunakan data dan informasi Anda sebagaimana yang dinyatakan
        dalam Kebijakan Privasi berikut. Kami hanya akan mengumpulkan dan menggunakan
        informasi yang berhubungan dengan transaksi kami dengan Anda.
        </li>
        <li>
        waterplus.com tidak bertanggung jawab atas pertukaran data yang dilakukan sendiri di
        antara pengguna situs
        </li>
        <li>
        Kami hanya akan menyimpan informasi privasi Anda sepanjang kami diwajibkan oleh
        hukum atau selama informasi tersebut masih berhubungan dengan tujuan awal pengumpulan
        informasi tersebut.
        </li>
    </ul>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Informasi apa yang kami kumpulkan</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pemesanan bisa Anda lakukan untuk tujuan pengiriman ke seluruh wilayah yang terlayani oleh
pihak jasa ekspedisi yang kami tunjuk. Untuk mempercepat proses pemesanan, silakan konfirmasi
ke Customer Service kami setelah Anda melakukan pemesanan.</li>
        <li>Keterangan mengenai produk dan cara belanja di waterplus.com kami anggap telah Anda pelajari
terlebih dahulu.</li>
        <li>Kami meng-update informasi produk hanya pada produk yang harus diupdate. Tetapi, jika ada
kesalahan teknis yang menyebabkan harga, stok, atau informasi lainnya menjadi tidak benar dan
Anda terlanjur melakukan pemesanan, maka kami akan menginformasikan dan memberi pilihan
kepada Anda untuk tetap memesan produk tersebut atau membatalkannya.</li>
        <li>Kami memberikan batas waktu pembayaran selama 1x24 jam sejak Anda menyelesaikan transaksi
pembelian. Apabila Anda belum melakukan pembayaran setelah batas waktu tersebut, maka kami
dapat membatalkan pesanan Anda.</li>
        <li>Pembatalan pesanan dapat Anda lakukan sebelum pembayaran. Jika Anda telah melakukan
pembayaran, pesanan tidak dapat Anda batalkan. Anda hanya diperbolehkan melakukan penukaran
pesanan dengan produk lain sesuai jumlah pembayaran yang Anda tunaikan. Penukaran pesananakan diproses melalui transaksi offline. Silakan hubungi Customer Service kami melalui telepon
atau email.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pembayaran</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Mata uang yang dipakai untuk pembayaran adalah Rupiah (Rp).</li>
        <li>Pembayaran bisa melalui transfer ke rekening bank yang kami informasikan kepada Anda.</li>
        <li>Pembayaran dianggap lunas jika uang telah kami terima sesuai dengan jumlah yang harus
dibayarkan. Segera lakukan konfirmasi kepada kami melalui fitur Konfirmasi Pembayaran yang
tersedia di waterplus.com.</li>
        <li>Keterlambatan proses transfer antarbank bukan tanggung jawab kami.</li>
        <li>Kelalaian penulisan rekening dan informasi lainnya atau kelalaian pihak bank pada saat Anda melakukan pembayaran bukan tanggung jawab kami.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pengiriman</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pesanan Anda akan kami kirim segera setelah pembayaran lunas. Status pengiriman / nomor resi akan kami informasikan melalui fitur "order->view invoice" di waterplus.com. Jika diperlukan, nomor resi pengiriman dapat kami informasikan melalui email Anda.</li>
        <li>Pesanan Anda akan kami kirim ke alamat yang Anda berikan saat transaksi pemesanan.</li>
        <li>Kesalahan Anda dalam memberikan alamat pengiriman sehingga menyebabkan paket kiriman
        tidak sampai atau tidak Anda terima bukan tanggung jawab kami.</li>
        <li>Pengiriman dilakukan oleh pihak jasa ekspedisi yang kami tunjuk sebagaimana telah kami
        tampilkan saat Anda melakukan transaksi pemesanan. Biaya pengiriman ditanggung oleh pembeli.</li>
        <li>Lama waktu pengiriman menyesuaikan paket ekspedisi yang Anda pilih saat transaksi pemesanan. Jaminan kepastian waktu pengiriman sepenuhnya menjadi tanggung jawab pihak jasa ekspedisi. Konpensasi atas keterlambatan dan atau kehilangan barang sepenuhnya tunduk pada peraturan pihak jasa ekspedisi.</li>
        <li>Anda dapat memantau status pengiriman melalui layanan “tracking” pada website dan Call
        Center pihak jasa ekspedisi yang bersangkutan. Anda juga dapat meminta bantuan kami untuk
        mengetahui status pengiriman pesanan Anda.</li>
        <li>Setelah paket kiriman Anda terima, segera konfirmasikan kepada kami melalui layanan "Hubungi Kami" atau informasi kontak kami (telp/email) yang tersedia di Tokoalvabet.com. Apabila Anda tidak melakukan konfirmasi penerimaan barang setelah 7 (tujuh) hari dari batas waktu perkiraan kiriman sampai di tujuan, maka kami anggap kiriman tersebut telah Anda terima.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Penukaran Produk</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Kami pastikan pesanan Anda telah kami cek ulang sesuai data pesanan serta kami kemas dengan baik sebelum kami kirim. Pada saat menerima paket kiriman, Anda wajib melakukan pengecekan terhadap kondisi produk.</li>
        <li>Jika produk yang Anda terima tidak sesuai data pesanan atau terdapat cacat produksi, maka produk tersebut dapat ditukarkan dengan produk yang sama kepada kami.</li>
        <li>Biaya pengiriman/pengembalian produk tidak sesuai pesanan atau cacat produksi kepada kami ditanggung oleh pembeli, sedangkan biaya pengiriman produk pengganti kepada Anda ditanggung oleh kami.</li>
        <li>Pemberitahuan penerimaan produk tidak sesuai pesanan atau cacat produksi kami layani paling lambat 7 (tujuh) hari sejak produk Anda terima. Jika dalam batas waktu tersebut tidak ada pemberitahuan, maka produk yang kami kirimkan dianggap telah sesuai dengan data pesanan Anda dan tidak cacat produksi.</li>
        <li>Produk pengganti akan kami kirimkan kepada Anda segera setelah kami menerima dan
        memverifikasi pengembalian produk tidak sesuai pesanan atau cacat produksi dari Anda.
        Cantumkan keterangan mengenai produk yang Anda kirimkan kembali kepada kami untuk
        memudahkan kami melakukan verifikasi.</li>
        <li>Jika stok produk pengganti tidak tersedia di gudang, kami akan mengirimkannya setelah stok produk kembali tersedia. Dan jika stok produk pengganti telah habis, Anda dapat menukarnya dengan produk lain yang harganya sama (atau setara) atau Anda dapat meminta pengembalian uang sesuai jumlah yang telah Anda bayarkan kepada kami.</li>
        <li>Produk yang Anda beli di luar waterplus.com tidak dapat dikembalikan/ditukarkan kepada kami.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pengembalian Uang (Refund)</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Pengembalian uang (refund) hanya berlaku untuk produk yang Anda tukarkan dan kami tidak dapat mengirimkan kembali produk pengganti kepada Anda karena stok habis.</li>
        <li>Pengembalian uang dilakukan dalam waktu 10 hari kerja, terhitung sejak tanggal kesepakatan refund.</li>
        <li>Besarnya uang yang dikembalikan sesuai dengan jumlah yang tertera pada invoice untuk produk tersebut, ditambah ongkos kirim penukaran/pengembalian dari Anda kepada kami; sedangkan ongkos pengiriman produk dari kami kepada Anda tidak dapat diminta kembali.</li>
        <li>Pengembalian uang dilakukan melalui transfer ulang ke rekening Anda.</li>
        <li>Kami akan memberikan konfirmasi kepada Anda dalam bentuk email bahwa pengembalian uang
        telah kami lakukan.</li>
    </ol>
</li>
</ol>

</div>
<br><br>
</div>';

if (!$this->input->is_ajax_request()) {
    return strtolower($$lang);
}
else{
    echo strtolower($$lang);
}

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart', 'encryption','session','Recaptcha'));
		$this->load->model('app');
	}

	public function index($offset=0)
	{
	  //if uri segment is home
	  if($this->uri->segment(2) == 'home' || $this->uri->segment(2) == ''){
	  $this->load->library('pagination');
      //configure
      $config['base_url'] = base_url();
      $config['total_rows'] = $this->app->get_all('t_items')->num_rows();
      $config['per_page'] = 6;
      $config['uri_segment'] = 3;

      $this->pagination->initialize($config);

      $data['link']  = $this->pagination->create_links();

		if ($this->session->userdata('user_login') == TRUE)
		{
			$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
			$arraydata = array(
                'user'  => $this->session->userdata('user_id')
        	);
        	$this->session->set_userdata($arraydata);
		}
		$data['user'] 		= $this->session->userdata('user');
		$data['data']		= $this->db->order_by('id_item','desc');
      	$data['data'] 		= $this->app->select_where_limit('t_items', ['aktif' => 1], $config['per_page'], $offset);
      	$data['title'] 		= "our products";
      	$data['metadeskripsi'] = "anda dapat melihat katalog bath & kitchen, waterpumps, water filters, home & living untuk keperluan rumah anda";
		$this->template->olshop('home', $data);
	  } //end if home
	}

	public function terms_and_condition()
	{
		$data['title'] 		= "terms and condition";
		$data['keterangan'] = $this->lang_terms();
		$this->template->olshop('terms', $data);
	}

	public function lang_terms()
	{
		//if (!$this->input->is_ajax_request()) {

		//	redirect('terms-and-conditions');

		//} else {
			if(empty($this->input->post('lang', TRUE))){
				$lang = 'eng';
			}
			else{
				$lang = $this->input->post('lang', TRUE);
			}
$ind = '
<div id="ind" class="content">
<div class="header" style="position:relative; margin:auto; max-width:800px;">
    <h1 style="font-size: 24px; text-align:center; padding:18px; padding-top:32px;">SYARAT & KETENTUAN</h1>
    <div style="background:rgba(100,100,100,0.5); padding:6px; position:absolute; bottom:-27px; right:16px; width:auto; text-align:right; z-index:3;">
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

<ol type="a" style="padding:0px 12px; padding-inline-start:26px;">
<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Ketentuan Umum</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Dengan menggunakan, berbelanja dan mendaftarkan diri Anda di waterplus.com, berarti Anda
setuju untuk terikat dan patuh pada syarat dan ketentuan yang berlaku.</li>
        <li>Syarat dan ketentuan ini dapat berubah sewaktu-waktu dan kami tidak berkewajiban untuk
memberitahukannya kepada Anda.</li>
        <li>Syarat dan ketentuan ini kami buat untuk kepentingan bersama, untuk menjaga hak dan kewajiban
masing-masing pihak, dan tidak dimaksudkan untuk merugikan salah satu pihak.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Informasi Produk</h2>
    <ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
        <li>Dengan melakukan transaksi pemesanan secara online di waterplus.com, Anda kami anggap telah
mengerti informasi produk yang akan Anda beli.</li>
        <li>Produk yang tersedia di waterplus.com sesuai dengan katalog online dan detail produk. Kami
berusaha menyajikan data seakurat mungkin tanpa rekayasa agar Anda selaku pembeli tidak
dirugikan.</li>
        <li>Perbedaan warna dalam foto/gambar produk yang kami tampilkan di waterplus.com bisa
diakibatkan oleh faktor pencahayaan dan setting/resolusi monitor komputer, dan karena itu tidak
dapat dijadikan acuan.</li>
        <li>Harga produk dalam situs ini adalah benar pada saat dicantumkan.</li>
        <li>Harga yang tercantum adalah harga produk semata, tidak termasuk ongkos kirim. Ongkos kirim
dihitung otomatis (berdasarkan harga dari jasa ekspedisi) sesuai dengan alamat pengiriman yang
Anda berikan pada saat transaksi pemesanan.</li>
    </ol>
</li>

<li>
    <h2 style="font-size: 20px; padding:12px 6px;">Pemesanan dan Pembatalan</h2>
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
</div>
';

$eng = '
<div id="eng" class="content">
<div class="header" style="position:relative; margin:auto; max-width:800px;">
	<h1 style="font-size: 24px; text-align:center; padding:18px; padding-top:32px;">TERMS & CONDITIONS</h1>
	<div style="background:rgba(100,100,100,0.5); padding:6px; position:absolute; bottom:-27px; right:16px; width:auto; text-align:right; z-index:3;">
	<div>
		<div class="flag-icon flag-icon-gb" onclick="change(\'eng\')">
		<span style="position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>&nbsp;&nbsp;
		<div class="flag-icon flag-icon-id" onclick="change(\'ind\')">
		<span style="background:rgba(100,100,100,0.5); position:absolute; top:0; left:0; width:100%;">&nbsp;</span>
		</div>
	</div>
	</div>
</div>
<div style="border: solid 1px #ddd; padding:12px; border-radius:12px; max-width:800px; margin:auto; background:#fff; max-height:600px; overflow-y:scroll; position:relative;">

<ol type="a" style="padding:0px 12px; padding-inline-start:26px;">
<li>
	<h2 style="font-size: 20px; padding:12px 6px;">general requirements</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>by using, shopping and registering yourself at waterplus.com, you agree to be bound and abide by the terms and conditions that apply.</li>
		<li>these terms and conditions are subject to change at any time and we are not obliged to inform you.</li>
		<li>we make these terms and conditions for the common good, to protect the rights and obligations of each party, and are not intended to harm either party.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">product information</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>By making an order transaction online at waterplus.com, we assume you understand the product information that you will buy.</li>
		<li>Products available at waterplus.com according to the online catalog and product details. We strive to present data as accurately as possible without engineering so that you as the buyer are not disadvantaged.</li>
		<li>Color differences in the photos / images of products that we display on Waterplus.com can be caused by lighting factors and computer monitor settings / resolutions, and therefore cannot be used as a reference.</li>
		<li>Product prices on this site are correct at the time of listing.</li>
		<li>The price listed is the price of the product alone, not including postage. Shipping costs are calculated automatically (based on the price of the shipping service) according to the shipping address you provided at the time of the order transaction.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">reservations and cancellations</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>You can place an order for the purpose of shipping to all areas served by the shipping service that we designate. To speed up the order process, please confirm to our customer service after you place an order.</li>
		<li>information about the product and how to shop at waterplus.com we assume you have learned it first.</li>
		<li>We update product information only on products that must be updated. However, if there is a technical error that causes the price, stock, or other information to be incorrect and you have already placed an order, we will inform you and give you the choice to continue to order the product or cancel it.</li>
		<li>We provide a payment deadline of 1x24 hours since you complete a purchase transaction. If you have not made payment after the deadline, then we can cancel your order.</li>
		<li>Cancellation of the order you can do before payment. If you have made a payment, you cannot cancel the order. You are only allowed to exchange orders with other products according to the payment amount that you are paying. Exchange orders will be processed through offline transactions. please contact our customer service via telephone or email.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">payment</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>The currency used for payment is Rupiah (Rp).</li>
		<li>payment can be through a transfer to a bank account that we inform you.</li>
		<li>payment is considered to be paid off if the money we have received in accordance with the amount to be paid. immediately confirm to us through the payment confirmation feature available at waterplus.com.</li>
		<li>delays in the process of interbank transfers are not our responsibility.</li>
		<li>negligence of account writing and other information or negligence of the bank when you make payment is not our responsibility.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">delivery</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>Your order will be sent immediately after payment is paid. We will inform you of the delivery status / receipt number via the "order-> view invoice" feature on waterplus.com. if needed, we can inform the shipping receipt number via your email.</li>
		<li>Your order will be sent to the address you provided during the order transaction.</li>
		<li>Your mistake in giving the delivery address so that the package does not arrive or you do not receive is not our responsibility.</li>
		<li>delivery is carried out by the shipping service that we designate as we have shown when you make an order transaction. Shipping costs borne by the buyer.</li>
		<li>the shipping time adjusts the shipping package that you chose during the order transaction. guaranteed delivery time is fully the responsibility of the shipping service. compensation for the delay and / or loss of goods is fully subject to the regulations of the shipping service.</li>
		<li>You can monitor the status of the shipment through the "tracking" service on the website and the call center of the expedition service provider. You can also ask for our help to find out the delivery status of your order.</li>
		<li>After the package you have received, immediately confirm with us via the "contact us" service or our contact information (tel / email) available at tokoalvabet.com. If you do not confirm receipt of goods after 7 (seven) days from the time limit for the estimated shipment to arrive at the destination, then we assume that you have received the shipment.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">product exchange</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>we make sure your order has been re-checked according to the order data and we pack it well before we send. when receiving a shipment package, you must check the condition of the product.</li>
		<li>If the product you receive does not match the order data or there is a production defect, then the product can be exchanged for the same product for us.</li>
		<li>The cost of shipping / returning the product does not match the order or production defects to us borne by the buyer, while the cost of shipping the replacement product to you is borne by us.</li>
		<li>notification of receipt of products not according to order or production defects we serve no later than 7 (seven) days from the product you receive. if within the time limit there is no notification, then the product we send is considered to be in accordance with your order data and is not defective in production.</li>
		<li>We will send a replacement product to you as soon as we receive and verify a product return that does not match the order or production defect from you. include information about the product you sent back to us to make it easier for us to verify.</li>
		<li>If the replacement product stock is not available in the warehouse, we will send it after the product stock is available again. and if the replacement product stock has run out, you can exchange it for other products that have the same price (or equivalent) or you can request a refund according to the amount you have paid to us.</li>
		<li>Products that you buy outside of Waterplus.com cannot be returned / exchanged with us.</li>
	</ol>
</li>

<li>
	<h2 style="font-size: 20px; padding:12px 6px;">Refunds</h2>
	<ol style="font-size:14px; text-align:justify; line-height: 20px; margin:0; padding-inline-start:26px;">
		<li>Refunds only apply to the product you are exchanging and we cannot send you a replacement product again because the stock is out.</li>
		<li>Refunds are made within 10 working days, starting from the date of the refund agreement.</li>
		<li>the amount of money returned is in accordance with the amount stated on the invoice for the product, plus the exchange / return shipping cost from you to us, while the cost of shipping the product from us to you is not refundable.</li>
		<li>Refunds are made via a re-transfer to your account.</li>
		<li>We will provide confirmation to you in the form of an email that we have refunded.</li>
	</ol>
</li>
</ol>

</div>
<br><br>
</div>
';
if (!$this->input->is_ajax_request()) {

	return strtolower($$lang);

}
else{
	echo strtolower($$lang);
}
		//}
	}

	public function search()
	{
		if ($this->input->get('search', TRUE))
		{
			$search = $this->input->get('search', TRUE);

		} else {

			$search = $this->uri->segment(2);

		}

		if (!$this->uri->segment(3))
		{

			$offset = 0;

		} else {

			$offset = $this->uri->segment(3);

		}

		$this->load->library('pagination');
      //configure
      $config['base_url'] = base_url().'search/'.$search.'/';
      $config['total_rows'] = $this->app->get_like('t_items', ['aktif' => 1], ['nama_item' => $search])->num_rows();
      $config['per_page'] = 24;
      $config['uri_segment'] = 3;

      $this->pagination->initialize($config);
      if ($this->session->userdata('user_login') == TRUE)
	  {
		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
	  }
      $data['link']  = $this->pagination->create_links();
      $data['data'] 	= $this->app->select_like('t_items', ['aktif' => 1], ['nama_item' => $search], $config['per_page'], $offset);
		$data['search'] = $search;
		$data['title'] 		= "search results " . $search;
		$data['metadeskripsi'] = "search results " . $search;
		$data['total_row'] = $config['total_rows'];
		$this->template->olshop('search', $data);

	}

	public function subscribe()
	{
date_default_timezone_set("Asia/Bangkok");
$today = date("Y-m-d H:i:s");
$tgl = date("ymd");
$this->load->view('classes/class.phpmailer.php');
function send_email($email){
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "mail.waterplus.com"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "no-reply@waterplus.com"; //user email
$mail->Password = "Waterplus2019"; //password email 
$mail->SetFrom("no-reply@waterplus.com","waterplus+"); //set email pengirim
$mail->Subject = "thank you for signing up to our newsletter"; //subyek email
$mail->AddAddress($email,"");  //tujuan email
$message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=640">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="margin: 0; font-family: bariol_regular; white-space: normal;">
    <table style="min-width: 700px; width: 100%; max-width: 1024px; margin: auto;">
        <tr>
            <td colspan="2" style="padding: 0px 12px;">
                <div style="display:inline-flex; height:60px; float: left;">
                    <img style="margin: auto;" src="http://www.waterplus.com/img/email/logo1.png" alt="logo waterplus">
                </div>
                <div style="display:inline-flex; height:60px; float: right;">
                    <span style="margin:auto 6px;"><a style=" color: #666; text-decoration: none;" href="https://www.waterplus.com/?page=ourstory">our story</a></span>
                    <span style="margin:auto 6px;"><a style=" color: #666; text-decoration: none;" href="https://www.waterplus.com/?page=whyus">why us</a></span>
                    <span style="margin:auto 6px;"><a style=" color: #666; text-decoration: none;" href="https://www.waterplus.com/our-products">our products</a></span>
                    <span style="margin:auto 6px;"><a style=" color: #666; text-decoration: none;" href="https://www.waterplus.com/?page=one_for_one">one for one</a></span>
                    <span style="margin:auto 6px;"><a style=" color: #666; text-decoration: none;" href="https://www.waterplus.com/?page=showroom">contact</a></span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="box" style="height: 320px; display: flex; background: url(http://www.waterplus.com/img/email/bath.jpg); background-size: cover; background-position: center center;">
                    <div style="margin: auto;">
                        <a style="text-decoration: none;" href="https://www.waterplus.com/our-products/bath-and-kitchen.html">
                            <p style="font-size: 32px; color: #fff; text-shadow:0px 0px 6px #000; padding: 32px;">&nbsp;</p>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="padding: 12px;">
                    <p style="text-align: center; margin:6px; font-size: 24px;">
                        thank you for signing up to our newsletter
                    </p>
                    <p style="text-align: center; margin:6px; font-size: 18px;">
                        stay tuned for our upcoming promotions!
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="box" style="height: 320px; display: flex; background: url(http://www.waterplus.com/img/email/bath-and-kitchen.png); background-size: cover; background-position: center center;">
                    <div style="margin: auto;">
                        <a style="text-decoration: none;" href="https://www.waterplus.com/our-products/bath-and-kitchen.html">
                            <p style="font-size: 32px; color: #fff; text-shadow:0px 0px 6px #000; padding: 32px;">bath & kitchen</p>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="box" style="height: 320px; display: flex; background: url(http://www.waterplus.com/img/email/shallow-submersible-pumps.png); background-size: cover; background-position: center center;">
                    <div style="margin: auto;">
                        <a style="text-decoration: none;" href="https://www.waterplus.com/our-products/water-pumps.html">
                            <p style="font-size: 32px; color: #fff; text-shadow:0px 0px 6px #000; padding: 32px;">water pumps</p>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%;">
                <div class="box2" style="height: 320px; display: flex; background: url(http://www.waterplus.com/img/email/water-filters.png); background-size: cover; background-position: center center;">
                    <div style="margin: auto;">
                        <a style="text-decoration: none;" href="https://www.waterplus.com/our-products/water-filters.html">
                            <p style="font-size: 32px; color: #fff; text-shadow:0px 0px 6px #000; padding: 32px;">water filters</p>
                        </a>
                    </div>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="box2" style="height: 320px; display: flex; background: url(http://www.waterplus.com/img/email/water-bottles.png); background-size: cover; background-position: center center;">
                    <div style="margin: auto;">
                        <a style="text-decoration: none;" href="https://www.waterplus.com/our-products/home-and-living.html">
                            <p style="font-size: 32px; color: #fff; text-shadow:0px 0px 6px #000; padding: 32px;">home & living</p>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>
                    <div style="background:#555; text-align: center; padding: 32px 0px; color: #fff;">
                        <div class="medsos">
                            <a style="color: #fff; margin:0px 8px; font-size:18px;" href="http://www.twitter.com/waterplus_" target="_blank"><img src="http://www.waterplus.com/img/email/twitter.png" alt="twitter"></a>
                            <a style="color: #fff; margin:0px 8px; font-size:18px;" href="https://www.facebook.com/waterplus.waterforall/" target="_blank"><img src="http://www.waterplus.com/img/email/facebook.png" alt="facebook"></a>
                            <a style="color: #fff; margin:0px 8px; font-size:18px;" href="https://www.youtube.com/channel/UCF4Jrx90WL8GRYczyF_vSsg" target="_blank"><img src="http://www.waterplus.com/img/email/youtube.png" alt="youtube"></a>
                            <a style="color: #fff; margin:0px 8px; font-size:18px;" href="http://www.pinterest.com/waterplus/" target="_blank"><img src="http://www.waterplus.com/img/email/path.png" alt="pinterest"></a>
                            <a style="color: #fff; margin:0px 8px; font-size:18px;" href="http://instagram.com/waterplus.waterforall" target="_blank"><img src="http://www.waterplus.com/img/email/instagram.png" alt="instagram"></a>
                        </div>
                        <div style="padding: 12px;">
                            <p style="display: flex; margin: auto; width: 200px;"><img style="margin: auto 0px;" src="http://www.waterplus.com/img/email/phone.png" alt="phone">&nbsp; <span style="margin: auto 0px;">(021) 4226888</span></p>
                        </div>
                    </div>
                    <div style="background:#333; padding: 12px; color:#fff; font-size: 14px;">
                        <p style="margin:auto;">&copy; copyright waterplus 2019</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <script>
        window.addEventListener("load", myFunction);
        window.addEventListener("resize", myFunction);

        var x = 0;
        var box = document.getElementsByClassName("box");
        var box2 = document.getElementsByClassName("box2");

        function myFunction() {
            for (i = 0; i < box.length; i++) {
                var txt = document.getElementsByClassName("box")[i].offsetWidth;
                var count = txt * 40 / 100;
                document.getElementsByClassName("box")[i].style.height = count + "px";
            }
            for (i = 0; i < box2.length; i++) {
                var txt = document.getElementsByClassName("box2")[i].offsetWidth;
                var count = txt * 60 / 100;
                document.getElementsByClassName("box2")[i].style.height = count + "px";
            }
        }
    </script>
</body>

</html>
';
$mail->MsgHTML($message);
if($mail->Send()){
    echo "Message has been sent";
}
else{
    echo "Failed to sending message";
}
}// end function send_email
if($this->input->post('email', TRUE) && !empty($this->input->post('email', TRUE))){
    $email = $this->input->post('email', TRUE);
    $query = $this->db->query("SELECT * FROM subscriber where email = '$email'");
    $row2 = $query->row();
    if ($query->num_rows() > 0) {
        $aktif = $row2->status;
        if($aktif == 'aktif'){
            echo "<script>
				alert ('sorry, email already exists');
				window.history.go(-1);
				</script>";
        }
        else{
            $query = $this->db->query("UPDATE subscriber SET status='aktif' WHERE email='$email'");
            if ($query === TRUE) {
                echo "Record updated successfully";
                echo "<script>
				alert ('thank you for signing up to our newsletter');
				window.history.go(-1);
				</script>";
				send_email($email);
            } else {
                echo "Error updating record: " . $this->db->error(); // Has keys 'code' and 'message'
            }
        }
        //unset($this->input->post('subscribe', TRUE));
		//unset($this->input->post('email', TRUE));
    } else {
        $query = $this->db->query("SELECT MAX(id_subscriber) AS id_subscriber FROM subscriber where id_subscriber LIKE '%$tgl%'");
        $row2 = $query->row();
        $id = $row2->id_subscriber;
        if ($query->num_rows() > 0 && !empty($id)) {
            $new_id = $id + 1;
        }
        else{
            $new = $tgl;
            $new_id = $new . "001";
        }
        $new_id = $new_id;
        $query = $this->db->query("insert into subscriber (id_subscriber, tgl, email, status) values ('$new_id','$today','$_POST[email]','aktif')");

        if ($query === TRUE) {
            echo "Record updated successfully";
            echo "<script>
				alert ('thank you for signing up to our newsletter');
				window.history.go(-1);
				</script>";
				send_email($email);
        } else {
            echo "Error updating record: " . $this->db->error(); // Has keys 'code' and 'message'
        }
    }
}
	}

	public function price()
	{

		if ($this->input->post('submit', TRUE) == 'Filter')
		{

			$this->session->set_userdata([
				'min' => $this->input->post('min', TRUE),
				'max' => $this->input->post('max', TRUE)
			]);

			$min = str_replace('.','',$this->session->userdata('min'));
			$max = str_replace('.','',$this->session->userdata('max'));

		} else {

			$min = $this->uri->segment(3);
			$max = $this->uri->segment(4);

		}

		if (!is_numeric($min) || !is_numeric($max))
		{

			redirect('home');

		}

		if (!$this->uri->segment(5))
		{

			$offset = 0;

		} else {

			$offset = $this->uri->segment(5);

		}

		$where = ['harga >=' => $min, 'harga <=' => $max, 'aktif' => 1];

		$this->load->library('pagination');
      //configure
      $config['base_url'] = base_url().'home/price/'.$min.'/'.$max;
      $config['total_rows'] = $this->app->get_where('t_items', $where)->num_rows();
      $config['per_page'] = 6;
      $config['uri_segment'] = 5;

      $this->pagination->initialize($config);

      $data['link']  = $this->pagination->create_links();
      $data['data'] 	= $this->app->select_where_limit('t_items', $where, $config['per_page'], $offset);
		$this->template->olshop('home', $data);

	}

	public function kategori()
	{

		if (!$this->uri->segment(3))
		{
			redirect('home');
		}

		$offset = (!$this->uri->segment(5)) ? 0 : $this->uri->segment(5);

		$url = strtolower(str_replace([' ','%20','_'], '-', $this->uri->segment(3)));

		$master = $this->app->get_where('masterkategori', ['link' => $url]);
		if ($master->num_rows() > 0) {
			$master = $master->row();
			$idmaster = $master->id;
		}
		else{
			$idmaster="";
		}
		$table = 't_kategori k
						JOIN t_rkategori rk ON (k.id_kategori = rk.id_kategori)
						JOIN t_items i ON (rk.id_item = i.id_item)';
		//load library pagination
		$this->load->library('pagination');
		if ($this->session->userdata('user_login') == TRUE)
		{
			$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		}
		$sort = "";
		if (empty($this->uri->segment(4)) || $this->uri->segment(4)=='page') {
		//configure
		$config['base_url'] 	= base_url().'home/kategori/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 5;

		$this->pagination->initialize($config);
		$data['link']  = $this->pagination->create_links();
			if ($this->input->get('sort', TRUE)){
			$sort = $this->input->get('sort');
			$sort2 = explode(",", $sort);
			$array = "";
			array_push($array, $sort2[0]);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by($sort2[0], $sort2[1])->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster], $config['per_page'], $offset);
			//$data['data'] 		= $this->db->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster], $config['per_page'], $offset);
			}
			$page="kategori";
			$masterkategori = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(3)])->row();
			$data['subkat'] = $masterkategori->masterkategori;
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(3)));
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(3)])->row();
		}
		else if (!empty($this->uri->segment(4)) && $this->uri->segment(4)!='page') {
		$subkategori = $this->app->get_where('t_kategori', ['url' => $this->uri->segment(4)])->row();
		//configure
		$config['base_url'] 	= base_url().'home/kategori/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 5;

		$this->pagination->initialize($config);
		$data['link']  = $this->pagination->create_links();
			if ($this->input->get('sort', TRUE)){
			$sort = $this->input->get('sort');
			$sort2 = explode(",", $sort);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by($sort2[0], $sort2[1])->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)], $config['per_page'], $offset);
			//$data['data'] 		= $this->db->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)], $config['per_page'], $offset);
			}
			$page="subkategori";
			$subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(4)])->row();
			$data['subkat'] = $subkat->kategori;
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(4)));
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(3)])->row();
			$data['thumbnail'] = $subkategori -> foto_kategori;
			$data['thumbnail2'] = 'kategori';
		}
		$data['title'] 		= $data['url'];
		
		$data['metadeskripsi'] = "anda dapat melihat daftar produk di kategori ".$data['url'];
		$this->template->olshop($page, $data);
	}
	
	public function filter_by(){
	    if (!$this->uri->segment(3))
		{
			redirect('home');
		}
		$offset = (!$this->uri->segment(5)) ? 0 : $this->uri->segment(5);
		$filter = $this->uri->segment(4);
		//load library pagination
		$this->load->library('pagination');
		//configure
		$config['base_url'] 	= base_url().'filter_by/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
		$config['total_rows'] 	= $this->app->get_where('t_items', ['kategori' => $filter, 'aktif' => 1])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['link']  = $this->pagination->create_links();
		$subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(3)])->row();
		$data['subkat'] = $subkat->kategori;
		$data['data'] 		= $this->db->get_where('t_items', ['kategori' => $this->uri->segment(4)], $config['per_page'], $offset);
		$data['title'] 		= $filter;
		$data['url'] 		= $filter;
		$data['total_row'] = $config['total_rows'];
		$this->load->view('listproduct', $data);
	}
	
	public function list_product(){
		if (!$this->uri->segment(2))
		{
			redirect('home');
		}

		$offset = (!$this->uri->segment(5)) ? 0 : $this->uri->segment(5);

		$url = strtolower(str_replace([' ','%20','_'], '-', $this->uri->segment(2)));

		$master = $this->app->get_where('masterkategori', ['link' => $url]);
		if ($master->num_rows() > 0) {
			$master = $master->row();
			$idmaster = $master->id;
		}
		else{
			$idmaster="";
		}
		$table = 't_kategori k
						JOIN t_rkategori rk ON (k.id_kategori = rk.id_kategori)
						JOIN t_items i ON (rk.id_item = i.id_item)';
		//load library pagination
		$this->load->library('pagination');
		if ($this->session->userdata('user_login') == TRUE)
		{
			$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		}
		
		$sort = "";
		if (empty($this->uri->segment(3)) || $this->uri->segment(3) == "sort") {
		//configure
		$config['base_url'] 	= base_url().'pilih/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 5;
		$this->pagination->initialize($config);
		$data['link']  = $this->pagination->create_links();
		
			if ($this->uri->segment(2) == "sort"){
			$sort = $this->uri->segment(2);
			//$sort2 = explode(",", $sort);
			//$array = "";
			//array_push($array, $sort2[0]);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->like('nama_item', $sort)->get_where($table, ['i.aktif' => 1], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster], $config['per_page'], $offset);
			}
			$page="kategori";
			$masterkategori = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(2)])->row();
			$data['subkat'] = $masterkategori->masterkategori;
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(2)));
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(2)])->row();
		}
		else if (!empty($this->uri->segment(3))) {
		
			if (!empty($this->uri->segment(4)) && strlen($this->uri->segment(4)) > 5) {
			//configure
			$sort = $this->uri->segment(4);
			$config['base_url'] 	= base_url().'pilih/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
			$config['total_rows'] 	= $this->db->or_like('i.kategori', $sort)->get_where($table, ['i.aktif' => 1, 'i.kategori' => $this->uri->segment(4)])->num_rows();
			$config['per_page'] 	= 24;
			$config['uri_segment'] 	= 5;

			$this->pagination->initialize($config);
			$data['link']  = $this->pagination->create_links();
			
			//$sort2 = explode(",", $sort);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'i.kategori' => $sort], $config['per_page'], $offset);
			//$data['data'] 		= $this->db->or_like('nama_item', $sort)->get_where($table, ['i.aktif' => 1], $config['per_page'], $offset);
			}
			else{
			//configure
			$config['base_url'] 	= base_url().$this->uri->segment(2).'/'.$this->uri->segment(3).'/';
			$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(3)])->num_rows();
			$config['per_page'] 	= 24;
			$config['uri_segment'] 	= 3;
			$load = "load('".base_url()."pilih/bath-and-kitchen/bath-and-shower-mixers', '0')";
			$config['attributes'] = array('onclick' => $load);

			$this->pagination->initialize($config);
			$data['link']  = $this->pagination->create_links();
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(3)], $config['per_page'], $offset);
			}
			$subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(3)])->row();
			$data['subkat'] = $subkat->kategori;
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(3)));
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(2)])->row();
		}
		$data['title'] 		= $data['url'];
		$data['total_row'] = $config['total_rows'];
		$this->load->view('listproduct', $data);
		//$this->template->olshop($page, $data);
	}
	public function detail()
	{
		date_default_timezone_set('Asia/Jakarta');
		$id = $this->uri->segment(3);
		$rrr = "brand like '%waterplus%' or aktif = '1'";
		$items = $this->app->get_where('t_items', array('link' => $id));
		$r = $this->app->get_where($rrr);
		$get = $items->row();
		$metadeskripsi = $get->metadeskripsi;
		$thumbnail = $get->gambar;
		$paket = "id_item = '$get->id_item'";
		$time = date('Y-m-d H:i:s'); // Hasil: 2017-03-01 05:32:15
		$table = "t_rkategori rk JOIN t_kategori k ON (k.id_kategori = rk.id_kategori)";
		$kat = $this->app->get_where($table, array('rk.id_item' => $get->id_item));
		$rk = $kat->row();
		$count = $this->app->get_where('last_view', ['id_item' => $get->id_item])->num_rows();
		$where1 = [
			'id_item' => $get->id_item
		];
		if ($this->session->userdata('user_login') == TRUE)
		{
		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		$where = [
			'id_user' => $this->session->userdata('user_id'),
			'id_item' => $get->id_item
		];
		$cek = $this->app->get_where('last_view', $where)->num_rows();
			if ($cek > 0) {
				$item = array(
				'waktu' => $time
				);
				$last = array(
				'dilihat' => $count
				);
				$this->app->update('last_view', $item, $where);
				$this->app->update('t_items', $last, $where1);
			}
			else{
				$item = array(
				'id' => time(),
				'waktu' => $time,
				'id_item' => $get->id_item,
				'id_user' => $this->session->userdata('user_id')
				);
				$count++;
				$last = array(
				'dilihat' => $count
				);
				$this->app->insert('last_view', $item);
				$this->app->update('t_items', $last, $where1);
			}
		}
		else{
			$where = [
			'id_user' => $this->session->userdata('user'),
			'id_item' => $get->id_item
		];
		$pengunjung = array(
		'idvisitor' => time(),
		'waktu' => $time,
		'halaman' => $this->uri->segment(3),
		'id_user' => $this->session->userdata('user')
		);
		$this->app->insert('pengunjung', $pengunjung);
		$cek = $this->app->get_where('last_view', $where)->num_rows();
			if ($cek > 0) {
				$item = array(
				'waktu' => $time
				);
				$last = array(
				'dilihat' => $count
				);
				$this->app->update('last_view', $item, $where);
				$this->app->update('t_items', $last, $where1);
			}
			else{
				$item = array(
				'id' => time(),
				'waktu' => $time,
				'id_item' => $get->id_item,
				'id_user' => $this->session->userdata('user')
				);
				$count++;
				$last = array(
				'dilihat' => $count
				);
				$this->app->insert('last_view', $item);
				$this->app->update('t_items', $last, $where1);
			}
		}
		$data['tipe'] = $this->db->order_by('urut ASC, link ASC')->get_where('t_items', ['model' => $get->model,'aktif' => '1']);
		$data['package'] = $this->app->get_where('paket',$paket);
		$data['nf'] = $this->app->get_where('t_favorite', ['id_item' => $get->id_item]);
		$data['spesifikasi'] = $this->app->get_where('spesifikasi', ['id_item' => $get->id_item, 'model' => $get->model]);
		$data['kat'] 	= $this->app->get_where('t_kategori', array('id_kategori' => $rk->id_kategori));
		$id_master = $data['kat']->row();
		$data['master'] = $this->db->get_where('masterkategori', ['id' => $id_master->id_master])->row();
		$data['data'] 	= $items;
		$data['r'] 		= $r;
		$data['img'] 	= $this->app->get_where('t_img', ['id_item' => $get->id_item]);
		$data['title']  = $get -> nama_item;
		$data['key']    = $this->app->get_where('t_profil', ['id_profil' => 1]);
		$data['rating'] = $this->app->get_where('rating', ['id_item' => $get->id_item]);
		$data['metadeskripsi'] = $metadeskripsi;
		$data['thumbnail'] = $thumbnail;
		$data['thumbnail2'] = 'item';
		$this->template->olshop('item_detail', $data);
	}

	public function wishlist(){

		if (!$this->session->userdata('user_id'))
		{
			redirect('home');
		}
		
		if (!$this->uri->segment(3))
		{

			$offset = 0;

		} else {

			$offset = $this->uri->segment(3);

		}
		
		$table = 't_favorite k
						JOIN t_items i ON (k.id_item = i.id_item)';
		//load library pagination
		$this->load->library('pagination');
        //configure
        $config['base_url'] = base_url().'home/wishlist/'.$this->uri->segment(3);
        $config['total_rows'] = $this->db->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')])->num_rows();
        $config['per_page'] = 24;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);
        
        
		if ($this->session->userdata('user_login') == TRUE)
		{
			$data['fav'] = $this->app->get_where($table, ['k.id_user' => $this->session->userdata('user_id')]);
		}
		
		$data['link']  = $this->pagination->create_links();
		$data['total_row'] = $config['total_rows'];
		
		$data['link']  = $this->pagination->create_links();
		$sort = "";
			if ($this->input->get('sort', TRUE)){
			$sort = $this->input->get('sort');
			$sort2 = explode(",", $sort);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by($sort2[0], $sort2[1])->get_where($table, ['k.id_user' => $this->session->userdata('user_id')], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->get_where($table, ['k.id_user' => $this->session->userdata('user_id')], $config['per_page'], $offset);
			}
		$data['title'] 		= "wishlist products";
		$data['metadeskripsi'] = "your favorite products";
		$this->template->olshop('wishlist', $data);
	}

	public function favorite()
	{
		//paksa login
		if ($this->session->userdata('user_login') != TRUE)
		{
			redirect('home/login');
		}
		//ambil data
		$get = $this->app->get_where('t_items', ['link' => $this->uri->segment(3)])->row();

		//cek data
		$where = [
			'id_user' => $this->session->userdata('user_id'),
			'id_item' => $get->id_item
		];

		$cek = $this->app->get_where('t_favorite', $where)->num_rows();

		if ($cek > 0)
		{
			$this->session->set_flashdata('alert', 'item removed from wishlist');
			//hapus data
			$this->app->delete('t_favorite', $where);
		} else {
			//masukkan data ke variabel
			$data = array(
				'id_user' => $this->session->userdata('user_id'),
				'id_item' => $get->id_item
			);

			$this->session->set_flashdata('success', 'item added to wishlist');
			//insert DataBase
			$this->app->insert('t_favorite', $data);
		}

		echo '<script type="text/javascript">window.history.go(-1)</script>';
	}

	public function list_fav()
	{
		if (!$this->session->userdata('user_login'))
      {
         redirect('home/login');
      }

		//ambil data
		$table = 't_favorite f
						JOIN t_items i ON (f.id_item = i.id_item)';

		$data['data'] = $this->app->get_where($table, ['aktif' => 1, 'f.id_user' => $this->session->userdata('user_id')]);

		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		$data['title'] = "favorite list";
		$data['metadeskripsi'] = "showing your favorite products list";
		$this->template->olshop('fav', $data);

	}

	public function registrasi()
	{

		if($this->input->post('submit', TRUE) == 'Submit')
		{

			$this->load->library('form_validation');
			$this->form_validation->set_rules('user', 'username', "required|min_length[5]|regex_match[/^[a-zA-Z0-9]+$/]");
			$this->form_validation->set_rules('email', 'email', "required|valid_email");
			$this->form_validation->set_rules('pass1', 'password', "required|min_length[5]");

			if ($this->form_validation->run() == TRUE)
			{

				$profil 	= $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$admin		= $this->app->get_where('t_admin', ['id_admin' => 1])->row();
				//proses
				$this->load->library('email');

				$config['smtp_user'] = 'no-reply@waterplus.com'; //isi dengan email gmail
				$config['smtp_pass'] = 'Waterplus2019'; //isi dengan password
				
				$this->email->initialize($config);
				date_default_timezone_set("Asia/Bangkok");
                $today = date("Y-m-d H:i:s");
				$username = $this->input->post('user', TRUE);
				$user = $username;
				$email = $this->input->post('email', TRUE);
				$tgl_pesan 	= date("Y-m-d");
				$tglpesan   = date('d-m-Y', strtotime($tgl_pesan));
				$link = base_url()."verify/link/".$username."/".time();
				$onclick = "document.location = '".$link."'";
        $this->email->set_mailtype("html");
        $this->email->from('no-reply@waterplus.com', $profil->title);
        $this->email->to($email);
        $this->email->subject('waterplus+ - verify your email');
        $this->email->message(
          '
          <!DOCTYPE html>
          <html>
          <head>
          <title>email verification</title>
          </head>
          <body style="width:500px; font-size:14px;">
          <div><img src="https://www.waterplus.com/img/logo.png" alt="logo waterplus"></div>
          <p>hi '.$user.'!</p>
          <p>thank you for signing up :)<br>
just one more step! to activate and verify your account, please click the link below</p>
          <a href="'.$link.'" style="text-decoration:none; width:auto;"><div style="width:150px; text-align:center; padding:12px; background: rgba(10,42,59,1); border-radius:5px; color:#fff;">verify now</div></a>
          <p>if the button above does not work, please copy and paste the complete url below into your browser and then press enter.<br>
          <span style="color:rgba(10,42,59,1);">'.$link.'</span>
          </p>
          <p>you can login to your account through <a style="color:rgba(10,42,59,1);" href="https://www.waterplus.com/our-products/signin">https://www.waterplus.com/our-products/signin</a> after verifying your email!</p>
          <br>
          <p>thank you!</p>
          <p>waterplus+</p>
		  </body>
		  </html>
		'
          );
          $id_user = '';
            $query = $this->db->query("SELECT MAX(id_user) as id_user from t_users")->row();
            if (!empty($query->id_user)) {
                $id_user = $query->id_user + 1;
                if($id_user < 10){
                    $id_user = '100000'.$id_user;
                }
                elseif($id_user >= 10 && $id_user < 100){
                    $id_user = '10000'.$id_user;
                }
                elseif($id_user >= 100 && $id_user < 1000){
                    $id_user = '1000'.$id_user;
                }
            }
            else{
                $id_user = '1000001';
            }
        $data1 = array(
                    'id_user'           => $id_user,
                    'terakhir_update'   => $today,
					'username'          => $this->input->post('user', TRUE),
					'email'             => $this->input->post('email', TRUE),
					'password'          => password_hash($this->input->post('pass1', TRUE), PASSWORD_DEFAULT, ['cost' => 10]),
					'status'            => 0,
					'reset'             => time()
			);
            
          if ($this->app->insert('t_users', $data1))
          {
          	
          	if ($this->email->send()) {
          		$this->email->from($profil->email_toko, $profil->title);
		        	$this->email->to($admin->email);
		        	$this->email->subject('Akun Baru / Username : '.$username);
		        	$this->email->message(
		          	'Hai admin,<br /><br />Ada member baru dari '.$profil->title.' dengan username '.$username.' pada tanggal '.date('d M Y', strtotime($tgl_pesan)).'. Silahkan login untuk melihat member secara lengkap.'
		        	);

					if ($this->email->send())
					{
						$this->session->set_flashdata('success', 'we\'ve send an email to '.$this->input->post('email', TRUE));
					}
		  	}
		  	else {
		  	    echo $this->email->print_debugger(array('headers'));
		  	}
          	} else {
            	$this->session->set_flashdata('alert', "username / email has been registered");
		  	    echo '<script>window.history.go(-1)</script>';
		  	$halaman = "login2";
          	}
			$halaman = 'reg_success';


			} else {
				$halaman = 'login2';
			}

		} else {

			$halaman = 'login2';

		}

		if ($this->session->userdata('user_login') == TRUE)
      {
         redirect('home');
      }

		$data = array(
			'user' 	=> $this->input->post('user', TRUE),
			'nama1' 	=> $this->input->post('nama1', TRUE),
			'nama2' 	=> $this->input->post('nama2', TRUE),
			'email' 	=> $this->input->post('email', TRUE),
			'jk' 		=> $this->input->post('jk', TRUE),
			'telp' 	=> $this->input->post('telp', TRUE),
			'alamat' => $this->input->post('alamat', TRUE),
			'captcha' => $this->recaptcha->getWidget(), // menampilkan recaptcha
            'script_captcha' => $this->recaptcha->getScriptTag()
		);
		$data['title'] = "Registration";
		$data['metadeskripsi'] = "daftar untuk menikmati belanja online di waterplus.com";
		$data['email'] = $this->input->post('email', TRUE);
		$this->template->olshop($halaman, $data);

	}
	
public function resend()
{
if ($this->input->post('submit', TRUE) == 'resend')
{
$email = $this->input->post('email', TRUE);
$query = $this->db->query("SELECT * from t_users WHERE email = '$email'");
if ($query->num_rows() == 1) {
    $query_result = $query->row();
}
date_default_timezone_set("Asia/Bangkok");
$today = date("Y-m-d H:i:s");
$tgl = date("ymd");
$this->load->view('classes/class.phpmailer.php');
$count = $query_result->reset + 60;
$time = time();
if($time > $count){
$query = $this->db->query("UPDATE t_users SET terakhir_update='$today', reset='$time' WHERE email='$email'");
if ($query == TRUE) {
$query = $this->db->query("SELECT * FROM t_users where email = '$email'");
$user = '';
if ($query->num_rows() > 0) {
    $query_result = $query->row();
    $user = $query_result->username;
}
$link = base_url()."verify/link/".$user."/".time();
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "mail.waterplus.com"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "no-reply@waterplus.com"; //user email
$mail->Password = "Waterplus2019"; //password email
$mail->SetFrom("no-reply@waterplus.com","waterplus+"); //set email pengirim
$mail->Subject = "waterplus+ - verify your email"; //subjek email
$mail->AddAddress($email,"");  //tujuan email
$message = '
          <!DOCTYPE html>
          <html>
          <head>
          <title>email verification</title>
          </head>
          <body style="width:500px; font-size:14px;">
          <div><img src="https://www.waterplus.com/img/logo.png" alt="logo waterplus"></div>
          <p>hi '.$user.'!</p>
          <p>thank you for signing up :)<br>
just one more step! to activate and verify your account, please click the link below</p>
          <a href="'.$link.'" style="text-decoration:none; width:auto;"><div style="width:150px; text-align:center; padding:12px; background: rgba(10,42,59,1); border-radius:5px; color:#fff;">verify now</div></a>
          <p>if the button above does not work, please copy and paste the complete url below into your browser and then press enter.<br>
          <span style="color:rgba(10,42,59,1);">'.$link.'</span>
          </p>
          <p>you can login to your account through <a style="color:rgba(10,42,59,1);" href="https://www.waterplus.com/our-products/signin">https://www.waterplus.com/our-products/signin</a> after verifying your email!</p>
          <br>
          <p>thank you!</p>
          <p>waterplus+</p>
		  </body>
		  </html>
';
if($mail->Send()){
    $this->session->set_flashdata('success', 'we\'ve send an email to budihari47@gmail.com');
    echo '<script>window.history.go(-1);</script>';
}
else{
    $this->session->set_flashdata('alert', 'failed to send to your email');
}
//echo "<script>
//		window.history.go(-1);
//	  </script>";
}
else{
    echo "Error updating record: ";
    echo $today;
}
} //end if time
echo '<script>window.history.go(-1);</script>';
$profil['title'] = "resend email";
$this->template->olshop('reg_success', $profil);
} //end form validation
else{
    redirect();
}
} //end public function resend


public function login()
{
    $page = 'login';
	if ($this->input->post('submit') == 'submit')
    {
      date_default_timezone_set("Asia/Bangkok");
      $today = date("Y-m-d H:i:s");
      $user  = $this->input->post('username', TRUE);
      $pass  = $this->input->post('password', TRUE);
			$where = "username = '".$user."' || email = '".$user."'";

			$cek 	 = $this->app->get_where('t_users', $where);

      if ($cek->num_rows() == 1)
		{

      	$data = $cek->row();
      	if ($data->status == 0) {
          	$page = "reg_success";
      	}
      	else{
        if (password_verify($pass, $data->password))
        {
            if(!empty($data->fullname)){
                $fullname = $data->fullname;
            }
            else{
                $fullname = $data->username;
            }


          $datauser = array (
			'user_id' 		=> $data->id_user,
            'name' 			=> $fullname,
            'username'      => $data->username,
            'user_login' 	=> TRUE
          );
          
          $this->session->set_userdata($datauser);
          
          $where = ['id_user' => $this->session->userdata('user_id')];
          
          $data1 = array(
				'terakhir_login'    => $today
					);
          
          $this->db->update('t_users', $data1, $where);

          if ($this->session->userdata('check') == TRUE) {
			$redirect = $this->session->userdata('link');
          	redirect($redirect);
          }
          else{
          redirect();
      	  }

        } else {

          $this->session->set_flashdata('alert', "password wrong");
          echo '<script>window.history.go(-1);</script>';
            $page = 'login';
        }
    	}

      } else {

				$this->session->set_flashdata('alert', "username / email not registered");
                echo '<script>window.history.go(-1);</script>';
                $page = 'login';
			}

		}

      if ($this->session->userdata('user_login') == TRUE)
      {
         redirect();
      }

		$profil['data'] = $this->app->get_all('t_profil');
		$profil['title'] = "login";
		$profil['metadeskripsi'] = "login sekarang untuk mulai belanja online di waterplus.com";
		$this->template->olshop($page, $profil);
		//$this->load->view('login2', $profil);
	}

	public function profil()
	{

	if (!$this->session->userdata('user_login'))
      {
         redirect('sigin');
      }

		$get = $this->app->get_where('t_users', array('id_user' => $this->session->userdata('user_id')))->row();
        
		if($this->input->post('submit', TRUE) == 'Submit')
		{

			$this->load->library('form_validation');

			$this->form_validation->set_rules('nama1', 'name', "required|min_length[3]");
			$this->form_validation->set_rules('pass', 'verify your password', "required|min_length[5]");
			$this->form_validation->set_rules('jk', 'gender', "required");
			$this->form_validation->set_rules('telp', 'phone', "required|min_length[8]|numeric");

			if ($this->form_validation->run() == TRUE)
			{

				if (password_verify($this->input->post('pass', TRUE), $get->password))
				{
					$prov = $this->input->post('prov', TRUE);
					$data = array(
						'fullname' 	=> $this->input->post('nama1', TRUE),
						'jk' 			=> $this->input->post('jk', TRUE),
						'telp' 			=> $this->input->post('telp', TRUE)
					);
					$where = ['id_user' => $this->session->userdata('user_id')];

					if ($this->app->update('t_users', $data, $where))
					{

						$this->session->set_userdata(array('name' => $this->input->post('nama1', TRUE)));
						$this->session->set_flashdata('success', 'profil berhasil disimpan');
						redirect ('home/profil');

					} else {
						$this->session->set_flashdata('alert', 'username / email tidak tersedia');

					}

				} else {
					$this->session->set_flashdata('alert', 'password salah');
				}

			}

		}
		$nama = $get->fullname;
		$data['nama'] 	= $get->fullname;
		$data['user'] 	= $get->username;
		$data['email'] = $get->email;
		$data['jk'] 	= $get->jk;
		$data['telp'] 	= $get->telp;
		$data['title'] = "your profile";
		$data['metadeskripsi'] = "your profile page";
		$this->template->olshop('profil', $data);

	}

	public function shipping()
	{
	if (!$this->session->userdata('user_login'))
      {
         redirect('home/login');
      }
    elseif (!empty($this->uri->segment(3)) && $this->uri->segment(3) == "ubah") {
    	$cek = $this->app->get_where('alamat', array('idalamat' => $this->uri->segment(4), 'iduser' => $this->session->userdata('user_id')));
    	if ($cek -> num_rows() != 1) {
    		redirect ('home/shipping');
    	}
    	else{
    	if (!empty($this->input->post('change', TRUE))) {
    		$data = array(
						'nama' 			=> $this->input->post('receiver', TRUE),
						'phone' 		=> $this->input->post('phone', TRUE),
						'provinsi' 		=> $this->input->post('prov', TRUE),
						'kabupaten' 	=> $this->input->post('kota', TRUE),
						'kota' 	        => $this->input->post('subdistrict', TRUE),
						'kodepos' 		=> $this->input->post('postal', TRUE),
						'alamat' 		=> $this->input->post('address', TRUE)
			);
			$cond = array('idalamat' => $this->uri->segment(4));
			if ($this->app->update('alamat', $data, $cond))
					{
						$this->session->set_flashdata('success', 'shipping option has been update');
						redirect ('home/shipping');

					} else {
						$this->session->set_flashdata('alert', 'failed to update');
						redirect ('home/shipping');
					}
			redirect('home/logout');
    	}// end if post change
    	}// end if $cek -> num_row()
		$data['shipping'] = $cek -> row();
		$data['provinsi'] = explode(",",$data['shipping']->provinsi);
		$data['kabupaten'] = explode(",",$data['shipping']->kabupaten);
		$data['kecamatan'] = explode(",",$data['shipping']->kota);
		$data['title'] = "change shipping address";
		$data['metadeskripsi'] = "change shipping address";
		$this->template->olshop('ubah-alamat', $data);
	} //end if $this->uri->segment(3) == "ubah"
	else{
	if (!empty($this->input->post('hapus', TRUE))) {
		$shipping = $this->app->get_where('alamat', array('idalamat' => $this->input->post('hapus', TRUE))) -> row();
		$user = $shipping->iduser;
		if ($user == $this->session->userdata('user_id')) {
			$this->db->where('idalamat', $shipping->idalamat);
			$this->db->delete('alamat');

			$this->session->set_flashdata('success', 'shipping address has been delete');

         	redirect('home/shipping');
		}
	}
	$this->db->select_max('idalamat');
	$alamat = $this->db->get('alamat') -> row();
	$idalamat = $alamat->idalamat;
	$idalamat++;

		$get = $this->app->get_where('alamat', array('iduser' => $this->session->userdata('user_id')));
        if($get->num_rows() == 0){
            $aktif = 1;
        }
        else{
            $aktif = 0;
        }
		if($this->input->post('submit') == 'Submit')
		{

			$this->load->library('form_validation');
			$this->form_validation->set_rules('receiver', 'recipient s name', "required|min_length[3]");
			$this->form_validation->set_rules('phone', 'phone number', "required|min_length[8]|numeric");
			$this->form_validation->set_rules('prov', 'province', "required");
			$this->form_validation->set_rules('kota', 'city', "required");
			$this->form_validation->set_rules('subdistrict', 'subdistrict', "required");
			$this->form_validation->set_rules('postal', 'postal code', "required|min_length[5]|numeric");
			$this->form_validation->set_rules('address', 'your address', "required|min_length[5]");

			if ($this->form_validation->run() == TRUE)
			{
			    date_default_timezone_set("Asia/Bangkok");
                $today = date("Y-m-d H:i:s");
                $tgl = date("ymd");
                $query = $this->db->query("SELECT MAX(idalamat) AS idalamat FROM alamat where idalamat LIKE '%$tgl%'");
                $row2 = $query->row();
                $id = $row2->idalamat;
                if ($query->num_rows() > 0 && !empty($id)) {
                    $new_id = $id + 1;
                }
                else{
                    $new = $tgl;
                    $new_id = $new . "001";
                }
                    $new_id = $new_id;
					$prov = $this->input->post('prov', TRUE);
					$data = array(
						'idalamat' 		=> $new_id,
						'iduser' 		=> $this->session->userdata('user_id'),
						'nama' 			=> $this->input->post('receiver', TRUE),
						'phone' 		=> $this->input->post('phone', TRUE),
						'provinsi' 		=> $prov,
						'kabupaten' 	=> $this->input->post('kota', TRUE),
						'kota' 	=> $this->input->post('subdistrict', TRUE),
						'kodepos' 		=> $this->input->post('postal', TRUE),
						'alamat' 		=> $this->input->post('address', TRUE),
						'aktif' 		=> $aktif
					);
					//$where = ['id_user' => $this->session->userdata('user_id')];

					if ($this->app->insert('alamat', $data))
					{
						$this->session->set_flashdata('success', 'shipping option has been save');
						//redirect ('home/shipping');

					} else {
						$this->session->set_flashdata('alert', 'shipping option not save');
						//redirect ('home/shipping');
					}

			}
		}
		$data['shipping'] = $this->app->get_where('alamat', array('iduser' => $this->session->userdata('user_id')));
		$data['title'] = "shipping address";
		$data['metadeskripsi'] = "your profile page";
		$this->template->olshop('alamat', $data);
	}
	}

	public function password()
	{

		if (!$this->session->userdata('user_login'))
      {
         redirect('home/login');
      }

		if ($this->input->post('submit', TRUE) == 'submit')
		{

			$this->load->library('form_validation');
			//validasi form
			$this->form_validation->set_rules('pass1', 'Password Baru', 'required|min_length[5]');
			$this->form_validation->set_rules('pass2', 'Ketik Ulang Password Baru', 'required|matches[pass1]');
			$this->form_validation->set_rules('pass3', 'Password Lama', 'required');

			if ($this->form_validation->run() == TRUE)
			{

				$get_data = $this->app->get_where('t_users', array('id_user' => $this->session->userdata('user_id')))->row();

				if (!password_verify($this->input->post('pass3',TRUE), $get_data->password))
				{

					echo '<script type="text/javascript">alert("Password lama yang anda masukkan salah");window.history.go(-1);")</script>';

				} else {

					$pass = $this->input->post('pass1', TRUE);
					$data['password'] = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
					$cond = array('id_user' => $this->session->userdata('user_id'));

					$this->app->update('t_users', $data, $cond);

					redirect('home/logout');

				}

			}

		}
		$data['title'] = "change password";
		$data['metadeskripsi'] = "change your password";
		$this->template->olshop('pass',$data);

	}

	public function transaksi()
	{

		if (!$this->session->userdata('user_id'))
		{
			redirect('home');
		}

		$table		 = "t_order o JOIN t_users u ON (o.email = u.email)";
		$data['get'] = $this->db->order_by('id_order','desc')->get_where($table, ['id_user' => $this->session->userdata('user_id')]);
		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		$data['title'] = "order history";
		$data['metadeskripsi'] = "";
		$this->template->olshop('transaksi1', $data);

	}

	public function detail_transaksi()
	{
	
	if (!$this->session->userdata('user_login'))
      {
		$datauser = array (
			'check' => TRUE,
			'link' => $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)
			 );
		$this->session->set_userdata($datauser);
		redirect('signin');
	  }
	  else{
		$user = $this->app->get_where('t_users', ['username' => $this->session->userdata('username')])->row();
	  }

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home/transaksi');
		}

		$table = "t_order o
						JOIN t_detail_order do ON (o.id_order = do.id_order)
						JOIN t_items i ON (do.id_item = i.id_item)";
		$data['get'] = $this->app->get_where($table, ['o.id_order' => $this->uri->segment(3)]);
		$order = $data['get']->row();
		if($user->email != $order->email){
			redirect('home/transaksi');
		}

$api  = $this->db->get_where('t_profil', ['id_profil' => 1])->row();
$html = "";

if(!empty($order->resi)){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "waybill=".$order->resi."&courier=".$order->kurir,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: ".$api->api_key
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
	$result = json_decode($response, TRUE)['rajaongkir']['result']['manifest'];

	$arr = array();
	if(!empty($result)){
	for ($i=0; $i < count($result); $i++) {
		$a = $result[$i]['manifest_date'].' '.$result[$i]['manifest_time'].'_'.$result[$i]['manifest_description'];
		array_push($arr, $a);
	}

	sort($arr);

	for ($i=0; $i < count($arr); $i++) {
		$get = $arr[$i];
		$result = explode("_",$get);
		$html .= '<tr>
		<td>'.$result[0].'</td><td>'.$result[1].'</td>
		</tr>
		';
	}
	}
	
}
}
		$data['response'] = $html;
		$data['detail_order'] = $this->app->get_where('t_detail_order', ['id_order' => $this->uri->segment(3)]);
		$data['pembayaran'] = $this->app->get_where('buktipembayaran', ['id_order' => $this->uri->segment(3)]);
		$data['fav'] = $this->app->get_where('t_favorite', ['id_user' => $this->session->userdata('user_id')]);
		$data['title'] = "details order";
		$data['metadeskripsi'] = "detail transaksi anda";
		$this->template->olshop('detail_transaksi', $data);

	}

	public function hapus_transaksi()
	{

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home');
		}
		//kembalikan stok
		$table 	= 't_detail_order do
							JOIN t_items i ON (do.id_item = i.id_item)';
		$get 		= $this->app->get_where($table, ['id_order' => $this->uri->segment(3)]);

		foreach ($get->result() as $key) {
			//jumlahkan stok
			$stok = ($key->qty + $key->stok);
			//update stok
			$this->app->update('t_items', ['stok' => $stok], ['id_item' => $key->id_item]);
		}

		$tables = array('t_order', 't_detail_order');
		$this->app->delete($tables, ['id_order' => $this->uri->segment(3)]);

		redirect('home/transaksi');

	}

	public function transaksi_selesai()
	{

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home');
		}

		$this->app->update('t_order', ['status_proses' => 'selesai'], ['id_order' => $this->uri->segment(3)]);

		redirect('home/transaksi');

	}

	public function upload_bukti()
	{
		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('id_invoice', 'No. Invoice / Id Pemesanan', 'required|min_length[10]');

			if ($this->form_validation->run() == TRUE)
         	{
				//cek data
				$get = $this->app->get_where('t_order', ['id_order' => $this->input->post('id_invoice', TRUE)]);
				$hitung = $get->num_rows();

				if ($hitung > 0)
				{
					//fetch data
					$detail = $get->row();

					$config['upload_path'] = './assets/bukti/';
					$config['allowed_types'] = 'jpg|png|jpeg';
					$config['max_size'] = '2048';
					$config['file_name'] = 'bukti'.$detail->id_order;

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('bukti'))
					{
						$gbr = $this->upload->data();
						//proses insert data item
			         $bukti = array ('bukti' => $gbr['file_name']);
						$where = array ('id_order' => $detail->id_order);
						//update data
						$update = $this->app->update('t_order', $bukti, $where);

						if ($update)
						{
							$admin 	= $this->app->get_where('t_admin', ['id_admin' => 1])->row();
							$profil 	= $this->app->get_where('t_profil', ['id_profil' => 1])->row();

							//proses
			        $this->load->library('email');

							$config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
							$config['smtp_pass'] = $profil->pass_toko; //isi dengan password

							$this->email->initialize($config);

							$tanggal = date('d - m - Y');

			        $this->email->from($profil->email_toko, $profil->title);
			        $this->email->to($admin->email);
			        $this->email->subject('Status Pembayaran');
			        $this->email->message(
			          'Pesanan dengan ID. '.$detail->id_order.' Telah dibayar pada tanggal '.$tanggal.', silahkan cek menu transaksi untuk melihat bukti pembayaran
								'
			        );

							if ($this->email->send())
							{
								echo '<script type="text/javascript">alert("Bukti Pembayaran Berhasil Diunggah...");window.location.replace("'.base_url().'")</script>';
							}

						} else {

							echo '<script type="text/javascript">alert("Maaf Telah Terjadi Kesalahan... silahkan ulangi lagi")</script>';

						}

					} else {

						echo '<script type="text/javascript">alert("Bukti Gagal Diunggah...")</script>';

					}

				} else {

					echo '<script type="text/javascript">alert("Id Pemesanan Tidak dikenali..")</script>';

				}
			}
		}

		$data['id_invoice'] = $this->input->post('id_invoice', TRUE);
		$data['title'] = "upload payment proof";
		$data['metadeskripsi'] = "upload your payment proof";
		$this->template->olshop('up_bukti', $data);
	}

	public function logout()
	{

		$this->session->sess_destroy();
		redirect();

	}
}

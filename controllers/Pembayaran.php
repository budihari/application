<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
      $this->load->model('bayar');
	}

   public function index()
   {
		$this->cek_login();

		$this->template->admin('admin/pembayaran');
   }

	public function ajax_list()
   {
      $list = $this->bayar->get_datatables();
      $data = array();
      $no = $_POST['start'];
		$today = date('Y-m-d');

      foreach ($list as $i) {

			$batas = $i->tgl_pembayaran;

			$btn = '';
			$validation = '<a href="'.base_url().'pembayaran/detail/'.$i->idpembayaran.'" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>';

			if ($i->status == 'not valid' && $this->session->userdata('level_admin') == '21') {

				$btn = '<a href="'.site_url('pembayaran/delete/'.$i->idpembayaran).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin Ingin Menghapus Data ini ?\')"><i class="fa fa-trash"></i></a>';
				$validation = '<a href="'.base_url().'pembayaran/valid/'.$i->idpembayaran.'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';

			} else if ($i->status == 'valid' && $this->session->userdata('level_admin') == '21') {

				//$btn = '<a href="'.base_url().'pembayaran/notvalid/'.$i->idpembayaran.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a>';
				$btn = '<a href="'.base_url().'pembayaran/tolak/'.$i->idpembayaran.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a>';
				$validation = '<a href="'.base_url().'pembayaran/detail/'.$i->idpembayaran.'" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>';
			}
			else if ($this->session->userdata('level_admin') == '21'){
				//$btn = '<a href="'.base_url().'pembayaran/notvalid/'.$i->idpembayaran.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a>';
				$btn = '<a href="'.base_url().'pembayaran/tolak/'.$i->idpembayaran.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a>';
				$validation = '<a href="'.base_url().'pembayaran/valid/'.$i->idpembayaran.'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>';
			}

         $no++;
         $row = array();
         $row[] = $no;
         $row[] = '<a href="'.base_url().'pembayaran/detail/'.$i->idpembayaran.'" style="color:#0ad;">'.$i->idpembayaran.'</a>';
         $row[] = '<a href="'.base_url().'user/detail/'.$i->iduser.'" style="color:#0ad;">'.$i->iduser.'</a>';
         $row[] = '<a href="'.base_url().'transaksi/detail/'.$i->id_order.'" style="color:#0ad;">'.$i->id_order.'</a>';
         $row[] = date('d M Y', strtotime($i->tgl_pembayaran));
		 $row[] = $i->namapengirim." (".$i->bank_asal.")";
		 $row[] = "Rp ".number_format($i->jumlah_transfer, 0, ',', '.');
		 $row[] = $i->bank_tujuan;
		 $row[] = $i->status;
         $row[] = $validation.$btn;

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->bayar->count_all(),
               	"recordsFiltered" => $this->bayar->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }

   public function add_pembayaran()
   {
	  $this->cek_login();
	  if (!is_numeric($this->uri->segment(3)))
      {
         echo '<script type="text/javascript">window.history.go(-1)</script>';
	  }
	  $table = 't_order o
	  JOIN t_users usr ON (o.email = usr.email)';
	  $cek = $this->bayar->get_where($table, array('o.id_order' => $this->uri->segment(3))) -> row();
	  if($cek->status_proses != 'not paid'){
		  redirect('pembayaran');
	  }
	  if ($this->input->post('formbayar', TRUE) == 'Submit') {
		//validasi
		$this->form_validation->set_rules('idbayar', 'ID Bayar', 'required|min_length[4]');
		$this->form_validation->set_rules('idorder', 'ID Order', 'required|min_length[4]');
		$this->form_validation->set_rules('tglbayar', 'Tanggal Bayar', 'required');
		$this->form_validation->set_rules('waktubayar', 'Waktu Bayar', 'required');
		$this->form_validation->set_rules('namapengirim', 'Nama Pengirim', 'required');
		$this->form_validation->set_rules('bankasal', 'Bank Asal', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah Transfer', 'required');
		$this->form_validation->set_rules('banktujuan', 'Bank Tujuan', 'required');

		$id_order = $this->input->post('idorder', TRUE);
		$idbayar = $this->input->post('idbayar', TRUE);
		$table = 't_order o
		JOIN t_users usr ON (o.email = usr.email)';
		$cek = $this->bayar->get_where($table, array('o.id_order' => $id_order)) -> row();
		$jumlah = $this->input->post('jumlah', TRUE);
        $jumlah = str_replace(array(',', '.'), "", $jumlah);
		$bayar = array (
			'idpembayaran' => $idbayar,
			'iduser' => $cek->id_user,
			'id_order' => $id_order,
			'tgl_pesan' => $cek->tgl_pesan,
			'tgl_pembayaran' => $this->input->post('tglbayar', TRUE).' '.$this->input->post('waktubayar', TRUE),
			'namapengirim' => $this->input->post('namapengirim', TRUE),
			'bank_asal' => $this->input->post('bankasal', TRUE),
			'jumlah_transfer' => $jumlah,
			'bank_tujuan' => $this->input->post('banktujuan', TRUE),
			'status' => 'not valid'
		 );
		 $this->db->insert('buktipembayaran', $bayar);
		 redirect('pembayaran/valid/'.$idbayar);
	  } // end submit
	  $data['idorder'] = $this->uri->segment(3);
	  $data['totalbayar'] = $cek->total;
      $data['header'] = "Tambah Pembayaran";
      $this->template->admin('admin/formbayar', $data);
   }

   public function tolak(){
	$this->cek_login();
	if (!is_numeric($this->uri->segment(3)))
	{
	   echo '<script type="text/javascript">window.history.go(-1)</script>';
	}
	$table = 't_order o
	JOIN t_users usr ON (o.email = usr.email) JOIN buktipembayaran bayar ON (o.id_order = bayar.id_order)';
	$cek = $this->bayar->get_where($table, array('bayar.idpembayaran' => $this->uri->segment(3)));
	if ($this->input->post('formbayar', TRUE) == 'Submit') {
	  //validasi
	  $this->form_validation->set_rules('alasan_tolak', 'Alasan Tolak', 'required');

	  $id_order = $this->input->post('idorder', TRUE);
	  $idbayar = $this->uri->segment(3);
	  $table = 't_order o
	  JOIN t_users usr ON (o.email = usr.email)';
	  $cek = $this->bayar->get_where($table, array('o.id_order' => $id_order)) -> row();
	  $jumlah = $this->input->post('jumlah', TRUE);
	  $jumlah = str_replace(array(',', '.'), "", $jumlah);
	  $alasan = $this->input->post('alasan_tolak');
	  $bayar = array (
		  'alasan' => $alasan
	   );
	   $this->bayar->update('buktipembayaran', $bayar, ['idpembayaran' => $idbayar]);
	   redirect('pembayaran/notvalid/'.$idbayar);
	} // end submit
	$data['cek'] = $cek->row();
	$data['idbayar'] = $this->uri->segment(3);
	$data['header'] = "Konfirmasi Pembayaran Tidak Valid";
	$this->template->admin('admin/formtolak', $data);
   }

   public function valid()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         echo '<script type="text/javascript">window.history.go(-1)</script>';
	  }
	  date_default_timezone_set("Asia/Bangkok");
	  $today = date("Y-m-d H:i:s");
	  $id = $this->uri->segment(3);
	  $idpembayaran = '';
	  $cek = $this->bayar->get_where('buktipembayaran', array('idpembayaran' => $id));
	  if($cek->num_rows() == 1){
		$cek = $cek->row();
		$id_order = $cek->id_order;
		$idpembayaran = $cek->idpembayaran;
		$cekorder = $this->bayar->get_where('t_order', array('id_order' => $id_order)) -> row();
		$detail = $cek->detail_pembayaran;
		$do = $cekorder->detail;
		if(empty($detail)){
			$detail = 'valid by '.$this->session->userdata('user').' at '.$today;
		}
		else{
			$detail = $detail.', valid by '.$this->session->userdata('user').' at '.$today;
		}
		$spek = array (
						'status' => "valid",
						'detail_pembayaran' => $detail
					);
		$this->bayar->update('buktipembayaran', $spek, ['idpembayaran' => $id]);
	  }
	  else{
		$cek = $this->bayar->get_where('t_order', array('id_order' => $id))->row();
		$id_order = $cek->id_order;
		$do = $cek->detail;
	  }
	  
	  if(empty($do)){
		$do = 'verified by '.$this->session->userdata('user').' at '.$today;
	  }
	  else{
		$do = $do.', verified by '.$this->session->userdata('user').' at '.$today;
	  }
	  $table_order = array (
      				'bukti' => $cek->bukti,
					'status_proses' => "paid",
					'detail' => $do
				);
	  $this->bayar->update('t_order', $table_order, ['id_order' => $id_order]);
		$tgl = date("ymd");
		$profil = $this->db->get_where('t_profil', ['id_profil' => '1'])->row();
		if(!empty($idpembayaran)){
			$table = "t_order o
				JOIN t_users usr ON (o.email = usr.email)
				JOIN buktipembayaran bukti ON (o.id_order = bukti.id_order)";
			$order = $this->db->get_where($table, ['bukti.idpembayaran' => $idpembayaran])->row();
		}
		else{
			$table = "t_order o
				JOIN t_users usr ON (o.email = usr.email)";
			$order = $this->db->get_where($table, ['o.id_order' => $id_order])->row();
		}
		
		$table = '';
		$table1 = "t_detail_order detail
		JOIN t_items i ON (detail.id_item = i.id_item)";
		$detail = $this->db->get_where($table1, ['detail.id_order' => $order->id_order]);
		foreach ($detail->result() as $row)
		{
			$harga = $row->harga;
			$qty = $row->qty;
			$subtotal = $qty * $harga;
			$table .= '<tr><td>'.$row->nama_item.' ('.$qty.' x rp '.number_format($harga, 0, ',', '.').')</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($subtotal, 0, ',', '.').'</td></tr>';
		}
		$subjek = 'payment received for transaction ID '.$id_order;
		//proses
		$this->load->library('email');
		$config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
		$config['smtp_pass'] = $profil->pass_toko; //isi dengan password
		$ongkir = $order->ongkir;

		$message_user = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
		<head>
			<title>
				Tes Email Pembayaran Telah Diterima
			</title>
			<style>
			*{
				font-family: arial;
			}
			</style>
		</head>
		<body style="background: #ddd; min-width: 600px; padding: 24px 6px;">
			<div style="max-width: 700px; min-height: 500px; margin: auto; background: #fff; padding: 24px 12px; border-radius: 12px;">
			<div style="margin:auto; max-width: 500px; text-align: center;" class="icon-bayar">
				
				<h1 style="font-size: 24px;">payment received</h1>
			</div>
			<hr>
			<div class="content" style="padding: 12px;">
				<p style="margin: 0px;">thank you for completing the payment via bank transfer</p>
			</div>
			<table style="width: 100%;" cellpadding="12">
				<tr>
					<td style="width: 50%;"><p><b>total payment</b><br>rp '.number_format($order->jumlah_transfer, 0, ',', '.').'</p></td>
					<td style="width: 50%;"><p><b>payment reference</b><br>'.$idpembayaran.'</p></td>
				</tr>
				<tr>
					<td><p><b>payment method</b><br>'.$order->payment_method.'</p></td><td><p><b>payment date</b><br>'.date('d M Y', strtotime($order->tgl_pembayaran)).'</p></td>
				</tr>
				<tr>
					<td><p><b>payment status</b><br>'.$order->status.'</p></td>
				</tr>
				<tr>
					<td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'home/transaksi.html">check transaction status</a></div></td>
					<td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'">buy again</a></div></td>
				</tr>
			</table>
			<hr>
			<div style="padding: 12px;">
				<h2 style="margin: 0px; font-size: 24px;">your order</h2>
			</div>
			<hr>
			<div style="padding: 0px 4px;">
				<table cellpadding="8" style="width:100%;">
				'.$table.'
					<tr>
					<td>discount ('.$order->kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($order->potongan, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->kode_unik, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>delivery ( '.$order->kurir.'/'.$order->service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
					</tr>
				<tr>
					<td colspan="3"><hr style="margin:0px;"></td>
				</tr>
			
					<tr>
					<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->total, 0, ',', '.').'</td>
					</tr>
				</table>
				<br>
				<div style="text-align: center; padding: 12px; border-radius: 8px; background: #ffa; font-size: 14px;">
					<p>please ensure that you do not give any proof of payment and/or payment details to any party apart from waterplus+</p>
				</div>
				<hr>
			</div>
				<div style="padding: 0px 12px;">
					<p style="font-size: 14px;">please do not reply, this is a system generated email.</p>
				</div>
				<hr>
				<div>
					<p>&copy; copyright 2020</p>
				</div>
			</div>
		</body>
		</html>';

		$message_admin = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
		<head>
			<title>
				Tes Email Pembayaran Telah Diterima
			</title>
			<style>
			*{
				font-family: arial;
			}
			</style>
		</head>
		<body style="background: #ddd; min-width: 600px; padding: 24px 6px;">
			<div style="max-width: 700px; min-height: 500px; margin: auto; background: #fff; padding: 24px 12px; border-radius: 12px;">
			<div style="margin:auto; max-width: 500px; text-align: center;" class="icon-bayar">
				
				<h1 style="font-size: 24px;">payment received</h1>
			</div>
			<hr>
			<div class="content" style="padding: 12px;">
				<p style="margin: 0px;">customer payment for transaction ID '.$order->id_order.' is valid.</p>
			</div>
			<table style="width: 100%;" cellpadding="12">
				<tr>
					<td style="width: 50%;"><p><b>total payment</b><br>rp '.number_format($order->jumlah_transfer, 0, ',', '.').'</p></td>
					<td style="width: 50%;"><p><b>payment reference</b><br>'.$idpembayaran.'</p></td>
				</tr>
				<tr>
					<td><p><b>payment method</b><br>'.$order->payment_method.'</p></td><td><p><b>payment date</b><br>'.date('d M Y', strtotime($order->tgl_pembayaran)).'</p></td>
				</tr>
				<tr>
					<td><p><b>payment status</b><br>'.$order->status.'</p></td>
				</tr>
			</table>
			<hr>
			<div style="padding: 12px;">
				<h2 style="margin: 0px; font-size: 24px;">customer order</h2>
			</div>
			<hr>
			<div style="padding: 0px 4px;">
				<table cellpadding="8" style="width:100%;">
				'.$table.'
					<tr>
					<td>discount ('.$order->kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($order->potongan, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->kode_unik, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>delivery ( '.$order->kurir.'/'.$order->service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
					</tr>
				<tr>
					<td colspan="3"><hr style="margin:0px;"></td>
				</tr>
			
					<tr>
					<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->total, 0, ',', '.').'</td>
					</tr>
				</table>
				<hr>
			</div>
				<div style="padding: 0px 12px;">
					<p style="font-size: 14px;">please do not reply, this is a system generated email.</p>
				</div>
				<hr>
				<div>
					<p>&copy; copyright 2020</p>
				</div>
			</div>
		</body>
		</html>';

		$this->email->initialize($config);
		$this->email->from($profil->email_toko, $profil->title);
		$this->email->to('budihari47@gmail.com');
		//$this->email->to(array('budihari47@gmail.com','brian.chandra@waterplus.com','henry.gunawan@waterplus.com','rendi.gunawan@waterplus.com','m.ilham@waterplus.com','emaculata.dona@waterplus.com','pingkan.wenas@waterplus.com'));
		$this->email->subject($subjek);
		$this->email->message($message_admin);
		if ($this->email->send())
		{
			$this->email->initialize($config);
			$this->email->from($profil->email_toko, $profil->title);
			//$this->email->to($order->email);
			$this->email->to(
			array($order->email)
			);
			$this->email->subject($subjek);
			$this->email->message($message_user);
			if ($this->email->send())
			{
			redirect('transaksi');
			}
		}
		else{
			echo '<script type="text/javascript">
			alert("gagal dikirim");
			</script>';
		}
      //echo '<script type="text/javascript">window.history.go(-1)</script>';
   }

   public function notvalid()
   {
	$this->cek_login();

	if (!is_numeric($this->uri->segment(3)))
	{
	   echo '<script type="text/javascript">window.history.go(-1)</script>';
	}
	date_default_timezone_set("Asia/Bangkok");
	$today = date("Y-m-d H:i:s");
	$idpembayaran = $this->uri->segment(3);
	$cek = $this->bayar->get_where('buktipembayaran', array('idpembayaran' => $idpembayaran)) -> row();
	$detail = $cek->detail_pembayaran;
	  if(empty($detail)){
		$detail = 'invalid by '.$this->session->userdata('user').' at '.$today;
	  }
	  else{
		$detail = $detail.', invalid by '.$this->session->userdata('user').' at '.$today;
	  }
	  $spek = array (
					'status' => "invalid",
					'detail_pembayaran' => $detail
				);
	$this->bayar->update('buktipembayaran', $spek, ['idpembayaran' => $idpembayaran]);
	$order = array (
		'status_proses' => "not paid",
		'detail' => $detail
	);
$this->bayar->update('t_order', $order, ['id_order' => $cek->id_order]);
	  $tgl = date("ymd");
	  $profil = $this->db->get_where('t_profil', ['id_profil' => '1'])->row();
	  $table = "t_order o
			  JOIN t_users usr ON (o.email = usr.email)
			  JOIN buktipembayaran bukti ON (o.id_order = bukti.id_order)";
	  $order = $this->db->get_where($table, ['bukti.idpembayaran' => $this->uri->segment(3)])->row();
	  $status = $order->status;
	  //if($status == "not valid"){
	  //	$status = "invalid";
	  //}
	  $table = '';
	  $table1 = "t_detail_order detail
	  JOIN t_items i ON (detail.id_item = i.id_item)";
	  $detail = $this->db->get_where($table1, ['detail.id_order' => $order->id_order]);
	  foreach ($detail->result() as $row)
	  {
		  $harga = $row->harga;
		  $qty = $row->qty;
		  $subtotal = $qty * $harga;
		  $table .= '<tr><td>'.$row->nama_item.' ('.$qty.' x rp '.number_format($harga, 0, ',', '.').')</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($subtotal, 0, ',', '.').'</td></tr>';
	  }
	  $subjek = 'invalid payment for ID '.$idpembayaran;
	  //proses
	  $this->load->library('email');
	  $config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
	  $config['smtp_pass'] = $profil->pass_toko; //isi dengan password
	  $ongkir = $order->ongkir;

	  $message_user = '
	  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>
	  Tes Email Pembayaran Ditolak
  </title>
  <style>
  *{
	  font-family: arial;
  }
  </style>
</head>    
<body style="background: #ddd; min-width: 600px; padding: 24px 6px;">
  <div style="max-width: 700px; min-height: 500px; margin: auto; background: #fff; padding: 24px 12px; border-radius: 12px;">
  <div style="margin:auto; max-width: 500px; text-align: center;" class="icon-bayar">

	  <h1 style="font-size: 24px;">invalid payment</h1>
  </div>
  <hr>
  <div class="content" style="padding: 12px;">
	  <p style="margin: 0px;">sorry, we declined your payment confirmation. with the following reasons "'.$order->alasan.'". if you have a problem with your payment, please contact us.</p>
  </div>
  <table style="width: 100%;" cellpadding="12">
	  <tr>
		  <td style="width: 50%;"><p><b>total payment</b><br>rp '.number_format($order->jumlah_transfer, 0, ',', '.').'</p></td>
		  <td style="width: 50%;"><p><b>payment reference</b><br>'.$idpembayaran.'</p></td>
	  </tr>
	  <tr>
		  <td><p><b>payment method</b><br>'.$order->payment_method.'</p></td><td><p><b>payment date</b><br>'.date('d M Y', strtotime($order->tgl_pembayaran)).'</p></td>
	  </tr>
	  <tr>
		  <td><p><b>payment status</b><br>'.$status.'</p></td>
	  </tr>
	  <tr>
		  <td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'home/transaksi.html">check transaction status</a></div></td>
		  <td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'">buy again</a></div></td>
	  </tr>
  </table>
  <hr>
  <div style="padding: 12px;">
	  <h2 style="margin: 0px; font-size: 24px;">your order</h2>
  </div>
  <hr>
  <div style="padding: 0px 4px;">
	  <table cellpadding="8" style="width:100%;">
	  '.$table.'
	  <tr>
	  <td>discount ('.$order->kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($order->potongan, 0, ',', '.').'</td>
	  </tr>
	  <tr>
	  <td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->kode_unik, 0, ',', '.').'</td>
	  </tr>
	  <tr>
	  <td>delivery ( '.$order->kurir.'/'.$order->service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
	  </tr>
	  <tr>
		  <td colspan="3"><hr style="margin:0px;"></td>
	  </tr>
  
		  <tr>
		  <td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->total, 0, ',', '.').'</td>
		  </tr>
	  </table>
	  <br>
	  <div style="text-align: center; padding: 12px; border-radius: 8px; background: #ffa; font-size: 14px;">
		  <p>please ensure that you do not give any proof of payment and/or payment details to any party apart from waterplus+</p>
	  </div>
	  <hr>
  </div>
	  <div style="padding: 0px 12px;">
		  <p style="font-size: 14px;">please do not reply, this is a system generated email.</p>
	  </div>
	  <hr>
	  <div>
		  <p>&copy; copyright 2020</p>
	  </div>
  </div>
</body>
</html>';

$message_admin = '
	  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>
	  Tes Email Pembayaran Ditolak
  </title>
  <style>
  *{
	  font-family: arial;
  }
  </style>
</head>    
<body style="background: #ddd; min-width: 600px; padding: 24px 6px;">
  <div style="max-width: 700px; min-height: 500px; margin: auto; background: #fff; padding: 24px 12px; border-radius: 12px;">
  <div style="margin:auto; max-width: 500px; text-align: center;" class="icon-bayar">

	  <h1 style="font-size: 24px;">invalid payment</h1>
  </div>
  <hr>
  <div class="content" style="padding: 12px;">
	  <p style="margin: 0px;">sorry, we declined your payment confirmation. with the following reasons "'.$order->alasan.'". if you have a problem with your payment, please contact us.</p>
  </div>
  <table style="width: 100%;" cellpadding="12">
	  <tr>
		  <td style="width: 50%;"><p><b>total payment</b><br>rp '.number_format($order->jumlah_transfer, 0, ',', '.').'</p></td>
		  <td style="width: 50%;"><p><b>payment reference</b><br>'.$idpembayaran.'</p></td>
	  </tr>
	  <tr>
		  <td><p><b>payment method</b><br>'.$order->payment_method.'</p></td><td><p><b>payment date</b><br>'.date('d M Y', strtotime($order->tgl_pembayaran)).'</p></td>
	  </tr>
	  <tr>
		  <td><p><b>payment status</b><br>'.$status.'</p></td>
	  </tr>
  </table>
  <hr>
  <div style="padding: 12px;">
	  <h2 style="margin: 0px; font-size: 24px;">customer order</h2>
  </div>
  <hr>
  <div style="padding: 0px 4px;">
	  <table cellpadding="8" style="width:100%;">
	  '.$table.'
	  <tr>
	  <td>discount ('.$order->kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($order->potongan, 0, ',', '.').'</td>
	  </tr>
	  <tr>
	  <td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->kode_unik, 0, ',', '.').'</td>
	  </tr>
	  <tr>
	  <td>delivery ( '.$order->kurir.'/'.$order->service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
	  </tr>
	  <tr>
		  <td colspan="3"><hr style="margin:0px;"></td>
	  </tr>
  
		  <tr>
		  <td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($order->total, 0, ',', '.').'</td>
		  </tr>
	  </table>
	  <hr>
  </div>
	  <div style="padding: 0px 12px;">
		  <p style="font-size: 14px;">please do not reply, this is a system generated email.</p>
	  </div>
	  <hr>
	  <div>
		  <p>&copy; copyright 2020</p>
	  </div>
  </div>
</body>
</html>';

	  $this->email->initialize($config);
	  $this->email->from($profil->email_toko, $profil->title);
	  //$this->email->to($order->email);
	  $this->email->to(
		array($order->email)
		);
	  $this->email->subject($subjek);
	  $this->email->message(
	  $message_user
	  );
	  if ($this->email->send())
	  {
		$this->email->initialize($config);
		$this->email->from($profil->email_toko, $profil->title);
		//$this->email->to($order->email);
		$this->email->to(
		  array('budihari47@gmail.com','brian.chandra@waterplus.com','henry.gunawan@waterplus.com','rendi.gunawan@waterplus.com','emaculata.dona@waterplus.com')
		  );
		$this->email->subject($subjek);
		$this->email->message(
		$message_admin
		);
		if ($this->email->send())
	  	{
		  redirect('pembayaran');
		}
	  }
	  else{
		  echo '<script type="text/javascript">
		  alert("gagal dikirim");
		  </script>';
	  }
	//redirect('pembayaran');
	  
	//echo '<script type="text/javascript">window.history.go(-1)</script>';
   } //end public function not valid

   public function delete()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         echo '<script type="text/javascript">window.history.go(-1)</script>';
      }

      $this->bayar->delete('buktipembayaran', ['idpembayaran' => $this->uri->segment(3)]);

      echo '<script type="text/javascript">window.history.go(-1)</script>';
   }

   public function detail()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('pembayaran');
      }

      $bayar = [
				'idpembayaran',
				'iduser',
				'id_order',
				'tgl_pesan',
				'tgl_pembayaran',
				'namapengirim',
				'bank_asal',
				'jumlah_transfer',
				'bank_tujuan',
				'bukti',
				'status'
					];
	  $order = [
				'total'
	  ];

      $table = "buktipembayaran";

	  $data['data'] = $this->bayar->select_where($bayar, $table, ['idpembayaran' => $this->uri->segment(3)]);
	  $bayar = $data['data']->row();
	  $data['t_order'] = $this->bayar->select_where($order, 't_order', ['id_order' => $bayar->id_order])->row();

      $this->template->admin('admin/detail_pembayaran', $data);
   }

	public function report()
	{
		$this->load->library('form_validation');
		$this->cek_login();

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			$this->form_validation->set_rules('bln', 'Bulan', 'required|numeric');
			$this->form_validation->set_rules('thn', 'Tahun', 'required|numeric');

			if ($this->form_validation->run() == TRUE)
			{
				$bln = $this->input->post('bln', TRUE);
				$thn = $this->input->post('thn', TRUE);
			}

		} else {
			$bln = date('m');
			$thn = date('Y');
		}
		//YYYY-mm-dd
		//2017-04-31
		$awal  = $thn.'-'.$bln.'-01';
		$akhir = $thn.'-'.$bln.'-31';

		$where = ['tgl_pesan >=' => $awal, 'tgl_pesan <=' => $akhir, 'status !=' => 'belum'];

		$data['data'] 	= $this->trans->report($where);
		$data['bln'] 	= $bln;
		$data['thn']	= $thn;

		$this->template->admin('admin/laporan', $data);
	}

	public function cetak()
	{
		$this->cek_login();
		if (!is_numeric($this->uri->segment(3)) || !is_numeric($this->uri->segment(4)) )
		{
			redirect('pembayaran');
		}

		$bln 	= $this->uri->segment(3);
		$thn 	= $this->uri->segment(4);
		$awal = $thn.'-'.$bln.'-01';
		$akhir= $thn.'-'.$bln.'-31';

		$where = ['tgl_pesan >=' => $awal, 'tgl_pesan <=' => $akhir, 'status !=' => 'belum'];

		$data['data'] 	= $this->trans->report($where);
		$data['bln'] 	= $bln;
		$data['thn'] 	= $thn;

		$this->load->view('admin/cetak', $data);
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('admin');
		}
	}
}

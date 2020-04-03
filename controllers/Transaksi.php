<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
      	$this->load->model('trans');
	}

   public function index()
   {
		$this->cek_login();
		$query = "select id_order,resi,kurir,status_proses from t_order where status_proses = 'on process' or status_proses = 'delivery process' and resi != ''";
		$data = $this->db->query($query);
		//$data = $this->db->get('t_order');
		$cek = $data->row();
		$api  = $this->db->get_where('t_profil', ['id_profil' => 1])->row();

		if($data->num_rows() > 0){
			foreach ($data->result() as $cek) :
			if(!empty($cek->resi)){
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "waybill=".$cek->resi."&courier=".$cek->kurir,
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
				$html = "";
				$item = $cek->status_proses;
				$result = json_decode($response, TRUE)['rajaongkir'];
				//print_r($result);
				$sp = strtolower($result['result']['summary']['status']);
				if($result['status']['code'] == 400){
					$html = $result['status']['description'];
					$item = 'invalid waybill';
				}
				elseif($result['status']['code'] == 200){
					$html = $result['result']['delivery_status']['status'].' to '.$result['result']['delivery_status']['pod_receiver'].' | '.$result['result']['delivery_status']['pod_date'].' '.$result['result']['delivery_status']['pod_time'];
					if($sp != 'on process'){
						$item = strtolower($result['result']['summary']['status']);
					}
					
				}
				
				$status['status_proses'] = $item;
				$status['status_pengiriman'] = $html;
				$this->db->update('t_order', $status, array('id_order' => $cek->id_order));
			}
			}
			endforeach;
		}

		$this->template->admin('admin/transaksi');
   }

	public function ajax_list()
   	{
    $list = $this->trans->get_datatables();
    $data = array();
    $no = $_POST['start'];
	$today = date('Y-m-d');

      foreach ($list as $i) {

			$batas = $i->bts_bayar;

			if ($i->status_proses == 'not paid' && $this->session->userdata('level_admin') == 11) {

				$btn = '<a href="'.site_url('transaksi/delete/'.$i->id_order).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin Ingin Menghapus Data ini ?\')"><i class="fa fa-trash"></i></a>';

			} else {

				if ($i->status_proses == 'paid' && $this->session->userdata('level_admin') == '11') {
					$btn = '<a href="'.site_url('transaksi/process/'.$i->id_order).'" class="btn btn-success btn-xs"><i class="fa fa-circle-o-notch"></i></a>';
				} elseif ($i->status_proses == 'on process' && $this->session->userdata('level_admin') == '11') {
					$btn = '<a href="'.site_url('transaksi/resi/'.$i->id_order).'" class="btn btn-success btn-xs"><i class="fa fa-barcode"></i></a>';
				} else {
					$btn = '';
				}
			}
		 $tgl_pesan = date('d M Y / H:i:s', strtotime($i->tgl_pesan));
		 $bts_bayar = date('d M Y / H:i:s', strtotime($i->bts_bayar));
		 $waktu_pesan = explode(" / ",$tgl_pesan);
		 $bts_waktu = explode(" / ",$bts_bayar);
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = '<a href="'.base_url().'transaksi/detail/'.$i->id_order.'" style="color:#0ad;">'.$i->id_order.'</a>';
         $row[] = $i->nama_pemesan;
         $row[] = $waktu_pesan[0].'<br>'.$waktu_pesan[1];
		 $row[] = $bts_waktu[0].'<br>'.$bts_waktu[1];
		 $row[] = "Rp ".number_format($i->total, 0, ',', '.');
		 $row[] = $i->status_proses;
         $row[] = '<a href="'.base_url().'transaksi/detail/'.$i->id_order.'" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>'.$btn;

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->trans->count_all(),
               	"recordsFiltered" => $this->trans->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }

   public function konfirmasi()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('transaksi');
      }

		$select = [
						'o.id_order AS id_order',
						'tgl_pesan',
						'bts_bayar',
						'nama_pemesan',
						'status_proses',
						'pos',
						'service',
						'kota',
						'tujuan',
						'total',
						'biaya',
						'kurir',
						'nama_item',
						'qty',
						'email'
					];

      $table = "t_order o
						JOIN t_detail_order do ON (o.id_order = do.id_order)
						JOIN t_items i ON (do.id_item = i.id_item)";

		$detail = $this->trans->select_where($select, $table, ['o.id_order' => $this->uri->segment(3)]);
		$profil = $this->trans->get_where('t_profil', ['id_profil' => 1])->row();

		//proses
		$this->load->library('email');
		$config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
		$config['smtp_pass'] = $profil->pass_toko; //isi dengan password
				
		$this->email->initialize($config);
									
		$table = '';
		$no = 1;
		$biaya = 0;
		foreach ($detail->result() as $item) {
			$table .= '<tr><td>'.$no++.'</td><td>'.$item->nama_item.'</td><td>'.$item->qty.'</td><td style="text-align:right">'.number_format($item->biaya, 0, ',', '.').'</td></tr>';

			$biaya += $item->biaya;
		}

		$info_detail = $detail->row();
		$ongkir = $info_detail->total - $biaya;

		$this->email->from($profil->email_toko, $profil->title);
		$this->email->to($info_detail->email);
		$this->email->subject('Status Pemesanan');
		$this->email->message(
			'Terima Kasih telah melakukan pemesanan di toko kami, Saat ini Pesanan Anda dengan detail sebagai berikut :<br/><br/>
			Id Order : '.$info_detail->id_order.' ('.$info_detail->tgl_pesan.')<br/><br/>
			<table border="1" style="width: 80%">
			<tr><th>#</th><th>Nama Barang</th><th>Jumlah</th><th>Harga</th></tr>
			'.$table.'
			<tr><td colspan="3">Ongkos Kirim</td><td style="text-align:right">'.number_format($ongkir, 0, ',', '.').'</td></tr>
			<tr><td colspan="3">Total</td><td style="text-align:right">'.number_format($info_detail->total, 0, ',', '.').'</td></tr>
			</table><br />Sedang kami Proses.
			'
		);

		if ($this->email->send())
		{
			$this->trans->update('t_order', ['status_proses' => 'proses'], ['id_order' => $this->uri->segment(3)]);

		} else {
			echo $this->email->print_debugger(array('header'));
		}

		redirect('transaksi');
   }

   public function process()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('transaksi');
	  }
	  date_default_timezone_set("Asia/Bangkok");
	  $today = date("Y-m-d H:i:s");
	  $id_order = $this->uri->segment(3);
	  $profil = $this->db->get_where('t_profil', ['id_profil' => '1'])->row();
	  $table = "t_order o
				JOIN t_users usr ON (o.email = usr.email)
				JOIN buktipembayaran bukti ON (o.id_order = bukti.id_order)";
	  $order = $this->db->get_where($table, ['o.id_order' => $id_order])->row();
	  $do = $order->detail;
	  if(empty($do)){
		$do = 'process by '.$this->session->userdata('user').' at '.$today;
	  }
	  else{
		$do = $do.', process by '.$this->session->userdata('user').' at '.$today;
	  }
      $tableorder = array (
					'status_proses' => "on process",
					'detail'		=> $do
				);
	  $this->trans->update('t_order', $tableorder, ['id_order' => $id_order]);
	  $order = $this->db->get_where($table, ['o.id_order' => $id_order])->row();
	  $subjek = 'your order has been process. ID order '.$id_order;
	  $alamat = array();
	  $alamat1 = array();
         if (!empty($order->tujuan)) {
            array_push($alamat, $order->tujuan);
         }
         if (!empty($order->subdistrict)) {
            $subdistrict = explode(",", $order->subdistrict);
            if (!empty($subdistrict[1])) {
               array_push($alamat, $subdistrict[1]);
            }
         }
         if (!empty($order->kota)) {
            $kota = explode(",", $order->kota);
            if (!empty($kota[1])) {
               array_push($alamat, $kota[1]);
            }
         }
         if (!empty($order->provinsi)) {
            $provinsi = explode(",", $order->provinsi);
            if (!empty($provinsi[1])) {
               array_push($alamat1, $provinsi[1]);
            }
         }
         if (!empty($order->pos)) {
               array_push($alamat1, $order->pos);
         }
		 $alamat = join(", ", $alamat);
		 $alamat1 = join(", ", $alamat1);

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
	  //proses
	  $this->load->library('email');
	  $config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
	  $config['smtp_pass'] = $profil->pass_toko; //isi dengan password
	  $ongkir = $order->ongkir;

	  $this->email->initialize($config);
	  $this->email->from($profil->email_toko, $profil->title);
	  //$this->email->to($order->email);
	  $this->email->to(
		array($order->email,'budihari47@gmail.com','brian.chandra@waterplus.com','m.ilham@waterplus.com','emaculata.dona@waterplus.com','pingkan.wenas@waterplus.com')
		);
	  $this->email->subject($subjek);
	  $this->email->message(
	  '
	  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>
	  Pesanan diproses
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
		<h1 style="font-size: 24px;">your order has been processed</h1>
    </div>
  <hr>
  <div class="content" style="padding: 12px;">
        <p>hi '.$order->username.'</p>
        <p style="margin: 0px;">your order with ID '.$order->id_order.' has been process.</p>
  </div>
  <table style="width: 100%;" cellpadding="12">
        <tr>
            <td style="width: 50%;"><p><b>ID order</b><br>'.$order->id_order.'</p></td>
            <td style="width: 50%;"><p><b>order date</b><br>'.date('d M Y', strtotime($order->tgl_pesan)).'</p></td>
        </tr>
        <tr>
            <td valign="top"><p><b>address</b><br>
                <span style="font-size: 14px; line-height: 20px;">'.$order->nama_pemesan.'<br>'.$alamat.'<br>'.$alamat1.'<br>phone: '.$order->telepon.'</span>
            </p></td>
            <td valign="top">
                <p><b>status</b><br>'.$order->status_proses.'</p>
            </td>
        </tr>
        <tr>
		  <td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'home/detail_transaksi/'.$order->id_order.'">check transaction status</a></div></td>

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
</html>'
	  );
	  if ($this->email->send())
	  {
		echo '<script type="text/javascript">window.history.go(-1)</script>';
	  }
	  else{
		  echo '<script type="text/javascript">
		  alert("gagal dikirim");
		  </script>';
	  }
   }

   public function delete()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('transaksi');
      }

      $this->trans->delete(['t_order', 't_detail_order'], ['id_order' => $this->uri->segment(3)]);

      redirect('transaksi');
   }

   public function detail()
   {
      $this->cek_login();

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('transaksi');
      }

      $select = [
						'o.id_order AS id_order',
						'tgl_pesan',
						'bts_bayar',
						'nama_pemesan',
						'telepon',
						'email',
						'status_proses',
						'pos',
						'service',
						'subdistrict',
						'kota',
						'provinsi',
						'tujuan',
						'total',
						'biaya',
						'catatan',
						'kurir',
						'resi',
						'kupon',
						'potongan',
						'kode_unik',
						'ongkir',
						'nama_item',
						'qty',
						'bukti',
						'bukti_pengiriman'
					];

      $table = "t_order o
						JOIN t_detail_order do ON (o.id_order = do.id_order)
						JOIN t_items i ON (do.id_item = i.id_item)";

	  $data['data'] = $this->trans->select_where($select, $table, ['o.id_order' => $this->uri->segment(3)]);
	  $cek = $data['data']->row();
	  $api  = $this->db->get_where('t_profil', ['id_profil' => 1])->row();
	  $html = "";

$data['status'] = 0;
$data['response'] = 'nomor resi belum di input';

if(!empty($cek->resi)){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "waybill=".$cek->resi."&courier=".$cek->kurir,
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
	//print_r($result);
	$html = "";
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
	$data['status'] = 1;
	//$html = rtrim($html,'<br>');
	}
	else{
		$result = json_decode($response, TRUE)['rajaongkir'];
		$html = $result['status']['description'];
		$data['status'] = 0;
	}
	$data['response'] = $html;
	/*
	$result = json_decode($response, TRUE);
	$html = $result['rajaongkir']['query']['waybill'];
	
	for ($i=0; $i < count($result['rajaongkir']['results']['manifest']); $i++) {
	   $html .= '<span>'.$result['rajaongkir']['results']['manifest'][$i]['manifest_description'].'</span><br>';
	}

	$data['response'] = $html;
	*/
}
}
	 
	  
      $this->template->admin('admin/detail_transaksi', $data);
   }

   public function resi()
   {
      $this->cek_login();

      $id_order = $this->uri->segment(3);

      if (!is_numeric($this->uri->segment(3)))
      {
         redirect('transaksi');
	  }
	  date_default_timezone_set("Asia/Bangkok");
	  $today = date("Y-m-d H:i:s");
      if ($this->input->post('form', TRUE) == 'Submit') {
         //validasi
      		$this->form_validation->set_rules('resi', 'Nomor Resi', 'required|min_length[4]');

         if ($this->form_validation->run() == TRUE)
         {

	  $table = "t_order o
				JOIN t_users usr ON (o.email = usr.email)";
	  $order = $this->db->get_where($table, ['o.id_order' => $this->uri->segment(3)])->row();
	  $do = $order->detail;
	  if(empty($do)){
		$do = 'delivery process by '.$this->session->userdata('user').' at '.$today;
	  }
	  else{
		$do = $do.', delivery process by '.$this->session->userdata('user').' at '.$today;
	  }
	  $subjek = 'your order with ID '.$id_order.' has been submitted to the courier';
	  $alamat = array();
	  $alamat1 = array();
         if (!empty($order->tujuan)) {
            array_push($alamat, $order->tujuan);
         }
         if (!empty($order->subdistrict)) {
            $subdistrict = explode(",", $order->subdistrict);
            if (!empty($subdistrict[1])) {
               array_push($alamat, $subdistrict[1]);
            }
         }
         if (!empty($order->kota)) {
            $kota = explode(",", $order->kota);
            if (!empty($kota[1])) {
               array_push($alamat, $kota[1]);
            }
         }
         if (!empty($order->provinsi)) {
            $provinsi = explode(",", $order->provinsi);
            if (!empty($provinsi[1])) {
               array_push($alamat1, $provinsi[1]);
            }
         }
         if (!empty($order->pos)) {
               array_push($alamat1, $order->pos);
         }
		 $alamat = join(", ", $alamat);
		 $alamat1 = join(", ", $alamat1);
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
	  $profil = $this->db->get_where('t_profil', ['id_profil' => '1'])->row();
	  //proses
	  $this->load->library('email');
	  $config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
	  $config['smtp_pass'] = $profil->pass_toko; //isi dengan password
	  $ongkir = $order->ongkir;

	  $this->email->initialize($config);
	  $this->email->from($profil->email_toko, $profil->title);
	  //$this->email->to($order->email);
	  $this->email->to(
		array($order->email,'budihari47@gmail.com','brian.chandra@waterplus.com','m.ilham@waterplus.com','emaculata.dona@waterplus.com','pingkan.wenas@waterplus.com')
		);
	  $this->email->subject($subjek);
	  $this->email->message(
	  '
	  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>
	  Pesanan dikirim
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
        <h1 style="font-size: 24px;">your order has been sent</h1>
    </div>
  <hr>
  <div class="content" style="padding: 12px;">
        <p>hi '.$order->username.'</p>
        <p style="margin: 0px;">your order with ID '.$order->id_order.' has been submitted to the courier.</p>
  </div>
  <table style="width: 100%;" cellpadding="12">
        <tr>
            <td style="width: 50%;"><p><b>ID order</b><br>'.$order->id_order.'</p></td>
            <td style="width: 50%;"><p><b>order date</b><br>'.date('d M Y', strtotime($order->tgl_pesan)).'</p></td>
		</tr>
		
		<tr>
		<td valign="top"><p><b>courier information</b><br>
			<span style="font-size: 14px; line-height: 20px;">'.$order->kurir.'<br>('.$order->service.')
		</p></td>
		<td valign="top">
			<p><b>tracking number</b><br>'.$this->input->post('resi').'</p>
		</td>
		</tr>

        <tr>
            <td valign="top"><p><b>address</b><br>
                <span style="font-size: 14px; line-height: 20px;">'.$order->nama_pemesan.'<br>'.$alamat.'<br>'.$alamat1.'<br>phone: '.$order->telepon.'</span>
            </p></td>
            <td valign="top">
                <p><b>status</b><br>delivery process</p>
            </td>
        </tr>
        <tr>
		  <td><div style="background: rgba(10,42,59,1); border-radius:4px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'home/detail_transaksi/'.$order->id_order.'">check transaction status</a></div></td>

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
</html>'
	  );
	  if ($this->email->send())
	  {
			$order = array (
			'resi' => $this->input->post('resi'),
		  	'status_proses' => "delivery process"
	  		);
			$this->trans->update('t_order', $order, ['id_order' => $id_order]);
			redirect('transaksi');
	  }
	  else{
		  echo "Email tidak berhasil dikirim";
	  }

		 } // end $this->form_validation->run() == TRUE
     }
      $select = [
						'o.id_order AS id_order',
						'tgl_pesan',
						'bts_bayar',
						'nama_pemesan',
						'telepon',
						'email',
						'status_proses',
						'pos',
						'service',
						'kota',
						'provinsi',
						'tujuan',
						'total',
						'biaya',
						'kurir',
						'resi',
						'ongkir',
						'nama_item',
						'qty',
						'bukti',
						'bukti_pengiriman'
					];

      $table = "t_order o
						JOIN t_detail_order do ON (o.id_order = do.id_order)
						JOIN t_items i ON (do.id_item = i.id_item)";

      $data['data'] = $this->trans->select_where($select, $table, ['o.id_order' => $id_order]);

      $this->template->admin('admin/resi', $data);
   }

	public function up_bukti()
	{
		//validasi uri
		if (!$this->uri->segment(3)) { redirect('transaksi'); }

		if ($this->input->post('submit', TRUE) == 'Submit') {
			//load libarary form validation
			$this->load->library('form_validation');
			/*
			$config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
		  	$config['smtp_pass'] = $profil->pass_toko; //isi dengan password
			
      		$this->email->initialize($config);
			*/
			$this->form_validation->set_rules('trans', 'Id Transaksi', 'required|numeric');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './assets/bukti/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['file_name'] = 'bukti'.time();

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('img'))
				{
					$gbr = $this->upload->data();
					//proses update data
					$this->trans->update('t_order', ['pengiriman' => $gbr['file_name']], ['id_order' => $this->input->post('trans', TRUE)]);

					redirect('transaksi');

				} else {
					$this->session->set_flashdata('alert', 'anda belum memilih foto');
				}

			}
		}

		$data['id_trans']	=	$this->uri->segment(3);

		$this->template->admin('admin/up_bukti', $data);
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

		$where = ['tgl_pesan >=' => $awal, 'tgl_pesan <=' => $akhir, 'status_proses !=' => 'belum'];

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
			redirect('transaksi');
		}

		$bln 	= $this->uri->segment(3);
		$thn 	= $this->uri->segment(4);
		$awal = $thn.'-'.$bln.'-01';
		$akhir= $thn.'-'.$bln.'-31';

		$where = ['tgl_pesan >=' => $awal, 'tgl_pesan <=' => $akhir, 'status_proses !=' => 'belum'];

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

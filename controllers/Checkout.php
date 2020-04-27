<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart', 'encryption'));
		$this->load->library('session');
		$this->load->model('app');
	}

	public function add()
	{
		if (!$this->session->userdata('user_id'))
		{
			redirect();
		}
		else{
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

		$get = $this->app->get_where('alamat', array('iduser' => $this->session->userdata('user_id')))->row();

		if($this->input->post('submit') == 'Submit')
		{

			$this->load->library('form_validation');
			$this->form_validation->set_rules('receiver', 'recipient s name', "required|min_length[3]");
			$this->form_validation->set_rules('phone', 'phone number', "required|min_length[8]|numeric");
			$this->form_validation->set_rules('prov', 'province', "required");
			$this->form_validation->set_rules('kota', 'city', "required");
			$this->form_validation->set_rules('subdistrict', 'subdistrict', "required");
			$this->form_validation->set_rules('postal', 'postal code', "required|min_length[5]|numeric");
			$this->form_validation->set_rules('address', 'your address', "required|min_length[10]");

			if ($this->form_validation->run() == TRUE)
			{
					$prov = $this->input->post('prov', TRUE);
					$data = array(
						'idalamat' 		=> $new_id,
						'iduser' 		=> $this->session->userdata('user_id'),
						'nama' 			=> $this->input->post('receiver', TRUE),
						'phone' 		=> $this->input->post('phone', TRUE),
						'provinsi' 		=> $prov,
						'kabupaten' 	=> $this->input->post('kota', TRUE),
						'kota' 	        => $this->input->post('subdistrict', TRUE),
						'kodepos' 		=> $this->input->post('postal', TRUE),
						'alamat' 		=> $this->input->post('address', TRUE),
						'aktif' 		=> "1"
					);
$update = array(
		'aktif' 		=> "0"
		);
$this->app->update('alamat', $update, array('iduser' => $this->session->userdata('user_id')));
					if ($this->app->insert('alamat', $data))
					{
						$this->session->set_flashdata('success', 'shipping option has been added');
						//redirect ('checkout');
						echo '
						<script>
							window.history.go(-1)
						</script>
						';

					} else {
						$this->session->set_flashdata('alert', 'shipping option not added');
						//redirect ('checkout');
						echo '
						<script>
							window.history.go(-1)
						</script>
						';
					}

			}
			}
		}
	}

	public function change()
	{
		if (!$this->session->userdata('user_id'))
		{
			redirect('home');
		}
		else{
			if (!empty($this->input->post('change', TRUE))) {
				$data = array(
					'aktif' 		=> "0"
				);
				$this->app->update('alamat', $data, array('iduser' => $this->session->userdata('user_id')));
				$data = array(
					'aktif' 		=> "1"
				);
				$this->app->update('alamat', $data, array('iduser' => $this->session->userdata('user_id'), 'idalamat' => $this->input->post('change', TRUE)));
				$this->session->set_flashdata('success', 'address changed successfully');
				//redirect ('checkout');
				echo '
						<script>
							window.history.go(-1)
						</script>
						';
			}
		}
	}
	public function update(){
		if ($this->input->post('submit', TRUE) == "Submit") {
			$id = $this->encryption->decrypt($this->input->post('id'));
    		$data = array(
						'nama' 			=> $this->input->post('receiver', TRUE),
						'phone' 		=> $this->input->post('phone', TRUE),
						'provinsi' 		=> $this->input->post('prov', TRUE),
						'kabupaten' 	=> $this->input->post('kota', TRUE),
						'kota' 	        => $this->input->post('subdistrict', TRUE),
						'kodepos' 		=> $this->input->post('postal', TRUE),
						'alamat' 		=> $this->input->post('address', TRUE)
			);
			$cond = array('idalamat' => $id);
			if ($this->app->update('alamat', $data, $cond))
					{
						$this->session->set_flashdata('success', 'shipping option has been update');
						//redirect ('checkout');
						echo '
						<script>
							window.history.go(-1)
						</script>
						';

					} else {
						$this->session->set_flashdata('alert', 'failed to update');
						//redirect ('checkout');
						echo '
						<script>
							window.history.go(-1)
						</script>
						';
					}
    	}// end if post change
	}
	
	public function payment_info()
	{
	    if ($this->session->userdata('user_id'))
		{
		        $kode_bayar = $this->uri->segment(3);
		        $table = 't_order t_order JOIN t_users users ON (t_order.email = users.email)';
		        $sql = 't_detail_order detail JOIN t_items item ON (detail.id_item = item.id_item)';
                $detail = $this->app->get_where($sql, ['detail.id_order' => $kode_bayar]);
          		$get = $this->db->get_where($table, ['t_order.id_order' => $kode_bayar]);
				$user = $get->row();
				$profil = $this->db->get_where('t_profil', ['id_profil' => 1])->row();
				
				$key['nama']        = $user->username;
		        //$key['phone']       = $user->phone;
        		$key['id_order'] 	= $kode_bayar;
        		$key['provinsi']	= $user->provinsi;
        		$key['kabupaten'] 	= $user->kota;
				$key['kota'] 		= $user->subdistrict;
				$key['alamat'] 	    = $user->tujuan;
				$key['pos'] 		= $user->pos;
				$key['kurir'] 		= $user->kurir;
				$key['layanan'] 	= $user->service;
				$key['ongkir'] 	    = $user->ongkir;
				$key['potongan']    = $user->potongan;
				$key['uniq']    	= $user->kode_unik;
				$key['total'] 		= $user->total;
				$key['tgl_pesan'] 	= $user->tgl_pesan;
				$key['today']       = date("Y-m-d H:i:s");
				$key['tglpesan']    = date('d-m-Y', strtotime($key['tgl_pesan']));
				$key['bts'] 		= $user->bts_bayar;
				$key['bts_bayar']	= date('d-M-Y / H:i:s',strtotime($key['bts']));
				$key['rekening']    = $profil->rekening;
				$key['detail']      = $detail;
				$key['title']       = 'payment info';

				$table = '';
				$no = 1;
				/*
				foreach ($this->cart->contents() as $carts) {
					$table .= '<tr><td style="text-align:center;">'.$no++.'</td><td>'.$carts['name'].'</td><td style="text-align:center;">'.$carts['qty'].'</td><td style="text-align:right">rp '.number_format($carts['subtotal'], 0, ',', '.').'</td></tr>';
				}
				$key['table'] = $table;
				*/
				$this->template->olshop('infopembayaran', $key);
		}
	}
	
	public function index()
	{
	    date_default_timezone_set("Asia/Bangkok");
		if (!$this->cart->contents())
		{
			redirect('home');
		}
		
		$page = 'checkoutnew';
		$key['ongkir'] = "";
		if (!$this->session->userdata('uniq'))
      	{
			$kodeunik = rand(1,50);
			do {
				$query = $this->db->get_where('t_order',['kode_unik' => $kodeunik, 'status_proses' => 'not paid']);
				//$judul = $this->input->post('link', TRUE).'_'.$kodeunik; //rename foto yang diupload
				//$name = $judul . $ext;
				if($query -> num_rows() > 0){
					$validation = 'same';
					$kodeunik++;
				}
				else{
					$validation = 'not';
				}
				} while ($validation == 'same');
			$datauser = array (
				'uniq' => $kodeunik
    		     );
			$this->session->set_userdata($datauser);
		}
		$key['uniq'] = $this->session->userdata('uniq');

		if ($this->input->post('submit', TRUE) == 'submit' && $this->session->userdata('user_id'))
    	{
    		/*
    		if ($this->input->post('saveprofil', TRUE) == 'save') {
						$data = array(
						'fullname' 	=> $this->input->post('first_name', TRUE).' '.$this->input->post('last_name', TRUE),
						'email' 			=> $this->input->post('user_mail', TRUE),
						'telp' 			=> $this->input->post('telp', TRUE),
						'provinsi' 		=> $this->input->post('prov', TRUE),
						'kabupaten' 	=> $this->input->post('kota', TRUE),
						'alamat' 	=> $this->input->post('alamat', TRUE),
						'kodepos' 	=> $this->input->post('kd_pos', TRUE)
					);
						$this->app->update('t_users', $data, array('id_user' => $this->session->userdata('user_id')));
			}*/
					if (empty($this->input->post('layanan', TRUE))) {
						$this->session->set_flashdata('alert', 'choose courier first');
						redirect('checkout');
					}
          			$get = $this->app->get_where('t_users', ['id_user' => $this->session->userdata('user_id')]);
					$user = $get->row();

					$nama_pemesan = $user->username;
					$email = $user->email;
				$profil 	= $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$admin		= $this->app->get_where('t_admin', ['id_admin' => 1])->row();
				//proses
				$this->load->library('email');

				$config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
				$config['smtp_pass'] = $profil->pass_toko; //isi dengan password
				
				$this->email->initialize($config);
                $get = $this->app->get_where('alamat', ['iduser' => $this->session->userdata('user_id'), 'aktif' => "1"]);
                $user = $get->row();
		        $nama = $user->nama;
		        $phone = $user->phone;
        		$id_order 	= time();
        		$provinsi	= $user->provinsi;
        		$kabupaten 	= $user->kabupaten;
				$kota 		= $user->kota;
				$alamat 	= $user->alamat;
				$pos 		= $user->kodepos;
				$kurir 		= $this->input->post('kurir', TRUE);
				$layanan 	= explode(",", $this->encryption->decrypt($this->input->post('layanan', TRUE)));
				$service 	= $layanan[1];
				$ongkir 	= $layanan[0];
				$kupon		= $this->session->userdata('nama_kupon');
				$potongan   = $this->session->userdata('discount');
				$kodeunik	= $this->session->userdata('uniq');
				$total 		= $this->cart->total() + $ongkir + $kodeunik - $potongan;
				$tgl_pesan 	= date("Y-m-d");
				$today      = date("Y-m-d H:i:s");
				$tglpesan   = date('d-m-Y', strtotime($today));
				$bts 		= date('Y-m-d H:i:s',strtotime('+1 day',strtotime($today)));
				$bts_bayar	= date('d-M-Y / H:i:s',strtotime('+1 day',strtotime($today)));
				$rekening 	= $profil->rekening;
				$method = 'bank transfer';
				$subjek = 'waiting payment for transaction ID '.$id_order;
				$this->session->unset_userdata('uniq');
				$this->session->unset_userdata('discount');
				$this->session->unset_userdata('nama_kupon');

				$table = '';
				$no = 1;
				foreach ($this->cart->contents() as $carts) {
					$table .= '<tr><td style="text-align:center;">'.$no++.'</td><td>'.$carts['name'].'</td><td style="text-align:center;">'.$carts['qty'].'</td><td style="text-align:right">rp '.number_format($carts['subtotal'], 0, ',', '.').'</td></tr>';
				}
				$key['table'] = $table;
				$table = '';

				foreach ($this->cart->contents() as $row)
				{
					$table .= '<tr><td>'.$row['name'].' ('.$row['qty'].' x '.number_format($row['price'], 0, ',', '.').')</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($row['subtotal'], 0, ',', '.').'</td></tr>';
				}

		$waktu = explode(" / ", $bts_bayar);
		$tanggal = explode("-", $waktu[0]);
		$tgl = $tanggal[0];
		$bulan = $tanggal[1];
		$tahun = $tanggal[2];
		$total1 = substr($total, 0, -3);
		$total2 = substr($total, -3);
		
        $this->email->set_mailtype("html");
        $this->email->from($profil->email_toko, $profil->title);
        $this->email->to($email);
        $this->email->subject($subjek);
        $this->email->message(
		'
		<!DOCTYPE html>
		<html>
		<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>
				Info Pembayaran
			</title>
			<style>
			*{
				font-family: arial;
			}
			</style>
		</head>
		<body style="background: #ddd; min-width: 600px; padding: 24px 6px;">
			<div style="max-width: 700px; min-height: 500px; margin: auto; background: #fff; padding: 24px 12px; border-radius: 12px;">
			<div class="content" style="padding: 12px;">
			<p>hi '.$nama_pemesan.'</p>
			<p>one more step and this item will be yours! don\'t wait until it runs out, complete the process now.</p>
			<div>
                <p>please complete the payment before the item runs out.</p>
                <div style="text-align: center; background: #ddd; padding:12px; font-size: 12px; border-radius:8px;">
                    <p>remaining time for your payment</p>
                    <p style="font-size: 24px; font-weight: bold; ">'.$waktu[1].' WIB<br></p>
                    <p style="font-size: 14px;">'.$waktu[0].'</p>
                </div>
			</div>
			<br>
            <div style="text-align: center; padding: 12px; border-radius: 8px; background: #ffa; font-size: 14px;">
                <p>please ensure that you do not give any proof of payment and/or payment details to any party apart from waterplus+</p>
			</div>
			<br>
            <div style="font-size: 14px;">
                <p style="line-height:24px;">total amount payable:<br>
				<span style="font-size:24px;">rp '.number_format($total1, 0, ',', '.').',<span style="color:#007;"><u>'.$total2.'</u></span></span><br>
				<span>enter payment until exactly the last 3 digits</span>
                </p>
			</div>
			<br>
            <div style="font-size: 14px;">
                <p>transfer your payment to the following bank account:</p>
                <table style="width:auto; margin:0px 12px;">
                <tr>
                    <td><img style="max-width:80px;" src="'.base_url().'assets/img/bca.png"></td>
                    <td>&nbsp;&nbsp;<span>'.$rekening.'</span>
                    </td>
                </tr>
                </table>
                <p style="padding:0px 12px;">p.t. bisnis plus sosial</p>
            </div>
			</div>
			<hr>
			<table style="width: 100%;" cellpadding="12">
				<tr>
					<td style="width: 50%;"><p><b>ID order</b><br>'.$id_order.'</p></td>
					<td style="width: 50%;"><p><b>due date of payment</b><br>'.$waktu[0].'</p></td>
				</tr>
				<tr>
					<td><p><b>payment method</b><br>'.$method.'</p></td><td><p><b>payment status</b><br>not paid</p></td>
				</tr>
				<tr>
					<td><div style="background: rgba(10,42,59,1); border-radius:8px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'payment/confirm/'.$id_order.'">upload proof of payment</a></div></td>
					<td><div style="background: rgba(10,42,59,1); border-radius:8px;"><a style="color: #fff; text-decoration: none; line-height:50px; padding:15px 24px;" href="'.base_url().'home/transaksi.html">check transaction status</a></div></td>
				</tr>
			</table>
			<div style="padding: 12px;">
				<span>please note the order ID in the bank transfer statement or upload proof of payment</span>
			</div>
			<hr>
			<div style="padding: 12px;">
				<h2 style="margin: 0px; font-size: 24px;">your order</h2>
			</div>
			<hr>
			<div style="padding: 0px 4px;">
				<table cellpadding="8" style="width:100%;">
				'.$table.'
			
					<tr>
					<td>discount ('.$kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($potongan, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($kodeunik, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>delivery ( '.$kurir.'/'.$service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
					</tr>
				<tr>
					<td colspan="3"><hr style="margin:0px;"></td>
				</tr>
					<tr>
					<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($total, 0, ',', '.').'</td>
					</tr>
				</table>
			</div>
				<div style="padding: 2px 12px; border-radius:6px; background:#ddd;">
					<p style="font-size: 14px;">please do not reply, this is a system generated email.</p>
				</div>
				<div>
					<p>&copy; copyright 2020</p>
				</div>
			</div>
		</body>
		</html>
		');

          if ($this->email->send())
          {
			$data = array(
				'id_order' 			=> $id_order,
				'nama_pemesan' 		=> $nama,
				'telepon'       	=> $phone,
				'email' 			=> $email,
				'kupon'				=> $kupon,
				'potongan'			=> $potongan,
				'total' 			=> $total,
				'kode_unik'			=> $kodeunik,
				'tujuan' 			=> $alamat,
				'pos' 				=> $pos,
				'subdistrict' 		=> $kota,
				'kota' 				=> $kabupaten,
				'provinsi' 	    	=> $provinsi,
				'kurir' 			=> $kurir,
				'service' 			=> $layanan[1],
				'ongkir' 			=> $layanan[0],
				'tgl_pesan' 		=> $today,
				'bts_bayar' 		=> $bts,
				'payment_method' 	=> $method,
				'status_proses'		=> 'not paid'
			);
		if ($this->app->insert('t_order', $data)) {

			foreach ($this->cart->contents() as $key) {
				$id_item = $key['id'];
				$qty = $key['qty'];
				$query1 = "SELECT terjual FROM t_items WHERE id_item = '$id_item'";
				$cek1 = $this->db->query($query1)->row();
				$terjual = $cek1->terjual + $qty;
				$detail = [
					'id_order' 	=> $id_order,
					'id_item' 	=> $key['id'],
					'qty' 		=> $key['qty'],
					'biaya' 	=> $key['subtotal'],
					'catatan' 	=> $key['note']
				];
				$t_item = [
					'terjual' 	=> $terjual
				];
				$this->app->insert('t_detail_order', $detail);
				$this->app->update('t_items', $t_item, array('id_item' => $id_item));
			}

			$this->cart->destroy();

				//$key['key']    = $this->app->get_where('t_profil', ['id_profil' => 1]);

					$this->email->from($profil->email_toko, $profil->title);
		        	$this->email->to(array($admin->email,'m.ilham@waterplus.com','brian.chandra@waterplus.com','emaculata.dona@waterplus.com','pingkan.wenas@waterplus.com'));
					//$this->email->to($admin->email);
		        	$this->email->subject('Pesanan Masuk');
		        	$this->email->message(
					  'Hai admin,<br /><br />Ada pesanan baru dari '.$nama_pemesan.' dengan ID pesanan '.$id_order.' pada tanggal '.date('d M Y', strtotime($tgl_pesan)).'. Silahkan login untuk melihat detail pesanan secara lengkap.
			<hr>
			<table style="width: 100%;" cellpadding="12">
				<tr>
					<td style="width: 50%;"><p><b>ID order</b><br>'.$id_order.'</p></td>
					<td style="width: 50%;"><p><b>due date of payment</b><br>'.$waktu[0].'</p></td>
				</tr>
				<tr>
					<td><p><b>payment method</b><br>'.$method.'</p></td><td><p><b>payment status</b><br>not paid</p></td>
				</tr>
			</table>
			<hr>
			<div style="padding: 12px;">
				<h3 style="margin: 0px; font-size: 24px;">customer order</h3>
			</div>
			<hr>
			<div style="padding: 0px 4px;">
				<table cellpadding="8" style="width:100%;">
				'.$table.'
			
					<tr>
					<td>discount ('.$kupon.')</td><td style="text-align:right; color:red;">rp</td><td style="text-align:right; color:red;">'.number_format($potongan, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>unique code</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($kodeunik, 0, ',', '.').'</td>
					</tr>
					<tr>
					<td>delivery ( '.$kurir.'/'.$service.' )</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($ongkir, 0, ',', '.').'</td>
					</tr>
				<tr>
					<td colspan="3"><hr style="margin:0px;"></td>
				</tr>
					<tr>
					<td>total</td><td style="text-align:right;">rp</td><td style="text-align:right;">'.number_format($total, 0, ',', '.').'</td>
					</tr>
				</table>
			</div>
					  '
		        	);

					if ($this->email->send())
					{
						
					}
				} // end if ($this->app->insert('t_order', $data))
				else{
				    echo "data tidak tersimpan";
				}
          } else {
            echo $this->email->print_debugger(array('headers'));
          }
        

		/*
		        $key['title']  = "payment info";
		        $key['user'] = $user;
				$key['nama'] = $nama;
				$key['phone'] = $phone;
				$key['id_order'] = $id_order;
				$key['provinsi'] = $provinsi;
				$key['kabupaten'] = $kabupaten;
				$key['kota'] = $kota;
				$key['alamat'] = $alamat;
				$key['pos'] = $pos;
				$key['kurir'] = $kurir;
				$key['layanan'] = $layanan;
				$key['service'] = $service;
				$key['ongkir'] = $ongkir;
				$key['potongan'] = $potongan;
				$key['total'] = $total;
				$key['tgl_pesan'] = $tgl_pesan;
				$key['tglpesan'] = $tglpesan;
				$key['bts'] = $bts;
				$key['bts_bayar'] = $bts_bayar;
				$key['rekening'] = $rekening;
				$key['ongkir'] = $layanan[0];
				$key['table'] = $table;
				*/
				$redirect = 'checkout/payment_info/'.$id_order;
                redirect($redirect);
		} //end if submit
		
		$key['deskripsi_kupon'] = '';
		//$this->session->unset_userdata('uniq');
		if (!$this->session->userdata('discount'))
      	{
			$datauser = array (
				'nama_kupon' 	=> '',
				'discount' 		=> 0
    		     );
			$this->session->set_userdata($datauser);
		}
		else{
			$kupon 	= $this->app->get_where('kupon', ['id_kupon' => $this->session->userdata('nama_kupon')]);
			if($kupon->num_rows() == 1){
				$kupon = $kupon->row();
				if($this->cart->total() < $kupon->min_bayar || $kupon->kategori == 'ongkir'){
					$datauser = array (
						'nama_kupon' 	=> '',
						'discount' 		=> 0
						 );
					$this->session->set_userdata($datauser);
				}
				else{
					$diskon = $kupon->persen * $this->cart->total() / 100;
					if($diskon >= $kupon->potongan){
						$diskon = $kupon->potongan;
					}
					$datauser = array (
						'discount' 		=> $diskon
						 );
					$this->session->set_userdata($datauser);
					$key['deskripsi_kupon'] = '<span style="line-height:18px;">'.strtolower($kupon->deskripsi_kupon).'</span>';
				}
			}
		}
		$key['discount'] = $this->session->userdata('discount');

		$key['key']    = $this->app->get_where('t_profil', ['id_profil' => 1]);
		$key['title']  = "checkout";
		if ($this->session->userdata('user_id'))
		{
		$get = $this->app->get_where('alamat', ['iduser' => $this->session->userdata('user_id'), 'aktif' => "1"]);
		if ($get -> num_rows() < 1) {
			$this->session->set_flashdata('alert', 'add shipping address first');
		$key['idalamat'] = "";
		$key['nama1'] = "";
		$key['telp'] = "";
		$key['provinsi'] = "";
		$key['kabupaten'] = "";
		$key['alamat'] = "";
		$key['kodepos'] = "";
		$key['kurir'] = "";
		$key['layanan'] = "";
		$key['ongkir'] = "";
		$key['address'] = "";
		}
		else{
		$user = $get->row();
		$nama = $user->nama;
		$name = $nama;
		$key['idalamat'] = $this->encryption->encrypt($user->idalamat);
		$key['nama1'] = $name;
		$key['telp'] = $user->phone;
		$key['provinsi'] = explode(",", $user->provinsi);
		$key['kabupaten'] = explode(",", $user->kabupaten);
		$key['kecamatan'] = explode(",", $user->kota);
		$key['alamat'] = $user->alamat;
		$key['kodepos'] = $user->kodepos;
		$key['kurir'] = $this->input->post('kurir', TRUE);
		$key['layanan'] = $this->input->post('layanan', TRUE);
		$key['address'] = $this->app->get_where('alamat', array('iduser' => $this->session->userdata('user_id')));
		}
			$this->template->olshop($page, $key);
		}
		else{
			$datauser = array (
				'check' => TRUE,
				'link' => 'checkout'
    		     );
          	$this->session->set_userdata($datauser);
			redirect('home/login');
		}
	} //end if function index

   public function city()
   {
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('prov', 'Provinsi', 'required');

			if ($this->form_validation->run() == TRUE)
			{
		      $prov = explode(",", $this->input->post('prov', TRUE));
				$key  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
		      $curl = curl_init();

		      curl_setopt_array($curl, array(
		        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=$prov[0]",
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => "",
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 30,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => "GET",
		        CURLOPT_HTTPHEADER => array(
		          "key: ".$key->api_key
		        ),
		      ));

		      $response = curl_exec($curl);
		      $err = curl_error($curl);

		      curl_close($curl);

		      if ($err) {
		        echo "cURL Error #:" . $err;
		      } else {
		         $data = json_decode($response, TRUE);

		         echo '<option value="" selected disabled>Kota / Kabupaten</option>';

		         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		         	//$kabupaten = $kabupaten;
		         	$kota = $data['rajaongkir']['results'][$i]['city_name'];
		         	//if ($kota == $kabupaten) {
		         	//	$selected = "selected";
		         	//}
		            echo '<option value="'.$data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name'].'">'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
		         }
		      }
			}
		}
   }
   
   public function subdistrict()
   {
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('kabupaten', 'kabupaten', 'required');

			if ($this->form_validation->run() == TRUE)
			{
		      $prov = explode(",", $this->input->post('kabupaten', TRUE));
			  $key  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
		      $curl = curl_init();

		      curl_setopt_array($curl, array(
		        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$prov[0]",
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => "",
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 30,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => "GET",
		        CURLOPT_HTTPHEADER => array(
		          "key: ".$key->api_key
		        ),
		      ));

		      $response = curl_exec($curl);
		      $err = curl_error($curl);

		      curl_close($curl);

		      if ($err) {
		        echo "cURL Error #:" . $err;
		      } else {
		         $data = json_decode($response, TRUE);

		         echo '<option value="" selected disabled>select subdistrict</option>';

		         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		         	//$kabupaten = $kabupaten;
		         	$kota = $data['rajaongkir']['results'][$i]['subdistrict_name'];
		         	//if ($kota == $kabupaten) {
		         	//	$selected = "selected";
		         	//}
		            echo '<option value="'.$data['rajaongkir']['results'][$i]['subdistrict_id'].','.$data['rajaongkir']['results'][$i]['subdistrict_name'].'">'.$data['rajaongkir']['results'][$i]['subdistrict_name'].'</option>';
		         }
		      }
			}
		}
   }

   /*
   public function allcity()
   {
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

				$key  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
		      $curl = curl_init();

		      curl_setopt_array($curl, array(
		        CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => "",
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 30,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => "GET",
		        CURLOPT_HTTPHEADER => array(
		          "key: ".$key->api_key
		        ),
		      ));

		      $response = curl_exec($curl);
		      $err = curl_error($curl);

		      curl_close($curl);

		      if ($err) {
		        echo "cURL Error #:" . $err;
		      } else {
		         $data = json_decode($response, TRUE);

		         echo '<option value="" selected disabled>Kota / Kabupaten</option>';

		         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
		         	$kabupaten = $this->encryption->encrypt($data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name']);
		         	if ($kota == $kabupaten) {
		         		$selected = "selected";
		         	}
		            echo '<option value="'.$kabupaten.'" '.$selected.'>'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
		         }
		      }
		}
   }
   */

   public function ongkir()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('dest', 'Tujuan', 'required');
			$this->form_validation->set_rules('kurir', 'Kurir', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$api  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$asal = $api->asal;
				$dest = explode(",", $this->input->post('dest', TRUE));
				$kurir = $this->input->post('kurir', TRUE);
				$berat = 0;

				foreach ($this->cart->contents() as $key) {
					$berat += ($key['weight'] * $key['qty']);
				}

				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "origin=$asal&destination=$dest[0]&weight=$berat&courier=$kurir",
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
				  	$data = json_decode($response, TRUE);
				  	echo '<option value="" selected disabled>Layanan yang tersedia</option>';

				  	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

						for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {
							$biaya = explode(',', $this->encryption->decrypt($this->input->post('layanan', TRUE)));
							$total = $this->cart->total() + $biaya[0];
							$datauser = array (
    		    			'cost' => $biaya[0]
    		    			);
          					$this->session->set_userdata($datauser);
		
							echo $biaya[0].','.$total;
							echo '<option value="'.$this->encryption->encrypt($data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service']).'">';
							echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

						}

				  	}
			  	}
			}
		}
	}

	public function getcost()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('dest', 'Tujuan', 'required');
			$this->form_validation->set_rules('kurir', 'Kurir', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$api  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$asal = $api->asal;
				$dest = explode(",", $this->input->post('dest', TRUE));
				$kurir = $this->input->post('kurir', TRUE);
				$berat = 0;

				foreach ($this->cart->contents() as $key) {
					$berat += ($key['weight'] * $key['qty']);
				}

				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "origin=$asal&originType=subdistrict&destination=$dest[0]&destinationType=subdistrict&weight=$berat&courier=$kurir",
				                       //origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne
				  CURLOPT_HTTPHEADER => array(
				    "content-type: application/x-www-form-urlencoded",
				    "key: ".$api->api_key
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				  	echo "cURL Error :" . $err;
				} else {
				  	$data = json_decode($response, TRUE);
				  	echo '<option value="" selected disabled>select service</option>';

				  	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

						for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

							echo '<option value="'.$this->encryption->encrypt($data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service']).'">';
							echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].' ('.strtolower($data['rajaongkir']['results'][$i]['costs'][$l]['description']).')</option>';

						}

				  	}
			  	}
			}
		}
	}

		public function layanan()
		{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('dest', 'Tujuan', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$api  = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
				$asal = $api->asal;
				$dest = explode(",", $this->input->post('dest', TRUE));
				$kurir = "jne";
				$berat = $this->input->post('berat', TRUE);

				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "origin=$asal&destination=$dest[0]&weight=$berat&courier=$kurir",
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
				  	$data = json_decode($response, TRUE);

				  	echo '<option value="" selected disabled>layanan yang tersedia</option>';

				  	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

						for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

							echo '<option value="'.$this->encryption->encrypt($data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service']).'">';
							echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

						}

				  	}
			  	}
			}
		}
	}

	public function discount()
	{
		$total = $this->cart->total();
		echo $this->get_discount('diskon',$this->input->post('coupon'),$this->input->post('ongkir'),$total);
		//echo $diskon.',,'.$total.',,'.$deskripsi;
	}

	public function get_discount($tipe=null,$id_kupon=null,$biaya_ongkir,$total)
	{
		date_default_timezone_set("Asia/Bangkok");
		$kupon 	= $this->db->get_where('kupon', ['id_kupon' => $id_kupon]);
		$ongkir = 0;
		if(!empty($biaya_ongkir)){
			$layanan 	= explode(",", $this->encryption->decrypt($biaya_ongkir));
			$ongkir 	= $layanan[0];
		}
		$deskripsi = "";
		if($kupon->num_rows() == 1){
			$kupon = $kupon->row();
			$diskon = $kupon->persen * $total / 100;
			$username = $this->session->userdata('username');
			$today = date("Y-m-d");
			$jarak = 0 - $kupon->batas_waktu;
			$date = date('Y-m-d',strtotime($jarak.' day',strtotime($today)));;
			if($total >= $kupon->min_bayar){
				if($kupon->batas_waktu == 0){
					$query1 = "SELECT o.kupon,usr.id_user,usr.username FROM t_order o JOIN t_users usr ON (o.email = usr.email) WHERE o.kupon = '$kupon->id_kupon' and usr.username = '$username'";
				}
				else{
					$query1 = "SELECT o.kupon,usr.id_user,usr.username FROM t_order o JOIN t_users usr ON (o.email = usr.email) WHERE o.tgl_pesan BETWEEN '$date' and '$today' and o.kupon = '$kupon->id_kupon' and usr.username = '$username'";
				}
				$cek1 = $this->db->query($query1);
				$jml = $cek1->num_rows();
				if($jml < $kupon->batas_peruser){
				if($kupon->kategori != 'ongkir'){
					if($diskon > $kupon->potongan){
						$diskon = $kupon->potongan;
					}
					$datauser = array (
						'nama_kupon' => $kupon->id_kupon,
						'discount' => $diskon
							);
					$this->session->set_userdata($datauser);
					$deskripsi = '<span style="line-height:18px;">'.strtolower($kupon->deskripsi_kupon).'</span>';
				}
				
				elseif($kupon->kategori == 'ongkir'){
					if($ongkir > 1){
						if($ongkir < $kupon->potongan){
						$diskon = $ongkir;
						}
						else{
							$diskon = $kupon->potongan;
						}
						$datauser = array (
							'nama_kupon' => $kupon->id_kupon,
							'discount' => $diskon
						);
						$this->session->set_userdata($datauser);
						$deskripsi = '<span style="line-height:18px;">'.strtolower($kupon->deskripsi_kupon).'</span>';
					}
					else{
						$deskripsi = '<span style="color:red;">choose a courier first</span>';
					}
				}

			}
			else{
				$datauser = array (
					'nama_kupon' => '',
					'discount' => 0
						);
				$this->session->set_userdata($datauser);
				$deskripsi = '<span style="color:red;">sorry, you have reached the coupon usage limit.</span>';
			}
				
			} //end if $this->cart->total() >= $kupon->min_bayar
			else{
				$datauser = array (
					'nama_kupon' => '',
					'discount' => 0
						);
				$this->session->set_userdata($datauser);
				$deskripsi = '<span style="color:red;">sorry, your total price is less than rp '.number_format($kupon->min_bayar, 0, ',', ',').'</span>';
			}
		} //end if num rows = 0
		else{
			$datauser = array (
				'nama_kupon' => '',
				'discount' => '0'
					);
			$this->session->set_userdata($datauser);
			if(!empty($id_kupon)){
				$deskripsi = '<span style="color:red;">coupon not found</span>';
			}
		}
		$diskon = $this->session->userdata('discount');
		//$ongkir = str_replace(array(',', '.'), "", $this->input->post('ongkir', TRUE));
		$totalbayar = $total + $ongkir + $this->session->userdata('uniq') - $this->session->userdata('discount');
		if($tipe=='diskon'){
			$result = $diskon.',,'.$totalbayar.',,'.$deskripsi;
			return $result;
		}
		else if($tipe=='ongkir'){
			$result = $ongkir.',,'.$totalbayar.',,'.$diskon.',,'.$deskripsi;
			return $result;
		}
		
	}

	public function unique()
	{
		$kodeunik = rand(1,50);
		do {
			$query = $this->db->get_where('t_order',['kode_unik' => $kodeunik, 'status_proses' => 'not paid']);
			//$judul = $this->input->post('link', TRUE).'_'.$kodeunik; //rename foto yang diupload
			//$name = $judul . $ext;
			if($query -> num_rows() > 0){
				$validation = 'same';
				$kodeunik++;
			}
			else{
				$validation = 'not';
			}
			} while ($validation == 'same');
		$datauser = array (
			'uniq' => $kodeunik
				);
		$this->session->set_userdata($datauser);
		$ongkir = str_replace(array(',', '.'), "", $this->input->post('layanan', TRUE));
		$total = $this->cart->total() + $ongkir + $this->session->userdata('uniq') - $this->session->userdata('discount');
		echo $kodeunik.','.$total;
	}

	public function cost()
	{
		if (!$this->input->is_ajax_request()) {

			redirect('checkout');

		} else {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('layanan', 'Layanan', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$total = $this->cart->total();
				echo $this->get_discount('ongkir',$this->input->post('kupon'),$this->input->post('layanan'),$total);
				/*
				$datauser = array (
    		    'cost' => $biaya[0]
    		     );
				  $this->session->set_userdata($datauser);
				 */
				//echo $biaya[0].',,'.$total.',,'.$diskon.',,'.$deskripsi;
			}
		}
	}
}

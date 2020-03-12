<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template','cart', 'form_validation'));
		$this->load->model('app');
	}
   
   public function index()
   {

      $data['payment'] = $this->db->order_by('tgl_pembayaran','desc')->get_where('buktipembayaran', array('iduser' => $this->session->userdata('user_id')));
      $data['title']    = "payment history";
      $this->template->olshop('paymentm',$data);
   }

	public function confirm()
	{
		if ($this->session->userdata('user_id'))
      {
      if ($this->input->post('submit', TRUE) == 'Submit') {
         $this->db->select_max('idpembayaran');
         $id = $this->db->get('buktipembayaran') -> row();
         $idpembayaran = time();
         //validasi
      	$this->form_validation->set_rules('id', 'order id', 'required|min_length[4]');
         $this->form_validation->set_rules('date', 'date', 'required');
			$this->form_validation->set_rules('sender', 'sender name', 'required|min_length[4]');
         $this->form_validation->set_rules('amount', 'amount transferred', 'required');
         $this->form_validation->set_rules('originbank', 'origin bank', 'required');
			$this->form_validation->set_rules('tobank', 'to bank', 'required');

         if ($this->form_validation->run() == TRUE)
         {
            $config['upload_path'] = './assets/bukti/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['file_name'] = 'bukti'.time();

            $this->load->library('upload', $config);
            $table = 't_order t_order JOIN t_users users ON (t_order.email = users.email)';
            $id_order = $this->app->get_where($table, ['t_order.id_order' => $this->input->post('id', TRUE)]);
            $cek_bayar = $this->app->get_where('buktipembayaran', ['id_order' => $this->input->post('id', TRUE)]);
            $status_bayar = $cek_bayar -> row();
            if($cek_bayar -> num_rows() >= 1 && $status_bayar != "valid"){
               $this->db->delete('buktipembayaran', ['id_order' => $this->input->post('id', TRUE)]);
            }
            else if($status_bayar == "valid"){
               $this->session->set_flashdata('alert', 'anda sudah membayar untuk transaksi ini');
               echo '<script type="text/javascript">window.history.go(-1)</script>';
            }
            if ($id_order -> num_rows() == 1) {
               $id_order = $id_order->row();

               if ($this->upload->do_upload('file'))
               {
               $gbr = $this->upload->data();
               //proses insert data item
               $amount = $this->input->post('amount', TRUE);
               $amount = str_replace(",","",$amount);
               $items = array (
                  'idpembayaran' => $idpembayaran,
                  'iduser' => $this->session->userdata('user_id'),
                  'id_order' => $this->input->post('id', TRUE),
                  'tgl_pesan' => $id_order->tgl_pesan,
                  'tgl_pembayaran' => date("Y-m-d H:i:sa"),
                  'namapengirim' => $this->input->post('sender', TRUE),
                  'jumlah_transfer' => $amount,
                  'bank_asal' => $this->input->post('originbank', TRUE),
                  'bank_tujuan' => $this->input->post('tobank', TRUE),
                  'bukti' => $gbr['file_name'],
                  'status' => "not verified"
                  );
               
                  $profil 	= $this->app->get_where('t_profil', ['id_profil' => 1])->row();
                  $admin	= $this->app->get_where('t_admin', ['id_admin' => 1])->row();
                  //proses email
                  $this->load->library('email');
                  $config['host'] = 'mail.waterplus.com'; //isi dengan host email
                  $config['smtp_user'] = $profil->email_toko; //isi dengan email
                  $config['smtp_pass'] = $profil->pass_toko; //isi dengan password
                  
                  $this->email->initialize($config);
                  $this->email->set_mailtype("html");
                  $this->email->from($profil->email_toko, $profil->title);
                  $this->email->to(
                      array('admin@websederhana.com','m.ilham@waterplus.com','brian.chandra@waterplus.com')
                      );
                  $this->email->subject('Konfirmasi Pembayaran');
                  $this->email->message(
                    'Hai admin,<br /><br />Ada yang melakukan konfirmasi pembayaran dari akun '.$id_order->username.' dengan ID transaksi '.$id_order->id_order.' pada tanggal '.date("Y-m-d").' dengan nominal Rp. '.number_format($amount, 0, ',', '.').'. Silahkan login untuk melihat detail pembayaran secara lengkap.
         <hr>
         <h3>Detail Pembayaran</h3>
         <table style="width: 100%;" cellpadding="12">
				<tr>
					<td style="width: 50%;"><p><b>ID order</b><br>'.$id_order->id_order.'</p></td>
					<td style="width: 50%;"><p><b>ID Pembayaran</b><br>'.$idpembayaran.'</p></td>
				</tr>
				<tr>
					<td><p><b>Metode Pembayaran</b><br>'.$id_order->payment_method.'</p></td><td><p><b>Tanggal Bayar</b><br>'.date("Y-m-d").'</p></td>
            </tr>
            <tr>
            <td><p><b>Jumlah Transfer</b><br>Rp. '.number_format($amount, 0, ',', '.').'</p></td><td><p><b>Status Pembayaran</b><br>not verified</p></td>
            </tr>
         </table>
         <hr>
         <div>
         <p>Bukti Pembayaran</p>
         <img style="max-width:500px;" src="'.base_url().'assets/bukti/'.$gbr['file_name'].'" alt="bukti bayar">
         </div>
                    '
                  );
 
                  if ($this->email->send())
                  {
                     $this->app->insert('buktipembayaran', $items);
                     $this->session->set_flashdata('success', 'payment has been sent');
                  }
                  redirect('payment');
               } else {
                  $this->session->set_flashdata('alert', 'anda belum memilih foto');
                  echo '<script type="text/javascript">window.history.go(-1)</script>';
               }

            }
            else{
               $this->session->set_flashdata('alert', 'data not found');
               echo '<script type="text/javascript">window.history.go(-1)</script>';
            }
            
         }
     }
      $data['id_order'] = $this->uri->segment(3);
		$data['title'] 	= "payment confirmation";
      	$this->template->olshop('payment',$data);
      }
      else{
         $datauser = array (
            'check' => TRUE,
            'link' => $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)
             );
         $this->session->set_userdata($datauser);
         redirect('signin');
      }
	}
   function cek_login()
   {
      if (!$this->session->userdata('user_id'))
      {
         redirect('signin');
      }
   }
}
?>
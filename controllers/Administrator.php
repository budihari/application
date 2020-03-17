<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
		$this->load->model('admin');
	}

	public function index()
	{
		$this->cek_login();

		$data['user'] 		= $this->admin->count('t_users');
		$data['tag'] 		= $this->admin->count('t_kategori');
		$data['item'] 		= $this->admin->count('t_items');
		$data['trans'] 		= $this->admin->count_where('t_order', ['status_proses!=' => 'belum']);
		$sql				= $this->db->order_by('tgl_pesan','desc');
		if($this->session->userdata('level_admin') == '11'){
			$sql 		= $this->db->get_where('t_order', ['status_proses !=' => 'not paid'], 5);
		}
		elseif($this->session->userdata('level_admin') == '21'){
			$sql 		= $this->db->get_where('t_order', ['status_proses' => 'not paid'], 5);
		}
		$data['last'] 		= $sql;
		// $this->admin->last('t_order', 5, 'tgl_pesan');
		if($this->session->userdata('level_admin') == '11'){
			$this->template->admin('admin/home', $data);
		}
		elseif($this->session->userdata('level_admin') == '21'){
			$this->template->admin('admin/home_finance', $data);
		}
	}

	public function edit_profil()
	{
		$this->cek_login();

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			//validasi form
			$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('fullname', 'Fullname', "required|trim|min_length[3]|regex_match[/^[a-z A-Z.']+$/]");
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$get_data = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

				if (!password_verify($this->input->post('password',TRUE), $get_data->password))
				{
					echo '<script type="text/javascript">alert("Password yang anda masukkan salah");window.location.replace("'.base_url().'login/logout")</script>';
				} else {

					$data = array(
						'username' => $this->input->post('username', TRUE),
						'fullname' => $this->input->post('fullname', TRUE),
						'email' => $this->input->post('email', TRUE),
					);

					$cond = array('id_admin' => $this->session->userdata('admin'));

					$this->admin->update('t_admin', $data, $cond);

					redirect('administrator');
				}
			}

		}

		$get = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

		$data['username'] = $get->username;
		$data['fullname'] = $get->fullname;
		$data['email'] 		= $get->email;

		$this->template->admin('admin/edit_profil', $data);
	}

	public function update_password()
	{
		$this->cek_login();

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			//validasi form

			$this->form_validation->set_rules('password1', 'Password Baru', 'required');
			$this->form_validation->set_rules('password2', 'Password Lama', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$get_data = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

				if (!password_verify($this->input->post('password2',TRUE), $get_data->password))
				{
					echo '<script type="text/javascript">alert("Password lama yang anda masukkan salah");window.location.replace("'.base_url().'login/logout")</script>';

				} else {

					$pass = $this->input->post('password1', TRUE);
					$data['password'] = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
					$cond = array('id_admin' => $this->session->userdata('admin'));

					$this->admin->update('t_admin', $data, $cond);

					redirect('login/logout');
				}
			}
		}
		$this->template->admin('admin/update_pass');
	}

	public function kupon()
	{
		$this->cek_login();

		$sql = $this->db->order_by('terakhir_update','desc');
		$sql = $this->db->get('kupon');
		$data['header'] = "Manajemen Kupon";
		$data['kupon'] = $sql;
		$this->template->admin('admin/list_kupon', $data);
	}

	public function add_kupon()
	{

		$this->cek_login();

		if ($this->input->post('formkupon', TRUE) == 'Submit') {
			//validasi
			$this->form_validation->set_rules('id_kupon', 'ID Kupon', 'required');
			$this->form_validation->set_rules('nama_kupon', 'Nama Kupon', 'required|min_length[4]');
			$this->form_validation->set_rules('deskripsi_kupon', 'Deskripsi Kupon', 'required');
			$this->form_validation->set_rules('persen', 'Berapa Persen', 'required');
			$this->form_validation->set_rules('potongan', 'Maksimal Diskon', 'required');
			$this->form_validation->set_rules('stok_kupon', 'Stok Kupon', 'required');
			$this->form_validation->set_rules('min_beli', 'Minimal Pembelian', 'required');
			$this->form_validation->set_rules('batas_peruser', 'Batas Peruser', 'required');
			if($this->form_validation->run() == TRUE){
			$id_kupon = $this->input->post('id_kupon', TRUE);
			//$table = 't_order o JOIN t_users usr ON (o.email = usr.email)';
			//$cek = $this->bayar->get_where($table, array('o.id_order' => $id_order)) -> row();
			$potongan = str_replace(array(',', '.'), "", $this->input->post('potongan', TRUE));
			$min_beli = $this->input->post('min_beli', TRUE);
			$min_beli = str_replace(array(',', '.'), "", $min_beli);
			$kupon = array (
				'id_kupon' => $id_kupon,
				'terakhir_update' => date("Y-m-d h:i:s", time()),
				'nama_kupon' => $this->input->post('nama_kupon', TRUE),
				'deskripsi_kupon' => $this->input->post('nama_kupon', TRUE),
				'persen' => $this->input->post('persen', TRUE),
				'potongan' => $potongan,
				'stok_kupon' => $this->input->post('stok_kupon', TRUE),
				'min_bayar' => $min_beli,
				'kategori' => $this->input->post('kategori', TRUE),
				'batas_peruser' => $this->input->post('batas_peruser', TRUE),
				'batas_waktu' => $this->input->post('batas_waktu', TRUE),
				'dibuat' => $this->session->userdata('user')
			 );
			 $this->db->insert('kupon', $kupon);
			 redirect('administrator/kupon');
			} // end if form validation true
		  } // end submit

		$data['header'] = "Tambah Kupon";
		$this->template->admin('admin/form_kupon', $data);
	}

	public function edit_kupon()
	{

		$this->cek_login();

		$id_kupon = $this->uri->segment(3);

		if ($this->input->post('formkupon', TRUE) == 'Submit') {
			//validasi
			$this->form_validation->set_rules('id_kupon', 'ID Kupon', 'required');
			$this->form_validation->set_rules('nama_kupon', 'Nama Kupon', 'required|min_length[4]');
			$this->form_validation->set_rules('deskripsi_kupon', 'Deskripsi Kupon', 'required');
			$this->form_validation->set_rules('persen', 'Berapa Persen', 'required');
			$this->form_validation->set_rules('potongan', 'Maksimal Diskon', 'required');
			$this->form_validation->set_rules('stok_kupon', 'Stok Kupon', 'required');
			$this->form_validation->set_rules('min_beli', 'Minimal Pembelian', 'required');
			$this->form_validation->set_rules('batas_peruser', 'Batas Peruser', 'required');
			if($this->form_validation->run() == TRUE){
			//$table = 't_order o JOIN t_users usr ON (o.email = usr.email)';
			//$cek = $this->bayar->get_where($table, array('o.id_order' => $id_order)) -> row();
			$potongan = str_replace(array(',', '.'), "", $this->input->post('potongan', TRUE));
			$min_beli = $this->input->post('min_beli', TRUE);
			$min_beli = str_replace(array(',', '.'), "", $min_beli);
			$kupon = array (
				'id_kupon' => $this->input->post('id_kupon', TRUE),
				'terakhir_update' => date("Y-m-d h:i:s", time()),
				'nama_kupon' => $this->input->post('nama_kupon', TRUE),
				'deskripsi_kupon' => $this->input->post('nama_kupon', TRUE),
				'persen' => $this->input->post('persen', TRUE),
				'potongan' => $potongan,
				'stok_kupon' => $this->input->post('stok_kupon', TRUE),
				'min_bayar' => $min_beli,
				'kategori' => $this->input->post('kategori', TRUE),
				'batas_peruser' => $this->input->post('batas_peruser', TRUE),
				'batas_waktu' => $this->input->post('batas_waktu', TRUE),
				'dibuat' => $this->session->userdata('user')
			);
			$this->db->update('kupon', $kupon, array('id_kupon' => $id_kupon));
			redirect('administrator/kupon');
			} // end if form validation true
		  } // end submit

		$kupon = $this->db->get_where('kupon', array('id_kupon' => $id_kupon));
		$data['header'] = "Tambah Kupon";
		$data['kupon'] = $kupon;
		$this->template->admin('admin/form_kupon', $data);
	}

	public function delete_kupon()
   	{
   		$this->cek_login();
		$id_kupon = $this->uri->segment(3);
		$this->db->delete('kupon', ['id_kupon' => $id_kupon]);
		echo '<script type="text/javascript">window.history.go(-1)</script>';
   	}

	public function report()
	{
		$data = $this->admin->report();

		foreach ($data->result() as $key) {
			echo ($key->total - $key->biaya);
		}
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('admin_waterplus');
		}
	}
}

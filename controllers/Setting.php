<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation', 'encryption'));
		$this->load->model('admin');
	}

	public function index()
	{
		$this->cek_login();

		if ($this->input->post('submit', TRUE)) {
			//validasi
			$this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('hp', 'Phone', 'required|min_length[5]|max_length[15]|numeric');
			$this->form_validation->set_rules('fb', 'Facebook', 'required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('twitter', 'Twitter', 'required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('gplus', 'G+', 'required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('alamat', 'Alamat Toko', 'required|min_length[5]');
			$this->form_validation->set_rules('email_toko', 'Email Toko', 'required|valid_email');
			$this->form_validation->set_rules('pass_toko', 'Password Email Toko', 'required|min_length[5]');
			$this->form_validation->set_rules('asal', 'ID Kota / Kabupaten', 'required|max_length[4]|numeric');
			$this->form_validation->set_rules('api_key', 'Api Key', 'required|min_length[5]');
			$this->form_validation->set_rules('rekening', 'Rekening', 'required|min_length[8]');

			if ($this->form_validation->run() == TRUE) {
				$password = $this->encryption->decrypt($this->input->post('pass_toko', TRUE));
				$apikey = $this->encryption->decrypt($this->input->post('api_key', TRUE));
				$profile = array(
					'title' => $this->input->post('title', TRUE),
					'phone' => $this->input->post('hp', TRUE),
					'alamat_toko' => $this->input->post('alamat', TRUE),
					'facebook' => $this->input->post('fb', TRUE),
					'twitter' => $this->input->post('twitter', TRUE),
					'gplus' => $this->input->post('gplus', TRUE),
					'youtube' => $this->input->post('youtube', TRUE),
					'pinterest' => $this->input->post('pinterest', TRUE),
					'instagram' => $this->input->post('instagram', TRUE),
					'email_toko' => $this->input->post('email_toko', TRUE),
					'asal' => $this->input->post('asal', TRUE),
					'rekening' => $this->input->post('rekening', TRUE)
				);
				if ($this->input->post('pass_toko', TRUE) != 'the password') {
					$profile['pass_toko'] = $this->input->post('pass_toko', TRUE);
				}
				if ($this->input->post('api_key', TRUE) != 'the api key') {
					$profile['api_key'] = $this->input->post('api_key', TRUE);
				}

				//$update = ;
				if($this->db->update('t_profil', $profile, ['id_profil' => 1])){
					$this->session->set_flashdata('success', 'Data berhasil di update');
					echo '
					<script>
					window.history.go(-1);
					</script>
					';
				}
				else{
					$this->session->set_flashdata('alert', 'Data gagal di update');
					echo '
					<script>
					window.history.go(-1);
					</script>
					';
				}

				//redirect('setting');
			}

			$data['judul']    	= $this->input->post('title', TRUE);
			$data['alamat']   	= $this->input->post('alamat', TRUE);
			$data['hp']       	= $this->input->post('hp', TRUE);
			$data['fb']       	= $this->input->post('fb', TRUE);
			$data['twitter']  	= $this->input->post('twitter', TRUE);
			$data['gplus']    	= $this->input->post('gplus', TRUE);
			$data['mail_toko']   = $this->input->post('email_toko', TRUE);
			$data['pass_toko']   = $this->input->post('pass_toko', TRUE);
			$data['api_key']   	= $this->input->post('api_key', TRUE);
			$data['asal']  	  	= $this->input->post('asal', TRUE);
			$data['rekening']  	= $this->input->post('rekening', TRUE);
		} else {

			$profil = $this->admin->get_all('t_profil')->row();

			$data['judul']    	= $profil->title;
			$data['alamat']   	= $profil->alamat_toko;
			$data['hp']       	= str_replace('-', '', $profil->phone);
			$data['fb']       	= $profil->facebook;
			$data['twitter']  	= $profil->twitter;
			$data['gplus']    	= $profil->gplus;
			$data['youtube']    = $profil->youtube;
			$data['pinterest']  = $profil->pinterest;
			$data['instagram']  = $profil->instagram;
			$data['mail_toko']  = $profil->email_toko;
			$data['pass_toko']  = 'the password';
			$data['api_key']    = 'the api key';
			$data['asal']	    = $profil->asal;
			$data['rekening']   = $profil->rekening;
		}

		$this->template->admin('admin/setting', $data);
	}

	function faq()
	{
		if ($this->input->post('form_faq', TRUE)) {
			$x = 0;
			$no = 1;
			$query = "DELETE from faq";
			$this->db->query($query);
			if (!empty($this->input->post('pertanyaan')[$x])) { //if post pertanyaan not empty
				foreach ($this->input->post('pertanyaan') as $value) {
				if (!empty($value)) {
					if ($x < 10) {
						$count = '0' . $x;
					} elseif ($x >= 10) {
						$count = $x;
					}
				$id = $this->input->post('idpertanyaan')[$x];
				if(!empty($id)){
					$id = $id;
				}
				else{
					$query = "SELECT MAX(id) AS id FROM faq";
					$cek = $this->db->query($query)->row();
					$id = $cek->id + 1;
				}
				$pertanyaan = $value;
				$jawaban = $this->input->post('jawaban')[$x];
				$query = "SELECT id from faq where id = '$id'";
				$cek = $this->db->query($query);
				if($cek->num_rows() == 1){
					$record = array(
						'tanya'		=> $pertanyaan,
						'jawab'		=> $jawaban,
						'urut'		=> $no
					);
					$this->db->update('faq', $record, array('id' => $id));
				}
				else if($cek->num_rows() == 0){
					$record = array(
						'id'		=> $id,
						'tanya'		=> $pertanyaan,
						'jawab'		=> $jawaban,
						'urut'		=> $no
					);
					$this->db->insert('faq', $record);
				}
				$x++;
				$no++;
				}
				}
				$this->session->set_flashdata('success', 'Berhasil di update');
			}
			echo '
			<script>
				window.history.go(-1);
			</script>
			';
		}
		$data['header']   = 'Frequently Asked Question';
		$this->template->admin('admin/form_faq', $data);
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin')) {
			redirect('login');
		} elseif ($this->session->userdata('level_admin') != '11') {
			echo '<script type="text/javascript">
			alert("Anda tidak di izinkan untuk mengakses halaman ini!");
			window.history.go(-1);
			</script>';
		}
	}
}

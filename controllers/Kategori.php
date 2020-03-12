<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart', 'encryption','session','Recaptcha'));
		$this->load->model('app');
	}
	
    public function index()
	{

		$offset = (!$this->uri->segment(3)) ? 0 : $this->uri->segment(3);

		$url = strtolower(str_replace([' ','%20','_'], '-', $this->uri->segment(1)));

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
		if (empty($this->uri->segment(2)) || $this->uri->segment(2)=='page') {
		//configure
		$config['base_url'] 	= base_url().$this->uri->segment(1).'/page/';
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 3;

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
			$masterkategori = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(1)]);
			if ($masterkategori->num_rows() > 0) {
			$masterkategori = $masterkategori->row();
			$data['subkat'] = $masterkategori->masterkategori;
			$data['url'] = strtolower($masterkategori->masterkategori);
			}
			else{
			    redirect();
			}
			$data['item_rows'] = $this->app->get_where($table, ['i.aktif' => 1, 'k.id_master' => $idmaster]);
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(1)])->row();
		}
		else if (!empty($this->uri->segment(2)) && $this->uri->segment(2)!='page') {
		$subkategori = $this->app->get_where('t_kategori', ['url' => $this->uri->segment(2)])->row();
		//configure
		$config['base_url'] 	= base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)])->num_rows();
		$config['per_page'] 	= 24;
		$config['uri_segment'] 	= 3;

		$this->pagination->initialize($config);
		$data['link']  = $this->pagination->create_links();
			if ($this->input->get('sort', TRUE)){
			$sort = $this->input->get('sort');
			$sort2 = explode(",", $sort);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by($sort2[0], $sort2[1])->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->order_by('urut ASC, link ASC')->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)], $config['per_page'], $offset);
			//$data['data'] 		= $this->db->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)], $config['per_page'], $offset);
			}
			$page="subkategori";
			$subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(2)]);
			if ($subkat->num_rows() > 0) {
			$subkat = $subkat->row();
			$data['subkat'] = $subkat->kategori;
			}
			else{
			    redirect();
			}
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(2)));
			$data['item_rows'] = $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(2)]);
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(1)])->row();
			$data['thumbnail'] = $subkategori -> foto_kategori;
			$data['thumbnail2'] = 'kategori';
		}
		$data['title'] 		= $data['url'];
		$data['total_row'] = $config['total_rows'];
		$data['metadeskripsi'] = "anda dapat melihat daftar produk di kategori ".$data['url'];
		$this->template->olshop($page, $data);
	}
}
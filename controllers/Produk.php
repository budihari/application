<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart', 'encryption','session','Recaptcha'));
		$this->load->model('app');
	}
	
	public function index()
	{
	    date_default_timezone_set('Asia/Jakarta');
		$id = $this->uri->segment(2);
		//$rrr = "brand like '%waterplus%' or aktif = '1'";
		$items = $this->app->get_where('t_items', array('link' => $id));
		//$r = $this->app->get_where($rrr);
		$get = $items->row();
		$metadeskripsi = $get->metadeskripsi;
		$thumbnail = $get->gambar;
		//$paket = "id_item = '$get->id_item'";
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
		'halaman' => $this->uri->segment(2),
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
		//$data['package'] = $this->app->get_where('paket',$paket);
		$data['nf'] = $this->app->get_where('t_favorite', ['id_item' => $get->id_item]);
		$data['spesifikasi'] = $this->app->get_where('spesifikasi', ['id_item' => $get->id_item, 'model' => $get->model]);
		$data['kat'] 	= $this->app->get_where('t_kategori', array('id_kategori' => $rk->id_kategori));
		$id_master = $data['kat']->row();
		$data['master'] = $this->db->get_where('masterkategori', ['id' => $id_master->id_master])->row();
		$data['data'] 	= $items;
		//$data['r'] 		= $r;
		$data['img'] 	= $this->app->get_where('t_img', ['id_item' => $get->id_item]);
		$data['title']  = $get -> nama_item;
		$data['key']    = $this->app->get_where('t_profil', ['id_profil' => 1]);
		$data['rating'] = $this->app->get_where('rating', ['id_item' => $get->id_item]);
		$data['metadeskripsi'] = $metadeskripsi;
		$data['thumbnail'] = $thumbnail;
		$data['thumbnail2'] = 'item';
		$this->template->olshop('item_detail', $data);
	}
	
	public function detail()
	{
	    date_default_timezone_set('Asia/Jakarta');
		$id = $this->uri->segment(3);
		//$rrr = "brand like '%waterplus%' or aktif = '1'";
		$items = $this->app->get_where('t_items', array('link' => $id));
		//$r = $this->app->get_where($rrr);
		$get = $items->row();
		$metadeskripsi = $get->metadeskripsi;
		$thumbnail = $get->gambar;
		//$paket = "id_item = '$get->id_item'";
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
		//$data['package'] = $this->app->get_where('paket',$paket);
		$data['nf'] = $this->app->get_where('t_favorite', ['id_item' => $get->id_item]);
		$data['spesifikasi'] = $this->app->get_where('spesifikasi', ['id_item' => $get->id_item, 'model' => $get->model]);
		$data['kat'] 	= $this->app->get_where('t_kategori', array('id_kategori' => $rk->id_kategori));
		$id_master = $data['kat']->row();
		$data['master'] = $this->db->get_where('masterkategori', ['id' => $id_master->id_master])->row();
		$data['data'] 	= $items;
		//$data['r'] 		= $r;
		$data['img'] 	= $this->app->get_where('t_img', ['id_item' => $get->id_item]);
		$data['title']  = $get -> nama_item;
		$data['key']    = $this->app->get_where('t_profil', ['id_profil' => 1]);
		$data['rating'] = $this->app->get_where('rating', ['id_item' => $get->id_item]);
		$data['metadeskripsi'] = $metadeskripsi;
		$data['thumbnail'] = $thumbnail;
		$data['thumbnail2'] = 'item';
		$this->template->olshop('item_detail', $data);
	}

}
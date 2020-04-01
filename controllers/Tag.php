<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {

	function __construct()
	{
		parent::__construct();
      $this->load->library(array('template', 'form_validation'));
      $this->load->model('items');
      $this->load->model('tags');
	}

   public function index()
	{
		$this->cek_login();

      $this->template->admin('admin/tag');
	}

   public function add_kategori()
   {
      $this->cek_login();
      $id_item = $this->uri->segment(3);

      if ($this->input->post('itemform', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('url', 'Url Kategori', 'required|min_length[4]');
         $this->form_validation->set_rules('kategori', 'Nama Kategori', 'required|min_length[4]');

         if ($this->form_validation->run() == TRUE)
         {
            $config['upload_path'] = './assets/upload/kategori/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['file_name'] = $this->input->post('url');

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar'))
            {
               $gbr = $this->upload->data();
               $items = array (
                  'id_kategori' => $this->input->post('id', TRUE),
                  'url' => $this->input->post('url', TRUE),
                  'kategori' => $this->input->post('kategori', TRUE),
                  'foto_kategori' => $gbr['file_name'],
                  'id_master' => $this->input->post('master', TRUE)
               );
               $this->items->insert('t_kategori', $items);
               redirect('tag');
            }
            else {
               $this->session->set_flashdata('alert', 'anda belum memilih foto');
            }
            }
         }
      $data['master'] = $this->items->get_all('masterkategori');
      $data['kategori'] = "";
      $data['header'] = "Add Kategori";
      $this->template->admin('admin/tagform', $data);
   }

   public function update_kategori()
   {
      $this->cek_login();
      $id_item = $this->uri->segment(3);

      if ($this->input->post('itemform', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('url', 'Url Kategori', 'required|min_length[4]');
         $this->form_validation->set_rules('kategori', 'Nama Kategori', 'required|min_length[4]');

         if ($this->form_validation->run() == TRUE)
         {
            $config['upload_path'] = './assets/upload/kategori/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['file_name'] = $this->input->post('url');

            $this->load->library('upload', $config);
            $idsubkategori = array(); // cek idsubkategori from post idsubkategori
            $subkategori = array();
            $urlsubkategori = array();
            $cek = $this->items->get_where('t_kategori', array('id_kategori' => $id_item))->row();
            $idsub = array(); //cek idsubkategori from database
            if(!empty($cek->kategori2)){
            $ceksubkategori = explode(",_,",$cek->kategori2);
            foreach($ceksubkategori as $value){
                $sub = explode(",/,", $value);
                $id = explode(".", $sub[0]);
                array_push($idsub, $id[1]);
            }
            }
            $x=0;
            $xx=1;
            $count = '';
            if(!empty($this->input->post('subkategori')[$x])){ //if post subkategori not empty
            foreach($this->input->post('subkategori') as $value){
                if(!empty($value)){
                if($x < 10){
                    $count = '0' . $x;
                }
                elseif($x >= 10){
                    $count = $x;
                }
                $idsub2 = $this->input->post('idsubkategori')[$x];
                $url2 = $this->input->post('urlsubkategori')[$x];
                if($x > 0){
                    $xx = $x - 1;
                }
                if(!empty($idsub2) && in_array($idsub2,$idsub) && !in_array($idsub2,$idsubkategori) && $idsub2 != $this->input->post('idsubkategori')[$xx]){ //if post idsubkategori in array or not same with post idsubkategori -1
                    array_push($idsubkategori, $idsub2);
                }
                elseif(empty($idsub2) || !in_array($idsub2, $idsub) || in_array($idsub2, $idsubkategori)){
                    do {
                        $random=rand(10,25);
                        if(empty($idsub2) || !in_array($random, $idsub)){
  		                    array_push($idsubkategori, $random);
                        }
                        else{
                            array_push($idsubkategori, $idsub2);
                        }
                    } while (in_array($random, $idsub));
                }
                $id = $this->input->post('id');
			    $new = $id. $count . "." . $idsubkategori[$x] . ",/," . $value;
                array_push($subkategori, $new);
                array_push($urlsubkategori, $url2);
                $x++;
                }
            }
            $subkategori = join(",_,",$subkategori);
			$urlsubkategori = join(",_,", $urlsubkategori);
            }
            else{
                $subkategori = "";
			    $urlsubkategori = "";
            }
            $items = array (
               'id_kategori' => $this->input->post('id', TRUE),
               'url' => $this->input->post('url', TRUE),
               'kategori' => $this->input->post('kategori', TRUE),
               'id_master' => $this->input->post('master', TRUE),
               'kategori2' => $subkategori,
               'url2' => $urlsubkategori
            );
            if ($this->upload->do_upload('gambar'))
            {
               //fetch data file yang diupload
               $gbr = $this->upload->data();
               //hapus file img dari folder
               unlink('assets/upload/kategori/'.$this->input->post('old_pict', TRUE));
               $items['foto_kategori'] = $gbr['file_name'];
            }
               $this->items->update('t_kategori', $items, array('id_kategori' => $id_item));
            redirect('tag');
            }
         }
      $kategori = $this->items->get_where('t_kategori', array('id_kategori' => $id_item))->row();
      $data['master'] = $this->items->get_all('masterkategori');
      $data['kategori'] = $this->items->get_where('t_kategori', array('id_kategori' => $id_item));
      $data['gambar'] = $kategori->foto_kategori;
      $data['header'] = "Update Kategori";
      $this->template->admin('admin/tagform', $data);
   }

   private function kategori($id_item, $kategori)
   {
      $kat  = explode(", ", $kategori);
      $len  = count($kat);
      $a       = array(' ');
      $b       = array ('`','~','!','@','#','$','%','^','&','*','(',')','_','+','=','[',']','{','}','\'','"',':',';','/','\\','?','/','<','>');

      for ($i = 0; $i  < $len; $i ++) {
         $url = str_replace($b, '', $kat[$i]);
         $url = str_replace($a, '-', strtolower($url));

         $cek = $this->items->get_where('t_kategori', ['url' => $url]);

         if ($cek->num_rows() > 0) {

            $get = $cek->row();
            $id = $get->id_kategori;

         } else {

            $data = array(
               'kategori' => ucwords(trim($kat[$i])),
               'url' => $url
            );

            $id = $this->items->insert_last('t_kategori', $data);
         }

         $cek2 = $this->items->get_where('t_rkategori', ['id_item' => $id_item, 'id_kategori' => $id]);

         if ($cek2->num_rows() < 1) {
            $this->items->insert('t_rkategori', ['id_item' => $id_item, 'id_kategori' => $id]);
         }
      }
   }

   public function ajax_list()
   {
      $list = $this->tags->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $i) {
         $no++;
         $no2 = 0;
         $id=$i->id_master;
         $master = $this->items->get_where('masterkategori', array('id' => $id))->row();
         $sub = '';
         $subkategori = explode(",_,",$i->kategori2);
         if(!empty($i->kategori2)){
         foreach($subkategori as $value){
             $no2++;
             $sub .= '<br>'.$no2.'. '.$value;
         }
         }
         $url = '';
         $urlkategori = explode(",_,",$i->url2);
         $no2 = 0;
         if(!empty($i->kategori2)){
         foreach($urlkategori as $value){
             $no2++;
             $url .= '<br>'.$no2.'. '.$value;
         }
         }
         $row = array();
         $row[] = $no;
         $row[] = $master->masterkategori;
         $row[] = $i->kategori . $sub;
         $row[] = '<center><img style="width:30%;" src="assets/upload/kategori/'.$i->foto_kategori.'" alt="'.$i->kategori.'"></center>';
         $row[] = $i->url . $url;
         $row[] = '
         <a href="'.site_url('tag/update_kategori/'.$i->id_kategori).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
         <a href="'.site_url('tag/del_tag/'.$i->id_kategori).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa fa-trash"></i></a>';

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->tags->count_all(),
               	"recordsFiltered" => $this->tags->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }

	public function del_tag()
	{
		$this->cek_login();
		if(!is_numeric($this->uri->segment(3)))
		{
			redirect('tag');
		}
      $kategori = $this->items->get_where('t_kategori', array('id_kategori' => $this->uri->segment(3)))->row();
      $gambar = $kategori->foto_kategori;
      unlink('assets/upload/kategori/'.$gambar);
		$this->tags->delete(['t_kategori', 't_rkategori'], ['id_kategori' => $this->uri->segment(3)]);

		redirect('tag');
	}

   function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('admin');
		}
	}
}

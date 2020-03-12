<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//banner controller
function compress_image($source_url, $destination_url, $quality, $nama) {
      $nama = str_replace(' ','-',$nama);
      $info = getimagesize($source_url);

          if ($info['mime'] == 'image/jpeg'){
          $image = imagecreatefromjpeg($source_url);
          $destination_url = $destination_url . '.jpg';
          $nama = $nama . '.jpg';
          imagejpeg($image, $destination_url, $quality);
          }

          elseif ($info['mime'] == 'image/gif'){
          $image = imagecreatefromgif($source_url);
          $destination_url = $destination_url . '.gif';
          $nama = $nama . '.gif';
          imagegif($image, $destination_url, $quality);
          }

          elseif ($info['mime'] == 'image/png'){
          $image = imagecreatefrompng($source_url);
          $destination_url = $destination_url . '.png';
          $nama = $nama . '.png';
          imagepng($image, $destination_url, 9);
          }
          return $nama;
        }

class Banner extends CI_Controller {

	function __construct()
	{
		parent::__construct();
      $this->load->library(array('template', 'form_validation'));
      $this->load->model('items');
	}

   public function index()
	{
		$this->cek_login();

      $this->template->admin('admin/banner');
	}

   public function add_banner()
   {
      $this->cek_login();

      if ($this->input->post('bannerform', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('url', 'URL', 'required|min_length[4]');
         $this->form_validation->set_rules('kategori', 'Kategori', 'required');

         if ($this->form_validation->run() == TRUE)
         {

            if (!empty($_FILES["banner"]["name"]))
            {
                $nama = str_replace(' ','-',$this->input->post('nama_banner', TRUE));
                $kategori = explode(", ", $this->input->post('kategori', TRUE));
                if ($_FILES["banner"]["error"] > 0) {
                    $error = $_FILES["banner"]["error"];
                    }
                    else if (($_FILES["banner"]["type"] == "image/jpeg") ||
                    ($_FILES["banner"]["type"] == "image/png") ||
                    ($_FILES["banner"]["type"] == "image/pjpeg")) {
                    $name = $nama;
                    $url = 'assets/upload/banner/'.$name;
                    $filename = compress_image($_FILES["banner"]["tmp_name"], $url, 80, $name);
                    $this->db->select_max('id');
                    $this->db->like('kategori', $kategori[1]);
                    $query = $this->db->get('banner') -> row();
                    // Produces: SELECT MAX(id) as id FROM banner
                    $urutan = substr($query->id, -2);
                    $urutan++;
                    if($urutan < 10){
                        $urutan  = '0' . $urutan;
                    }
                    elseif($urutan >= 10){
                        $urutan = $urutan;
                    }
                    $items = array (
                        'id' => $kategori[0] . $urutan,
                        'gambar' => $filename,
                        'kategori' => $kategori[1],
                        'url' => $this->input->post('url', TRUE),
                        'terakhir_update' => date("Y-m-d H:i:s", time()),
                        'oleh' => $this->session->userdata('user')
                    );
                    $this->items->insert('banner', $items);
                    redirect('banner');
                    }
                    else {
                    $this->session->set_flashdata('alert', 'hanya menerima file jpg dan png');
                    echo "<script>
                        window.history.go(-1);
                        </script>
                    ";
                    }
            }
            else {
               $this->session->set_flashdata('alert', 'anda belum memilih foto');
               echo "<script>
               window.history.go(-1);
               </script>
               ";
            }
            }
         }
      $data['master'] = $this->items->get_all('masterkategori');
      $data['banner'] = "";
      $data['header'] = "Add Banner";
      $this->template->admin('admin/banner_form', $data);
   }

   public function update_banner()
   {
      $this->cek_login();

      if ($this->input->post('bannerform', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('url', 'URL', 'required|min_length[4]');
         $this->form_validation->set_rules('kategori', 'Kategori', 'required');

         if ($this->form_validation->run() == TRUE)
         {
            $this->db->like('id', $this->uri->segment(3));
            $banner = $this->db->get('banner') -> row();
            $ext = explode(".",$banner->gambar);
            $gambar = $banner->gambar;
            $extention = "." . $ext[1];
            $nama = str_replace(' ','-',$this->input->post('nama_banner', TRUE));
            $kategori = explode(", ", $this->input->post('kategori', TRUE));
            if (!empty($_FILES["banner"]["name"]))
            {
                $gambar = "";
                if ($_FILES["banner"]["error"] > 0) {
                    $error = $_FILES["banner"]["error"];
                    }
                    else if (($_FILES["banner"]["type"] == "image/jpeg") ||
                    ($_FILES["banner"]["type"] == "image/png") ||
                    ($_FILES["banner"]["type"] == "image/pjpeg")) {
                    $name = $nama;
                    $url = 'assets/upload/banner/'.$name;
                    $filename = compress_image($_FILES["banner"]["tmp_name"], $url, 80, $name);
                    $gambar = $filename;
                    }
                    else {
                    $this->session->set_flashdata('alert', 'hanya menerima file jpg dan png');
                    echo "<script>
                        window.history.go(-1);
                        </script>
                    ";
                    }
                    $items['gambar'] = $filename;
            }
            else{
                $dir = 'assets/upload/banner/';
                // Old Name Of The file
                $old_name = $dir . $gambar;
   
                // New Name For The File
                $new_name = $dir . $nama . $extention;
   
                // Checking If File Already Exists
                if($old_name != $new_name && file_exists($new_name))
                 {
                     $this->session->set_flashdata('alert', 'Error pada saat merubah nama file');
                 }
                else
                 {
                   if(rename($old_name, $new_name))
                     {
                         $this->session->set_flashdata('success', 'Nama file berhasil diubah');
                        $items['gambar'] = $new_name;
                     }
                     else
                     {
                         $this->session->set_flashdata('alert', 'Nama file sudah ada');
                     }
                  }
            }
                    $id_baru = $banner->id;
                    if($banner->kategori != $kategori[1]){
                        $this->db->select_max('id');
                        $this->db->where('kategori', $kategori[1]);
                        $query = $this->db->get('banner') -> row();
                        // Produces: SELECT MAX(id) as id FROM banner
                        $urutan = substr($query->id, -2);
                        $urutan++;
                        if($urutan < 10){
                            $urutan  = '0' . $urutan;
                        }
                        elseif($urutan >= 10){
                            $urutan = $urutan;
                        }
                        $id_baru = $kategori[0] . $urutan;
                    }
                    $id = $banner->id;
                    $items = array (
                        'id' => $id_baru,
                        'gambar' => $nama . $extention,
                        'kategori' => $kategori[1],
                        'url' => $this->input->post('url', TRUE),
                        'terakhir_update' => date("Y-m-d H:i:s", time()),
                        'oleh' => $this->session->userdata('user')
                    );
                $this->items->update('banner', $items, array('id' => $id));
                redirect('banner');
            }
         }
      $data['master'] = $this->items->get_all('masterkategori');
      $data['banner'] = $this->items->get_where('banner', array('id' => $this->uri->segment(3)));
      $data['header'] = "Update Banner";
      $this->template->admin('admin/banner_form', $data);
   }
   
   public function kelola_banner()
   {
      $this->cek_login();
      $this->template->admin('admin/kelola_banner');
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

	public function del_banner()
	{
		$this->cek_login();
		if(!is_numeric($this->uri->segment(3)))
		{
			redirect('banner');
		}
      $kategori = $this->items->get_where('banner', array('id' => $this->uri->segment(3)))->row();
      $gambar = $kategori->gambar;
      if(file_exists('assets/upload/banner/'.$gambar)){
          unlink('assets/upload/banner/'.$gambar);
      }
      $where = array('id' => $this->uri->segment(3));
      $this->db->where($where);
		$this->db->delete('banner');
		echo "<script>
                        window.history.go(-1);
                        </script>";
	}

   function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}

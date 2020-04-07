<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class Item extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
      $this->load->model('items');
	}

   public function index()
   {
		$this->cek_login();

		$this->template->admin('admin/manage_item');
   }

	public function ajax_list()
   {
      $list = $this->items->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $i) {
	     $status = ($i->aktif == 1) ? "Dijual" : 'Tidak Dijual';
	     $berat="";
	     if($i->berat >= 1000){
	         $berat = $i->berat / 1000 . 'kg';
	     }
	     else{
	         $berat = $i->berat . 'gr';
		 }

		 $table = 't_kategori k
						JOIN t_rkategori rk ON (k.id_kategori = rk.id_kategori)
						JOIN masterkategori mk ON (k.id_master = mk.id)
						JOIN t_items i ON (rk.id_item = i.id_item)';
		$sql = $this->db->select('mk.masterkategori, k.kategori, k.kategori2');
		$sql = $this->db->get_where($table, ['i.id_item' => $i->id_item])->row();
         $no++;
         $row = array();
         $row[] = $no;
		 $row[] = $i->nama_item.' ( '.$berat.' )';
		 $row[] = $sql->masterkategori." ><br>".$sql->kategori;
         $row[] = "Rp ".number_format($i->harga, 0, ',', '.');
         $row[] = $status;
         $row[] = $i->stok;
         $row[] = '<a href="'.site_url('item/detail/'.$i->id_item).'" class="btn btn-success btn-xs"><i class="fa fa-search-plus"></i></a>
				<a href="'.site_url('item/update_item/'.$i->id_item).'" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
				<a href="'.site_url('item/delete/'.$i->link).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin Ingin Menghapus Data ini ?\')"><i class="fa fa-trash"></i></a>';

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->items->count_all(),
               	"recordsFiltered" => $this->items->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }

   	public function multiupdate()
   	{
		$this->cek_login();
		$this->template->admin('admin/multiupdate');
	}

	public function download_format()
	{
	$this->cek_login();
	$connect = mysqli_connect("localhost","root","","new");
	header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data item.csv');
      $output = fopen("php://output", "w");

      fputcsv($output, array('ID Item', 'Link', 'Nama Item', 'harga', 'harga promo', 'berat (gram)', 'stok', 'aktif', 'deskripsi', 'model', 'tipe'));

      $query = "SELECT * from t_items";

      $result = mysqli_query($connect, $query);

      while($d = mysqli_fetch_array($result))

      {
		  $item = array(
			$d['id_item'],
			$d['link'],
			$d['nama_item'],
			$d['harga'],
			$d['hargapromo'],
			$d['berat'],
			$d['stok'],
			$d['aktif'],
			$d['deskripsi'],
			$d['model'],
			$d['tipe']
		  );

           fputcsv($output, $item);

      }

	  fclose($output);
	}


   public function add_item()
   {
		$this->cek_login();
		$this->db->select_max('id_item');
			$query = $this->db->get('t_items')->row();  // Produces: SELECT MAX(age) as age FROM members
			$id_item = $query->id_item;
			$id_item++;
      if ($this->input->post('itemform', TRUE) == 'Submit') {
         //validasi
      		$this->form_validation->set_rules('link', 'Link Item', 'required|min_length[4]');
         	$this->form_validation->set_rules('nama', 'Nama Item', 'required|min_length[4]');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required|min_length[4]');
         	$this->form_validation->set_rules('harga', 'Harga Item', 'required');
			$this->form_validation->set_rules('stok', 'Stok Item', 'required|numeric');
         	$this->form_validation->set_rules('berat', 'Berat Item', 'required|numeric');
         	$this->form_validation->set_rules('status', 'Status', 'required|numeric');
         	$this->form_validation->set_rules('brand', 'Brand', 'required|min_length[3]');
         	$this->form_validation->set_rules('katakunci', 'Keyword', 'required|min_length[3]');
         	$this->form_validation->set_rules('metadeskripsi', 'Meta Deskripsi', 'required|min_length[3]');
         	$this->form_validation->set_rules('model', 'Model ID', 'required|min_length[3]');
         	$this->form_validation->set_rules('type', 'Type', 'required|min_length[3]');

         if ($this->form_validation->run() == TRUE)
         {
            function compress_image($source_url, $destination_url, $quality) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source_url);
            $tujuan = $destination_url.'.jpg';
            imagejpeg($image, $tujuan, $quality);
            }
            elseif ($info['mime'] == 'image/gif'){
            $image = imagecreatefromgif($source_url);
            $tujuan = $destination_url.'.gif';
            imagegif($image, $tujuan, $quality);
            }
            elseif ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($source_url);
            $tujuan = $destination_url.'.png';
            imagepng($image, $tujuan, 9);
            }
            
            return $tujuan;
            }
				$config['upload_path'] = './assets/product/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['file_name'] = $this->input->post('link', TRUE);

				$this->load->library('upload', $config);
				
				if (isset($_FILES["foto"]) && !empty($_FILES["foto"]))
				{
				    if ($_FILES["foto"]["error"] > 0) {
                    $error = $_FILES["foto"]["error"];
                    }
                    else if (($_FILES["foto"]["type"] == "image/gif") ||
                    ($_FILES["foto"]["type"] == "image/jpeg") ||
                    ($_FILES["foto"]["type"] == "image/png") ||
                    ($_FILES["foto"]["type"] == "image/pjpeg")) {
                    $name = $this->input->post('link', TRUE);
                    $url = 'assets/product/'.$name;
                    $filename = compress_image($_FILES["foto"]["tmp_name"], $url, 80);
                    $ext = substr($filename, -4);
                    $name = $name . $ext;
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
					//proses insert data item
					$namaspek = array();
                    $keterangan = array();
				    foreach($this->input->post('namaspek') as $value){
                        array_push($namaspek, $value);
                    }
                    foreach($this->input->post('keterangan') as $value){
                        array_push($keterangan, $value);
					}
/*
					$imgpoint = array();
					$pointjudul = array();
                    $pointketerangan = array();
				    //upload Foto Selling Point
				    $img = count($_FILES['imgpoint']['name']); //hitung jumlah form
                for ($i=0; $i < $img; $i++) {
                    $foto = '';
                    $judul = $this->input->post('link', TRUE)."_".$i;

                    if (isset($_FILES["imgpoint"]['name']) && !empty($_FILES["imgpoint"]['name']))
				    {
				        if ($_FILES["imgpoint"]["error"] > 0) {
                        $error = $_FILES["imgpoint"]["error"];
                        }
                        else if (($_FILES["imgpoint"]["type"] == "image/gif") ||
                        ($_FILES["imgpoint"]["type"] == "image/jpeg") ||
                        ($_FILES["imgpoint"]["type"] == "image/png") ||
                        ($_FILES["imgpoint"]["type"] == "image/pjpeg")) {
                        $name = $judul;
                        $url = 'assets/upload/sellingpoint/'.$name;
                        $filename = compress_image($_FILES["imgpoint"]["tmp_name"], $url, 80);
                        array_push($imgpoint, $name);
                        }
                        else {
                        $error = "Uploaded image should be jpg or gif or png";
                        }
				    }
                  }


					foreach($this->input->post('pointjudul') as $value){
                        array_push($pointjudul, $value);
                    }
                    foreach($this->input->post('pointketerangan') as $value){
                        array_push($pointketerangan, $value);
                    }
                    */
                    $namaspek = join(",_,",$namaspek);
					$keterangan = join(",_,", $keterangan);
					//$imgpoint = join(",_,",$imgpoint);
					//$pointjudul = join(",_,",$pointjudul);
                    //$pointketerangan = join(",_,", $pointketerangan);
					$garansi = $this->input->post('garansisparepart', TRUE)." | ".$this->input->post('garansimotor', TRUE);
					$nama_admin = $this->session->userdata('user');
					$subkat = "";
					$url = $this->input->post('kategori');
                    $cek = $this->db->get_where('t_kategori',['url'=>$url])->row();
					$id_kategori = $cek->id_kategori;
					$harga = $this->input->post('harga', TRUE);
                	$harga = str_replace(array(',', '.'), "", $harga);
					if(!empty($this->input->post('subkategori', TRUE))){
					    $subkat = $this->input->post('subkategori', TRUE);
					}
		         	$items = array (
		         		'id_item' 	            => $id_item,
		         		'urut'                  => $id_kategori . $this->input->post('urutan', TRUE),
						'link' 		            => $this->input->post('link', TRUE),
						'nama_item'             => $this->input->post('nama', TRUE),
						'gambar'                => $name,
						'harga' 	            => $harga,
						'berat' 	            => $this->input->post('berat', TRUE),
						'stok' 		            => $this->input->post('stok', TRUE),
		            	'aktif' 	            => $this->input->post('status', TRUE),
						'brand' 	            => $this->input->post('brand', TRUE),
						'katakunci'             => $this->input->post('katakunci', TRUE),
						'metadeskripsi'         => $this->input->post('metadeskripsi', TRUE),
						'deskripsi'             => $this->input->post('deskripsi', TRUE),
						'penggunaan'            => $this->input->post('penggunaan', TRUE),
						'kategori'              => $subkat,
						'model' 	            => $this->input->post('model', TRUE),
						'tipe' 	    	        => $this->input->post('type', TRUE),
						'garansi' 	            => $garansi,
						'terakhir_update'       => date("Y-m-d h:i:s", time()),
					    'dibuat'           		=> $nama_admin
		         	);
		        	$this->items->insert('t_items', $items);
		        $performance = $this->input->post('performance')." - ".$this->input->post('unit')." - ".$this->input->post('opsi');
				$curva = $this->input->post('old_curva', TRUE)." - ".$this->input->post('curva1');
				$spek = array (
					'id_item' => $id_item,
					'performance' => $performance,
					'model' => $this->input->post('model', TRUE),
					'voltase' => $this->input->post('voltase', TRUE),
					'daya' => $this->input->post('daya', TRUE),
					'stage' => $this->input->post('stage', TRUE),
					'currentarus' => $this->input->post('currentarus', TRUE),
					'totalhead' => $this->input->post('totalhead', TRUE),
					'maxcapacity' => $this->input->post('maxcapacity', TRUE),
					'outletpompa' => $this->input->post('outletpompa'),
					'outletkonektor' => $this->input->post('outletkonektor'),
					'mpartikel' => $this->input->post('mpartikel'),
					'rated' => $this->input->post('rated'),
					'impeler' => $this->input->post('impeler'),
					'dmsumur' => $this->input->post('diameter'),
					'minflow' => $this->input->post('minflow'),
					'inlet' => $this->input->post('inlet'),
					'hisap' => $this->input->post('hisap', TRUE),
					'head' => $this->input->post('head', TRUE),
					'kapasitas' => $this->input->post('kapasitas', TRUE),
					'membrane' => $this->input->post('membrane', TRUE),
					'precharge_pressure' => $this->input->post('precharge_pressure', TRUE),
					'max_pressure' => $this->input->post('max_pressure', TRUE),
					'ukuran' => $this->input->post('ukuran', TRUE),
					'temperatur' => $this->input->post('temperatur'),
					'flange' => $this->input->post('flange', TRUE),
					'on_off' => $this->input->post('on-off', TRUE),
					'pressure' => $this->input->post('pressure', TRUE),
					'pipa' => $this->input->post('pipa'),
					'kabel' => $this->input->post('kabel'),
					'berat' => $this->input->post('beratkotor'),
					'namaspek'              => $namaspek,
                    'keterangan'            => $keterangan
                );
                
                //upload foto master selling point
                //$config['upload_path'] = './assets/upload/sellingpoint/';
                //$config['file_name'] = 'foto_'.$this->input->post('link', TRUE); //rename foto yang diupload
				//$this->upload->initialize($config);
				if ($this->upload->do_upload('fotomaster'))
				{
					//fetch data file yang diupload
					$gbr = $this->upload->data();
					//hapus file img dari folder
					unlink('assets/upload/'.$this->input->post('old_fotomaster', TRUE));
					$fotomaster = $gbr['file_name'];
				}
				else{
				    $fotomaster = $this->input->post('old_fotomaster', TRUE);
				}

                $config['upload_path'] = './assets/upload/curva/';
				$config['file_name'] = 'curva_'.$this->input->post('link', TRUE); //rename foto yang diupload
				$this->upload->initialize($config);
				if ($this->upload->do_upload('curva'))
				{
					//fetch data file yang diupload
					$gbr = $this->upload->data();
					if (!empty($this->input->post('curva1')))
					{
					$spek['curva'] = $gbr['file_name']." - ".$this->input->post('curva1');
					}
					else{
					$spek['curva'] = $gbr['file_name'];
					}
				}
				else{
				if (!empty($this->input->post('curva1')) && !empty($this->input->post('old_curva')))
				{
					$spek['curva'] = $this->input->post('old_curva', TRUE)." - ".$this->input->post('curva1');
				}
				elseif (empty($this->input->post('curva1')) && !empty($this->input->post('old_curva'))) {
					$spek['curva'] = $this->input->post('old_curva', TRUE);
				}
				}

                $config['upload_path'] = './assets/upload/curva/';
				$config['file_name'] = 'spek_'.$this->input->post('link', TRUE); //rename foto yang diupload
				$this->upload->initialize($config);
				if ($this->upload->do_upload('spek'))
				{
					//fetch data file yang diupload
					$gbr = $this->upload->data();
					//hapus file img dari folder
					unlink('assets/upload/'.$this->input->post('old_spek', TRUE));
					$spek['spek'] = $gbr['file_name'];
				}
				$cek_spek = $this->items->get_where('spesifikasi', array('id_item' => $id_item));
				if ($cek_spek->num_rows() < 1) {
					$this->items->insert('spesifikasi', $spek);
				}
				else{
					$this->items->update('spesifikasi', $spek, array('id_item' => $id_item));
				}

					//akses function kategori
					$this->kategori($id_item, $this->input->post('kategori', TRUE));
					//upload Foto Lainnya
					$len = count($_FILES['gb']['name']); //hitung jumlah form
					
					for ($i=0; $i < $len; $i++) {
					$judul = 'img_'.$this->input->post('link', TRUE).'_'.$i; //rename foto yang diupload
					if (isset($_FILES["gb"]['name']) && !empty($_FILES["gb"]['name']))
				    {
				        if ($_FILES["gb"]["error"] > 0) {
                        $error = $_FILES["gb"]["error"];
                        }
                        else if (($_FILES["gb"]["type"] == "image/gif") ||
                        ($_FILES["gb"]["type"] == "image/jpeg") ||
                        ($_FILES["gb"]["type"] == "image/png") ||
                        ($_FILES["gb"]["type"] == "image/pjpeg")) {
                        $name = $judul;
                        $url = 'assets/upload/lainnya/'.$name;
                        $filename = compress_image($_FILES["gb"]["tmp_name"], $url, 80);
                        $ext = substr($filename, -4);
                        $data = [
								'id_item' => $id_item,
								'img' => $name . $ext
							];
							//insert data img
							$this->items->insert('t_img', $data);
                        }
                        else {
                        $error = "Uploaded image should be jpg or gif or png";
                        }
				    }
			      }

				//upload foto Selling Point
				$array_newsp = array();
				$old_selling = array();
				if(!empty($this->input->post('old_sellingpoint'))){
				foreach($this->input->post('old_sellingpoint') as $value){
				    array_push($old_selling, $value);
				}
				$len = count($old_selling);
				//hitung jumlah array old_sellingpoint
	            for ($i=0; $i < $len; $i++) {
                    if(!empty($_FILES["new_sellingpoint"]["name"][$i])){
                    $sp = $_FILES["new_sellingpoint"]["name"][$i];
                    if ($_FILES["new_sellingpoint"]["error"][$i] > 0) {
                    $error = $_FILES["new_sellingpoint"]["error"][$i];
                    }
                    else if (($_FILES["new_sellingpoint"]["type"][$i] == "image/gif") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/jpeg") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/png") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/pjpeg")) {
                    $judul = substr($old_selling[$i], 0, -4); //rename foto yang diupload
                    $name = $judul;
                    $url = "";
                    $url = 'assets/upload/sellingpoint/'.$name;
                    $filename = compress_image($_FILES["new_sellingpoint"]["tmp_name"][$i], $url, 80);
                    $ext = substr($filename, -4);
                    array_push($array_newsp, $name . $ext);
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
                    }
                    else{
                        array_push($array_newsp, $this->input->post('old_sellingpoint', TRUE)[$i]);
                    }
                }
            } //end if isset old_sellingpoint

                //upload tambah foto selling point
				$len = count($_FILES['newsellingpoint']['name']); //hitung jumlah form
				$ext = "";
				for ($i=0; $i < $len; $i++) {
				    $x=$i;
					$judul = $this->input->post('link', TRUE).'_'.$i; //rename foto yang diupload
                    
				    if ($_FILES["newsellingpoint"]["error"][$i] > 0) {
                    $error = $_FILES["newsellingpoint"]["error"][$i];
                    }
                    else if (($_FILES["newsellingpoint"]["type"][$i] == "image/gif") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/jpeg") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/png") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/pjpeg")) {
                        do {
                            $judul = $this->input->post('link', TRUE).'_'.$x; //rename foto yang diupload
                            $name = $judul . $ext;
                            if(in_array($name, $array_newsp)){
                                $validation = 'same';
                                $x++;
                            }
                            else{
                                $validation = 'not';
                            }
                            } while ($validation == 'same');
                    $url = 'assets/upload/sellingpoint/'.$name;
                    $filename = compress_image($_FILES["newsellingpoint"]["tmp_name"][$i], $url, 80);
                    $ext = substr($filename, -4);
                    $name = $name . $ext;
                    array_push($array_newsp, $name);
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
                $array_join = join(" // ", $array_newsp);
                $newsp = [
							'gambar_point' => $array_join
				      ];

				$this->items->update('sellingpoint', $newsp, array('id_item' => $id_item));

/*
			      $len = count($_FILES['sel']['name']); //hitung jumlah form
					for ($i=0; $i < $len; $i++) {
						$foto = '';
						//masukkan data file ke variabel foto sesuai index array
						$_FILES[$foto]['name'] = $_FILES['sel']['name'][$i];
				      	$_FILES[$foto]['type'] = $_FILES['sel']['type'][$i];
				      	$_FILES[$foto]['tmp_name'] = $_FILES['sel']['tmp_name'][$i];
						$_FILES[$foto]['size'] = $_FILES['sel']['size'][$i];
						$_FILES[$foto]['error'] = $_FILES['sel']['error'][$i];

						$config['file_name'] = 'selling'.time().$i; //rename foto yang diupload

						$this->upload->initialize($config);

						if ($this->upload->do_upload($foto))
						{
							//fetch data file yang diupload
							$sl = $this->upload->data();

							$data = [
								'id_item' => $id_item,
								'gambar' => $sl['file_name']
							];
							//insert data img
							$this->items->insert('sellingpoint', $data);
						}
			      }
			      */

					redirect('item');

				} else {
					$this->session->set_flashdata('alert', 'anda belum memilih foto');
				}
         }
      } //end submit
      	$data['id_item'] 		 = $id_item;
      	$data['urut'] 		     = $this->input->post('urutan', TRUE);
		$data['kategori'] 		 = $this->input->post('kategori', TRUE);
		$data['kat'] 			 = $this->items->get_all('t_kategori');
		$data['masterkategori']  = $this->items->get_all('masterkategori');
		$data['nama'] 			 = $this->input->post('nama', TRUE);
		$data['link'] 			 = $this->input->post('link', TRUE);
		$data['berat'] 			 = $this->input->post('berat', TRUE);
		$data['harga'] 			 = $this->input->post('harga', TRUE);
		$data['status'] 		 = $this->input->post('status', TRUE);
		$data['desk'] 			 = $this->input->post('desk', TRUE);
		$data['stok'] 			 = $this->input->post('stok', TRUE);
		$data['brand'] 			 = $this->input->post('brand', TRUE);
		$data['katakunci'] 		 = $this->input->post('katakunci', TRUE);
		$data['metadeskripsi'] 	 = $this->input->post('metadeskripsi', TRUE);
		$data['deskripsi'] 		 = $this->input->post('deskripsi', TRUE);
		$data['penggunaan'] 	 = $this->input->post('penggunaan', TRUE);
		$data['model'] 			 = $this->input->post('model', TRUE);
		$data['type'] 			 = $this->input->post('type', TRUE);
		$data['gsp'] 	    	 = $this->input->post('garansisparepart', TRUE);
		$data['gm'] 		     = $this->input->post('garansimotor', TRUE);
		$data['detail'] 		 = $this->input->post('detail', TRUE);
		$data['namaspek'] 	     = $this->input->post('namaspek');
		$data['keterangan'] 	 = $this->input->post('keterangan');
		$data['rk'] 			 = '';
		$data['sellingpoint'] 	 = $this->input->post('sel');
		$data['sellingtitle'] 	 = $this->input->post('sellingtitle');
		$data['sellingsubtitle'] = $this->input->post('sellingsubtitle');

      $data['header'] = "Add New Item";

      $this->template->admin('admin/item_form', $data);
   }

	public function detail()
	{
		$this->cek_login();
		$id_item = $this->uri->segment(3);
		$item = $this->items->get_where('t_items', array('id_item' => $id_item));
		$spesifik = $this->items->get_where('spesifikasi', array('id_item' => $id_item));

		foreach ($item->result() as $key) {
		    $garansi = explode(" | ",$key->garansi);
		    $data['gsp'] = $garansi[0];
		    if(!empty($garansi[1])){
		        $data['gm'] = $garansi[1];
		    }
		    else{
		        $data['gm'] = "";
		    }
			$data['id_item'] = $key->id_item;
			$data['nama_item'] = $key->nama_item;
			$data['harga'] = $key->harga;
			$data['berat'] = $key->berat;
			$data['status'] = $key->aktif;
			$data['stok'] = $key->stok;
			$data['gambar'] = $key->gambar;
			$data['brand'] = $key->brand;
			$data['katakunci'] = $key->katakunci;
			$data['metadeskripsi'] = $key->metadeskripsi;
			$data['model'] = $key->model;
			$data['type'] = $key->tipe;
			$data['deskripsi'] = $key->deskripsi;
			$data['detail'] = $key->detail;
		}
		foreach($spesifik->result() as $spesifik) {
			$data['voltase'] 	= $spesifik->voltase;
			$data['daya'] 	= $spesifik->daya;
			$data['currentarus'] 	= $spesifik->currentarus;
			$data['totalhead'] 	= $spesifik->totalhead;
			$data['maxcapacity'] = $spesifik->maxcapacity;
			$data['hisap'] 	= $spesifik->hisap;
			$data['head'] 	= $spesifik->head;
			$data['kapasitas'] 	= $spesifik->kapasitas;
			$data['pressure'] 	= $spesifik->pressure;
			$data['pipa'] 	= $spesifik->pipa;
			$data['berat'] 	= $spesifik->berat;
		}

		$table = "t_rkategori rk
						JOIN t_kategori k ON (rk.id_kategori = k.id_kategori)";
		$data['kategori'] = $this->items->get_where($table, ['rk.id_item' => $id_item]);
		//ambil data img berdasarkan id_item
		$data['img'] = $this->items->get_where('t_img', ['id_item' => $id_item]);

		$this->template->admin('admin/detail_item', $data);
	}

	public function delete()
   	{
   		$this->cek_login();
		$link = $this->uri->segment(3);
		$this->items->delete('t_items', ['link' => $link]);
		echo '<script type="text/javascript">window.history.go(-1)</script>';
   	}

	public function update_item()
   	{
		$this->cek_login();
		$id_item = $this->uri->segment(3);

      if ($this->input->post('itemform', TRUE) == 'Submit') {
         //validasi
      	 $this->form_validation->set_rules('link', 'Link Item', 'required|min_length[4]');
         $this->form_validation->set_rules('nama', 'Nama Item', 'required|min_length[4]');
		 $this->form_validation->set_rules('kategori', 'Kategori', 'required|min_length[4]');
         $this->form_validation->set_rules('harga', 'Harga Item', 'required');
		 $this->form_validation->set_rules('stok', 'Stok Item', 'required|numeric');
         $this->form_validation->set_rules('berat', 'Berat Item', 'required|numeric');
         $this->form_validation->set_rules('status', 'Status', 'required|numeric');
         $this->form_validation->set_rules('brand', 'Brand', 'min_length[3]');
         $this->form_validation->set_rules('katakunci', 'Keyword', 'min_length[3]');
         $this->form_validation->set_rules('metadeskripsi', 'Meta Deskripsi', 'min_length[3]');
         $this->form_validation->set_rules('model', 'Model', 'min_length[3]');
         $this->form_validation->set_rules('type', 'Type', 'required');

         if ($this->form_validation->run() == TRUE)
         {
    function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);

          if ($info['mime'] == 'image/jpeg'){
          $image = imagecreatefromjpeg($source_url);
          $tujuan = $destination_url.'.jpg';
          imagejpeg($image, $tujuan, $quality);
          }
          elseif ($info['mime'] == 'image/gif'){
          $image = imagecreatefromgif($source_url);
          $tujuan = $destination_url.'.gif';
          imagegif($image, $tujuan, $quality);
          }
          elseif ($info['mime'] == 'image/png'){
          $image = imagecreatefrompng($source_url);
          $tujuan = $destination_url.'.png';
          imagepng($image, $tujuan, 9);
          }
          return $tujuan;
        }
                $namaspek = array();
                $keterangan = array();
				foreach($this->input->post('namaspek') as $value){
                    array_push($namaspek, $value);
                }
                foreach($this->input->post('keterangan') as $value){
                    array_push($keterangan, $value);
                }
                $namaspek = join(",_,",$namaspek);
				$keterangan = join(",_,", $keterangan);
                $garansi = $this->input->post('garansisparepart', TRUE)." | ".$this->input->post('garansimotor', TRUE);
                $url = $this->input->post('kategori');
                $cek = $this->db->get_where('t_kategori',['url'=>$url])->row();
                $id_kategori = $cek->id_kategori;
                $harga = $this->input->post('harga', TRUE);
                $harga = str_replace(array(',', '.'), "", $harga);
                $nama_admin = $this->session->userdata('user');
				$items = array (
				    'urut' => $id_kategori . $this->input->post('urutan', TRUE),
					'link' => $this->input->post('link', TRUE),
					'nama_item' => $this->input->post('nama', TRUE),
					'harga' => $harga,
					'berat' => $this->input->post('berat', TRUE),
					'stok' => $this->input->post('stok', TRUE),
					'aktif' => $this->input->post('status', TRUE),
					'brand' => $this->input->post('brand', TRUE),
					'katakunci' => $this->input->post('katakunci', TRUE),
					'metadeskripsi' => $this->input->post('metadeskripsi', TRUE),
					'deskripsi'             => $this->input->post('deskripsi'),
					'penggunaan'            => $this->input->post('penggunaan', TRUE),
					'kategori'            => $this->input->post('subkategori', TRUE),
					'model'                 => $this->input->post('model', TRUE),
					'tipe'                  => $this->input->post('type', TRUE),
					'garansi'               => $garansi,
					'terakhir_update'       => date("Y-m-d h:i:s", time()),
					'diubah_oleh'           => $nama_admin
				);
				$performance = $this->input->post('performance')." - ".$this->input->post('unit')." - ".$this->input->post('opsi');
				$curva = $this->input->post('old_curva', TRUE)." - ".$this->input->post('curva1');
				$spek = array (
					'id_item'               => $id_item,
					'performance'           => $performance,
					'model'                 => $this->input->post('model', TRUE),
					'voltase'               => $this->input->post('voltase', TRUE),
					'daya'                  => $this->input->post('daya', TRUE),
					'stage'                 => $this->input->post('stage', TRUE),
					'currentarus'           => $this->input->post('currentarus', TRUE),
					'totalhead'             => $this->input->post('totalhead', TRUE),
					'maxcapacity'           => $this->input->post('maxcapacity', TRUE),
					'outletpompa'           => $this->input->post('outletpompa'),
					'outletkonektor'        => $this->input->post('outletkonektor'),
					'mpartikel'             => $this->input->post('mpartikel'),
					'rated'                 => $this->input->post('rated'),
					'impeler'               => $this->input->post('impeler'),
					'dmsumur'               => $this->input->post('diameter'),
					'minflow'               => $this->input->post('minflow'),
					'inlet'                 => $this->input->post('inlet'),
					'hisap'                 => $this->input->post('hisap', TRUE),
					'head'                  => $this->input->post('head', TRUE),
					'kapasitas'             => $this->input->post('kapasitas', TRUE),
					'membrane'              => $this->input->post('membrane', TRUE),
					'precharge_pressure'    => $this->input->post('precharge_pressure', TRUE),
					'max_pressure'          => $this->input->post('max_pressure', TRUE),
					'ukuran'                => $this->input->post('ukuran', TRUE),
					'temperatur'            => $this->input->post('temperatur', TRUE),
					'flange'                => $this->input->post('flange', TRUE),
					'on_off'                => $this->input->post('on-off', TRUE),
					'pressure'              => $this->input->post('pressure', TRUE),
					'pipa'                  => $this->input->post('pipa'),
					'kabel'                 => $this->input->post('kabel'),
                    'berat'                 => $this->input->post('beratkotor'),
                    'namaspek'              => $namaspek,
                    'keterangan'            => $keterangan
				);
                
                //upload foto curva
				if (isset($_FILES["curva"]) && !empty($_FILES["curva"]["name"]))
				{
					if ($_FILES["curva"]["error"] > 0) {
                    $error = $_FILES["curva"]["error"];
                    }
                    else if (($_FILES["curva"]["type"] == "image/gif") ||
                    ($_FILES["curva"]["type"] == "image/jpeg") ||
                    ($_FILES["curva"]["type"] == "image/png") ||
                    ($_FILES["curva"]["type"] == "image/pjpeg")) {
                    //hapus file img dari folder
					unlink('assets/upload/curva/'.$this->input->post('old_curva', TRUE));
					
                    $name = "curva_".$this->input->post('link', TRUE);
                    $url = 'assets/upload/curva/'.$name;
                    $filename = compress_image($_FILES["curva"]["tmp_name"], $url, 80);
                    $ext = substr($filename, -4);
                    
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
                    if (!empty($this->input->post('curva1')))
					    {
					        $spek1 = " - ".$this->input->post('curva1');
					    }
					    else{
					        $spek1 = "";
					    }
				    $spek['curva'] = $name . $ext . $spek1;
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
				else{
				$name = $this->input->post('old_curva', TRUE);
				if (!empty($this->input->post('curva1')))
					    {
					        $spek1 = " - ".$this->input->post('curva1');
					    }
					    else{
					        $spek1 = "";
					    }
                    $spek['curva'] = $name . $spek1;
				}
                
                //upload foto spek
                /*
				if (isset($_FILES["spek"]) && !empty($_FILES["spek"]))
				{
					$foto_spek = $_FILES["spek"];
					if ($foto_spek["error"] > 0) {
                    $error = $foto_spek["error"];
                    }
                    else if (($foto_spek["type"] == "image/gif") ||
                    ($foto_spek["type"] == "image/jpeg") ||
                    ($foto_spek["type"] == "image/png") ||
                    ($foto_spek["type"] == "image/pjpeg")) {
                    //hapus file img dari folder
					unlink('assets/upload/curva/'.$this->input->post('old_pict', TRUE));
                    $name = $this->input->post('link', TRUE);
                    $url = 'assets/upload/curva/'.$name;
                    $filename = compress_image($foto_spek["tmp_name"], $url, 80);
                    $items['gambar'] = $name;
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
				*/
				$cek_spek = $this->items->get_where('spesifikasi', array('id_item' => $id_item));
				if ($cek_spek->num_rows() < 1) {
					$this->items->insert('spesifikasi', $spek);
				}
				else{
					$this->items->update('spesifikasi', $spek, array('id_item' => $id_item));
				}

                //upload foto produk
				if (isset($_FILES["foto"]) && !empty($_FILES["foto"]))
				{
				    if ($_FILES["foto"]["error"] > 0) {
                    $error = $_FILES["foto"]["error"];
                    }
                    else if (($_FILES["foto"]["type"] == "image/gif") ||
                    ($_FILES["foto"]["type"] == "image/jpeg") ||
                    ($_FILES["foto"]["type"] == "image/png") ||
                    ($_FILES["foto"]["type"] == "image/pjpeg")) {
                    //hapus file img dari folder
                    $file = 'assets/product/'.$this->input->post('old_pict', TRUE);
                    if(file_exists($file)){
					unlink($file);
                    }
                    $name = $this->input->post('link', TRUE);
                    $url = 'assets/product/'.$name;
                    $filename = compress_image($_FILES["foto"]["tmp_name"], $url, 80);
                    $ext = substr($filename, -4);
                    $items['gambar'] = $name.$ext;
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
				$this->items->update('t_items', $items, array('id_item' => $id_item));
				$this->items->delete('t_rkategori', ['id_item' => $id_item]);
				$this->kategori($id_item, $this->input->post('kategori', TRUE));

                //upload foto lainnya
				$len = count($_FILES['gb']['name']); //hitung jumlah form
				for ($i=0; $i < $len; $i++) {
				    $x=$i;
					$judul = 'img_'.$this->input->post('link', TRUE).'_'.$i; //rename foto yang diupload
                    
				    if ($_FILES["gb"]["error"][$i] > 0) {
                    $error = $_FILES["gb"]["error"][$i];
                    }
                    else if (($_FILES["gb"]["type"][$i] == "image/gif") ||
                    ($_FILES["gb"]["type"][$i] == "image/jpeg") ||
                    ($_FILES["gb"]["type"][$i] == "image/png") ||
                    ($_FILES["gb"]["type"][$i] == "image/pjpeg")) {
                        do {
                            $judul = 'img_'.$this->input->post('link', TRUE).'_'.$x; //rename foto yang diupload
                            $name = $judul;
                            $cek = $this->items->get_where('t_img', array('img' => $name));
                            if($cek->num_rows() != 0){
                                $validation = 'same';
                                $x++;
                            }
                            else{
                                $validation = 'not';
                            }
                            } while ($validation == 'same');
                    $name = $judul;
                    $url = 'assets/upload/lainnya/'.$name;
                    $filename = compress_image($_FILES["gb"]["tmp_name"][$i], $url, 80);
                    $ext = substr($filename, -4);
                    $data = [
							'id_item' => $id_item,
							'img' => $name . $ext
						];

						$this->items->insert('t_img', $data);
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
                
				$cek_selling = $this->items->get_where('sellingpoint', array('id_item' => $id_item));
				$data = [
					'id_item' 		=> $id_item,
					'gambar' 		=> $this->input->post('sel')
				 ];
                if ($cek_selling->num_rows() == 0) {
					$this->items->insert('sellingpoint', $data);
				}
				else{
					$this->items->update('sellingpoint', $data, array('id_item' => $id_item));
				}
				
				//upload foto Selling Point
				$array_newsp = array();
				$old_selling = array();
				$bg_selling = array();
				if(!empty($this->input->post('old_sellingpoint'))){
				foreach($this->input->post('old_sellingpoint') as $value){
				    array_push($old_selling, $value);
				}
				foreach($this->input->post('old_bg_color') as $value){
                    array_push($bg_selling, $value);
                }
				$len = count($old_selling);
				//hitung jumlah array old_sellingpoint
	            for ($i=0; $i < $len; $i++) {
                    if(!empty($_FILES["new_sellingpoint"]["name"][$i])){
                    $sp = $_FILES["new_sellingpoint"]["name"][$i];
                    if ($_FILES["new_sellingpoint"]["error"][$i] > 0) {
                    $error = $_FILES["new_sellingpoint"]["error"][$i];
                    }
                    else if (($_FILES["new_sellingpoint"]["type"][$i] == "image/gif") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/jpeg") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/png") ||
                    ($_FILES["new_sellingpoint"]["type"][$i] == "image/pjpeg")) {
                    $judul = substr($old_selling[$i], 0, -4); //rename foto yang diupload
                    $name = $judul;
                    $url = "";
                    $url = 'assets/upload/sellingpoint/'.$name;
                    $filename = compress_image($_FILES["new_sellingpoint"]["tmp_name"][$i], $url, 80);
                    $ext = substr($filename, -4);
                    array_push($array_newsp, $name . $ext);
                    array_push($bg_selling, $this->input->post('bg_color', TRUE)[$i]);
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
                    }
                    else{
                        array_push($array_newsp, $this->input->post('old_sellingpoint', TRUE)[$i]);
                    }
                }
            } //end if isset old_sellingpoint

                //upload tambah foto selling point
				$len = count($_FILES['newsellingpoint']['name']); //hitung jumlah form
				for ($i=0; $i < $len; $i++) {
				    $x=$i;
					$judul = $this->input->post('link', TRUE).'_'.$i; //rename foto yang diupload
                    
				    if ($_FILES["newsellingpoint"]["error"][$i] > 0) {
                    $error = $_FILES["newsellingpoint"]["error"][$i];
                    }
                    else if (($_FILES["newsellingpoint"]["type"][$i] == "image/gif") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/jpeg") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/png") ||
                    ($_FILES["newsellingpoint"]["type"][$i] == "image/pjpeg")) {
                        $ext = explode(".",$_FILES["newsellingpoint"]["name"][$i]);
                        do {
                            $judul = $this->input->post('link', TRUE).'_'.$x; //rename foto yang diupload
                            $name = $judul.'.'.end($ext);
                            if(in_array($name, $array_newsp)){
                                $validation = 'same';
                                $x++;
                            }
                            else{
                                $validation = 'not';
                            }
                            } while ($validation == 'same');
                    $url = 'assets/upload/sellingpoint/'.$judul;
                    $filename = compress_image($_FILES["newsellingpoint"]["tmp_name"][$i], $url, 80);
                    array_push($array_newsp, $name);
                    array_push($bg_selling, $this->input->post('bg_color', TRUE)[$i]);
                    }
                    else {
                    $error = "Uploaded image should be jpg or gif or png";
                    }
					//fetch data file yang diupload
					//$gbr = $this->upload->data();
				}
                $array_join = join(" // ", $array_newsp);
                $bg_join = join(" // ", $bg_selling);
                $newsp = [
							'gambar_point'  => $array_join,
							'background'    => $bg_join
				      ];

				$this->items->update('sellingpoint', $newsp, array('id_item' => $id_item));
    
    
/*
				$len = count($_FILES['sel']['name']); //hitung jumlah form
				for ($i=0; $i < $len; $i++) {
                  $foto = '';
                  //masukkan data file ke variabel foto sesuai index array
                  $_FILES[$foto]['name'] = $_FILES['sel']['name'][$i];
                  $_FILES[$foto]['type'] = $_FILES['sel']['type'][$i];
                  $_FILES[$foto]['tmp_name'] = $_FILES['sel']['tmp_name'][$i];
                  $_FILES[$foto]['size'] = $_FILES['sel']['size'][$i];
                  $_FILES[$foto]['error'] = $_FILES['sel']['error'][$i];

                  $config['file_name'] = 'selling'.time().$i; //rename foto yang diupload

                  $this->upload->initialize($config);

                  if ($this->upload->do_upload($foto))
                  {
                     //fetch data file yang diupload
                     $sl = $this->upload->data();

                     $data = [
                        'id_item' => $id_item,
                        'gambar' => $sl['file_name']
                     ];
                     //insert data img
                     $this->items->insert('sellingpoint', $data);
                  }
               }
*/
				redirect('item');
         }
      }

		$item = $this->items->get_where('t_items', array('id_item' => $id_item));
		$spesifikasi = $this->items->get_where('spesifikasi', array('id_item' => $id_item));

		$table = "t_rkategori rk
						JOIN t_kategori k ON (rk.id_kategori = k.id_kategori)";
		$rk = $this->items->get_where($table, ['rk.id_item' => $id_item]);

		$value = '';
		$nama_admin = $this->session->userdata('user');
		foreach ($rk->result() as $k) {
			$value .= ', '.$k->url;
		}

		foreach($item->result() as $key) {
		    $garansi = explode(" | ",$key->garansi);
		    $data['gsp'] = $garansi[0];
		    if(!empty($garansi[1])){
		        $data['gm'] = $garansi[1];
		    }
		    else{
		        $data['gm'] = "";
		    }
			$data['id_item'] 	= $key->id_item;
			$urut = substr($key->urut, 2);
			$data['urut'] 	    = $urut;
			$data['link'] 	    = $key->link;
			$data['nama'] 	    = $key->nama_item;
			$data['berat'] 	    = $key->berat;
			$data['harga'] 	    = $key->harga;
			$data['status']     = $key->aktif;
			$data['brand'] 	    = $key->brand;
			$data['katakunci'] 	= $key->katakunci;
			$data['metadeskripsi'] 	= $key->metadeskripsi;
			$data['deskripsi'] 	= $key->deskripsi;
			$data['penggunaan'] = $key->penggunaan;
			$data['sub'] = $key->kategori;
			$data['model'] 	    = $key->model;
			$data['type'] 	    = $key->tipe;
			$data['desk'] 	    = $key->deskripsi;
			$data['gambar']     = $key->gambar;
			$data['stok'] 	    = $key->stok;
			$data['detail'] 	= $key->detail;
			$data['fullname']   = $nama_admin;
		}

		foreach($spesifikasi->result() as $spesifik) {
			$performance = explode(' - ', $spesifik->performance);
			$curva = explode(' - ', $spesifik->curva);
			$data['curva'] 	= $curva[0];
			if (!empty($curva[1])) {
				$data['curvaa'] = $curva[1];
			}
			$data['feature'] 	= $spesifik->spek;
			$data['performance'] 	= $performance[0];
			if (!empty($performance[1])) {
				$data['unit'] 	= $performance[1];
			}
			else{
				$data['unit'] 	= "";
			}
			if (!empty($performance[2])) {
				$data['opsi'] 	= $performance[2];
			}
			else{
				$data['opsi'] 	= "";
			}
			$data['voltase'] 	            = $spesifik->voltase;
			$data['daya'] 	                = $spesifik->daya;
			$data['stage'] 	                = $spesifik->stage;
			$data['currentarus'] 	        = $spesifik->currentarus;
			$data['totalhead'] 	            = $spesifik->totalhead;
			$data['maxcapacity']            = $spesifik->maxcapacity;
			$data['outletpompa']            = $spesifik->outletpompa;
			$data['outletkonektor']         = $spesifik->outletkonektor;
			$data['mpartikel']              = $spesifik->mpartikel;
			$data['rated']                  = $spesifik->rated;
			$data['impeler']                = $spesifik->impeler;
			$data['diameter']               = $spesifik->dmsumur;
			$data['minflow']                = $spesifik->minflow;
			$data['inlet']                  = $spesifik->inlet;
			$data['hisap'] 	                = $spesifik->hisap;
			$data['head'] 	                = $spesifik->head;
			$data['kapasitas'] 	            = $spesifik->kapasitas;
			$data['membrane'] 	            = $spesifik->membrane;
			$data['precharge_pressure'] 	= $spesifik->precharge_pressure;
			$data['max_pressure'] 	        = $spesifik->max_pressure;
			$data['ukuran'] 	            = $spesifik->ukuran;
			$data['temperatur'] 	        = $spesifik->temperatur;
			$data['flange']             	= $spesifik->flange;
			$data['on_off']             	= $spesifik->on_off;
			$data['pressure'] 	            = $spesifik->pressure;
			$data['pipa'] 	                = $spesifik->pipa;
			$data['kabel'] 	                = $spesifik->kabel;
			$data['beratkotor'] 	        = $spesifik->berat;
			$data['namaspek'] 	            = $spesifik->namaspek;
			$data['keterangan'] 	        = $spesifik->keterangan;
		}

		$data['kat'] = $this->items->get_all('t_kategori');
		$data['masterkategori'] = $this->items->get_all('masterkategori');
		$data['kategori'] = trim($value, ', ');
		$data['rk'] = $rk;
		//ambil data file img berdasarkan id_item
		$gb = $this->items->get_where('t_img', ['id_item' => $id_item]);
		//cek data img
		if ($gb->num_rows() != 0)
		{
			$data['gb'] = $gb;
		} else {
			$data['gb'] = null;
		}
		$sl = $this->items->get_where('sellingpoint', ['id_item' => $id_item]);
		//cek data img
		$sel = $sl->row();
		if ($sl->num_rows() != "0")
		{
			$data['sellingpoint'] = $sel->gambar;
			$data['old_sellingpoint'] = $sel->gambar_point;
			$data['bg_color'] = $sel->background;
			$data['sellingtitle'] = $sel->judul;
			$data['sellingsubtitle'] = $sel->subjudul;
			$data['fotomaster'] = $sel->fotomaster;
			$data['imgpoint'] = $sel->img;
			$data['ketpoin'] = $sel->keterangan;
		} else {
			$data['sellingpoint'] = "";
		}

      $data['header'] = "Update ".$key->nama_item ;

      $this->template->admin('admin/item_form', $data);
   }

	private function kategori($id_item, $kategori)
	{
		$kat 	= explode(", ", $kategori);
		$len 	= count($kat);
		$a 		= array(' ');
		$b 		= array ('`','~','!','@','#','$','%','^','&','*','(',')','_','+','=','[',']','{','}','\'','"',':',';','/','\\','?','/','<','>');

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

	public function del_img()
	{
		$this->cek_login();
		if (!$this->uri->segment(3))
		{
			redirect('item');
		}
		//hapus file image dari folder
		unlink('assets/upload/lainnya/'.$this->uri->segment(3));
		//hapus data yang ada pada database
		$this->items->delete('t_img', ['img' => $this->uri->segment(3)]);
		echo '<script type="text/javascript">window.history.go(-1)</script>';
	}

	public function update_img()
	{
		$this->cek_login();
		if (!$this->uri->segment(3))
		{
			redirect('item');
		}
		
		$img = $this->items->get_where('t_img', ['img' => $this->uri->segment(3)])->row();
		$produk = $this->items->get_where('t_items', ['id_item' => $img->id_item])->row();
		$nama_file = 'img_'.$produk->link.'_'.date('md',time());

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
		    $idproduk = $this->input->post('idproduct');
		    $nama_file = $idproduk;
			$config['upload_path'] = './assets/upload/lainnya/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '2048';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('img'))
			{
			    //hapus file image
				unlink('assets/upload/lainnya/'.$this->uri->segment(3));

				$gbr = $this->upload->data();
				//proses update Database
				$this->items->update('t_img', ['img' => $gbr['file_name']], ['img' => $this->uri->segment(3)]);

				echo '<script type="text/javascript">window.history.go(-2)</script>';
			} else {
				$this->session->set_flashdata('alert', 'anda belum memilih foto');
			}
		}  
		
		$data['idproduk']=$nama_file;

		$this->template->admin('admin/up_img',$data);
	}

	public function update_sel()
	{
		$this->cek_login();
		if (!$this->uri->segment(3))
		{
			redirect('item');
		}

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '2048';
			$config['file_name'] = 'selling_point_'.$this->input->post('link', TRUE);

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('img'))
			{
				//hapus file image
				unlink('assets/upload/'.$this->uri->segment(3));

				$gbr = $this->upload->data();
				//proses update Database
				$this->items->update('sellingpoint', ['gambar' => $gbr['file_name']], ['gambar' => $this->uri->segment(3)]);

				echo '<script type="text/javascript">window.history.go(-2)</script>';
			} else {
				$this->session->set_flashdata('alert', 'anda belum memilih foto');
			}
		}

		$this->template->admin('admin/up_img');
	}

	public function rename()
	{
		$this->cek_login();

		$this->template->admin('admin/rename');
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('admin');
		}
	}
}

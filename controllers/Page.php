<?php
public function kategori()
{
if (!empty($this->uri->segment(4))) {
			if ($this->input->get('sort', TRUE)){
			$sort = $this->input->get('sort');
			$sort2 = explode(",", $sort);
			$data['sort']		= $sort;
			$data['data'] 		= $this->db->order_by($sort2[0], $sort2[1])->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)], $config['per_page'], $offset);
			}
			else{
			$data['data'] 		= $this->db->get_where($table, ['i.aktif' => 1, 'k.url' => $this->uri->segment(4)], $config['per_page'], $offset);
			}
			$page="subkategori";
			$data['url'] = strtolower(str_replace(['-','%20','_'], ' ', $this->uri->segment(4)));
			$data['kat'] = $this->db->get_where('masterkategori', ['link' => $this->uri->segment(3)])->row();
}
$skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id));
          if ($kat->masterkategori == "water filters") {
            $width = "max-width:600px;";
          }
          else{
            $width = "max-width:800px;";
          }
          echo '
          <div id="'.$kat->masterkategori.'" class="kategori desktop" style="position:relative; background:#ddd;">
          <div class="subkategori" style="padding:12px; text-align:center; '.$width.' margin:auto;">
         ';
         $kategori = str_replace(" ", "-", $kat->masterkategori);
         foreach ($skategori->result() as $sk):
          $url2 = str_replace(" ", "-", $sk->kategori);
          if ($this->uri->segment(4) == $sk->url) {
            $color = "background: rgba(10,42,59,1); color:#fff;";
          }
          else{
            $color = "";
          }
          echo '
          <div class="listkategori bd-event" style="background:#fff; margin:auto; text-align:center; margin:6px 6px 6px 6px; vertical-align:top; display:inline-block;"><a href="'.site_url('home/kategori/'.$kategori."/".$sk->url).'">
          <div class="gambarkategori" style="display:flex; height:130px; padding-top:12px;"><img style="margin:auto; max-width:100%; max-height:100%;" src="'.base_url().'assets/upload/'.$sk->foto_kategori.'" alt="'.$sk->kategori.'"></div>
          <div style="min-height:44px;max-height:44px; overflow-y:hidden;'.$color.'display:flex;"><p style="padding:0; margin:auto;">'.$sk->kategori.'</p></div></a>
          </div>
          ';
         endforeach;
         echo '
         </div>
         </div>';
}
?>
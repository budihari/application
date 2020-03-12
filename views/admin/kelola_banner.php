<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$kategori = $this->uri->segment(3);
$this->db->like('kategori', $kategori);
$this->db->order_by('id', 'ASC');
$get = $this->db->get('banner');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Kelola Banner <?php echo ucwords($kategori);?></h2>
      <div style="float:right">
         <a href="<?= base_url('banner/add_banner'); ?>" class="btn btn-primary">Tambah Banner</a>
      </div>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-11">
            <table class="table table-striped table-bordered dt-responsive nowrap">
               <thead>
                  <tr>
                     <th width="8%">#</th>
                     <th width="20%">Kategori</th>
                     <th width="30%">Gambar</th>
                     <th width="30%">URL</th>
                     <th width="12%">Opsi</th>
                  </tr>
                  <?php
                  $x=0;
                  $count = 0;
                  foreach($get->result() as $banner){
                          $x++;
                          $kategori = $banner->kategori;
                          $cek = $this->db->get_where('banner', ['kategori' => $kategori]);
                          $count = $cek->num_rows() - 1;
                  ?>
                  <tr>
                     <td><?php echo $x;?></td>
                     <td><?php echo $banner->kategori;?></td>
                     <td style="text-align:center;"><img style="max-width:80%;" src="<?php echo base_url();?>assets/upload/banner/<?php echo $banner->gambar;?>" style="max-widtd:80%;" alt=""><br>
                     </td>
                     <td><?php echo $banner->url;?></td>
                     <td class="center">   
                        <a href="<?php echo site_url('banner/update_banner/'.$banner->id);?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                        <a href="<?php echo site_url('banner/del_banner/'.$banner->id);?>" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  <?php
                  }
                  ?>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

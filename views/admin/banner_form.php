<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!empty($banner)) {
    $kat = $banner->row();
    $nama_banner = explode('.', $kat->gambar);
    $nama = str_replace('-',' ',$nama_banner[0]);
    $gambar=$kat->gambar;
    $idhome = $this->uri->segment(3).', home';
    $idbanner = $kat->id;
}
else{
    $idhome = '00, home';
    $idbanner = '';
}
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?= $header; ?></h2>
     <div class="clearfix"></div>
     <?= validation_errors('<p style="color:red">','</p>'); ?>
     <?php
     if ($this->session->flashdata('alert'))
     {
        echo '<div class="alert alert-danger alert-message">';
        echo $this->session->flashdata('alert');
        echo '</div>';
     }
     ?>
   </div>

   <div id="item" class="x_content">
      <br />

      <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Banner
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="nama_banner" value="<?php if(!empty($nama_banner[0])){ echo $nama; } ?>" placeholder="">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Gambar banner
            </label>
            <div style="max-width:300px;" class="col-md-7 col-sm-6 col-xs-12">
              <?php
              if (isset($gambar)) {
                echo '<input type="hidden" name="old_banner" value="'.$gambar.'">';
                echo '<img src="'.base_url('assets/upload/banner/'.$gambar).'" width="80%">';
                echo '<div class="clear-fix"></div><br />';
              }
               ?>
               <input type="file" name="banner">
               <p>*Ukuran yg direkomendasikan 1300px * 500px</p>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kategori</label>
            <div class="col-md-7 col-sm-6">
                <label>
                <input type="radio" name="kategori" value="00, home" <?php if(!empty($kat->kategori) && $kat->kategori == 'home'){echo 'checked';} ?>> home&nbsp;
                </label>
               <?php foreach($master->result() as $k) :?>
               <label>
                  <input type="radio" name="kategori" value="0<?=$k->id;?>, <?=$k->link;?>" <?php if(!empty($kat->kategori) && str_replace(' ','-',$kat->kategori) == $k->link){echo 'checked';} ?>> <?=$k->masterkategori;?>&nbsp;
               </label>
               <?php endforeach; ?>

            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >URL Tujuan
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="url" value="<?php if(!empty($kat->url)){ echo $kat->url; } ?>" placeholder="contoh (https://www.waterplus.com/toko/promo_terbaru)">
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="bannerform" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>
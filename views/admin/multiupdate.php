<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div style="position:fixed; z-index:9; top:54px; left:0; right:0;">';
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo '<center>'.$this->session->flashdata('alert').'</center>';
         echo '</div>';
      }
      //tampilkan pesan success
      if ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      echo '</div>';
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Update Item Sekaligus</h2>
     <div class="clearfix"></div>
   </div>

    <div style="padding: 0px 5px;">
        <p>Untuk mengupdate item, silahkan download terlebih dahulu format csv dibawah kemudian upload kembali dihalaman ini</p>
        <div style="display:flex;">
            <div style="width:30%;">
              <a class="btn btn-primary" href="<?= base_url();?>item/download_format">Download Format</a>
            </div>
            <div style="width:68%;">
            <form action="" method="post" enctype='multipart/form-data'>
              <p><label>Silahkan pilih file (hanya file .csv)</label>
              <input type="file" name="product_file" />
              <span><?=$message;?></span>
              </p>
              <br />
              <input type="submit" name="upload" class="btn btn-info" value="Upload" />
            </form>
            </div>
        </div>
    </div>

</div>
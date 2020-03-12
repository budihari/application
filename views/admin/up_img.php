<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Ubah Foto</h2>
     <div class="clearfix"></div>
     <?php
     if ($this->session->flashdata('alert'))
     {
        echo '<div class="alert alert-danger alert-message">';
        echo $this->session->flashdata('alert');
        echo '</div>';
     }
     ?>
   </div>

   <div class="x_content">
      <br />

      <form class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="post">

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Id Produk</label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" name="idproduct" value="<?php echo $idproduk;?>" class="form-control col-md-7 col-xs-12" readonly>
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Foto Baru</label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <img src="<?= base_url('assets/upload/lainnya/'.$this->uri->segment(3)) ;?>" width="30%">
               <div class="clear-fix"></div><br />
               <input type="file" name="img" class="form-control col-md-7 col-xs-12">
            </div>
         </div>

         <div class="ln_solid"></div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="submit" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>

     </form>
   </div>
</div>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Upload Bukti</h2>
      <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <br />
      <?php
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo $this->session->flashdata('alert');
         echo '</div>';
      }
      ?>
      <form class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="post">

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Id Transaksi</label>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <label class="control-label"><?= $id_trans; ?></label>
               <input type="hidden" name="trans" value="<?= $id_trans; ?>">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Foto Bukti</label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="file" name="img" class="form-control col-md-7 col-xs-12">
               <p class="help-text">* Gunakan Format JPG, JPEG atau PNG</p>
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

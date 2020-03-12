<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$today = date("Y-m-d", time());
$time = date("H:i:s", time());
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
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="idbayar" value="<?php echo time(); ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Order
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="idorder" value="<?php echo $idorder; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Tanggal Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="date" class="form-control col-md-7 col-xs-12" name="tglbayar" max="<?php echo $today;?>" value="<?php echo $today;?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Waktu Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="time" class="form-control col-md-7 col-xs-12" name="waktubayar" value="<?php echo $time;?>" required="required">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Total Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="totalbayar" value="<?php echo "Rp ".number_format($totalbayar, 0, ',', '.');?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Pengirim
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="namapengirim" placeholder="Atas Nama" value="" required="required">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Bank Asal
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="bankasal"  placeholder="Nama Bank" value="" required="required">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Jumlah Transfer
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input id="amount" type="text" class="form-control col-md-7 col-xs-12" name="jumlah" placeholder="Jumlah Uang" value="" required="required">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Bank Tujuan
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="banktujuan"  placeholder="Nama Bank" value="" required="required">
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="formbayar" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>
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
     //$tgl = explode(" ", $cek->tgl_pembayaran);
     ?>
   </div>

   <div id="item" class="x_content">
      <br />

      <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Kode Kupon
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="id_kupon" value="<?php if(!empty($cek)){echo $cek->$id_kupon;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Kupon
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="nama_kupon" value="<?php if(!empty($cek)){echo $cek->nama_kupon;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Deskripsi Kupon
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="deskripsi_kupon" value="<?php if(!empty($cek)){echo $cek->deskripsi_kupon;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >diskon / potongan
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="potongan" placeholder="Atas Nama" value="<?php if(!empty($cek)){echo $cek->potongan;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Stok Kupon
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="stok_kupon" value="<?php if(!empty($cek)){echo $cek->stok_kupon;}?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Min. Pembelian
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input id="amount" type="text" class="form-control col-md-7 col-xs-12" name="min_beli" value="<?php if(!empty($cek)){echo "Rp ".number_format($cek->min_bayar, 0, ',', '.');}?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Alasan Ditolak
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <select id="select_reason" name="alasan_tolak" class="form-control" onchange="reason()">
                   <option value="">Select Reason</option>
                   <option value="insufficient payment">Kurang Bayar (insufficient payment)</option>
                   <option value="proof of payment is invalid">Bukti Pembayaran Tidak Sesuai (proof of payment is invalid)</option>
               </select>
               <!--<input id="alasan" class="form-control col-md-7 col-xs-12" style="display: none;" name="alasan_tolak" placeholder="Alasan Lainnya">-->
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
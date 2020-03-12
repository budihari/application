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
     $tgl = explode(" ", $cek->tgl_pembayaran);
     ?>
   </div>

   <div id="item" class="x_content">
      <br />

<script>
    function reason() {
    var select = document.getElementById("select_reason").value;
    if (select == "another") {
       document.getElementById("alasan").style.display = "block";
    }
    else{
       document.getElementById("alasan").style.display = "none";
    }
 }
</script>

      <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="idbayar" value="<?php echo $idbayar; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Order
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="idorder" value="<?php echo $cek->id_order; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Tanggal Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="date" class="form-control col-md-7 col-xs-12" name="tglbayar" value="<?php echo $tgl[0];?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Pengirim
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="namapengirim" placeholder="Atas Nama" value="<?php echo $cek->namapengirim; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Total Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="totalbayar" value="<?php echo "Rp ".number_format($cek->total, 0, ',', '.');?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Jumlah Transfer
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input id="amount" type="text" class="form-control col-md-7 col-xs-12" name="jumlah" value="<?php echo "Rp ".number_format($cek->jumlah_transfer, 0, ',', '.');?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Bukti Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
            <p><a href="<?php echo base_url().'assets/bukti/'.$cek->bukti;?>" target="_blank">Lihat Bukti</a></p>
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
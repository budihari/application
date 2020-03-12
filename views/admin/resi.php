<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Tambah Resi Pengiriman</h2>
     <div class="clearfix"></div>
   </div>
   <?php
   $user = $data->row();
   ?>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Id Order
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->id_order; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Tanggal Pesan
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= date('d M Y', strtotime($user->tgl_pesan)); ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Nama Penerima
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->nama_pemesan; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         No. Telepon
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->telepon; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Email
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->email; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Tujuan
      </div>
      <div class="col-md-10 col-sm-8">
      <?php
      $alamat = array();
         if (!empty($user->tujuan)) {
            array_push($alamat, $user->tujuan);
         }
         if (!empty($user->kota)) {
            $kota = explode(",", $user->kota);
            if (!empty($kota[1])) {
               array_push($alamat, $kota[1]);
            }
         }
         if (!empty($user->provinsi)) {
            $provinsi = explode(",", $user->provinsi);
            if (!empty($provinsi[1])) {
               array_push($alamat, $provinsi[1]);
            }
         }
         $alamat = join(", ", $alamat);
      ?>
         : <?= $alamat; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Kurir
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->kurir." / ".$user->service; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Biaya Ongkos Kirim
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= "Rp ".number_format($user->ongkir, 0, ',', '.');?>
      </div>
   </div>
   <hr>
   <form action="" method="post">
   <div class="row">
      <div class="col-md-2 col-sm-4" style="margin: auto;">
         Input Nomor Resi
      </div>
      <div class="col-md-7 col-sm-6 col-xs-12">
         <input type="text" class="form-control col-md-7 col-xs-12" name="resi" value="<?= $user->resi; ?>" required="required">
         <br><br><br>
         <button type="submit" class="btn btn-success" name="form" value="Submit">Submit</button>
         <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
      </div>
   </div>
   </form>
   <br />
</div>

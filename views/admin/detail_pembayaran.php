<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Detail Pembayaran</h2>
     <div class="clearfix"></div>
   </div>
   <?php
   $user = $data->row();
   $validation = '';
   $tolak = '';
   if ($user->status == 'not verified') {
      $validation = '<a href="'.base_url().'pembayaran/valid/'.$user->idpembayaran.'" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;terima</a>';
      $tolak = '<a href="'.base_url().'pembayaran/tolak/'.$user->idpembayaran.'" class="btn btn-danger"><i class="fa fa-close"></i>&nbsp;tolak</a>';
   }
   ?>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Id Pembayaran
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->idpembayaran; ?>
      </div>
   </div>
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
         Tanggal Bayar
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= date('d M Y', strtotime($user->tgl_pembayaran)); ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Nama Pengirim
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->namapengirim; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Bank Asal
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->bank_asal; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Bank Tujuan
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->bank_tujuan; ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Jumlah Transfer
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= "Rp ".number_format($user->jumlah_transfer, 0, ',', '.'); ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-2 col-sm-4">
         Status
      </div>
      <div class="col-md-10 col-sm-8">
         : <?= $user->status; ?>
      </div>
   </div>
   <div class="row">
      <p style="padding:0px 10px;">Bukti Pembayaran</p>
      <div>
          <a href="<?php echo base_url().'assets/bukti/'.$user->bukti;?>" target="_blank"><img style="max-width:80%;" src="<?php echo base_url().'assets/bukti/'.$user->bukti;?>"></a>
      </div>
   </div>
   <br>
   <div class="row">
      <div>
      <?php echo $validation.$tolak;?>
      </div>
   </div>
   <br />
</div>

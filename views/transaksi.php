<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h3><i class="fa fa-exchange"></i> data transaksi</h3>
<hr />
<br />
<div class="row" style="min-height: 300px;">
<?php
         $today = (abs(strtotime(date("Y-m-d"))));
         $i = 1;
if ($get -> num_rows() > 0) {
?>
   <table class="bordered">
      <thead>
         <tr>
            <th style="width:50px;" class="center">#</th>
            <th style="width:calc(55% - 50px);" class="center">detail transaksi</th>
            <th width="30%" class="center">status</th>
            <th width="10%" class="center">opsi</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $today = (abs(strtotime(date("Y-m-d"))));
         $i = 1;

         foreach ($get->result() as $key) :
         ?>

            <tr>
               <td class="center"><?= $i++; ?></td>
               <td>
                <p style="line-height:24px;" class="bariol-regular">
                <a href="<?=site_url('home/detail_transaksi/'.$key->id_order)?>" class="blue-text"><?= $key->id_order; ?></a><br>
                tanggal pesan : <?= date("d M Y", strtotime($key->tgl_pesan)); ?><br>
                batas pembayaran : <?= date("d M Y", strtotime($key->bts_bayar)); ?><br>
                <b class="red-text">Rp <?= number_format($key->total, 0, ',', '.') ?></b>
                </p>
               </td>
               <td class="center">
                  <?php
                  $batas = (abs(strtotime($key->bts_bayar)));

                  if ($today > $batas && $key->status_proses == 'belum') {
                     echo 'Kedaluarsa';
                  } else {
                     echo ucfirst($key->status_proses);
                  }
                  ?>
               </td>
               <td class="center">
                  <a href="<?=site_url('home/detail_transaksi/'.$key->id_order)?>" class="btn btn-floating green"><i class="fa fa-search-plus"></i></a>

                  <?php
                  if ($key->status_proses != 'proses' && $key->status_proses != 'selesai') {
                  ?>
                     <a href="<?=site_url('home/hapus_transaksi/'.$key->id_order);?>" class="btn btn-floating red" onclick="return confirm('yakin ingin menghapus data ini ?')"><i class="fa fa-trash"></i></a>
                  <?php
                  }
                  if ($key->status_proses == 'proses') {
                  ?>
                     <a href="<?=site_url('home/transaksi_selesai/'.$key->id_order);?>" class="btn btn-floating blue"><i class="fa fa-check"></i></a>
                  <?php
                  }
                  ?>
               </td>
            </tr>

         <?php endforeach; ?>
      </tbody>
   </table>
<?php
}
else{
?>
<div style="display: flex; min-height: 300px;">
  <div style="margin: auto;">
    <p>belum ada transaksi yang tersimpan</p>
  </div>
</div>
<?php
}
?>
</div>
<hr>
<div class="center">
   <button type="button" class="btn blue" onclick="window.history.go(-1)">Kembali</button>
</div>
<div style="clear: both;"></div>
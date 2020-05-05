<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="">
   <div class="row top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-users"></i></div>
            <div class="count"><?=$user;?></div>
            <h3>Jumlah User</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-cubes"></i></div>
            <div class="count"><?=$item;?></div>
            <h3>Jumlah Item</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-tags"></i></div>
            <div class="count"><?=$tag;?></div>
            <h3>Jumlah Kategori</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-exchange"></i></div>
            <div class="count"><?=$trans;?></div>
            <h3>Transaksi</h3>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="x_panel">
            <h3>Menu Lainnya</h3>
            <hr />
            <div>
               <a href="user/subscriber" class="btn btn-primary"><i class="fa fa-info"></i>&nbsp; Data Subscriber</a>
               <a href="setting/faq" class="btn btn-primary"><i class="fa fa-question"></i>&nbsp; FAQ</a>
            </div>
            <hr>
            <h3>Transaksi Terakhir</h3>
            <hr />
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Id Order</th>
                     <th>Nama Penerima</th>
                     <th>Kota Tujuan</th>
                     <th>Tanggal Pesan</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $i = 1;
                  foreach($last->result() as $key) :

                     $alamat = array();
                  if (!empty($key->tujuan)) {
                     array_push($alamat, $key->tujuan);
                  }
                  if (!empty($key->subdistrict)) {
                     $subdistrict = explode(",", $key->subdistrict);
                     if (!empty($subdistrict[1])) {
                        array_push($alamat, $subdistrict[1]);
                     }
                  }
                  if (!empty($key->kota)) {
                     $kota = explode(",", $key->kota);
                     if (!empty($kota[1])) {
                        array_push($alamat, $kota[1]);
                     }
                  }
                  if (!empty($key->provinsi)) {
                     $provinsi = explode(",", $key->provinsi);
                     if (!empty($provinsi[1])) {
                        array_push($alamat, $provinsi[1]);
                     }
                  }
                  $alamat = join(", ", $alamat);

                  ?>
                     <tr>
                        <td><?=$i++;?></td>
                        <td><a style="color:#0ad;" href="transaksi/detail/<?=$key->id_order;?>"><?=$key->id_order;?></a></td>
                        <td><?=$key->nama_pemesan;?></td>
                        <td><?=$alamat;?></td>
                        <td><?=date('d M Y', strtotime($key->tgl_pesan));?></td>
                        <td><?=$key->status_proses;?></td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

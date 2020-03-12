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
            <h3>Transaksi Terakhir</h3>
            <hr />
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>No.</th>
                     <th>Id Order</th>
                     <th>Tanggal Transaksi</th>
                     <th>Total Bayar</th>
                     <th>Status</th>
                     <th>Aksi</th>
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
                  $tgl_pesan = date('d M Y / H:i:s', strtotime($key->tgl_pesan));
                  $waktu_pesan = explode(" / ",$tgl_pesan);
                  ?>
                     <tr>
                        <td><?=$i++;?></td>
                        <td><a style="color:#0ad;" href="transaksi/detail/<?=$key->id_order;?>"><?=$key->id_order;?></a></td>
                        <td><?=$waktu_pesan[0].'<br>'.$waktu_pesan[1];?></td>
                        <td><?="Rp ".number_format($key->total, 0, ',', '.');?></td>
                        <td><?=$key->status_proses;?></td>
                        <td><a href="<?php echo base_url('pembayaran/add_pembayaran/'.$key->id_order);?>" class="btn btn-default">Konfirmasi</a></td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

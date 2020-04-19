<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$user = $data->row();
?>

<div style="background: #ffffff; margin:auto; max-width:800px; padding: 12px;">
   <div class="x_title">
      <h2>Detail Transaksi #<?= $user->id_order;?></h2>
     <div class="clearfix"></div>
   </div>
   <table style="width:100%;">
       <tr>
           <td style="width:30%; min-width:120px;">Nama Pemesan</td>
           
           <td style="width:65%;">: <?= $user->nama_pemesan; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Tanggal Pesan</td>
           
           <td style="width:65%;">: <?= date('d M Y', strtotime($user->tgl_pesan)); ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">No. Telepon</td>
           
           <td style="width:65%;">: <?= $user->telepon; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Email</td>
           
           <td style="width:65%;">: <?= $user->email; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Alamat</td>
           
           <td style="width:65%;"><?php
      $alamat = array();
      $alamat1 = array();
         if (!empty($user->tujuan)) {
            array_push($alamat, $user->tujuan);
         }
         if (!empty($user->subdistrict)) {
            $subdistrict = explode(",", $user->subdistrict);
            if (!empty($subdistrict[1])) {
               array_push($alamat, $subdistrict[1]);
            }
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
         if (!empty($user->pos)) {
               array_push($alamat, $user->pos);
         }
         $alamat = join(", ", $alamat);
         $alamat1 = join(", ", $alamat1);
      ?>: <?= $alamat; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Kurir / Service</td>
           
           <td style="width:65%;">: <?= $user->kurir.' / '.$user->service; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Biaya Ongkos Kirim</td>
           
           <td style="width:65%;">: <?= "Rp ".number_format($user->ongkir, 0, ',', '.');?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Status</td>
           
           <td style="width:65%;">: <?= ucfirst($user->status_proses); ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Bukti Pengiriman</td>
           
           <td style="width:65%;">: <?= '<a style="color:#2196f3" href="'.base_url().'assets/bukti/'.$user->bukti_pengiriman.'" target="_blank">'.$user->bukti_pengiriman.'</a>'; ?></td>
       </tr>
       <tr>
           <td style="width:30%; min-width:120px;">Nomor Resi</td>
           <td style="width:65%;">: <?= $user->resi; ?></td>
       </tr>
   </table>
   <hr>
   <div class="row">
      <div class="col-md-11">
         <h2>History Pengiriman</h2>
         <?php
         if($status == 1){
         ?>
         <table style="width: 100%;">
         <tr>
            <th style="width: 35%;">Waktu</th><th style="width: 65%;">Keterangan</th>
         </tr>
         <?php
         if(!empty($response)){
            echo $response;
         }
         ?>
         </table>
         <?php
         }
         else{
            echo $response;
         }
         ?>
      </div>
   </div>
   <hr>
   <div class="row">
      <div class="col-md-11">
         <h2>Bukti Pembayaran</h2>
         <?php
         if(!empty($user->bukti)){
         ?>
         <img style="max-width: 500px; max-height:500px;" src="<?php echo base_url().'assets/bukti/'.$user->bukti;?>">
         <?php
         }
         ?>
      </div>
   </div>
   <hr>
   <div class="row" style="padding: 0px 12px;">
   <div class="x_content">
      <div class="row">
         <div class="col-md-8 col-sm-12">
            <table class="table table-striped">
               <tr>
                  <th>#</th>
                  <th>Nama Item</th>
                  <th>Jumlah</th>
                  <th>Biaya</th>
               </tr>

               <?php
               $i = 1;
               foreach ($data->result() as $key):
                  ?>
                  <tr>
                     <td><?= $i++; ?></td>
                     <td><?=$key->nama_item.'<br>Note : '.$key->catatan;?></td>
                     <td><?=$key->qty;?></td>
                     <td style="text-align:right"><?=number_format($key->biaya, 0, ',','.')?></td>
                  </tr>
               <?php endforeach; ?>
               <tr>
                  <td colspan="3">Diskon (<?= $user->kupon; ?>)</td>
                  <td style="text-align:right">- <?=number_format($user->potongan, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Kode Unik</td>
                  <td style="text-align:right"><?=number_format($user->kode_unik, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Ongkir</td>
                  <td style="text-align:right"><?=number_format($user->ongkir, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Total</td>
                  <td style="text-align:right"><?=number_format($user->total, 0, ',','.')?></td>
               </tr>
            </table>
         </div>
      </div>
   </div>
   </div>


</div>
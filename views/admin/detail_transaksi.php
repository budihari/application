<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
   $user = $data->row();
?>
<div class="x_panel">
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
      </div>
   </div>
   <hr>
   <div class="row">
      <div class="col-md-11">
         <h2>Bukti Pembayaran</h2>
         <?php
         if(!empty($user->bukti)){
         ?>
         <img style="max-width: 80%;" src="<?php echo base_url().'assets/bukti/'.$user->bukti;?>">
         <?php
         }
         ?>
      </div>
   </div>
   <hr>
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
            <a href="#" class="btn btn-default" onclick="window.history.go(-1)">Kembali</a>
            <?php
            if ($user->status_proses == 'not paid') {

               $btn = '<a href="'.base_url('pembayaran/add_pembayaran/'.$user->id_order).'" class="btn btn-default">Tambah Pembayaran</a>';
   
            } else {
   
               if ($user->status_proses == 'paid' && $this->session->userdata('level_admin') == '11') {
                  $btn = '<a href="'.site_url('transaksi/process/'.$user->id_order).'" class="btn btn-success"><i class="fa fa-circle-o-notch"></i>&nbsp;Proses</a>';
               } elseif ($user->status_proses == 'on process' && $this->session->userdata('level_admin') == '11') {
                  $btn = '<a href="'.site_url('transaksi/resi/'.$user->id_order).'" class="btn btn-success"><i class="fa fa-barcode"></i>&nbsp;Input Resi Pengiriman</a>';
               } else {
                  $btn = '';
               }
            }

               echo $btn;
            
            ?>
         </div>
      </div>
   </div>
</div>

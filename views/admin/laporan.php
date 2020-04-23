<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Laporan Transaksi</h2>
      <div class="clearfix"></div>
      <?= validation_errors('<p style="color:red">','</p>'); ?>
      <form class="form-horizontal row"action="" method="post">

         <div class="form-group col-md-3 col-sm-12">
            <select class="form-control" name="bln">
               <option value="01" <?php if ($bln == 1) { echo 'selected'; } ?>>Januari</option>
               <option value="02" <?php if ($bln == 2) { echo 'selected'; } ?>>Februari</option>
               <option value="03" <?php if ($bln == 3) { echo 'selected'; } ?>>Maret</option>
               <option value="04" <?php if ($bln == 4) { echo 'selected'; } ?>>April</option>
               <option value="05" <?php if ($bln == 5) { echo 'selected'; } ?>>Mei</option>
               <option value="06" <?php if ($bln == 6) { echo 'selected'; } ?>>Juni</option>
               <option value="07" <?php if ($bln == 7) { echo 'selected'; } ?>>Juli</option>
               <option value="08" <?php if ($bln == 8) { echo 'selected'; } ?>>Agustus</option>
               <option value="09" <?php if ($bln == 9) { echo 'selected'; } ?>>September</option>
               <option value="10" <?php if ($bln == 10) { echo 'selected'; } ?>>Oktober</option>
               <option value="11" <?php if ($bln == 11) { echo 'selected'; } ?>>November</option>
               <option value="12" <?php if ($bln == 12) { echo 'selected'; } ?>>Desember</option>
            </select>
         </div>

         <div class="form-group col-md-3 col-sm-12">
            <select class="form-control" name="thn">
               <?php for ($i = 2016; $i <= 2035; $i++) { ?>
                  <option value="<?=$i;?>" <?php if ($thn == $i) { echo 'selected'; } ?>>
                     <?=$i;?>
                  </option>
               <?php } ?>
            </select>
         </div>

         <button type="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button>
      </form>
   </div>

   <div class="x_content">
      <div class="row">
         <?php
         switch ($bln) {
            case '01':
               $Bulan = 'Januari';
               break;
            case '02':
               $Bulan = 'Februari';
               break;
            case '03':
               $Bulan = 'Maret';
               break;
            case '04':
               $Bulan = 'April';
               break;
            case '05':
               $Bulan = 'Mei';
               break;
            case '06':
               $Bulan = 'Juni';
               break;
            case '07':
               $Bulan = 'Juli';
               break;
            case '08':
               $Bulan = 'Agustus';
               break;
            case '09':
               $Bulan = 'September';
               break;
            case '10':
               $Bulan = 'Oktober';
               break;
            case '11':
               $Bulan = 'November';
               break;
            case '12':
               $Bulan = 'Desember';
               break;
         }

         ?>
         <div class="col-md-10 col-sm-12">
            <h3>Laporan Bulan <?=$Bulan;?> Tahun <?=$thn;?></h3>
         </div>
         <div>
            <a href="<?= site_url('transaksi/download_laporan/'.$bln.'/'.$thn); ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i></a>
            <a href="<?= site_url('transaksi/print/'.$bln.'/'.$thn); ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Cetak</a>
         </div>

         <div>
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>No.</th>
                     <th>Outlet</th>
                     <th>Number</th>
                     <th>Customer</th>
                     <th>Date Time</th>
                     <th>Unique Code</th>
                     <th>Coupon</th>
                     <th>Ongkir</th>
                     <th>Total Bayar</th>
                     <!--<th>Pendapatan</th>-->
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  $pendapatan = 0;
                  foreach($data->result() as $key) :
                     $pendapatan += $key->total;
                     $tgl_pesan = date('d M Y / H:i:s', strtotime($key->tgl_pesan));
                     $bts_bayar = date('d M Y / H:i:s', strtotime($key->bts_bayar));
                     $waktu_pesan = explode(" / ",$tgl_pesan);
                     $bts_waktu = explode(" / ",$bts_bayar);
                     $kupon = '';
                     if(!empty($key->kupon)){
                        $kupon = $key->kupon."<br>- Rp. ".$key->potongan;
                     }
                  ?>
                  <tr>
                     <td rowspan="2"><?= $no++;?></td>
                     <td style="vertical-align: middle;">Waterplus+ Store</td>
                     <td style="vertical-align: middle;"><?=$key->id_order;?></td>
                     <td style="vertical-align: middle;"><?=$key->nama_pemesan;?></td>
                     <td style="vertical-align: middle;"><?=$waktu_pesan[0]."<br>".$waktu_pesan[1];?></td>
                     <td style="vertical-align: middle;"><?="Rp. ".$key->kode_unik;?></td>
                     <td style="vertical-align: middle;"><?=$kupon;?></td>
                     <td style="vertical-align: middle;">
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format($key->ongkir,0,',','.');?>,-</span>
                     </td>
                     <td style="vertical-align: middle;">
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format(($key->total),0,',','.');?>,-</span>
                     </td>
                     <!--<td>
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format($key->biaya,0,',','.');?>,-</span>
                     </td>-->
                  </tr>
                  <tr>
                     <td colspan="8">Tes</td>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                     <td colspan="8" style="text-align:center; vertical-align:middle;"><b>Total</b></td>
                     <td>
                        <b>
                           <span style="float:left">Rp.</span>
                           <span style="float:right"><?= number_format($pendapatan,0,',','.');?>,-</span>
                        </b>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>

         <!--<div class="col-md-12 col-sm-12">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Id Order</th>
                     <th>Nama Pemesan</th>
                     <th>Kota Tujuan</th>
                     <th>Total Bayar</th>
                     <th>Ongkir</th>
                     <th>Pendapatan</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  $pendapatan = 0;
                  foreach($data->result() as $key) :
                     $pendapatan += $key->biaya;
                  ?>
                  <tr>
                     <td><?= $no++;?></td>
                     <td><?=$key->id_order;?></td>
                     <td><?=$key->nama_pemesan;?></td>
                     <td><?=$key->kota;?></td>
                     <td>
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format($key->total,0,',','.');?>,-</span>
                     </td>
                     <td>
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format(($key->total - $key->biaya),0,',','.');?>,-</span>
                     </td>
                     <td>
                        <span style="float:left">Rp.</span>
                        <span style="float:right"><?= number_format($key->biaya,0,',','.');?>,-</span>
                     </td>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                     <td colspan="6" style="text-align:center"><b>Pendapatan</b></td>
                     <td>
                        <b>
                           <span style="float:left">Rp.</span>
                           <span style="float:right"><?= number_format($pendapatan,0,',','.');?>,-</span>
                        </b>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>-->

         <div class="col-md-6 col-sm-6">
            <a href="#" class="btn btn-default" onclick="window.history.go(-1)">Kembali</a>
         </div>

      </div>
   </div>
</div>

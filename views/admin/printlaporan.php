<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="background: #ffffff; padding:12px;">
<div>
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
                     <td style="text-align:center; vertical-align: middle;" rowspan="2"><?= $no++;?></td>
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

      </div>
   </div>
   </div>
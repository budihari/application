<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$pesan = $data->row();
$tgl = explode(" ", $pesan->tgl);
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?=$header;?></h2>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-12">
             <table>
                <tr>
                     <td style="width: 20%;">ID Pesan</td><td style="width: 80%;">: <?=$pesan->idpesan;?></td>
                </tr>
                <tr>
                     <td>Tanggal</td><td>: <?=$tgl[0].", Jam : ".$tgl[1];?></td>
                </tr>
                <tr>
                     <td>Nama</td><td>: <?=$pesan->nama;?></td>
                </tr>
                <tr>
                     <td>Email</td><td>: <?=$pesan->email;?></td>
                </tr>
                <tr>
                     <td>Subject</td><td>: <?=$pesan->subject;?></td>
                </tr>
                <tr>
                     <td>Pesan</td><td><p style="text-align: justify;">: <?=$pesan->pesan;?></p></td>
                 </tr>
             </table>
         </div>
      </div>
   </div>
</div>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?=$header;?></h2>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-12">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="datatable">
               <thead>
                  <tr>
                     <th width="5%">#</th>
                     <th width="55%">Keterangan</th>
                     <th width="15%">Email</th>
                     <th width="10%">Opsi</th>
                  </tr>
                  <?php
                    $i = 1;
                    foreach($data->result() as $pesan) :
                    $tgl = explode(" ", $pesan->tgl);
                  ?>
                  <tr>
                      <td><?=$i++;?></td>
                      <td style="white-space:normal;">
                         ID Pesan : <?=$pesan->idpesan;?><br>
                         Tanggal : <?=$tgl[0].", Jam : ".$tgl[1];?><br>
                         Nama : <?=$pesan->nama;?><br>
                         Subject : <?=$pesan->subject;?><br>
                         Pesan : <?=$pesan->pesan;?><br>
                      </td>
                      <td style="vertical-align: middle;"><?=$pesan->email;?></td>
                      <td style="vertical-align: middle;" class="center">
                      <a class="btn btn-primary" href="<?=base_url();?>user/detail_pesan/<?=$pesan->idpesan;?>">Lihat
                     </td>
                  </tr>
                  <?php
                    endforeach;
                  ?>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

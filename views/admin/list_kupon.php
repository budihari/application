<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?=$header;?></h2>
      <div style="float:right">
         <a href="<?= base_url('administrator/add_kupon'); ?>" class="btn btn-primary">Tambah Kupon</a>
      </div>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-12">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="datatable">
               <thead>
                  <tr>
                     <th width="2%">#</th>
                     <th>ID Kupon</th>
                     <th>Nama Kupon</th>
                     <th>Deskripsi Kupon</th>
                     <th>Potongan</th>
                     <th>Stok Kupon</th>
                     <th>Min. Pembelian</th>
                     <th>Batas Peruser</th>
                     <th>Periode</th>
                     <th>Opsi</th>
                  </tr>
                  <?php
                    $i = 1;
                    foreach($kupon->result() as $kupon) :
                  ?>
                  <tr>
                      <td><?=$i++;?></td>
                      <td><?=$kupon->id_kupon;?></td>
                      <td><?=$kupon->nama_kupon;?></td>
                      <td><?=$kupon->deskripsi_kupon;?></td>
                      <td><?=$kupon->persen."% max Rp ".number_format($kupon->potongan, 0, ',', '.');?></td>
                      <td><?=$kupon->stok_kupon;?></td>
                      <td><?="Rp ".number_format($kupon->min_bayar, 0, ',', '.');?></td>
                      <td><?=$kupon->batas_peruser;?></td>
                      <td><?=$kupon->batas_waktu.' hari';?></td>
                      <td></td>
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

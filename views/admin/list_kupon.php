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
                     <th width="5%">#</th>
                     <th width="55%">Keterangan</th>
                     <th width="15%">Potongan</th>
                     <th width="15%">Min. Bayar</th>
                     <th width="10%">Opsi</th>
                  </tr>
                  <?php
                    $i = 1;
                    foreach($kupon->result() as $kupon) :
                  ?>
                  <tr>
                      <td><?=$i++;?></td>
                      <td>
                         ID Kupon : <?=$kupon->id_kupon;?><br>
                         Nama Kupon : <?=$kupon->nama_kupon;?><br>
                         Deskripsi : <?=$kupon->deskripsi_kupon;?><br>
                         Stok Kupon : <?=$kupon->stok_kupon;?><br>
                         Batas Peruser : <?=$kupon->batas_peruser;?><br>
                         Masa Berlaku : <?=$kupon->batas_waktu.' hari';?>
                      </td>
                      <td style="vertical-align: middle;"><?=$kupon->persen."% max Rp ".number_format($kupon->potongan, 0, ',', '.');?></td>
                      <td style="vertical-align: middle;"><?="Rp ".number_format($kupon->min_bayar, 0, ',', '.');?></td>
                      <td style="vertical-align: middle;" class="center"><a href="<?=base_url();?>administrator/edit_kupon/<?=$kupon->id_kupon;?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                      <a style="color: #b00;" href="<?=base_url();?>administrator/delete_kupon/<?=$kupon->id_kupon;?>" onclick="return confirm('Yakin Ingin Menghapus Data ini ?')"><i class="fa fa-trash"></i></a>
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

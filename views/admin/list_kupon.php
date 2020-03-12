<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Managemen Item</h2>
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
                     <th width="30%">ID Kupon</th>
                     <th>Nama Kupon</th>
                     <th>Deskripsi Kupon</th>
                     <th>Potongan</th>
                     <th>Stok Kupon</th>
                     <th>Min. Pembelian</th>
                     <th>Batas Peruser</th>
                     <th>Periode</th>
                     <th width="12%">Opsi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

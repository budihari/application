<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Managemen Kategori</h2>
      <div style="float:right">
         <a href="<?= base_url('tag/add_kategori'); ?>" class="btn btn-primary">Tambah Kategori</a>
      </div>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-11">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="datatable">
               <thead>
                  <tr>
                     <th width="8%">#</th>
                     <th width="20%">Master Kategori</th>
                     <th width="40%">Kategori</th>
                     <th width="40%">Gambar</th>
                     <th>Url</th>
                     <th width="10%">Opsi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

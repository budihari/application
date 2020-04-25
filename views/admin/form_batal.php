<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$today = date("Y-m-d", time());
$time = date("H:i:s", time());
?>
<div class="x_panel">
   <div class="x_title">
      <h2><?= $header; ?></h2>
     <div class="clearfix"></div>
     <?php
     if ($this->session->flashdata('alert'))
     {
        echo '<div class="alert alert-danger alert-message">';
        echo $this->session->flashdata('alert');
        echo '</div>';
     }
     $tgl = explode(" ", $cek->tgl_pesan);
     $tgl = date("d-M-Y", strtotime($tgl[0]));
     ?>
   </div>

   <div id="item" class="x_content">
      <br />

<script>
    function reason() {
    var select = document.getElementById("select_reason").value;
    if (select == "lainnya") {
       document.getElementById("alasan").style.display = "block";
    }
    else{
       document.getElementById("alasan").style.display = "none";
    }
 }
</script>

      <form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ID Order
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="idorder" value="<?php echo $cek->id_order; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Penerima
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="namapenerima" placeholder="Atas Nama" value="<?php echo $cek->nama_pemesan; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Tgl Pesan
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="tgl_pesan" placeholder="Tgl Pesan" value="<?php echo $tgl; ?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Total Pembayaran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="totalbayar" value="<?php echo "Rp ".number_format($cek->total, 0, ',', '.');?>" readonly>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Alasan Batal
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <select id="select_reason" name="alasan_batal" class="form-control" onchange="reason()">
                   <option value="">Select Reason</option>
                   <option value="insufficient stock">stok tidak cukup (insufficient stock)</option>
                   <option value="lainnya">lainnya</option>
               </select>
               <input id="alasan" class="form-control col-md-7 col-xs-12" style="margin-top:8px; display: none;" name="alasan_lainnya" value="" placeholder="Apa alasan lainnya?" required='required'>
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
               <button type="submit" class="btn btn-success" name="formbatal" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
         </div>
      </form>
      <div>
         <div class="x_title">
            <h2>Detail Order</h2>
            <div class="clearfix"></div>
         </div>

         <table class="table table-striped">
               <tr>
                  <th>#</th>
                  <th>Nama Item</th>
                  <th style="text-align: center;">Jumlah</th>
                  <th style="text-align: center;">Biaya</th>
               </tr>

               <?php
               $i = 1;
               $table = '';
               $table1 = "t_detail_order detail
               JOIN t_items i ON (detail.id_item = i.id_item)";
               $data = $this->db->get_where($table1, ['detail.id_order' => $cek->id_order]);
               foreach ($data->result() as $key):
                  ?>
                  <tr>
                     <td><?= $i++; ?></td>
                     <td><?=$key->nama_item.'<br>Note : '.$key->catatan;?></td>
                     <td style="text-align: center;"><?=$key->qty;?></td>
                     <td style="text-align:right"><?=number_format($key->biaya, 0, ',','.')?></td>
                  </tr>
               <?php endforeach; ?>
               <tr>
                  <td colspan="3">Diskon (<?= $cek->kupon; ?>)</td>
                  <td style="text-align:right">- <?=number_format($cek->potongan, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Kode Unik</td>
                  <td style="text-align:right"><?=number_format($cek->kode_unik, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Ongkir</td>
                  <td style="text-align:right"><?=number_format($cek->ongkir, 0, ',','.')?></td>
               </tr>
               <tr>
                  <td colspan="3">Total</td>
                  <td style="text-align:right"><?=number_format($cek->total, 0, ',','.')?></td>
               </tr>
            </table>
      </div>
   </div>
</div>
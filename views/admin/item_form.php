<?php
defined('BASEPATH') OR exit('No direct script access allowed');

clearstatcache();
if ($rk) {
   foreach ($rk->result() as $l) {
      $r[] = $l->url;
   }
}

?>
<div class="x_panel">
   <div class="x_title">
      <h2><?= $header; ?></h2>
     <div class="clearfix"></div>
     <?= validation_errors('<p style="color:red">','</p>'); ?>
     <?php
     if ($this->session->flashdata('alert'))
     {
        echo '<div class="alert alert-danger alert-message">';
        echo $this->session->flashdata('alert');
        echo '</div>';
     }
     ?>
   </div>
<div style="border:solid 1px #ddd;">
   <div id="produk" class="tab" style="cursor: pointer; text-align: center; display: inline-flex; color: #0af; border-right: solid 1px #ddd;" onclick="tab(this, 'item')">
      <p style="padding: 12px; margin: 0;">Info Produk</p>
   </div>
   <div id="spek" class="tab" style="cursor: pointer; text-align: center; display: inline-flex; color: #777; border-right: solid 1px #ddd;" onclick="tab(this, 'spesifikasi')">
      <p style="padding: 12px; margin: 0;">Spesifikasi</p>
   </div>
   <div id="custom" class="tab" style="cursor: pointer; text-align: center; display: inline-flex; color: #777; border-right: solid 1px #ddd;" onclick="tab(this, 'spekcustom')">
      <p style="padding: 12px; margin: 0;">Sesuaikan</p>
   </div>
   <div id="sellingpoint" class="tab" style="cursor: pointer; text-align: center; display: inline-flex; color: #777; border-right: solid 1px #ddd;" onclick="tab(this, 'selling')">
      <p style="padding: 12px; margin: 0;">Selling point</p>
   </div>
<script>
function tab(data1, data2) {
  var x = document.getElementsByClassName("tab");
  var innertab = document.getElementsByClassName("innertab");
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].style.color = "#777";
  }
  i = 0;
  for (i = 0; i < innertab.length; i++) {
    innertab[i].style.display = "none";
  }
  data1.style.color="#0af";
  document.getElementById(data2).style.display = 'block';
}
</script>
</div>
<form id="postForm" class="form-horizontal form-label-left" action="" enctype="multipart/form-data" method="POST" onsubmit="return postForm()">
   <div id="item" class="innertab">
      <br />

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nomor urut
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="urutan" value="<?= $urut; ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Link Item*
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="link" value="<?= $link; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Nama Item*
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="nama" value="<?= $nama; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Gambar Utama*
            </label>
            <div class="col-md-5 col-sm-12 col-xs-12">
               <?php
               if (isset($gambar)) {
                  echo '<input type="hidden" name="old_pict" value="'.$gambar.'">';
                  echo '<center><img style="max-width:80%; max-height:200px;" src="'.base_url('assets/product/'.$gambar).'"></center>';
                  echo '<div class="clear-fix"></div><br />';
               }
               ?>
               <input type="file" class="form-control col-md-7 col-xs-12" name="foto">
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Gambar Lainnya*
            </label>
            <?php
               if (isset($gb)) {
                  $jml = 5 - $gb->num_rows();

                  echo '<div class="col-md-6 col-sm-6 col-xs-12">';

                  foreach ($gb->result() as $img) :
                     ?>

                     <div class="col-md-5 col-sm-6 card">
                        <div class="card-image">
                           <img src="<?= base_url('assets/upload/lainnya/'.$img->img); ?>">
                        </div>
                        <div class="card-action">
                           <a href="<?= base_url('item/update_img/'.$img->img); ?>" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Update Gambar</a>
                           <a href="<?= base_url('item/del_img/'.$img->img); ?>" class="btn btn-danger btn-flat" onclick="return confirm('Yakin ingin menghapus gambar ini ?')"><i class="fa fa-trash"></i> Hapus</a>
                        </div>
                     </div>

                  <?php endforeach; ?>

                  </div>
                  <div class="col-md-5 col-sm-6 col-xs-12 col-md-offset-2">
               <?php
               } else {
                  $jml = 5;
                  echo '<div class="col-md-5 col-sm-6 col-xs-12">';
               }
               for ($i = 0; $i < $jml; $i++) {
                  echo '<input type="file" class="form-control col-md-7 col-xs-12" name="gb[]">';
                  echo '<div class="clearfix" style="margin-bottom: 10px;"></div>';
               }
               ?>
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Harga Item*
            </label>
            <div class="col-md-4 col-sm-6">
               <input id="amount" class="form-control col-md-7 col-xs-12" type="text" name="harga" value="<?= number_format($harga, 0, '.', ','); ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Stok Item*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="number" name="stok" value="<?= $stok; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Berat Item*</label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7" type="number" name="berat" value="<?= $berat; ?>">
               <p class="help-text">* Berat dalam satuan Gram</p>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kategori*</label>
            <div class="col-md-7 col-sm-6">
<div style="max-height:200px; overflow-y:auto; border:solid 1px; padding:6px 12px;">
               <?php
               $xx=0;
               foreach($masterkategori->result() as $mk) :
                echo "<p style='padding:4px; font-size:18px; font-weight:bold; border-bottom:solid 1px #000; color:#000;'>".$mk->masterkategori."</p>";
                $kat = $this->db->get_where('t_kategori', array('id_master' => $mk->id));
               foreach($kat->result() as $k) :?>
               <label style="color:#079;">
                  <input type="radio" class="subkategori1" name="kategori" value="<?=$k->url;?>" onclick="sub('subkategori2','')" <?php if (isset($r)) { if($rk){ if(in_array($k->url, $r)){echo 'checked';}}} ?>> <?=$k->kategori;?>&nbsp;</label><br>
               <?php
               if(!empty($k->kategori2)){
               $sub1 = explode(",_,",$k->kategori2);
               foreach($sub1 as $subkategori){
                   $sub2 = explode(",/,", $subkategori);
                   ?>
                   <label style="padding:0px 24px;">
                   <input type="radio" class="subkategori2" name="subkategori" value="<?=$sub2[0];?>" onclick="sub('subkategori1','<?php echo $xx;?>')" <?php if (!empty($sub) && $sub == $sub2[0]){echo 'checked';} ?>> <?=$sub2[1];?></label><br>
                   <?php
               }
               }
               $xx++;
               endforeach;
               endforeach;
               ?>
</div>
            </div>
         </div>
         
         <script>
            function sub(data1,data2) {
                var data1 = document.getElementsByClassName(data1);
                var data2 = data2;
                var i;
                for (i = 0; i < data1.length; i++) {
                    data1[i].checked = false;
                }
                if(data2 != ''){
                    data1[data2].checked = true;
                }
            }
         </script>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Status*</label>
            <div class="col-md-4 col-sm-6">
               <select name="status" class="form-control">
                  <option value="">--Pilih Status--</option>
                  <option value="1" <?php if($status == 1) { echo "selected"; }?>>Aktif</option>
                  <option value="2" <?php if($status == 2) { echo "selected"; }?>>Tidak Aktif</option>
               </select>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Brand*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="brand" value="<?= $brand; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Deskripsi*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="deskripsi" value="<?= $deskripsi; ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Kata Kunci*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="katakunci" value="<?= $katakunci; ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Meta Deskripsi (untuk optimisasi SEO)*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="metadeskripsi" value="<?= $metadeskripsi; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Penggunaan
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="penggunaan" value="<?= $penggunaan; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Model ID*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="model" value="<?= $model; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Type*
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="type" value="<?= $type; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Garansi sparepart
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="garansisparepart" value="<?= $gsp; ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Garansi motor
            </label>
            <div class="col-md-4 col-sm-6">
               <input class="form-control col-md-7 col-xs-12" type="text" name="garansimotor" value="<?= $gm; ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Selling Point</label>
            <div class="col-md-9 col-sm-6">
               <textarea style="width: 100%;" name="sel" rows="10"><?= $sellingpoint; ?></textarea>
            </div>
         </div>
<?php
/*
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Selling Point
            </label>
            <?php
               if (isset($sl)) {
                  $jml = 5 - $sl->num_rows();

                  echo '<div class="col-md-6 col-sm-6 col-xs-12">';

                  foreach ($sl->result() as $img) :
                     ?>

                     <div class="col-md-5 col-sm-6 card">
                        <div class="card-image">
                           <img src="<?= base_url('assets/upload/'.$img->gambar); ?>">
                        </div>
                        <div class="card-action">
                           <a href="<?= base_url('item/update_sel/'.$img->gambar); ?>" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i> Update Gambar</a>

                           <a href="<?= base_url('item/del_img/'.$img->gambar); ?>" class="btn btn-danger btn-flat" onclick="return confirm('Yakin ingin menghapus gambar ini ?')"><i class="fa fa-trash"></i> Hapus</a>
                        </div>
                     </div>

                  <?php endforeach; ?>

                  </div>
                  <div class="col-md-5 col-sm-6 col-xs-12 col-md-offset-2">
               <?php
               } else {
                  $jml = 5;
                  echo '<div class="col-md-5 col-sm-6 col-xs-12">';
               }
               for ($i = 0; $i < $jml; $i++) {
                  echo '<input type="file" class="form-control col-md-7 col-xs-12" name="sel[]">';
                  echo '<div class="clearfix" style="margin-bottom: 10px;"></div>';
               }
               ?>
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
         </div>
*/ ?>
<?php
/*
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Detail</label>
            <div class="col-md-9 col-sm-6">
               <textarea class="summernote" name="detail" rows="10"><?= $detail; ?></textarea>
            </div>
         </div>
*/
?>
   </div>

   <div id="spesifikasi" class="innertab" style="display: none;">
<br>
      <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >curva
            </label>
            <div class="col-md-5 col-sm-12 col-xs-12">
               <?php
               if (isset($curva)) {
                  echo '<input type="hidden" name="old_curva" value="'.$curva.'">';
                  echo '<img src="'.base_url('assets/upload/curva/'.$curva).'" width="80%"><br>';
                  echo '<div class="clear-fix"><input type="checkbox" name="curva1" value="yes"';
                  if (!empty($curvaa) && $curvaa == 'yes') {
                     echo 'checked';
                  }
                  echo '> Pakai gambar ini</div>';

               }
               ?>
               <input type="file" class="form-control col-md-7 col-xs-12" name="curva">
               <p class="help-text">* Ukuran yg direkomendasikan 400 px x 400 px</p>
            </div>
         </div>

<hr>
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >performance
            </label>
            
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input id="performance" type="<?php if (!empty($opsi) && $opsi == "auto"){
                  echo 'hidden';
                  }
                  else{
                     echo 'text';
                     } ?>" class="form-control col-md-7 col-xs-12" name="performance" value="<?php if(!empty(
               $performance)){echo $performance;} ?>">
               <select id="opsi" class="select2" style="padding: 8px;" name="opsi" onchange="myFunction()">
                  <option value="" disabled>-- opsi --</option>
                  <option value="manual" <?php if (!empty($opsi) && $opsi == "manual") {
                     echo "selected";
                  }?>>manual</option>
                  <option value="auto" <?php if (!empty($opsi) && $opsi == "auto") {
                     echo "selected";
                  }?>>auto</option>
               </select>
            </div>
         </div>
<script>
   function myFunction() {
      var opsi = document.getElementById("opsi").value;
        if (opsi == 'auto') {
         document.getElementById("performance").setAttribute("type", "hidden");
        }
        else if (opsi == 'manual') {
         document.getElementById("performance").setAttribute("type", "text");
        }
      }
</script>
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >unit kapasitas
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <select class="select2" name="unit">
                  <option value="">pilih satuan kapasitas</option>
                  <option value="lpm" <?php if (!empty($unit) && $unit == "lpm") {
                     echo "selected";
                  }?>>lpm</option>
                  <option value="m<sup>3</sup>h" <?php if (!empty($unit) && $unit == "m<sup>3</sup>h") {
                     echo "selected";
                  }?>>m&sup3;h</option>
               </select>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >voltase
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="voltase" value="<?php if(!empty(
               $voltase)){echo $voltase;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >daya
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="daya" value="<?php if(!empty($daya)){echo $daya;} ?>">
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >stage
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="stage" value="<?php if(!empty($stage)){echo $stage;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >current arus
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="currentarus" value="<?php if(!empty($currentarus)){echo $currentarus;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >total head
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="totalhead" value="<?php if(!empty($totalhead)){echo $totalhead;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >max kapasitas
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="maxcapacity" value="<?php if(!empty($maxcapacity)){echo $maxcapacity;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >outlet pompa
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="outletpompa" value="<?php if(!empty($outletpompa)){echo $outletpompa;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >outlet konektor
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="outletkonektor" value="<?php if(!empty($outletkonektor)){echo $outletkonektor;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >max partikel
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="mpartikel" value="<?php if(!empty($mpartikel)){echo $mpartikel;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >rated h & q
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="rated" value="<?php if(!empty($rated)){echo $rated;} ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Impeler
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="impeler" value="<?php if(!empty($impeler)){echo $impeler;} ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Diameter Sumur
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="diameter" value="<?php if(!empty($diameter)){echo $diameter;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >min flow
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="minflow" value="<?php if(!empty($minflow)){echo $minflow;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >inlet / outlet
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="inlet" value="<?php if(!empty($inlet)){echo $inlet;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >hisap
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="hisap" value="<?php if(!empty($hisap)){echo $hisap;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >head
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="head" value="<?php if(!empty($head)){echo $head;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >kapasitas
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="kapasitas" value="<?php if(!empty($kapasitas)){echo $kapasitas;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >membrane
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="membrane" value="<?php if(!empty($membrane)){echo $membrane;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >pre-charge pressure
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="precharge_pressure" value="<?php if(!empty($precharge_pressure)){echo $precharge_pressure;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >max working pressure
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="max_pressure" value="<?php if(!empty($max_pressure)){echo $max_pressure;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >ukuran
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="ukuran" value="<?php if(!empty($ukuran)){echo $ukuran;} ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >max temperatur
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="temperatur" value="<?php if(!empty($temperatur)){echo $temperatur;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >flange
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="flange" value="<?php if(!empty($flange)){echo $flange;} ?>">
            </div>
         </div>
         
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >on-off setting
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="on-off" value="<?php if(!empty($on_off)){echo $on_off;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >pressure range
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="pressure" value="<?php if(!empty($pressure)){echo $pressure;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >pipa
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="pipa" value='<?php if(!empty($pipa)){echo $pipa;} ?>'>
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >kabel
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="kabel" value="<?php if(!empty($kabel)){echo $kabel;} ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >berat kotor
            </label>
            <div class="col-md-7 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="beratkotor" value="<?php if(!empty($beratkotor)){echo $beratkotor;} ?>">
            </div>
         </div>
   </div>
   
<div id="spekcustom" class="innertab" style="display:none;">
       <table id="myTable" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
           <tr>
               <th>
                   Nama Spesifikasi
               </th>
               <th>
                   Keterangan
               </th>
           </tr>
           <?php
           
           if($namaspek == ""){
           ?>
           <tr>
               <td style="vertical-align:middle; width:28%;">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="namaspek[]" placeholder="nama spesifikasi">
               </td>
               <td style="vertical-align:middle; width:50%;">
                        <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="keterangan[]" placeholder="keterangan">
               </td>
           </tr>
           <?php
           }
           else{
           $no = 0;
           $namaspek = explode(",_,", $namaspek);
           $keterangan = explode(",_,", $keterangan);
           foreach($namaspek as $value){
               
           ?>
           <tr>
               <td style="vertical-align:middle; width:28%;">
                   <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="namaspek[]" value="<?php echo $value;?>">
               </td>
               <td style="vertical-align:middle; width:50%;">
                        <input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="keterangan[]" value="<?php echo $keterangan[$no];?>">
               </td>
           </tr>
           <?php
           $no++;
           }
           }
           ?>
       </table>
    <div style="padding:12px;">
    <button type="button" onclick="myFunction()">Tambah Baris</button>
    <button type="button" onclick="DeleteFunction()">Hapus Baris</button>
    </div>
    <script>
    function myFunction() {
      var table = document.getElementById("myTable");
      var row = table.insertRow();
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      //var cell3 = row.insertCell(2);
      var nama = '<input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:90%; box-sizing:border-box;" type="text" name="namaspek[]" placeholder="nama spesifikasi">';
      var ket = '<input style="padding: 6px; border-radius: 4px; border: solid 1px #aaa; width:100%; box-sizing:border-box;" type="text" name="keterangan[]" placeholder="keterangan">';
      var button = '<button type="button" onclick="myFunction()">+</button> <button type="button" onclick="DeleteFunction()">-</button>';
      cell1.innerHTML = nama;
      cell2.innerHTML = ket;
      //cell3.innerHTML = button;
    }

    function DeleteFunction() {
        document.getElementById("myTable").deleteRow(-1);
    }
    </script>
</div>

<div id="selling" class="innertab" style="display:none;">
<?php /*
    <hr>
    <h2>Selling Point ( Teks )</h2>
    <div>
        <textarea name="sellingteks" id="editor1"></textarea>
    </div>
    <script>
    CKEDITOR.replace( 'sellingteks' );
    </script>
    <hr>
*/ ?>
<div>
    <?php
    if(!empty($old_sellingpoint)){
    ?>
   <!--New Selling Point-->
      <table id="listSelling" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
          <tr>
              <th>Selling Point</th>
          </tr>
          <?php
          $old_selling = explode(" // ", $old_sellingpoint);
          $bg_color = explode(" // ", $bg_color);
          $x = 0;
          foreach($old_selling as $value){
          ?>
         <tr>
            <td>
                <div class="bg_selling" style="background:<?php if(isset($bg_color[$x])){echo $bg_color[$x];}?>;">
               <div class="img-selling" style="position:relative; margin:auto; width:80%;">
               <?php
               if (isset($value) && !empty($value)) {
                  echo '<input type="hidden" name="old_sellingpoint[]" value="'.$value.'">';
                  echo '<img style="max-width:100%;" src="'.base_url('assets/upload/sellingpoint/'.$value).'">';
                  echo '<br />';
               }
               ?>
               <div class="selling-option">
                   <div style="margin:auto;">
                       <input type="file" name="new_sellingpoint[]"><br>
                       <p class="center">* Ukuran yg direkomendasikan 1300px</p>
                   </div>
                   <div style="position:absolute; bottom:0; left:0; padding:6px 12px; width:100%;">
                         Background Color : <input style="max-width:50px;" type="color" name="color" value="<?php if(isset($bg_color[$x])){echo $bg_color[$x];}?>" onchange="document.getElementsByClassName('old_bg_color')[<?php echo $x;?>].value = this.value, document.getElementsByClassName('bg_selling')[<?php echo $x;?>].style.background = this.value">
                         <input class="old_bg_color" style="max-width:100px;" type="text" name="old_bg_color[]" value="<?php if(isset($bg_color[$x])){echo $bg_color[$x];}?>" onchange="document.getElementsByClassName('bg_selling')[<?php echo $x;?>].style.background = this.value">
                    </div>
                       <p class="delete-selling" onclick="deleteRow('listSelling', this)"><i class="fa fa-trash"></i></p>
               </div>
            </div>
            </div>
            </td>
         </tr>
         <?php
         $x++;
         }
         ?>
    </table>
    <?php
    }
    ?>
    <br>
    <p>Tambah Selling Point</p>
    <hr class="no-margin">
    <table id="newSelling" style="width:calc(100% - 24px); margin:12px; box-sizing: border-box;">
         <tr>
             <td>
                 <div style="margin:auto; display:flex; width:90%; height:90px; border:solid 1px #ddd; position:relative;">
                     <input style="margin:auto;" type="file" name="newsellingpoint[]">
                     <div style="position:absolute; bottom:0; left:0; padding:6px 12px;">
                         Background Color : <input type="color" name="color" value="#000" onchange="document.getElementsByClassName('bg_color')[0].value = this.value">
                         <input class="bg_color" style="max-width:100px;" type="text" name="bg_color[]" value="#000">
                    </div>
                 </div>
               <p class="center">* Ukuran yg direkomendasikan 1300px</p>
            </td>
         </tr>
      </table>
        <div style="padding:0px 12px;">
        <button type="button" onclick="newSelling()">Tambah Baris</button>
        <button type="button" onclick="delete_newSelling()">Hapus Baris</button>
        </div>
</div>
<script>
    function newSelling() {
      var table = document.getElementById("newSelling");
      var row = table.insertRow();
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      //var cell3 = row.insertCell(2);
      var nomer = document.getElementById("newSelling").rows.length;
      var hr = "";
      if(nomer > 1){
         hr = "<hr>";
      }
      var x = nomer - 1;
      var bg_color = "document.getElementsByClassName('bg_color')[" + x + "]";
      var nama = hr + '<div><div style="margin:auto; display:flex; width:90%; height:90px; border:solid 1px #ddd; position:relative;"><input style="margin:auto;" type="file" name="newsellingpoint[]"><div style="position:absolute; bottom:0; left:0; padding:6px 12px;">Background Color : <input type="color" name="color" value="#000" onchange="' + bg_color + '.value = this.value"><input class="bg_color" style="max-width:100px;" type="text" name="bg_color[]" value="#000"></div></div><p class="center">* Ukuran yg direkomendasikan 1300px</p></div>';
      cell1.innerHTML = nama;
      //cell2.innerHTML = ket;
      //cell3.innerHTML = button;
    }
    
    function deleteRow(data, r) {
        var i = r.parentNode.parentNode.parentNode.parentNode.parentNode.rowIndex;
        var r = confirm("Yakin ingin menghapus gambar ini ?");
        if (r == true) {
            document.getElementById(data).deleteRow(i);
        }
        var table = document.getElementById(data);
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var img = document.getElementsByClassName('bg_selling');
        var nomer = img.length;
        if(nomer == 0){
            var newrow = '<p class="center">Tidak ada data</p>';
            cell1.innerHTML = newrow;
            table.remove();
        }
        console.log (nomer);
        console.log (i);
    }

    function delete_newSelling() {
        document.getElementById("newSelling").deleteRow(-1);
    }
</script>

</div><!-- end id="selling"-->
   <hr>
        <div class="form-group">
            <div style="padding:0px 12px;">
               <button type="submit" class="btn btn-success" name="itemform" value="Submit">Submit</button>
              <button type="button" onclick="window.history.go(-1)" class="btn btn-primary" >Kembali</button>
            </div>
        </div>
   </form>
</div>

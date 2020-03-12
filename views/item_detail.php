<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$key = $data->row();
$spesifik = $spesifikasi->row();
$kat = $kat->row();
$judul = explode(" / ",$key->nama_item);
//tampilkan pesan gagal
      echo '<div style="position:fixed; z-index:9; top:54px; left:0; right:0;">';
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo '<center>'.$this->session->flashdata('alert').'</center>';
         echo '</div>';
      }
      //tampilkan pesan success
      if ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      echo '</div>';
// Program to display URL of current page.
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    {$uri = "https";}
else
    {$uri = "http";}
// Here append the common URL characters.
$uri .= "://";
// Append the host(domain name, ip) to the URL.
$uri .= $_SERVER['HTTP_HOST'];
// Append the requested resource location to the URL
$uri .= $_SERVER['REQUEST_URI'];
function ambil_ukuran_gambar($filename){
    $data = getimagesize($filename);
    $width = $data[0];
    $height = $data[1];
    if($width < 300 && $height < 300){
        $hasil = 'height: 300px;';
    }
    else{
        $hasil = '';
    }
    $result = $hasil;
    return $result;
}
if($key->hargapromo != 0){
  $promo = '<div style="position: absolute; background:#0af; border-radius:8px; padding:12px; right:12px; top:12px; color:white;"><p>promo</p></div>';
}
else{
  $promo = '';
}
?>
<div class="background-white">
<div class="content">
<div style="padding: 12px 12px 18px 12px; font-size:14px;">
<a href="https://www.waterplus.com">home</a> > <a href="<?= site_url(); ?>">our products</a> > <a href="<?= site_url().str_replace(" ", "-", $master->link); ?>"><?php echo $master->masterkategori;?></a> > <a href="<?= site_url($master->link.'/'.$kat->url); ?>"><?php echo $kat->kategori; ?></a> > <span class="nopadding" style="color: #0af;"><?php echo $judul[0]; ?></span>
</div>
<div style="position: relative;">
<aside class="side1">
<article>
<table>
<tr>
<td>
<div id="flick" style="width: 100%;" class="gallery js-flickity">

<div class="gallery-cell">
  <?php echo $promo;?>
        <img id="img0" class="img-target" style="<?php echo ambil_ukuran_gambar(base_url('assets/product/'.$key->gambar)); ?> max-width: 90%; margin: auto;" src="<?= base_url('assets/product/'.$key->gambar); ?>" alt="<?php echo $judul[0];?>">
</div>

<?php
$x=1;
foreach ($img->result() as $list):
if ($x <= 4 ){
?>
<div class="gallery-cell">
    <img id="img<?php echo $x;?>" class="img-target" style="max-width: 90%; margin: auto;" src="<?= base_url('assets/upload/lainnya/'.$list->img); ?>" alt="<?php echo $judul[0];?>">
</div>
<?php
}
$x++;
endforeach;
?>
</div>
</td>
</tr>
<!--<tr class="desktop">
  <td class="img-produk" style="text-align: center; background: #fff;"><img id="myimg" style="max-width: 100%; max-height: 90%;" src="<?= base_url('assets/product/'.$key->gambar); ?>" alt="<?php echo $judul[0];?>"></td>
</tr>-->
</table>
<table class="desktop">
<tr class="select-img">
<td class="img-cell">
    <img src="<?= base_url('assets/product/'.$key->gambar); ?>" style="margin:auto; max-width: 80%; max-height: 80%;" alt="<?php echo $judul[0];?>">&nbsp;
    </td>
<?php
$x=1;
foreach ($img->result() as $img):
if ($x <= 4 ){
?>
<td class="img-cell">
    <img src="<?= base_url('assets/upload/lainnya/'.$img->img); ?>" style="margin:auto; max-width: 80%; max-height: 80%;" alt="<?php echo $judul[0];?>">&nbsp;
</td>
<?php
}
$x++;
endforeach;
/*
for ($i=1; $i < 4 ; $i++) {
    if (!empty($fu[$i])) {
        $result = foto($fu[$i],$da->idbarang);
        echo $result;
    }
}
*/
?>
</tr>
</table>
<script>
$('.select-img').on( 'click', '.img-cell', function() {
  var index = $(this).index();
  $('#flick').flickity( 'select', index );
  console.log (index);
});
</script>
</article>
</aside>
<aside class="side2">
<article class="article">
<h1 class="judul1" style="font-family: bariol_regular; font-weight: bold;"><?php echo $judul[0];?></h1>

    
<div>
    <div>
      <?php
      /*
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
        <i class="fa fa-star"></i>
      */
      ?>
    </div>
</div>
<div>
</div>

<div>
<?php
$garansi = strtolower($key->garansi);
$garansi = explode(" | ",$garansi);
if(!empty($garansi[1])){
    $gm = $garansi[1];
}
else{
    $gm = "-";
}
if (isset($tipe) && $tipe->num_rows() > 0) {
    $display = '';
if($tipe->num_rows() <= 4){
    $display = ' style="display:none;"';
}
echo '<p class="bariol-regular" style="padding: 0px 12px;">select model :</p>';
echo '<div class="select-model">';
echo '<div class="previus"'.$display;?> onclick="previus('model')<?php echo '"><span> < </span></div>';
echo '<div class="next"'.$display;?> onclick="next('model')<?php echo '"><span> > </span></div>';
echo '<div id="model" class="list-produk" style="max-width:100%; overflow:auto; white-space:nowrap; padding:12px;">';
foreach ($tipe->result() as $f) :
$type1 = $f->tipe;
$type2 = $key->tipe;
$promo = '';
if ($type2 == $type1) {
  if($f->hargapromo != 0){
    $promo = '<div style="position: absolute; right:12px; top:12px; color:white;"><div style="background:#0af; border-radius:4px; padding:4px; margin-bottom:4px; color:white;"><p class="nopadding" style="font-size:12px;">promo</p></div></div>';
  }
echo '<div class="type hover" style="display:inline-block; vertical-align:middle; height:auto; background:#fff; border:solid 1px #ddd; position:relative;">'.$promo.'
<div class="model" style="display:flex; height:68px;">
<img style="margin:auto; max-width:90%; max-height:80%;" src="'.base_url('assets/product/'.$f->gambar).'" alt="'.$type1.'">
</div>
<div style="display:flex; height:36px; background:#ddd;">
<p class="center" style="margin:auto; font-size:13px; padding:0px; white-space:normal;">'.$type1.'</p>
</div>
</div>';
}
else{
  if($f->hargapromo != 0){
    $promo = '<div style="position: absolute; right:12px; top:12px; color:white;"><div style="background:#0af; border-radius:4px; padding:4px; margin-bottom:4px; color:white;"><p class="nopadding" style="font-size:12px;">promo</p></div></div>';
  }
echo '<div class="type hover" style="display:inline-block; vertical-align:middle; height:auto; background:#fff; border:solid 1px #ddd; position:relative; cursor:pointer;"';?> onclick="loading(), window.location='<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$f->link); ?>'">
<?php echo $promo;
echo '<div class="model" style="display:flex; height:68px;">
<img style="margin:auto; max-width:90%; max-height:80%;" src="'.base_url('assets/product/'.$f->gambar).'" alt="'.$type1.'">
</div>
<div style="display:flex; height:36px; background:#ddd;">
<p class="center" style="margin:auto; font-size:13px; padding:0px; white-space:normal;">'.$type1.'</p>
</div>
</div>';
}
echo "&nbsp;&nbsp;";
endforeach;
echo '</div>';
echo '</div>';
}
?>
</div>
<div style="padding: 0px 12px 12px 12px;">
<table class="bariol-regular" style="max-width: 800px;" cellpadding="4px">
  <tr>
    <td style="width: 150px;">brand</td><td style="width: 2px;">:</td><td><?=$key->brand;?></td>
  </tr>
  <tr>
    <td>deskripsi</td><td>:</td><td><?=strtolower($key->deskripsi);?></td>
  </tr>
<?php

if($spesifik->namaspek != ""){
    $namaspek = explode(",_,", $spesifik->namaspek);
    $keterangan = explode(",_,", $spesifik->keterangan);
    $x = 0;
    foreach($namaspek as $value){
        if(!empty($value)){
            $value = explode('//', $value);
            if(!empty($value[1])){$spesial = '(<span style="font-size: 12px; font-style: italic;">'.$value[1].'</span>)';} else{$spesial = '';}
            echo '
            <tr>
            <td>'.$value[0].$spesial.'</td><td>:</td>
            <td>'.$keterangan[$x].'</td>
            </tr>
            ';
            $x++;
        }
    }
}
else{
include 'detail.php';
}
$grosir = '';
$display_harga = '';
$harga = $key->hargapromo;
if($key->hargapromo == 0){
  $display_harga = 'display:none;';
  $harga = $key->harga;
}
if($key->harga_grosir > 0){
    $grosir = "<sup>buy >= ".$key->grosir." @ rp ".number_format($key->harga_grosir, 0, ',', ',')."</sup>";
}
?>
</table>
</div>
<div style="padding: 12px;">
<span class="red-text" style="<?php echo $display_harga;?> font-size:14px; line-height:18px;"><strike>rp <?= number_format($key->harga, 0, ',', ','); ?></strike><br></span>
<span class="harga1" style="font-family: bariol_regular; padding:0px 4px;"><?= 'rp '.number_format($harga, 0, ',', ','); ?></span><?php echo $grosir;?>
</div>
<div id="tombol" style="padding: 6px 12px;">
<form action="<?= site_url('cart/add/'.$key->link); ?>" method="post" class="detail-item">
         <input style="width: 80px;" type="hidden" name="qty" min="1" max="<?=$key->stok;?>" value="1" <?php if($key->stok < 1) { echo 'disabled'; } ?>>
         <!-- Set tooltip dan icon untuk button favorite -->
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
            if (isset($fav) && $fav->num_rows() > 0) {
               if (in_array($key->id_item, $favorite))
               {
                  $color = '#f00';
                  $icon  = '<i class="fa fa-heart red-text"></i>';
                  $heart = 'remove';
               } else {
                  $color = '#fff';
                  $icon    = '<i class="fa fa-heart-o"></i>';
                  $heart = 'add to wishlist';
               }
            } else {
               $color = '#fff';
               $icon    = '<i class="fa fa-heart-o"></i>';
               $heart = 'add to wishlist';
            }


if($key->stok > 0) {
?>
<button id="buy" type="submit" name="buy" value="beli" style="background: #0af; text-align: center;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><span class="nopadding bariol-regular white-text">buy now</span></button>
<button id="add" type="submit" name="submit" value="Submit" style="background: rgba(10,42,59,1);text-align: center; vertical-align: top;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><i class="fa fa-shopping-cart white-text mobile"></i>&nbsp;&nbsp;<span class="nopadding desktop white-text">add to cart</span></button>
<?php
}
else{
?>
<button id="outofstok" type="button" style="background: #000; text-align: center;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><span class="nopadding bariol-regular white-text">out of stock</span></button>
<?php
}
?>
</form>
</div>
<?php
// Tombol
/*
<div id="tombol" style="padding: 0px 12px;">
<form action="<?= site_url('cart/add/'.$key->link); ?>" method="post" class="detail-item">
         <input style="width: 80px;" type="hidden" name="qty" min="1" max="<?=$key->stok;?>" value="1" <?php if($key->stok < 1) { echo 'disabled'; } ?>>
         <!-- Set tooltip dan icon untuk button favorite -->
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
            if (isset($fav) && $fav->num_rows() > 0) {
               if (in_array($key->id_item, $favorite))
               {
                  $color = '#f00';
                  $icon    = '<i class="fa fa-heart red-text"></i>';
               } else {
                  $color = '#fff';
                  $icon    = '<i class="fa fa-heart-o"></i>';
               }
            } else {
               $color = '#fff';
               $icon    = '<i class="fa fa-heart-o"></i>';
            }
?>
<button id="faa" type="button" onclick="window.location = '<?= site_url('home/favorite/'.$key->link); ?>'"><?= $icon; ?>&nbsp;<span class="desktop"><?php echo $nf->num_rows(); ?><span class="wishlist">wishlist</span></span></button>
<?php
if($key->stok > 0) {
?>
<button id="buy" type="submit" name="buy" value="beli" style="background: #0af; text-align: center;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><span class="nopadding bariol-regular white-text">beli sekarang</span></button>
<button id="add" type="submit" name="submit" value="Submit" style="background: rgba(10,42,59,1);text-align: center; vertical-align: top;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><i class="fa fa-shopping-cart white-text mobile"></i>&nbsp;<span class="nopadding desktop white-text">tambah ke keranjang</span></button>
<?php
}
else{
?>
<button id="outofstok" type="button" style="background: #000; text-align: center;" <?php if($key->stok < 1) { echo 'disabled'; } ?>><span class="nopadding bariol-regular white-text">out of stock</span></button>
<?php
}
?>
</form>
</div>
*/
// End Tombol
?>
<div>
    <div id="tombol1" style="float:left;">
    <button id="faa" type="button" onclick="window.location = '<?= site_url('home/favorite/'.$key->link); ?>'"><?= $icon; ?><span class="desktop">&nbsp;<?php echo $heart;?></span></button>
    </div>
    <div style="float:left;">
    <p class="share_button" style="padding:6px 16px;">share :
    <span class='tool-tip share-btn' onClick="window.open('http://www.facebook.com/share.php?u=<?php echo $uri;?>', 'waterplus', 'width=600,height=300,status=1,scrollbars=yes'); return false;">
        <i class="fa fa-facebook"></i>

    </span>
    <span class='tool-tip share-btn' onClick="window.open('https://twitter.com/intent/tweet?url=<?php echo $uri;?>&amp;text=Lihat informasi selengkapnya disini &amp;hashtags=waterplus', 'waterplus', 'width=600,height=300,status=1,scrollbars=yes'); return false;">
        <i class="fa fa-twitter"></i>

    </span>
    <span class='tool-tip share-btn' onClick="document.location='whatsapp://send?text=<?php echo $uri;?>', load_finish()">
        <i class="fa fa-whatsapp"></i>

    </span>
    <span class="tool-tip share-btn">
        <i class="fa fa-link" onClick="copy('linkcopy')" onmouseout="outcopy('linkcopy')"></i>
        <span class="tool-tiptext">
            <input id="linkcopy" type="text" style="transition:0.3s; padding:6px 0px; height:auto;" value="<?php echo $uri;?>" onClick="copy('linkcopy')" readonly>
            <span id="mytooltip" style="display:none;">link telah disalin</span>
        </span>
    </span>
    </p>
    </div>
</div>
</article>
</aside>
</div>
</div>
<!--end class content>
<!--container.//-->
<div style="clear: both;"></div>
<div>
<div id="content-bottom">
<?php
$selling=$this->app->get_where('sellingpoint', ['id_item' => $key->id_item]);
$cek = $selling->row();
if (empty($cek->gambar) && empty($cek->gambar_point) && empty($cek->img)) {
    $display="display:none;";
    $hr="<hr style='margin-bottom:0px;'>";
}
else{
    $display="";
    $hr="";
}
echo $hr;
?>
<div style="margin-top: 18px;<?php echo $display;?>">
<ul style="list-style: none; padding: 12px; margin: auto; max-width:1140px; font-family: bariol_light; font-weight: bold; letter-spacing: 1px;" class="menu-items">
    <li id="detil" style="display: inline-block; padding-right: 12px; color: #0af;" onclick="this.style.color = '#0af',document.getElementById('spesification').style.color = 'rgba(0,0,0,0.87)',document.getElementById('detail').style.display = 'block',document.getElementById('spesifikasi').style.display = 'none'">detail product</li>
    <?php /* ?><li id="review" style="display: inline-block; padding-right: 12px;" onclick="this.style.color = '#0af',document.getElementById('detil').style.color = 'rgba(0,0,0,0.87)',document.getElementById('compare').style.color = 'rgba(0,0,0,0.87)',document.getElementById('ulasan').style.display = 'block',document.getElementById('detail').style.display = 'none'">Review</li><?php */
    if (!empty($spesifik->performance) && $spesifik->performance !=' -  - manual') {
    ?>

    <li id="spesification" style="display: inline-block; padding-right: 12px;" onclick="this.style.color = '#0af',document.getElementById('detil').style.color = 'rgba(0,0,0,0.87)',document.getElementById('spesifikasi').style.display = 'block',document.getElementById('detail').style.display = 'none'">specification</li>
    <?php } ?>
    <li id="compare" style="display: none; padding-right: 12px;">product compare</li>
</ul>
<div id="detail" style="width:100%;border-top:1px solid silver; display: block; max-width:1140px; margin:auto;">
<?php
if ($selling->num_rows() > 0) {
?>

<?php
$img=$selling->row();
if(!empty($img->gambar_point)){
    $img_point = explode(" // ", $img->gambar_point);
    $background = explode(" // ", $img->background);
?>
    <?php
    $x = 0;
    foreach($img_point as $value){
    ?>
    <div style="background:<?php echo $background[$x];?>;">
    <div style="max-width:790px; margin:auto; position:relative; line-height:0;">
    <img style="width:100%;" src="<?php echo base_url().'assets/upload/sellingpoint/'.$value;?>"><br>
    </div>
    </div>
    <?php
    $x++;
    }
    ?>
<?php
}
elseif(!empty($img->gambar)){
echo $img->gambar;
}
elseif(!empty($img->judul)){
$no = 0;
$ip = "";
$kp = "";
$jp = "";
$kp = "";
//if
if(!empty($img->img)){
    $ip = explode(",_,", $img->img);
}
if(!empty($img->keterangan)){
    $kp = explode(",/,", $img->keterangan);
    if(!empty($kp[0])){
        $jp = explode(",_,", $kp[0]);
    }
    if(!empty($kp[1])){
        $kp = explode(",_,", $kp[1]);
    }
}
?>
<div class="sell">
<div class="left-sell inline-block" style="vertical-align: middle;">
    <img style="max-width: 100%;" src="<?php echo base_url('assets/sellingpoint/'.$img->fotomaster);?>" alt="SHS-023CW-S1">
</div>
<div class="right-sell inline-block" style="vertical-align: middle;">
<h2 style="font-style: italic; font-family: bariol_light;"><?php echo $img->judul;?></h2>
<p style="padding: 6px 12px; color: #0af;"><?php echo $img->subjudul;?></p>
<div style="padding: 12px;">
    <?php
        foreach ($jp as $judulpoint){
    ?>
    <div class="inline-block width49">
        <div class="img-sell">
            <img style="width: 100%; height:100%;" src="<?php echo base_url('assets/sellingpoint/'.$ip[$no]);?>" alt="<?php echo $judulpoint;?>">
        </div>
        <div class="text-sell">
            <p><span><?php echo $judulpoint;?></span><br>
            <?php echo $kp[$no];?></p>
        </div>
    </div>
    <?php
    $no++;
    }
    ?>

</div>
</div>
</div>
<?php
}
}
// echo $key->detail;?>
</div>
<div id="spesifikasi" class="max-width-1140" style="display: none;border-top:1px solid silver;">
  <div style="padding: 12px;">
    <?php
      if ($spesifikasi->num_rows() > 0) {
    ?>
    <!-- Spesifikasi -->
    <div class="spek" style="min-height: 300px; text-align: center;">
      <?php
        if (!empty($spesifik->performance) && $spesifik->performance !=' -  - manual') {
        $performance = $spesifik->performance;
        $performance = explode(" - ", $performance);
        if (!empty($performance[1])) {
          $unit = $performance[1];
        }
        else{
          $unit = "";
        }
        $array = explode(",", $performance[0]);
        $arr = array(); $arr2 = array();
        if (!empty($performance[2]) && $performance[2] == 'auto') {
          foreach ($array as $value) {
            $a = explode("/", $value);
            if (!empty($a[0]) || $a[0] == 0) {
              array_push($arr, $a[0]);
            }
            else{
              array_push($arr, "");
            }
            if (!empty($a[1]) || $a[1] == 0) {
              array_push($arr2, $a[1]);
            }
            else{
              array_push($arr2, "");
            }
          }
          $limit = end($arr);
          $center = $limit / 2 + 1;
          $cons = 0;
          $a = reset($arr2);
          $b = end($arr2);
          $selisih = $a - $b;
          $y = 0;
          $arr = array();
          $arr2 = array();
          if ($limit < 10) {
            $step = 0.1;
          }
          $angka = 4;
          for($i = 0; $i <= $limit;){
            if ($i == 0) {
              array_push($arr, $i);
            }
            $i = $i + $step;
            if ($i != 0) {
              array_push($arr, $i);
            }
          }

          $count = count($arr) - 1;
          $data = $a;
          $d = $data / $count;
          for($i = 0; $i <= $limit;){
            if ($i == 0) {
              array_push($arr2, round($data,2));
            }
            if ($i < $center || $i > $center) {
              $data = $data - $d;
              array_push($arr2, round($data,2));
            }
          $i = $i + $step;
          }
        }
        else{
        foreach ($array as $value) {
        if(!empty($value)){
          $a = explode("/", $value);
          if (!empty($a[0]) || $a[0] == 0) {
            array_push($arr, $a[0]);
          }
          else{
            array_push($arr, "");
          }
          if (!empty($a[1]) || $a[1] != 0) {
            array_push($arr2, $a[1]);
          }
          else{
            array_push($arr2, "0");
          }
        }
        }  
      }
      $label = join(",", $arr);
      $head = join(",", $arr2);
      ?>
      <div class="curva" style="margin:12px 6px;">
        <?php
        $curva = explode(" - ", $spesifik->curva);
        if (!empty($curva[1]) && $curva[1] == 'yes') {
          $grafik = "display:none;";
        }
        else{
          $grafik = "";
        }
        ?>
        <div style="width: 100%; height: auto;">
        <div style="border-radius:5px 5px 0px 0px; background: rgba(10,42,59,1); text-align: left; padding: 12px 18px; font-family: bariol_regular; font-weight: bold; font-size: 15px; color: #fff;">performance curve</div>

        <div style="position: relative; <?php echo $grafik;?>">
        <div style="transform: rotate(90deg); position: absolute; left: 30px; top: calc(50% - 12px);">
          <span>head (m)</span>
        </div>
        <canvas id="demobar"></canvas>
        <div style="position: absolute; bottom: 6px; right: 0; font-size: 12px;"><span>Q (<?php echo $unit;?>)</span></div>
        </div>

        </div>
        <script>

        var ctx = document.getElementById("demobar").getContext("2d");
        var data = {
          <?php
          /*
          $arr1 = array();
          $data = array();
          $get = 0;
          foreach ($dataPoints as $value) {
            if ($value == $get) {
              array_push($arr1, $value);
              if (!empty($dataValue[$get])) {
                array_push($data, $dataValue[$get]);
              }
              $get = $get + 5;
            }
          }
            $join = join(",",$arr1);
            */
          ?>
                  labels: [<?php echo $label; ?>,""],
                  datasets: [
                  {
                    label: "head (m)",
                    fill: false,
                    backgroundColor: "#fff",
                    borderColor: "rgba(0, 0, 222, 1)",
                    pointHoverBackgroundColor: "rgba(59, 100, 222, 1)",
                    pointHoverBorderColor: "rgba(59, 100, 222, 1)",
                    data: [<?php echo $head; ?>]
                  }
                  ]
                  };

        var myBarChart = new Chart(ctx, {
                  type: 'line',
                  data: data,
                  options: {
                  barValueSpacing: 20,
                  scales: {
                    yAxes: [{

                        ticks: {
                          min: 0,
                        }
                    }],
                    xAxes: [{
                                gridLines: {
                                    color: "rgba(200, 200, 200, 1)",
                                },
                            }]
                    }
                }
              });
      </script>

        <?php
        if (!empty($curva[1])) {
        ?>
        <div><img style="width: 100%; max-height: 100%;" src="<?= base_url('assets/upload/curva/'.$curva[0]); ?>"></div>
        <?php
        }
        /*
        if (!empty($spesifik->performance)) {
        ?>
        <div><img style="width: 100%; max-height: 100%;" src="<?= base_url('assets/curva/'.$spesifik->performance); ?>"></div>
        <?php
        }
        */
        ?>
<br>
<table class="bariol_regular" cellpadding="12" cellspacing="0">
  <tr>
    <th colspan="20" style="padding: 12px 18px; border-radius:5px 5px 0px 0px; background: rgba(10,42,59,1); color: #fff; font-family: bariol_regular; text-align: left;">performance table</th>
  </tr>

  <tr>
    <td>capacity ( <?php echo $unit;?> )</td>
    <?php
      foreach ($arr as $value) {
        echo "<td>".$value."</td>";
      }
    ?>
  </tr>

  <tr>
    <td>head</td>
    <?php
      foreach ($arr2 as $value) {
        if (!empty($value) || $value == 0) {
        $angka = $value;
        $angka_format = number_format($angka,1,",",".");
          $value1 = $angka_format;
        echo "<td>".$value1."</td>";
        }
        else{
        echo "<td></td>";
        }
      }
    ?>
  </tr>

</table>
      </div>
<?php
} #end if performance
?>
      <div class="tabelspek" style="text-align: left; vertical-align: top; margin:12px 6px;">
        <?php if (!empty($spesifik->voltase) || !empty($spesifik->daya) || !empty($spesifik->rated) || !empty($spesifik->minflow) || !empty($spesifik->inlet))
{
?>
<table class="bariol_regular" cellpadding="12" cellspacing="0" style="width: 100%;">
  <tr>
    <th colspan="2" style="border-radius:5px 5px 0px 0px; background: rgba(10,42,59,1); color: #fff; font-family: bariol_regular;">specification</th>
  </tr>
<?php
if (!empty($spesifik->voltase)) {
?>
  <tr>
    <td style="width: 30%;">voltase</td>
<?php
echo '<td class="gray" style="width:70%;">'.$spesifik->voltase.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->daya)) {
?>
  <tr>
    <td>daya</td>
<?php
echo '<td class="gray">'.$spesifik->daya.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->stage)) {
?>
  <tr>
    <td>stage</td>
<?php
echo '<td class="gray">'.$spesifik->stage.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->currentarus)) {
?>
  <tr>
    <td>current arus</td>
<?php
echo '<td class="gray">'.$spesifik->currentarus.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->totalhead)) {
?>
  <tr>
    <td>total head</td>
<?php
echo '<td class="gray">'.$spesifik->totalhead.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->maxcapacity)) {
?>
  <tr>
    <td>max capacity</td>
<?php
echo '<td class="gray">'.$spesifik->maxcapacity.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->outletpompa)) {
?>
  <tr>
    <td>outlet pompa</td>
<?php
echo '<td class="gray">'.$spesifik->outletpompa.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->outletkonektor)) {
?>
  <tr>
    <td>outlet connector</td>
<?php
echo '<td class="gray">'.$spesifik->outletkonektor.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->mpartikel)) {
?>
  <tr>
    <td>max particel</td>
<?php
echo '<td class="gray">'.$spesifik->mpartikel.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->rated)) {
?>
  <tr>
    <td>rated</td>
<?php
echo '<td class="gray">'.$spesifik->rated.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->minflow)) {
?>
  <tr>
    <td>min flow</td>
<?php
echo '<td class="gray">'.$spesifik->minflow.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->inlet)) {
?>
  <tr>
    <td>inlet outlet</td>
<?php
echo '<td class="gray">'.$spesifik->inlet.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->hisap)) {
?>
  <tr>
    <td>hisap</td>
<?php
echo '<td class="gray">'.$spesifik->hisap.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->head)) {
?>
  <tr>
    <td>head</td>
<?php
echo '<td class="gray">'.$spesifik->head.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->kapasitas)) {
?>
  <tr>
    <td>kapasitas</td>
<?php
echo '<td class="gray">'.$spesifik->kapasitas.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->pressure)) {
?>
  <tr>
    <td>pressure</td>
<?php
echo '<td class="gray">'.$spesifik->pressure.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->pipa)) {
?>
  <tr>
    <td>pipa</td>
<?php
echo '<td class="gray">'.$spesifik->pipa.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->kabel)) {
?>
  <tr>
    <td>kabel</td>
<?php
echo '<td class="gray">'.$spesifik->kabel.'</td>';
?>
  </tr>
<?php
}
if (!empty($spesifik->berat)) {
?>
  <tr>
    <td>berat</td>
<?php
echo '<td class="gray">'.$spesifik->berat.'</td>';
?>
  </tr>
<?php
}
?>
</table>
<?php
} // end if table
?>
      </div>
<hr>
    </div>
    </div>
<?php
}
?>

  </div>
</div>
<?php
/*
?>
<div id="ulasan" style="padding: 0px 12px; width:100%; border-top:1px solid silver; display: none;">
  <h3 style="padding: 14px 0px; font-size: 18px;">Ulasan Terbaru</h3>
<?php
if ($rating->num_rows() < 1) {
  echo '<div style="padding: 12px; border:solid 1px #ddd; display:flex; min-height:250px; margin-bottom: 12px;">
  <p style="margin:auto;">Ulasan Masih Kosong</p>
  </div>
  ';
}
else{
foreach ($rating->result() as $rating):
?>
  <div style="padding: 12px; border:solid 1px #ddd; margin-bottom: 12px;">
<?php
for ($i=1; $i <=5 ; $i++) { 
  if ($i <= $rating->rating) {
    echo '<i class="fa fa-star yellow-text"></i>';
  }
  else{
    echo '<i class="fa fa-star"></i>';
  }
}
$items = $this->app->get_where('t_users', array('id_user' => $rating->iduser));
$get = $items->row();
?>
<p style="padding: 12px 0px;">Oleh <b><?php echo $get->fullname; ?></b></p>
<p style="padding: 0px 0px 12px 0px;"><?php echo $rating->komentar; ?></p>
</div>
<?php
endforeach;
}
?>
</div>
<?php
*/
?>
</div>
<?php
/*
if ($package->num_rows() > 0) {
?>
<div>
  <h3 style="font-size: 24px;">package deals</h3>
  <hr style="margin: 0px 12px 12px 12px; max-width: 200px; border: solid 2px #0af;">
  <div class="list-produk" style=" overflow-x: scroll; overflow-y: hidden;">
  <div style="max-width: 1300px; display: flex;">
    <?php
    foreach ($package->result() as $row)
    {
      $id1=$row->id_item;
      $items1 = $this->app->get_where('t_items', array('id_item' => $id1));
      $get1 = $items1->row();
      $id2=$row->item1;
      $items2 = $this->app->get_where('t_items', array('id_item' => $id2));
      $get2 = $items2->row();
      $id3=$row->item2;
      $items3 = $this->app->get_where('t_items', array('id_item' => $id3));
      $get3 = $items3->row();
      ?>  
      <div style="width: 150px; background: #fff; height: auto; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$get1->link); ?>"><img src="<?php echo base_url('assets/product/'.$get1->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $get1->nama_item;?></p>
                <b><?= 'Rp '.number_format($get1->harga, 0, ',', ','); ?></b><br><br>
            </div>
      <span class="hargapackage bariol-regular" style="margin: auto 0px;"> + </span>
      <div style="width:150px; background: #fff; min-height: auto; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$get2->link); ?>"><img src="<?php echo base_url('assets/product/'.$get2->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $get2->nama_item;?></p>
                <b><?= 'Rp '.number_format($get2->harga, 0, ',', ','); ?></b><br><br>
            </div>
      <span class="hargapackage bariol-regular" style="margin: auto 0px;"> + </span>
      <div style="width: 150px; background: #fff; min-height: auto; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$get3->link); ?>"><img src="<?php echo base_url('assets/product/'.$get3->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $get3->nama_item;?></p>
                <b><?= 'Rp '.number_format($get3->harga, 0, ',', ','); ?></b><br><br>
            </div>
      <span class="hargapackage bariol-regular" style="margin: auto 0px;"> = </span><b class="hargapackage red-text bariol-regular" style="margin: auto 0px;"><?= 'Rp '.number_format($row->harga, 0, ',', ','); ?></b>
<?php
    }
?>
    </div>
  </div>
</div>
<hr>
<?php
}
*/
?>
</div>
</div>
<div style="padding-top:12px;">
<div class="content">
    <h3 style="font-size: 18px; padding:12px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">customers who bought this item also bought</h3>
    <div class="select-model random-produk">
    <div class="previus" onclick="previus('list-produk1')"><span> < </span></div>
    <div class="next" onclick="next('list-produk1')"><span> > </span></div>
    <div id="list-produk1" class="list-produk" style="width: 100%; overflow-x: auto; overflow-y: hidden;">
        <div style="min-height: 200px; white-space:nowrap;">
<?php
$query = $this->db->order_by('id_item','random');
$query = $this->db->limit(12);
$query = $this->db->get('t_items');
foreach ($query->result() as $row)
{
$tesquery = "SELECT masterkategori.link, t_kategori.url, t_items.link FROM t_rkategori JOIN t_kategori ON t_kategori.id_kategori = t_rkategori.id_kategori JOIN t_items ON t_items.id_item = t_rkategori.id_item JOIN masterkategori ON t_kategori.id_master = masterkategori.id WHERE t_items.id_item = '5'";
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
<div class="produk" style="background: #fff; margin-right:6px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px;'>".$nama1;?></span></a></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b><?= 'rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php
}
?>
        </div>
    </div>
    </div>
</div>

<div class="content">
    <h3 style="font-size: 18px; padding:12px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">you may also like</h3>
    <div class="select-model random-produk">
    <div class="previus" onclick="previus('list-produk2')"><span> < </span></div>
    <div class="next" onclick="next('list-produk2')"><span> > </span></div>
    <div id="list-produk2" class="list-produk" style="width: 100%; overflow-x: auto; overflow-y: hidden;">
        <div style="min-height: 200px; white-space:nowrap;">
<?php
$query = $this->db->order_by('id_item','random');
$query = $this->db->limit(12);
$query = $this->db->get('t_items');
foreach ($query->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
            <div class="produk" style="background: #fff; margin-right:6px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px;'>".$nama1;?></span></a></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b><?= 'rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php
}
?>
        </div>
    </div>
  </div>
</div>
<br><br>
<?php
/*
?>
<div class="listproduk" style="margin: 12px 0px;">
  <table>
    <tr>
      <td rowspan="4" style="width: 40%; height: 200px;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$r->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 100%;"></a></td>
      <td style="width: 60%; padding: 4px 12px; height: 20px;"><b style="font-size: 18px;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$r->link); ?>"><?php echo $r->nama_item;?></a></b></td>
    </tr>
    <tr>
      <td style="padding: 4px 12px; height: 20px;"><i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i></td>
    </tr>
    <tr>
      <td style="padding: 4px 12px; vertical-align: top;">Deskripsi Produk</td>
    </tr>
    <tr>
      <td style="padding: 4px 12px; height: 20px;"><div class="card-action">
                     <form action="<?= site_url('cart/add/'.$r->link); ?>" method="post">
                        <input type="hidden" name="qty" value="1" <?php if ($r->stok < 1) { echo 'disabled'; }?>>

                        <a href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$r->link); ?>" class="waves-effect waves-light btn blue white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lihat Detail">
                           <i class="fa fa-search-plus"></i>
                        </a>

                        <button type="submit" class="waves-effect waves-light btn green white-text tooltipped" name="submit" value="Submit" <?php if ($r->stok < 1) { echo 'disabled'; } ?> data-position="bottom" data-delay="50" data-tooltip="Tambah ke Keranjang">
                           <i class="fa fa-shopping-cart"></i>
                        </button>
                        <!-- Set tooltip dan icon untuk button favorite -->
                        <?php
                           if (isset($fav) && $fav->num_rows() > 0) {
                              if (in_array($r->id_item, $favorite))
                              {
                                 $tooltip = 'Hapus dari Favorite';
                                 $icon    = '<i class="fa fa-heart"></i>';
                              } else {
                                 $tooltip = 'Tambah ke Favorite';
                                 $icon    = '<i class="fa fa-heart-o"></i>';
                              }
                           } else {
                              $tooltip = 'Tambah ke Favorite';
                              $icon    = '<i class="fa fa-heart-o"></i>';
                           }
                        ?>

                        <a href="<?= site_url('home/favorite/'.$r->link); ?>" class="waves-effect waves-light btn pink white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?= $tooltip; ?>">
                           <?= $icon; ?>
                        </a>
                     </form>
                  </div></td>
    </tr>
  </table>
</div>
<?php
*/
/*
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$r->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 150px;"></a></div>
                <p><?php echo $r->nama_item;?></p>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i><br>
                <b><?= 'Rp. '.number_format($r->harga, 0, ',', '.').',-'; ?></b>
            </div>
<?php
*/
?>
</div>
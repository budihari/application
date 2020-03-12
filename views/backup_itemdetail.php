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
?>
<style type="text/css">

#detil,#review,#compare,#spesification{
  cursor: pointer;
}
.autocomplete {
  position: relative;
  display: inline-block;
}

#input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

#input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

#input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
@media only screen and (min-width: 1201px) {
.side3{
    display: block;
}
}
@media only screen and (max-width: 1200px) {
.side3{
    display: none;
}
}
.gallery {
  background: #EEE;
}

.gallery-cell {
  width: 100%;
  height: 100%;
  margin-right: 10px;
  background: #fff;
  display: flex;
}

/* cell number */
.gallery-cell:before {
  display: block;
  text-align: center;
  line-height: 300px;
  font-size: 80px;
  color: white;
}


/* big buttons, no circle */
.flickity-prev-next-button {
  width: 50px;
  height: 50px;
  background: transparent;
}
/* arrow color */
.flickity-prev-next-button .arrow {
  fill: transparent;
}
.flickity-prev-next-button.no-svg {
  color: transparent;
}
.flickity-prev-next-button:hover {
  background: transparent;
}
/* hide disabled button */
.flickity-prev-next-button:disabled {
  display: none;
}

/* position dots in gallery */
.flickity-page-dots {
  bottom: 4px;
}
/* white circles */
.flickity-page-dots .dot {
  width: 12px;
  height: 12px;
  opacity: 1;
  background: transparent;
  border: 2px solid #ddd;
}
.flickity-page-dots .dot:hover {
  background: #f00;
}
/* fill-in selected dot */
.flickity-page-dots .dot.is-selected {
  background: #ddd;
}
</style>
    <div style="padding: 12px 12px 18px 12px;">
      <a href="<?= site_url(); ?>">Home</a> > <a href="<?= site_url('home/kategori/'.$kat->url); ?>"><?php echo $kat->kategori; ?></a> > <span class="nopadding" style="color: #0af;"><?php echo $key->nama_item; ?></span>
    </div>
<div style="position: relative;">
<aside class="side1">
<article>
<table>
<tr class="mobile">
<td>
<div style="width: 100%; height: 300px;" class="gallery js-flickity">
<div class="gallery-cell"><img style="max-width: 100%; max-height: 90%; margin: auto;" src="<?= base_url('assets/upload/'.$key->gambar); ?>" alt="<?php echo $judul[0];?>"></div>
<?php
$x=1;
foreach ($img->result() as $list):
if ($x <= 3 ){
?>
<div class="gallery-cell"><img style="max-width: 100%; max-height: 90%; margin: auto;" src="<?= base_url('assets/upload/'.$list->img); ?>" alt="<?php echo $judul[0];?>"></div>
<?php
}
$x++;
endforeach;
?>
</div>
</td>
</tr>
<tr class="desktop">
  <td class="img-produk" style="text-align: center; background: #fff;"><img id="myimg" style="max-width: 100%; max-height: 90%;" src="<?= base_url('assets/upload/'.$key->gambar); ?>" alt="<?php echo $judul[0];?>"></td>
</tr>
</table>
<table class="desktop">
<tr>
<td style="width: 22%; height: 120px; text-align: center; border:solid 1px #ddd; display: inline-block; position: relative;" onclick="document.getElementById('myimg').src='<?= base_url('assets/upload/'.$key->gambar); ?>'"><img src="<?= base_url('assets/upload/'.$key->gambar); ?>" style="max-width: 100%; max-height: 90%;" alt="<?php echo $judul[0];?>"> </td>
<?php
$x=1;
foreach ($img->result() as $img):
if ($x <= 3 ){
?>
<td style="width: 22%; display: inline-block; vertical-align: middle; text-align: center;" onclick="document.getElementById('myimg').src='<?= base_url('assets/upload/'.$img->img); ?>'"><img style="margin: auto; max-width: 100%; max-height: 120px;" src="<?= base_url('assets/upload/'.$img->img); ?>" alt="<?php echo $judul[0];?>"></td>
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
</article>
</aside>
<aside class="side2">
<article>
    <h1 style="font-family: bariol_regular; font-size: 32px; padding-bottom: 8px;"><?php echo $judul[0];?></h1>
    <h2 style="font-family: bariol_regular; font-size: 24px; padding: 0px 12px;"><?php if (!empty($judul[1])) {
       echo strtolower($judul[1]);
    }?></h2>
<div>
    <div style="padding: 0px 12px;">
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
<div style="padding: 12px 0px 0px 12px;"> 
<b style="font-size: 24px; font-family: bariol_regular;"><?= 'Rp '.number_format($key->harga, 0, ',', ','); ?></b>
</div>
<div style="padding: 0px 12px;">
<?php
if (isset($tipe) && $tipe->num_rows() > 0) {
echo '<p class="bariol-regular" style="padding: 12px 0px;">select model :</p>';
foreach ($tipe->result() as $f) :
$type1 = $f->tipe;
$type2 = $key->tipe;
if ($type2 == $type1) {
echo '<div class="blue" style="line-height:18px; font-size:12px; border:solid 1px #ddd; margin:0px 2px; text-align: center; width: 90px; display: inline-block; padding: 2px; background: #aaa;"><img style="width:20px; height:20px;" src="'.base_url('assets/upload/'.$f->gambar).'" alt="'.$type1.'"><br>'.$type1.'</div>';
}
else{
echo '<div class="gray" style="cursor:pointer;line-height:18px; font-size:12px; border:solid 1px #ddd; margin: 0px 2px; text-align: center; width: 90px; display: inline-block; padding: 2px; background: #fff;"';?> onclick="window.location='<?= site_url('home/detail/'.$f->link); ?>'"><?php echo '<img style="width:20px; height:20px;" src="'.base_url('assets/upload/'.$f->gambar).'" alt="'.$type1.'"><br>'.$type1.'</div>';
}
endforeach;
}
?>
</div>
<div style="padding: 12px;">
<table class="bariol-regular" style="max-width: 500px;" cellpadding="4px">
  <tr>
    <td style="width: 100px;">brand</td><td style="width: 2px;">:</td><td><?=$key->brand;?></td>
  </tr>
  <tr>
    <td>description</td><td>:</td><td><?=strtolower($key->katakunci);?></td>
  </tr>
  <tr>
    <td>model id</td><td>:</td><td><?=strtolower($key->model);?></td>
  </tr>
  <tr>
    <td>garansi</td><td>:</td><td><?=strtolower($key->garansi);?></td>
  </tr>
</table>
</div>
<hr class="nomargin">
<div>
    <p style="line-height: 24px; padding:12px 18px;">share this product<br>
    <a href=""><i style="background: transparent; padding: 0;" class="fa fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
    <a href=""><i style="background: transparent; padding: 0;" class="fa fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
    <a href=""><i style="background: transparent; padding: 0;" class="fa fa-youtube"></i></a>&nbsp;&nbsp;&nbsp;
    <a href=""><i style="background: transparent; padding: 0;" class="fa fa-instagram"></i></a>&nbsp;&nbsp;&nbsp;
    <a href=""><i style="background: transparent; padding: 0;" class="fa fa-google"></i></a>
    </p>
</div>
</article>
</aside>
<?php
/*
?>
<aside class="side3" style="width: 25%; position:absolute; top: 0; right: 0; bottom: 0; background: #fff; z-index: 9;">
<div class="total" style="background: #eee; min-height: 100px;">
    <div style="line-height: 32px;">
        <p style="padding-bottom: 0;">Shipping Options<br>
            <b style="font-family: calibri; color: red;">Rp. 3.000.000</b><br>
        </p>
    </div>
    <div style="display: inline-block;">
    <p>Qty :<br><br>
    <select style="display: block; width:70px;">
     <option> 1 </option>
     <option> 2 </option>
     <option> 3 </option>
     <option> 4 </option>
     <option> 5 </option>
     <option> 6 </option>
     <option> 7 </option>
     <option> 8 </option>
     <option> 9 </option>
     <option> 10 </option>
 </select>
 </p>
 </div>
 <div style="display: inline-block;">
    <p>Model :<br><br>
    <select style="display: block; width:70px;">
     <option> 1 </option>
     <option> 2 </option>
     <option> 3 </option>
     <option> 4 </option>
     <option> 5 </option>
     <option> 6 </option>
     <option> 7 </option>
     <option> 8 </option>
     <option> 9 </option>
     <option> 10 </option>
 </select>
 </p>
 </div>
 <div>
    <p>Buying notes :<br><br>
    <textarea style="background: #fff; height: 120px; width: 100%; box-sizing: border-box; resize: none;"></textarea>
 </p>
 </div>
 <div>
    <p>Select courier :<br><br>
    <select style="display: block; background: #fff; width: 100%; box-sizing: border-box; padding: 8px;">
     <option> 1 </option>
     <option> 2 </option>
     <option> 3 </option>
     <option> 4 </option>
     <option> 5 </option>
     <option> 6 </option>
     <option> 7 </option>
     <option> 8 </option>
     <option> 9 </option>
     <option> 10 </option>
 </select>
 </p>
 </div>
 <div>
    <p>Apply coupon :<br><br>
    <input style="width: 100%; box-sizing: border-box; padding: 8px;" type="text" name="kupon" placeholder="Insert your coupon"/>
 </p>
 </div>
 <div style="text-align: center; margin:auto; background: #0af; width: 80%;">
     <a style="color: #000; line-height: 44px; display: block;" href="checkout">Checkout</a>
 </div>
 <br>
</div>
</aside>
<?php
*/
?>
</div>
<!--container.//-->
<div style="clear: both;"></div>
<div id="content-bottom">
<div style="margin-top: 18px;">
<ul style="list-style: none; padding: 12px; margin: 0;font-family: bariol_light; font-weight: bold; letter-spacing: 1px;" class="menu-items">
    <li id="detil" style="display: inline-block; padding-right: 12px; color: #0af;" onclick="this.style.color = '#0af',document.getElementById('spesification').style.color = 'rgba(0,0,0,0.87)',document.getElementById('compare').style.color = 'rgba(0,0,0,0.87)',document.getElementById('detail').style.display = 'block',document.getElementById('spesifikasi').style.display = 'none',document.getElementById('bandingkan').style.display = 'none'">detail product</li>
    <?php /* ?><li id="review" style="display: inline-block; padding-right: 12px;" onclick="this.style.color = '#0af',document.getElementById('detil').style.color = 'rgba(0,0,0,0.87)',document.getElementById('compare').style.color = 'rgba(0,0,0,0.87)',document.getElementById('ulasan').style.display = 'block',document.getElementById('detail').style.display = 'none'">Review</li><?php */ ?>
    <li id="spesification" style="display: inline-block; padding-right: 12px;" onclick="this.style.color = '#0af',document.getElementById('detil').style.color = 'rgba(0,0,0,0.87)',document.getElementById('compare').style.color = 'rgba(0,0,0,0.87)',document.getElementById('spesifikasi').style.display = 'block',document.getElementById('detail').style.display = 'none',document.getElementById('bandingkan').style.display = 'none'">spesification</li>
    <li id="compare" style="display: none; padding-right: 12px;" onclick="this.style.color = '#0af',document.getElementById('detil').style.color = 'rgba(0,0,0,0.87)',document.getElementById('spesification').style.color = 'rgba(0,0,0,0.87)',document.getElementById('bandingkan').style.display = 'block',document.getElementById('detail').style.display = 'none',document.getElementById('spesifikasi').style.display = 'none'">product compare</li>
</ul>
<div id="detail" style="width:100%;border-top:1px solid silver; display: block;">
<?php
$selling=$this->app->get_where('sellingpoint', ['id_item' => $key->id_item]);
if ($selling->num_rows() > 0) {
?>
<div id="carousel" onload="" class="carousel carousel-slider center desktop">
<?php
$x=1;
$selling=$this->app->get_where('sellingpoint', ['id_item' => $key->id_item]);
foreach ($selling->result() as $img)
{
?>
    <div class="carousel-item" href="#one!">
      <img id="item<?php echo $x;?>" style="width: 80%;" src="<?= base_url('assets/upload/'.$img->gambar); ?>" alt="">
    </div>
<?php
$x++;
}
?>
</div>

<div class="mobile">
<?php
$x=1;
$selling=$this->app->get_where('sellingpoint', ['id_item' => $key->id_item]);
foreach ($selling->result() as $img)
{
?>
  <div>
    <img class="full" src="<?= base_url('assets/upload/'.$img->gambar); ?>" alt="">
  </div>
<?php
$x++;
}
?>
</div>

<script type="text/javascript">
$(document).ready(function(){
  carousel();
});
window.addEventListener("resize", carousel);
$('.carousel.carousel-slider').carousel({
    fullWidth: true,
    indicators: true
  });
function carousel() {
var item = document.getElementById("item1");
var carousel = item.offsetHeight;
document.getElementById("carousel").style.height = carousel + "px";
}
</script>
<hr>
<?php
  # code...
}
// echo $key->detail;?>
</div>
<div id="spesifikasi" style="display: none;border-top:1px solid silver;">
  <div style="padding: 12px;">
    <?php
      if ($spesifikasi->num_rows() > 0) {
    ?>
    <!-- Spesifikasi -->
    <div class="spek" style="min-height: 300px; text-align: center;">
      <?php
      if (!empty($spesifik->curva)) {
      ?>
      <div style="width: calc(49% - 12px); display: inline-block; margin:12px 6px;">
        <div><img style="max-width: 100%; max-height: 100%;" src="<?= base_url('assets/upload/'.$spesifik->curva); ?>"></div>
      </div>
      <div style="text-align: left; width: calc(49% - 12px); display: inline-block; vertical-align: top; margin:12px 6px;">
        <div><img style="max-width: 100%; max-height: 100%;" src="<?= base_url('assets/upload/'.$spesifik->spek); ?>"></div>
        <div><img style="max-width: 100%; max-height: 100%;" src="<?= base_url('assets/upload/'.$spesifik->performance); ?>"></div>
      </div>
      <?php
      }
?>
<hr>
<?php if (!empty($spesifik->voltase) || !empty($spesifik->daya) || !empty($spesifik->rated) || !empty($spesifik->minflow) || !empty($spesifik->inlet))
{
?>
<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>model</th>
<?php
foreach ($tipe->result() as $f) :
$type1 = $f->tipe;
$type2 = $key->tipe;
if ($type2 == $type1) {
echo '<th class="blue"><img style="max-width:120px; max-height:120px;" src="'.base_url('assets/upload/'.$f->gambar).'" alt="'.$type1.'"><br>'.$type1.'</th>';
}
else{
echo '<th class="gray" style="cursor:pointer;"';?> onclick="window.location='<?= site_url('home/detail/'.$f->link); ?>'"><?php echo '<img style="max-width:120px; max-height:120px;" src="'.base_url('assets/upload/'.$f->gambar).'" alt="'.$type1.'"><br>'.$type1.'</th>';
}
endforeach;
?>
  </tr>
<?php
if (!empty($spesifik->voltase)) {
?>
  <tr>
    <td>voltase</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->voltase.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->daya)) {
?>
  <tr>
    <td>daya</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->daya.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->currentarus)) {
?>
  <tr>
    <td>current arus</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->currentarus.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->totalhead)) {
?>
  <tr>
    <td>total head</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->totalhead.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->maxcapacity)) {
?>
  <tr>
    <td>max capacity</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->maxcapacity.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->rated)) {
?>
  <tr>
    <td>rated</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->rated.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->minflow)) {
?>
  <tr>
    <td>min flow</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->minflow.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->inlet)) {
?>
  <tr>
    <td>inlet outlet</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->inlet.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->kabel)) {
?>
  <tr>
    <td>kabel</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->kabel.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->hisap)) {
?>
  <tr>
    <td>hisap</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->hisap.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->head)) {
?>
  <tr>
    <td>head</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->head.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->kapasitas)) {
?>
  <tr>
    <td>kapasitas</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->kapasitas.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->pressure)) {
?>
  <tr>
    <td>pressure</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->pressure.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->pipa)) {
?>
  <tr>
    <td>pipa</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->pipa.'</td>';
endforeach;
?>
  </tr>
<?php
}
if (!empty($spesifik->berat)) {
?>
  <tr>
    <td>berat</td>
<?php
foreach ($tipe->result() as $f) :
$id1 = $f -> id_item;
$model = $this->db->get_where('spesifikasi', array('id_item' => $id1));
$model = $model->row();
echo '<td class="gray">'.$model->berat.'</td>';
endforeach;
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
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$get1->link); ?>"><img src="<?php echo base_url('assets/upload/'.$get1->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $get1->nama_item;?></p>
                <b><?= 'Rp '.number_format($get1->harga, 0, ',', ','); ?></b><br><br>
            </div>
      <span class="hargapackage bariol-regular" style="margin: auto 0px;"> + </span>
      <div style="width:150px; background: #fff; min-height: auto; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$get2->link); ?>"><img src="<?php echo base_url('assets/upload/'.$get2->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $get2->nama_item;?></p>
                <b><?= 'Rp '.number_format($get2->harga, 0, ',', ','); ?></b><br><br>
            </div>
      <span class="hargapackage bariol-regular" style="margin: auto 0px;"> + </span>
      <div style="width: 150px; background: #fff; min-height: auto; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 120px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$get3->link); ?>"><img src="<?php echo base_url('assets/upload/'.$get3->gambar);?>" style="max-width: 120px; max-height: 120px; margin:auto;"></a></div>
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
<div>
    <h3 style="font-size: 24px;">customers who bought this item also bought</h3>
    <hr style="margin: 0px 12px 12px 12px; max-width: 200px; border: solid 2px #0af;">
    <div class="list-produk" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
        <div style="max-width: 1300px; min-height: 250px; display: flex;">
<?php
$query = $this->db->order_by('id_item','random');
$query = $this->db->get('t_items');
foreach ($query->result() as $row)
{
$foto = $row->gambar;
?>
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width: 150px; height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" style="max-width: 120px; max-height: 120px;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $row->nama_item;?></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b><?= 'Rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php
}
?>
        </div>
    </div>
</div>
<hr>

<div>
    <h3 style="font-size: 24px;">you may also like</h3>
    <hr style="margin: 0px 12px 12px 12px; max-width: 200px; border: solid 2px #0af;">
    <div class="list-produk" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
        <div style="max-width: 1300px; min-height: 250px; display: flex;">
<?php
$query = $this->db->order_by('id_item','random');
$query = $this->db->get('t_items');
foreach ($query->result() as $row)
{
$foto = $row->gambar;
?>
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" style="max-width: 120px; max-height: 120px;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $row->nama_item;?></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b><?= 'Rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php
}
?>
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
      <td rowspan="4" style="width: 40%; height: 200px;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$r->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" alt="<?php echo base_url('assets/upload/'.$foto);?>" style="width: 100%;"></a></td>
      <td style="width: 60%; padding: 4px 12px; height: 20px;"><b style="font-size: 18px;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$r->link); ?>"><?php echo $r->nama_item;?></a></b></td>
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

                        <a href="<?= site_url('home/detail/'.$r->link); ?>" class="waves-effect waves-light btn blue white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lihat Detail">
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
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$r->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" alt="<?php echo base_url('assets/upload/'.$foto);?>" style="width: 150px;"></a></div>
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
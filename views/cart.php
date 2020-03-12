<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?= validation_errors('<p style="color:red">','</p>'); ?>
<div class="box-cart">
<div class="max-width-1140 box-cart1" style="position:relative; background:white;">
<?php

//tampilkan pesan gagal
      echo '<div style="position:fixed; z-index:9; top:54px; left:0; right:0;">';
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo '<center>'.$this->session->flashdata('alert').'</center>';
         echo '</div>';
      }
      //tampilkan pesan success
      elseif ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      echo '</div>';
$i = 1;
if (!empty($this->cart->contents())) {
echo '
<div class="hpadding">
<table class="cart-detail" style="position:relative;">
<tr>
<td><h3 class="nomargin" style="width:auto; display:inline-block; padding:12px 0px;">shopping cart</h3></td>
<td style="vertical-align:bottom; text-align:center;"></td>
</tr>
<tr>
<td colspan="2"><br class="mobile"><hr class="nomargin"></td>
</tr>
';
$xx = 0;
foreach($this->cart->contents() as $key) :
   $get  = $this->app->get_where('t_items', array('link' => $key['link']))->row();
if ($xx == 0) {
  $produk = $key['name'];
}
$display_harga = '';
if($get->hargapromo == 0 && $get->harga_grosir == 0 || $key['qty'] < $get->grosir && $get->grosir == 0){
  $display_harga = 'display:none;';
}
$t_items = $this->db->query("SELECT i.*, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$key['link']."'")->row();
$nama = explode(" / ", $t_items->nama_item);
?>
<tr style="position: relative; height:120px;">
<td class="cart-product" style="position:relative;">
   <div class="cart-image" style="padding: 12px; display: inline-flex; background: #fff;">
      <img style="margin:auto;" src="<?php echo base_url('assets/product/'.$get->gambar);?>" alt="<?php echo $get->link;?>">
   </div>
   <div class="cart-name hpadding" style="margin: 0px; max-height: 300px; display: inline-block;">
      <p style="white-space: nowrap; width: 100%; overflow-x:hidden; text-overflow:ellipsis; line-height: 18px;"><a style="font-size:16px; color:#333;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$key['link']); ?>"><?= $nama[0]; ?></a></p>
        <span class="cart-deskripsi grey-text" style="font-size:11px; white-space:normal; line-height:14px;"><?php if ($get->stok > 0) {
          echo strtolower($get->deskripsi);
        } ?></span><br>
        <span class="harga-mobile red-text" style="<?php echo $display_harga;?> font-size:11px; line-height:18px;"><strike>rp <?= number_format($get->harga, 0, ',', ','); ?></strike></span><br>
         <span class="harga-mobile red-text" style="font-size:14px;">rp <?= number_format($key['price'], 0, ',', ','); ?><br></span>
         <div class="box-textarea">
         <form action="<?= site_url('cart/update/'.$key['rowid']); ?>" method="post">
        <?php if (!empty($key['note'])) {
            $note = $key['note'];
            ?>
                <span id="display<?php echo $key['rowid'];?>" class="display" style="white-space:normal;"><?php echo $key['note'];?> (<span onclick = "hidedata('#display<?php echo $key['rowid'];?>'), showdata('#note-<?php echo $key['rowid'];?>'), textfocus('text-<?php echo $key['rowid'];?>')">change</span>)</span>
            <?php
            } else{
            $note = "";
            ?>
                <span id="display<?php echo $key['rowid'];?>" class="display" style="white-space:normal;" onclick = "hidedata(this), showdata('#note-<?php echo $key['rowid'];?>'), textfocus('text-<?php echo $key['rowid'];?>')">add notes</span>
            <?php
            } ?>
            <div id="note-<?php echo $key['rowid'];?>" style="display:none;" onfocusout="showdata('#display<?php echo $key['rowid'];?>'), hidedata('#note-<?php echo $key['rowid'];?>')">
            <textarea id="text-<?php echo $key['rowid'];?>" style="max-height:26px; font-size:11px; padding-right:36px; resize:none; border:none; border-bottom:solid 1px #aaa; outline:none;" name="note"><?php echo $note;?></textarea>
            <button class="btn-cart-save blue" type="submit" style="height:26px; border:none; color:#fff; border-radius:2px; width:48px;" name="submit" value="Submit">save</button>
            </div>
       </form>
       </div>
      <?php
      if($key['qty'] >= $get->stok){
          $qty = $get->stok;
      }
      else{
          $qty = $key['qty'];
      }
            if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
            }
            if (isset($fav) && $fav->num_rows() > 0) {
               if (in_array($get->id_item, $favorite))
               {
                  $icon    = '<i style="font-size:14px;" class="fa fa-heart red-text"></i>';
               } else {
                  $icon    = '<i style="font-size:14px;" class="fa fa-heart grey-text"></i>';
               }
            }
            else{
              $icon    = '<i style="font-size:14px;" class="fa fa-heart grey-text"></i>';
            }
      ?>
   </div>
</td>
<td class="qty" style="position: relative;">
  <div class="qty-1" style="margin:auto; line-height:18px;">
  <span class="harga-desktop harga-cart red-text" style="<?php echo $display_harga;?> font-size:12px;"><strike>rp <?= number_format($get->harga, 0, ',', ','); ?></strike></span><br>
  <span class="harga-desktop harga-cart red-text" style="font-size:18px;">rp <?= number_format($key['price'], 0, ',', ','); ?></span>
  <div class="btn-cart-2">
  <a href="<?= site_url('home/favorite/'.$get->link); ?>" style="width: 20px; height: 20px; box-shadow: none;"><?= $icon; ?></a>
  &nbsp;
  <a href="<?= site_url('cart/delete/'.$key['rowid']); ?>" style="width: 20px; height: 20px; box-shadow: none;" onclick="return confirm('are you sure you want to delete this item from your basket ?')"><i style="font-size:14px;" class="fa fa-trash grey-text"></i></a>
  </div>
  </div>
  <form style="text-align:right;" name="formcart<?php echo $key['rowid'];?>" action="<?= site_url('cart/update/'.$key['rowid']); ?>" method="post">
        <!--<button type="button" onclick="myFunction('<?php echo $key['rowid'];?>','kurang')">-</button>-->
        <button class="btn-floating grey white-text" style="box-shadow: none; width: 25px; height: 25px; font-weight:bold;" type="button" onclick="myFunction('<?php echo $key['rowid'];?>','kurang'), updatecart('<?php echo $key['rowid'];?>')">-</button>
        <input id="qty<?php echo $key['rowid'];?>" style="width: 30px; height:2rem; text-align: center; box-sizing: border-box;" type="text" name="qty" min="1" max="<?=$get->stok;?>" value="<?= $qty; ?>" onkeyup="myFunction('<?php echo $xx;?>','')">
        <!--<button type="button" onclick="myFunction('<?php echo $key['rowid'];?>','tambah')">+</button>-->
        <button class="btn-floating blue white-text" style="box-shadow: none; width: 25px; height: 25px; font-weight:bold;" type="button" onclick="myFunction('<?php echo $key['rowid'];?>','tambah'), updatecart('<?php echo $key['rowid'];?>')">+</button>
  </form>
</td>
</tr>
<tr>
  <td colspan="3"><hr class="nomargin"></td>
</tr>
<?php
$xx++;
endforeach;
echo '
</table>
';
?>
<div class="right-side">
<div id="tombol" class="checkout">
   <div class="center">
      <span class="nopadding bariol-regular total">total <?php echo $xx;?> item</span>
      <hr class="nomargin desktop">
      <p class="red-text bariol-regular bold" style="margin: auto;">
      rp <?= number_format($this->cart->total(), 0, ',',','); ?>
      </p>
   </div>
   <button id="checkout" type="button" class="btn blue" onclick="window.location = '<?= site_url('checkout'); ?>'"><i class="fa fa-shopping-bag"></i> Checkout</button>
</div>
</div>
<script>
function myFunction(id,data) {
  var id = "qty" + id;
  var min = document.getElementById(id).min;
  var max = document.getElementById(id).max;
  var value = document.getElementById(id).value;
    if(data == "tambah"){
    value++;
    var newvalue = value;
    document.getElementById(id).value = newvalue;
    }
    else if (data == "kurang"){
    value--;
    var newvalue = value;
    document.getElementById(id).value = newvalue;
    }
  if(newvalue >= min && newvalue <= max){
    document.getElementById(id).value = newvalue;
  }
  else{
  if(value >= max){
    document.getElementById(id).value = max;
  }
  else if(value <= min){
    document.getElementById(id).value = min;
  }
  }
}
</script>
<?php
echo "</div>";
}
else{
?>
<div id="cart-empty" style="display: flex; height:50vh;">
   <div style="margin: auto; text-align: center;">
    <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>">
     <p>your bag is empty</p>
     <a href="<?= base_url();?>" class="btn white-text black">select products</a>
   </div>
</div>
<?php
}
?>
<div style="clear: both;"></div>
<?php
/*
if ($last->num_rows() > 0) {
?>
<div>
   <h3 style="font-size: 18px;">terakhir dilihat</h3>
   <hr class="nomargin">
   <br>
<div class="list-cart" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
<div style="max-width: 1300px; min-height: 250px; display: flex;">
<?php
foreach ($last->result() as $row)
{
$foto = $row->gambar;
?>
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" style="max-width: 150px;max-height: 150px;"></a></div>
                <p style="font-family: bariol_regular; line-height: 24px; overflow-y: hidden; height: 66px;"><?php echo $row->nama_item;?></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                
                ?>
                <b class="red-text"><?= 'rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php            
}
echo '</div></div></div>';
}
*/
?>
<script>
          function updatecart(id) {
          var id = 'formcart' + id;
          //document.getElementById(id).submit();
          setTimeout("document." + id + ".submit();",1000);
          }
</script>
<script>
function cart(id,data) {
  var id = "cart" + id;
  var min = document.getElementById(id).min;
  var max = document.getElementById(id).max;
  var value = document.getElementById(id).value;
    if(data == "tambah"){
    value++;
    var newvalue = value;
    document.getElementById(id).value = newvalue;
    }
    else if (data == "kurang"){
    value--;
    var newvalue = value;
    document.getElementById(id).value = newvalue;
    }
  if(newvalue >= min && newvalue <= max){
    document.getElementById(id).value = newvalue;
  }
  else{
  if(value >= max){
    document.getElementById(id).value = max;
  }
  else if(value <= min){
    document.getElementById(id).value = min;
  }
  }
}
</script>
<div style="clear:both;"></div>
<?php
$query = $this->db->query("SELECT * FROM last_view WHERE id_user = '".$this->session->userdata('user')."' ORDER BY waktu DESC");
if($query->num_rows() > 0){
?>
<div class="content" style="background: #fff; padding:0px; margin:12px 12px 0px 12px;">
    <div>
    <h2 style="font-size:18px; padding: 4px 0px; margin: 6px 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">last viewed</h2>
    </div>
    <div class="select-model random-produk" style="margin:0; max-height:220px;">
    <div class="previus" onclick="previus('list-cart2')"><span> < </span></div>
    <div class="next" onclick="next('list-cart2')"><span> > </span></div>
    <div id="list-cart2" class="list-cart" style="width: 100%; overflow-x: auto; overflow-y: hidden;">
        <div style="min-height: 220px; white-space:nowrap;">
<?php
$n = 1;
$query = $this->db->query("SELECT * FROM last_view WHERE id_user = '".$this->session->userdata('user')."' ORDER BY waktu DESC");
foreach ($query->result() as $row1)
{
$t_items = $this->db->query("SELECT i.*, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.id_item = '".$row1->id_item."'")->row();
$items2 = $this->db->query("SELECT link FROM t_items WHERE id_item = '".$t_items->id_item."'")->row();
$foto = $t_items->gambar;
$nama = explode(" / ",$t_items->nama_item);
$nama1 = "";
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
            <div class="cart-list" style="background: #fff; margin-right:6px; display: inline-block; position:relative; text-align: center; padding-top: 12px;">
                <?php
                if (isset($fav) && $fav->num_rows() > 0) {
                    foreach ($fav->result() as $f) :
                       $favorite[] = $f->id_item;
                    endforeach;
                }
                  if (isset($fav) && $fav->num_rows() > 0) {
                     if (in_array($t_items->id_item, $favorite))
                     {
                        $icon    = '<i style="font-size:11px;" class="fa fa-heart red-text"></i>';
                     } else {
                        $icon    = '<i style="font-size:11px;" class="fa fa-heart-o black-text"></i>';
                     }
                  }
                  else{
                    $icon    = '<i style="font-size:11px;" class="fa fa-heart-o black-text"></i>';
                  }
                  ?>
                <div class="cart-list-img" style="display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$items2->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 16px; overflow: hidden; height: 50px;"><a style="margin: auto;font-size:13px;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$items2->link); ?>"><?php echo $nama[0]." <br>";?></a><span style="font-size:11px; color:grey;"><?php echo $nama[1];?></span></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b style="font-size:13px;"><?= 'rp '.number_format($t_items->harga, 0, ',', ','); ?></b>
                <div class="hpadding vmargin">
                  <form action="<?= site_url('cart/add/'.$items2->link); ?>" method="post" class="detail-item">
                  <input id="cart<?php echo $n; ?>" type="hidden" name="qty" min="1" max="<?=$t_items->stok;?>" value="1" <?php if($t_items->stok < 1) { echo 'disabled'; } ?>>
                  <?php if($t_items->stok < 1) {
                    echo '<button class="black" style="width: 70px; height: 20px; border-radius:2px; border:none; font-size:9px; color:white;" type="submit" name="submit" value="Submit" disabled>out of stock</button>';
                  }
                  else {
                    echo '<button class="blue" style="width: 70px; height: 20px; border-radius:2px; border:none; font-size:9px; color:white;" type="submit" name="submit" value="Submit">add to cart</button>';
                  } ?>
                  <button class="btn-floating white" style="width: 20px; height: 20px; box-shadow:none;" type="button" onclick="window.location = '<?= site_url('home/favorite/'.$items2->link); ?>'"><?= $icon; ?></button>
                  </form>
                </div>
            </div>
<?php
$n++;
}
?>
        </div>
    </div>
  </div>
</div>
<?php
}
?>
<div style="clear:both;"></div>
</div>
</div>
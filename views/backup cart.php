<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h3><i class="fa fa-shopping-cart"></i> data belanja</h3>
<hr />
<br />
<?= validation_errors('<p style="color:red">','</p>'); ?>
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
<div style="padding:12px; position:relative;">
<div class="cart-detail">';
foreach($this->cart->contents() as $key) :
   $get  = $this->app->get_where('t_items', array('link' => $key['link']))->row();
            ?>
<div class="cart-product" style="position: relative; display: flex; margin: 0px; border:solid 1px #ddd; border-radius: 12px; box-shadow: #ddd 0px 0px 10px;min-height: 179px;">
   <div class="cart-image" style="padding: 12px; width: 150px;">
      <img src="<?php echo base_url('assets/upload/'.$get->gambar);?>" alt="<?php echo base_url('assets/upload/'.$get->gambar);?>">
   </div>
   <div class="cart-name" style="margin: 0; max-height: 150px;">
      <p style="white-space: nowrap; width: 100%; overflow-x:hidden; text-overflow:ellipsis; font-weight: bold; line-height: 24px;"><a href="<?= site_url('home/detail/'.$key['link']); ?>"><?= $key['name']; ?></a><br>
         jumlah : <?= $key['qty']; ?><br>
         berat : <?php if ($key['weight'] >= 1000) {
           $weight = $key['weight'] / 1000;
           $satuan = "kg";
         } else{ $weight = $key['weight']; $satuan = "gr"; } echo $weight.'&nbsp;'.$satuan; ?><br>
         <span class="nopadding red-text">Rp <?= number_format($key['price'], 0, ',', ','); ?></span>
      </p>
      <div style="padding: 0px 12px;">
      <a href="#<?= $key['rowid']; ?>" class="btn-floating orange"><i class="fa fa-edit"></i></a>
               <a href="<?= site_url('cart/delete/'.$key['rowid']); ?>" class="btn-floating red" onclick="return confirm('Yakin Ingin menghapus item ini dari keranjang anda ?')"><i class="fa fa-trash"></i></a>
      </div>
      <br>
   </div>
   <div class="modal" id="<?= $key['rowid']; ?>">
            <form action="<?= site_url('cart/update/'.$key['rowid']); ?>" method="post">
               <div class="row">
                  <div class="col m10 s12 offset-m1">
                     <div class="modal-content">
                        <h5><i class="fa fa-edit"></i> Edit Pesanan</h5>
                        <br />
                        <div class="input-field">
                           <input type="text" name="name" value="<?= $key['name']; ?>" id="name<?= $key['rowid']; ?>" readonly="readonly">
                           <label for="name<?= $key['rowid']; ?>">Nama Barang</label>
                        </div>
                        <div class="input-field">
                           <input type="number" name="qty" min="1" max="<?=$get->stok; ?>" value="<?= $key['qty']; ?>" id="qty<?= $key['rowid']; ?>" autofocus>
                           <p style="color:#6b6b6b; margin-top:-15px;"><i>* Isi dengan angka</i></p>
                           <label for="qty<?= $key['rowid']; ?>">Jumlah Pesan</label>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" name="submit" value="Submit" class="modal-action btn blue">Simpan</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
</div>
<br>
<?php
endforeach;
echo '</div>';
?>
<div id="tombol" class="checkout right" style="box-shadow: #ddd 0px 0px 10px;">
   <div class="center">
      <span class="nopadding bariol-regular total">total belanja</span>
      <hr class="nomargin desktop">
      <p class="red-text bariol-regular bold" style="margin: auto;">
      Rp <?= number_format($this->cart->total(), 0, ',',','); ?>
      </p>
   </div>
   <button id="checkout" type="button" class="btn blue" onclick="window.location = '<?= site_url('checkout'); ?>'"><i class="fa fa-shopping-bag"></i> Checkout</button>
</div>
<?php
echo "</div>";
}
else{
?>
<div style="display: flex; min-height: 200px;">
   <div style="margin: auto; text-align: center;">
    <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>">
     <p>keranjang anda masih kosong</p>
     <a class="btn white-text black" onclick="window.location='home'">lanjut belanja</a>
   </div>
</div>
<?php
}
?>
<div style="clear: both;"></div>
<?php
if ($last->num_rows() > 0) {
?>
<div>
   <h3 style="font-size: 18px;">terakhir dilihat</h3>
   <hr class="nomargin">
   <br>
<div class="list-produk" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
<div style="max-width: 1300px; min-height: 250px; display: flex;">
<?php
foreach ($last->result() as $row)
{
$foto = $row->gambar;
?>
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" style="max-width: 150px;max-height: 150px;"></a></div>
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
                <b class="red-text"><?= 'Rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php            
}
echo '</div></div>';
}
?>
</div>
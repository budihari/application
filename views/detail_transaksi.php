<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
$data = $get->row();
?>
<div class="row" style="min-height: 500px;">
   <div class="col m10 s12 offset-m1">
      <br>
      <h1 style="font-size:32px;"><i class="fa fa-user"></i> invoice #<?php echo $data->id_order;?></h1>
      <br />
<div style="text-align: right;">
<?php
$bayar = $pembayaran->row();
if(empty($data->status_proses) || $data->status_proses != 'not paid'){
?>
<button class="btn green" style="border-radius: 6px;"><i class="fa fa-check"></i>&nbsp;paid</button>
<?php
}
else{
?>
<button class="btn grey" style="border-radius: 6px;" onclick="document.location = '<?php echo base_url();?>payment/confirm/<?php echo $data->id_order;?>'">confirm payment</button>
<button class="btn grey" style="border-radius: 6px;" onclick="document.location='<?php echo base_url();?>checkout/payment_info/<?php echo $data->id_order;?>'">how to pay</button>
<?php
}
?>
</div><br>
<div class="shipping-address" style="display: inline-block;">
   <div style="width: 100%; min-height: 200px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
      <p style="line-height: 24px;" class="nopadding bariol-regular nomargin">
      <b><u>shipping address</u></b><br>
      <?php echo $data->nama_pemesan; ?><br>
      <?php
      $a = array();
      if (!empty($data->tujuan)) {
         array_push($a,$data->tujuan);
      }
      if (!empty($data->subdistrict)) {
         $subdistrict = explode(",", $data->subdistrict);
         if (!empty($subdistrict[1])) {
            array_push($a,$subdistrict[1]);
         }
      }
      if (!empty($data->kota)) {
         $kota = explode(",", $data->kota);
         if (!empty($kota[1])) {
            array_push($a,$kota[1]);
         }
      }
      $a = join(", ", $a);
      ?>
      <?php echo $a; ?><br>
      <?php
      if (!empty($data->provinsi)) {
          $provinsi = explode(",", $data->provinsi);
          if (!empty($provinsi[1])) {
             echo $provinsi[1];
          }
          if (!empty($data->pos)) {
             echo " (".$data->pos.")<br>";
          }
      }
      ?>
      phone : <?php echo $data->telepon;?><br>
      <b><u>courier</u></b><br>
      <?php
      echo $data->kurir." (".strtolower($data->service).")<br>";
      echo "tracking no.: ";
      if (!empty($data->resi)) {
        echo $data->resi;
      }
      else{
        echo "-";
      }

      $total = $data->total - $data->ongkir + $data->potongan;
      ?>
      </p>
        
   </div>
</div>
<div class="checkout-summary" style="display: inline-block; vertical-align: top;">
<div style="width: 100%; min-height: 200px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
   <p class="nopadding bariol-regular"><b><u>order summary</u></b></p>
   <div style="padding-top: 6px;">
   <table cellpadding="4" cellspacing="0" class="bariol-regular">
      <tr>
         <td>total price</td><td><span class="bariol-regular">Rp. </span><?= number_format($total - $data->kode_unik, 0, ',', ','); ?></td>
      </tr>
      <tr>
         <td>shipping cost</td><td><span class="bariol-regular">Rp. </span><?php echo $data->ongkir;?></td>
      </tr>
      <tr>
         <td>discounts</td><td><span class="bariol-regular">Rp. </span><?php echo $data->potongan;?></td>
      </tr>
      <tr>
         <td>unique code</td><td><span class="bariol-regular">Rp. </span><?php echo $data->kode_unik;?></td>
      </tr>
      <tr>
         <td colspan="2"><hr class="nomargin"></td>
      </tr>
      <?php
      $total = $total + $data->ongkir - $data->potongan;
      ?>
      <tr>
         <td>total bill</td><td><span class="bariol-regular">Rp </span>
                  <span id="totalbayar" class="bariol-regular"><?= number_format($total, 0, ',', ','); ?></span></td>
      </tr>
      <tr>
         <td>payment method</td><td><?php echo $data->payment_method;?></td>
      </tr>
      <tr>
         <td>status</td><td><?php echo $data->status_proses;?></td>
      </tr>
   </table>
   </div>
</div>

         </div>

   <div style="width: 100%; min-height: 100px; border:solid 1px #ddd; padding: 12px; margin-top: 12px; border-radius: 12px;">
      <p style="line-height: 24px;" class="nopadding bariol-regular nomargin">
      <b><u>list of products purchased</u></b><br>
      
      <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
?>
      <?php
      $x=1;
      foreach($detail_order->result() as $key) :
      $get  = $this->app->get_where('t_items', array('id_item' => $key->id_item))->row();
      if ($x > 1) {
         echo "<hr>";
      }
      if (isset($fav) && $fav->num_rows() > 0) {
               if (in_array($key->id_item, $favorite))
               {
                  $color = '#f00';
                  $icon    = 'remove from wishlist';
               } else {
                  $color = '#fff';
                  $icon    = 'add to wishlist';
               }
            } else {
               $color = '#fff';
               $icon    = 'add to wishlist';
            }
      ?>
      <div>
         <div class="detail-pesanan" style="overflow-y: hidden;">
         <div class="cart-image" style="padding: 12px; display: inline-flex; background: #fff;">
         <img style="margin:auto;" src="<?php echo base_url('assets/product/'.$get->gambar);?>" alt="<?php echo base_url('assets/product/'.$get->gambar);?>">
         </div>
         <div class="cart-name" style="margin: 0px; max-height: 150px; display: inline-block; vertical-align: top;">
         <p style="white-space: nowrap; width: 100%; overflow-x:hidden; text-overflow:ellipsis; line-height: 24px;"><a href="<?= site_url('home/detail/'.$get->link); ?>"><?php echo $get->nama_item; ?></a><br>
         Rp <?= number_format($key->biaya / $key->qty, 0, ',', ','); ?><br>
         quantity: <?= $key->qty; ?>&nbsp;&nbsp;&nbsp;weight: <?php if ($get->berat >= 1000) {
           $berat = $get->berat / 1000;
           $satuan = "kg";
         } else{ $berat = $get->berat; $satuan = "gr"; } echo $berat.'&nbsp;'.$satuan; ?><br>
         <?php if (!empty($key->catatan)) {
            echo  "note : ".$key->catatan."<br>";
         }?>
         </p>
         </div>
         </div>

         <div class="kurir">
            <div style="text-align: right;">
               <form action="<?= site_url('cart/add/'.$get->link); ?>" method="post" class="detail-item">
               <input style="width: 80px;" type="hidden" name="qty" min="1" max="<?=$get->stok;?>" value="1" <?php if($get->stok < 1) { echo 'disabled'; } ?>>
               <button type="submit" name="submit" value="Submit" class="btn blue">buy it again</button>
               <button type="button" class="btn" style="width: 200px; background: rgba(10,42,59,1);" onclick="window.location = '<?= site_url('home/favorite/'.$get->link); ?>'"><?php echo $icon; ?></button>
            </form>
            </div>
         </div>

      </div>
      <?php
      $x++;
      endforeach;
      ?>
   </div>

   <div style="width: 100%; min-height: 100px; border:solid 1px #ddd; padding: 12px; margin-top: 12px; border-radius: 12px;">
      <p style="line-height: 24px;" class="nopadding bariol-regular nomargin">
      <b><u>shipping history</u></b><br>
      <table style="width: 100%;" cellpadding="8" border="1">
         <tr>
            <td style="font-weight: bold; font-size:14px;">time</td><td style="font-weight: bold; font-size:14px;">detail</td>
         </tr>
         <?php
         echo $response;
         ?>
      </table>
   </div>

<br>
<br>
</div>
</div>
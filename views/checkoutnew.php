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
      $nama_kupon = "";
      if ($this->session->userdata('nama_kupon')){
         $nama_kupon = $this->session->userdata('nama_kupon');
      }
?>
<div class="vpadding background-white">
<div class="row bariol-regular">
   <div class="col m10 s12 offset-m1">
      <h3><i class="fa fa-shopping-bag"></i> checkout</h3>
      <hr />
      <br />
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="" method="post">
<div class="shipping-address" style="display: inline-block;">
   <div style="width: 100%; min-height: 200px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
      <p class="nopadding bariol-regular">shipping address</p>
      <hr class="nomargin">
      <p style="line-height: 24px;" class="vpadding bariol-regular nomargin"><?php echo $nama1; ?><br>
      <?php
      $a = array();
      if (!empty($alamat)) {
         array_push($a,$alamat);
      }
      if (!empty($kecamatan[1])) {
         array_push($a,$kecamatan[1]);
      }
      if (!empty($kabupaten[1])) {
         array_push($a,$kabupaten[1]);
      }
      $a = join(", ", $a);
      ?>
      <?php echo $telp; ?><br>
      <?php echo strtolower($a); ?><br>
      <?php
      if (!empty($provinsi[1])) {
         echo strtolower($provinsi[1])." (".$kodepos.")<br>";
      }
      ?>
      <?php if (!empty($address)) {
      echo '<a href="#update-address">ubah alamat</a>';
      }
      ?>
      </p><hr class="nomargin">
      <div>
         <a href="#add-address"><button class="btn grey new-address">use new address</button></a>&nbsp;
         <?php if (!empty($address)) {
            echo '<a href="#change-address"><button class="btn grey new-address">select another address</button></a>';
         }
         ?>
      </div>
   </div>
   <br>
   <div style="width: 100%; min-height: 200px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
      <p class="nopadding bariol-regular">detail orders</p>
      <hr class="nomargin">
      <div class="detail-pesanan">
      <?php
      $x=1;
      foreach($this->cart->contents() as $key) :
      $get  = $this->app->get_where('t_items', array('link' => $key['link']))->row();
      ?>
      <div>
         <div class="cart-image" style="padding: 12px; display: inline-flex; background: #fff;">
         <img style="margin:auto;" src="<?php echo base_url('assets/product/'.$get->gambar);?>" alt="<?php echo $get->nama_item;?>">
         </div>
         <div class="cart-name" style="margin: 0px; max-height: 150px; display: inline-block; vertical-align: top;">
         <p class="bariol-regular" style="white-space: nowrap; width: 100%; overflow-x:hidden; text-overflow:ellipsis; line-height: 24px;"><a href="<?= site_url('home/detail/'.$key['link']); ?>"><span><?= $key['name']; ?></span></a><br>
         <span class="nopadding">rp <?= number_format($key['price'], 0, ',', ','); ?></span><br>
         quantity: <?= $key['qty']; ?>&nbsp;&nbsp;&nbsp;weight: <?php if ($key['weight'] >= 1000) {
           $weight = $key['weight'] / 1000;
           $satuan = "kg";
         } else{ $weight = $key['weight']; $satuan = "gr"; } echo $weight.'&nbsp;'.$satuan; ?><br>
         <?php if (!empty($key['note'])) {
            echo "note : ".$key['note']."<br>";
         }
         ?>
         </p>
         </div>
      </div>
      <?php
      $x++;
      endforeach;
      ?>
   </div>
   <div class="kurir">
      <p class="nomargin bariol-regular">shipping option</p>
      <div id="kurirr" style="display: none;" onchange="document.getElementById('kurir2').style.display='block'">
      <select class="browser-default hpadding" name="kurir" id="kurir">
         <option value="">select courier</option>
         <option value="pos" <?php if ($kurir == "pos") {
            echo "selected";
         }?>>pos</option>
         <option value="jne" <?php if ($kurir == "jne") {
            echo "selected";
         }?>>jne</option>
         <option value="tiki" <?php if ($kurir == "tiki") {
            echo "selected";
         }?>>tiki</option>
         <option value="jet" <?php if ($kurir == "jet") {
            echo "selected";
         }?>>j&t</option>
      </select>
      </div>
      <br>
      <div id="kurir2" style="display: none;" onchange="myFungsi()">
      <select class="browser-default hpadding" name="layanan" id="layanan">
         <option value="" selected>select service</option>
      </select>
      </div>
      <div class="hpadding" id="ubahkurir">
      <button type="button" class="btn grey" style="width: 100%;" onclick="document.getElementById('kurirr').style.display='block',document.getElementById('kurir').selectedIndex = '0',document.getElementById('ubahkurir').style.display='none'">change</button>
      </div>
      <div id="ship">
      <p class="bariol-regular nomargin">shipping method</p>
      <p class="nopadding"><span id="shipping" class="bariol-regular hpadding">no shipping selected</span>(<span id="ongkir2" class="bariol-regular hpadding"></span>)</p>
      </div>
   </div>
   </div>
</div>
<script>
   function myFungsi(){
      var kode = document.getElementById('kurir').value;
      if(kode == 'jet'){
         document.getElementById("shipping").innerHTML = 'j&t';
      }
      else if(kode == 'pos'){
         document.getElementById("shipping").innerHTML = 'pos indonesia';
      }
      else{
         document.getElementById("shipping").innerHTML = kode;
      }
      
   }
</script>

<div class="checkout-summary" style="display: inline-block; vertical-align: top;">
<div style="width: 100%; min-height: 100px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
   <p class="nopadding bariol-regular">coupon code</p>
   <hr class="nomargin">
   <div style="position:relative;">
   <input id="kupon" style="max-width:calc(100% - 116px); padding:0px 8px;" type="text" name="coupon" value ="<?php echo $nama_kupon;?>" placeholder="apply coupon code">
   <button id="btn_promo" class="btn blue" style="position:absolute; right:0;" type="button" name="coupon_code">apply</button>
   </div>
   <span id="text_coupon"><?php if(!empty($deskripsi_kupon)){echo $deskripsi_kupon;}?></span>
</div>

<br>

<div style="width: 100%; min-height: 200px; border:solid 1px #ddd; padding: 12px; border-radius: 12px;">
   <p class="nopadding bariol-regular">shopping summary</p>
   <hr class="nomargin">
   <div style="padding-top: 12px;">
   <table cellpadding="2" cellspacing="0">
      <tr>
         <td>total price</td><td><span class="bariol-regular">rp </span><?= number_format($this->cart->total(), 0, ',', ','); ?></td>
      </tr>
      <tr>
         <td>shipping cost</td><td><span class="bariol-regular">rp </span><span id="ongkir" class="nopadding bariol-regular">0</span></td>
      </tr>
      <tr>
         <td>unique code</td><td><span class="bariol-regular">rp </span><span id="unique" class="nopadding bariol-regular"><?php echo $uniq;?></span></td>
      </tr>
      <tr>
         <td>discount</td><td><span class="bariol-regular">rp </span><span id="discount"><?= number_format($discount, 0, ',', ','); ?></span></td>
      </tr>
      <tr>
         <td colspan="2"><hr style="margin: 6px 0px;"></td>
      </tr>
      <tr>
         <td>total bill</td><td><span class="bariol-regular">rp </span>
                  <span id="totalbayar" class="bariol-regular"><?= number_format($this->cart->total() + $uniq - $discount, 0, ',', ','); ?></span></td>
      </tr>
      <tr>
         <td colspan="2">&nbsp;</td>
      </tr>
      <tr><td colspan="2"><span style="font-size: 12px;">by clicking "pay now" you agree to all our <a class="blue-text" href="syarat-dan-ketentuan">terms and conditions</a>.</span></td></tr>
      <tr class="desktop">
         <td colspan="2">
            <div>
               <button type="submit" name="submit" value="submit" class="btn blue waves-effect waves-light">pay now</button>
            </div></td>
      </tr>
   </table>
   </div>
</div>
            <div id="tombol" class="right mobile">
               <div style="padding: 12px;">
                  <p class="nopadding bariol-regular">total bill</p>
                  <span class="nopadding bariol-regular red-text" style="font-size: 18px;">rp </span>
                  <span id="bayar" class="nopadding bariol-regular red-text" style="font-size: 18px;"><?= number_format($this->cart->total() + $uniq - $discount, 0, ',', ','); ?></span>
               </div>
               <button id="checkout" type="submit" name="submit" value="submit" class="btn blue waves-effect waves-light">pay now</button>
            </div>

         </div>
      </form>
   </div>
</div>

<div class="modal" id="update-address">
            <form action="checkout/update" method="post">
               <div class="row">
                  <div class="col m10 s12 offset-m1">
                     <div class="modal-content">
                        <h5><i class="fa fa-edit"></i> edit shipping address</h5>
                        <br />
                        <input type="hidden" name="id" value="<?php echo $idalamat;?>">
                        <div class="input-field">
                        <span class="nopadding">recipient's name</span><input type="text" name="receiver" value="<?php echo $nama1; ?>" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">phone number</span><input type="text" name="phone" value="<?php echo $telp; ?>" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">province</span><br><select class="select2" style="width: 100%;" name="prov" id="changeprov" required="required">
                              <option value="" disabled selected>select province</option>
                              <?php $this->load->view('prov'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">city</span><br>
                        <select name="kota" class="select2" style="width: 100%;" id="changekota" required="required">
                              <option value="" disabled>select city</option>
                              <?php $this->load->view('kabupaten'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">subdistrict</span><br>
                        <select name="subdistrict" class="select2" style="width: 100%;" id="changesubdistrict" required="required">
                              <option value="" disabled selected>select subdistrict</option>
                              <?php $this->load->view('kecamatan'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">postal code</span><input type="text" name="postal" value="<?php echo $kodepos; ?>" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">your address</span><textarea id="textarea1" class="materialize-textarea" name="address" required="required"><?php echo $alamat; ?></textarea>
                        </div>
                     </div>
                     <div class="right">
                        <button type="submit" name="submit" value="Submit" class="modal-action btn blue">save</button>
                     </div>
                  </div>
               </div>
            </form>
            <br>
         </div>

<div class="modal" id="add-address">
            <form action="checkout/add" method="post">
               <div class="row">
                  <div class="col m10 s12 offset-m1">
                     <div class="modal-content">
                        <h5><i class="fa fa-edit"></i> add shipping address</h5>
                        <br />
                        <div class="input-field">
                        <span class="nopadding">recipient's name</span><input type="text" name="receiver" value="" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">phone number</span><input type="text" name="phone" value="" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">province</span><br><select class="select2" style="width: 100%;" name="prov" id="addprov" required="required">
                              <option value="" disabled selected>select province</option>
                              <?php $this->load->view('prov'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">city</span><br><select id="addkota" class="select2" style="width: 100%;" name="kota" required="required">
                              <option value="" disabled selected>select city</option>
                              <?php $this->load->view('kabupaten'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="vpadding">subdistrict</span><br>
                        <select name="subdistrict" class="select2" style="width: 100%;" id="addsubdistrict" required="required">
                              <option value="" disabled selected>select subdistrict</option>
                              <?php $this->load->view('kecamatan'); ?>
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">postal code</span><input type="text" name="postal" value="" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">your address</span><textarea id="textarea2" class="materialize-textarea" name="address" required="required"></textarea>
                        </div>
                     </div>
                     <div class="right">
                        <button type="submit" name="submit" value="Submit" class="modal-action btn blue">save</button>
                     </div>
                  </div>
               </div>
            </form>
            <br>
         </div>
<div class="modal" id="change-address">
<style>
      /* Table */
      @media screen and (max-width: 520px) {
   table {
      width: 100%;
   }
   thead th.column-primary {
      width: 100%;
   }

   thead th:not(.column-primary) {
      display:none;
   }
   
   th[scope="row"] {
      vertical-align: top;
   }
   
   td {
      display: block;
      width: auto;
   }
   thead th::before {
      font-weight: bold;
      content: attr(data-header);
   }
   thead th:first-child span {
      display: none;
   }
   td::before {
      display: none;
      font-weight: bold;
      content: attr(data-header);
   }
}
thead th{
   text-align: left;
}
</style>
<form action="checkout/change" method="post">
<div class="row">
<div class="col s12">
<h3>change shipping address</h3>
   <?php
   if (!empty($address) && $address -> num_rows() >= 1) {
      ?>
   <table class="bariol-regular bordered" cellpadding="8">
<thead>
   <tr>
      <th scope="col" class="column-primary" data-header="Pelanggan"><span class="bariol-regular">recipient's name</span></th>
      <th scope="col">shipping address</th>
      <th scope="col">shipping destination</th>
      <th scope="col">postal code</th>
      <th scope="col" class="column-primary">option</th>
   </tr>
</thead>
<tbody>
   <?php
   foreach ($address->result() as $key) {
   $alamat = array();
   $kecamatan = explode(",",$key->kota);
   $kabupaten = explode(",",$key->kabupaten);
   $provinsi = explode(",",$key->provinsi);
   if (!empty($kecamatan[1])) {
      array_push($alamat, $kecamatan[1]);
   }
   if (!empty($kabupaten[1])) {
      array_push($alamat, $kabupaten[1]);
   }
   if (!empty($provinsi[1])) {
      array_push($alamat, $provinsi[1]);
   }
   $shipping = join(", ", $alamat);
   ?>
   <tr>
      <td data-header="recipient's name"><?php echo $key->nama; ?></td>
      <td data-header="address" ><?php echo $key->alamat; ?></td>
      <td data-header="destination" ><?php echo strtolower($shipping); ?></td>
      <td data-header="postal code"><?php echo $key->kodepos; ?></td>
      <th scope="row">
      <div class="toolbox left">
         <button type="submit" name="change" value="<?php echo $key->idalamat;?>" class="btn blue"><i class="fa fa-check"></i></button>
                  </div>
                  </th>
                     </tr>
                     <?php
                     }
                     echo "
                  </tbody>
                  </table>";
                     }
                     ?>
                  </div>
               </div>
            </form>
         </div>
</div>

<script>
$(document).ready(function() {
$('#btn_promo').click(function() {
   var ongkir = $('#ongkir').text();
   var coupon = $('#kupon').val();

   $.ajax({
      url: "<?=base_url();?>checkout/discount",
      method: "POST",
      data: { ongkir : ongkir, coupon : coupon },
      success: function(obj) {
         var hasil = obj.split(",,");

         $('#total').val(convertToRupiah(hasil[1]));
         var element = document.getElementById("totalbayar");
         var total = convertToRupiah(hasil[1]);
         element.innerHTML = total;
         document.getElementById("bayar").innerHTML   = total;
         document.getElementById("discount").innerHTML = convertToRupiah(hasil[0]);
         document.getElementById("text_coupon").innerHTML = hasil[2];
      }
   });
});
});
</script>
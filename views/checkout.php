<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row bariol-regular">
   <div class="col m10 s12 offset-m1">
      <h3><i class="fa fa-shopping-bag"></i> checkout</h3>
      <hr />
      <br />
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="" method="post">
         <div style="width: 49%; display: inline-block;">

            <div class="row">
               <div class="input-field col s12">
                  <input type="text" id="first_name" class="validate" name="first_name" value="<?php echo $nama1; ?>">
                  <label for="first_name">nama lengkap</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col  s12">
                  <input type="email" id="user_mail" name="user_mail" value="<?php echo $email; ?>" class="validate">
                  <label for="user_mail">email</label>
               </div>
            </div>

            <div class="row">
               <div class="col  s12">
                  <label>provinsi</label>
                  <select class="browser-default" name="prov" id="prov">
                     <option value="" disabled selected>-- pilih provinsi --</option>
                     <?php $this->load->view('prov'); ?>
                  </select>
               </div>
            </div>

            <div class="row">
               <div class="col  s12">
                  <label>pilih kota / kabupaten</label>
                  <select name="kota" class="browser-default" id="kota">
                     <option value="" disabled selected>-- kota / kabupaten --</option>
                     <option value="<?php echo $kabupaten[0].','.$kabupaten[1]; ?>" <?php if (!empty($kabupaten[0])) {
                        echo "selected";
                     } ?>><?php echo $kabupaten[1]; ?></option>
                  </select>
               </div>
            </div>

            <div class="row">
               <div class="input-field col  s12">
                  <input type="text" id="alamat" class="validate" name="alamat" value="<?php echo $alamat; ?>">
                  <label for="alamat">alamat</label>
               </div>
               <div class="input-field col s12">
                  <input type="number" id="kd_pos" class="validate" name="kd_pos" min="0" value="<?php echo $kodepos; ?>">
                  <label for="kd_pos">kode pos</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col  s12">
                  <input type="text" id="alamat" class="validate" name="telp" value="<?php echo $telp; ?>">
                  <label for="alamat">nomor telepon</label>
               </div>
            </div>

            <div class="row">
               <div class="col  s12">
                  <input style="width: 14px; height: 14px; background: #fff;" type="checkbox" name="saveprofil" value="save"><span>simpan profil saya</span>
               </div>
            </div>

            <div class="row col  s12">
               <div class="col s12">
                  <label>pilih kurir</label>
                  <select class="browser-default" name="kurir" id="kurir" style="margin-top:12px;">
                     <option value="">-- pilih kurir --</option>
                     <option value="pos">pos</option>
                     <option value="jne">jne</option>
                  </select>
               </div>
               <div class="col s12">
                  <label>pilih layanan</label>
                  <select class="browser-default" name="layanan" id="layanan" style="margin-top:12px;">
                     <option value="" disabled selected>pilih layanan</option>
                  </select>
               </div>
               <div style="margin-top: 18px;" class="col s12">
                  <label>buying notes</label>
                  <textarea style="padding: 12px; margin-top:12px; box-sizing: border-box; background:#fff; border:solid 1px #eee; height: 150px; resize: none;" class="validate" name="buyingnotes" placeholder="buying notes"></textarea>
               </div>
            </div>
</div>
<div style="display: inline-block; width: 49%; vertical-align: top;">

   <div class="row col s12" style="position: relative;">
                  <label>payment method</label>
                  <br><br>
                  <div style="min-height: 100px; max-height: 200px; background: #fff; padding: 12px;">
                     <p class="nopadding bariol-regular">bank transfer</p>
                     <label>
                     <input class="with-gap" name="bank" type="radio" value="bca" />
                     <span class="nopadding bariol-regular">bca transfer</span>
                     </label><br>
                     <label>
                     <input class="with-gap" name="bank" type="radio" value="mandiri" />
                     <span class="nopadding bariol-regular">mandiri transfer</span>
                     </label><br>
                     <label>
                     <input class="with-gap" name="bank" type="radio" value="bni" />
                     <span class="nopadding bariol-regular">bni transfer</span>
                     </label><br>
                  </div>
               </div>

            <div class="row col s12" style="position: relative;">
                  <label>detail pesanan</label>
                  <div style="min-height: 200px; max-height: 200px; overflow-y: scroll; background: #fff; padding: 12px;">
                     
                  </div>
                  <div style="padding: 12px; background: #fff; border-top:solid 1px #ddd;">
                        <span style="font-weight: bold; line-height: 24px;">ongkos kirim : </span><span>Rp. </span><span id="ongkir" class="nopadding" style="font-weight: bold; line-height: 24px;">0</span>
                        <input id="ongkos" type="hidden" name="ongkir" value="">
                  </div>
                  <div class="col s12 totalbayar right desktop" style="padding-top: 24px;">
                  <p class="nopadding bariol-regular center">total biaya</p>
                  <span class="nopadding bariol-regular red-text" style="font-size: 32px;">Rp </span>
                  <span id="totalbayar" class="nopadding bariol-regular red-text" style="font-size: 32px;"><?= number_format($this->cart->total(), 0, ',', ','); ?></span>
               </div>
               </div>

               <div style="clear: both;"></div>

            <hr>

            <div class="col  s12 left" style="text-align: center;">
               <p class="nopadding">dengan mengklik "bayar sekarang" anda menyetujui segala <a class="blue-text" href="syarat-dan-ketentuan">persyaratan dan ketentuan kami</a>.</p>
            </div>

            <div class="col m4 s12 right desktop" style="text-align: center;">
               <button type="submit" name="submit" value="submit" class="btn blue waves-effect waves-light">bayar sekarang</button>
            </div>

            <div id="tombol" class="right mobile">
               <div style="padding: 12px;">
                  <p class="nopadding bariol-regular">total bayar</p>
                  <span class="nopadding bariol-regular red-text" style="font-size: 18px;">Rp </span>
                  <span id="bayar" class="nopadding bariol-regular red-text" style="font-size: 18px;"><?= number_format($this->cart->total(), 0, ',', ','); ?></span>
               </div>
               <button id="checkout" type="submit" name="submit" value="submit" class="btn blue waves-effect waves-light">bayar sekarang</button>
            </div>

         </div>
      </form>
   </div>
</div>

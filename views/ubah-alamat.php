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
?>
<div class="row" style="min-height: 500px;">
   <div class="col m10 s12 offset-m1">
      <h3><i class="fa fa-user"></i> user profile</h3>
      <hr />
      <br />
      <?php $this->load->view('menuprofil'); ?>
      <script>
         document.getElementsByClassName('link-profil')[1].style.color = "#0af";
         document.getElementById('shipping').style.borderBottom = "solid 1px #0af";
      </script>
            <form action="" method="post" style="font-family: bariol_regular;">
               <div class="row">
                  <div style="padding: 12px; max-width: 600px;">
                     <div class="modal-content">
                        <h5><i class="fa fa-edit"></i> edit shipping address</h5>
                        <br />
                        <div class="input-field">
                        <span class="nopadding">recipient's name</span><input type="text" name="receiver" value="<?php echo $shipping->nama;?>" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">phone number</span><input type="text" name="phone" onkeypress="return isNumberKey(event)" value="<?php echo $shipping->phone;?>" required="required">
                        </div>
                        <div class="input-field" style="max-width:600px;">
                        <span class="nopadding">province</span>
                        <select class="browser-default select2" name="prov" id="prov" required="required">
                              <option value="">select province</option>
                              <?php $this->load->view('prov'); ?>
                           </select>
                        </div>
                        <div class="input-field" style="max-width:600px;">
                        <span class="nopadding">city</span>
                        <select name="kota" class="browser-default select2" id="kota" required="required">
                              <option value="" disabled selected>select city</option>
                              <?php $this->load->view('kabupaten'); ?>
                              <!--<option value="<?php echo $shipping->kabupaten;?>" selected><?php echo $kabupaten[1];?></option>-->
                           </select>
                        </div>
                        <div class="input-field" style="max-width:600px;">
                        <span class="nopadding">subdistrict</span>
                        <select name="subdistrict" class="browser-default select2" id="subdistrict" required="required">
                              <option value="" disabled selected>select subdistrict</option>
                              <?php $this->load->view('kecamatan'); ?>
                              <!--<option value="<?php echo $shipping->kota;?>" selected><?php echo $kecamatan[1];?></option>-->
                           </select>
                        </div>
                        <div class="input-field">
                        <span class="nopadding">postal code</span><input type="text" name="postal" value="<?php echo $shipping->kodepos;?>" required="required">
                        </div>
                        <div class="input-field">
                        <span class="nopadding">your address</span><textarea id="textarea1" class="materialize-textarea" name="address" required="required"><?php echo $shipping->alamat;?></textarea>
                        </div>
                     </div>
                     <br>
                     <div class="right btn-profil">
                        <button type="submit" name="change" value="change" class="modal-action btn">save</button>
                     </div>
                  </div>
                  <div style="clear:both;"></div>
                  <br><br>
               </div>
            </form>
         </div>
      </div>
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
      <div style="min-height: 550px; display: flex; position: absolute; top: 0; left: 0; right: 0; bottom:0; background: url('<?= base_url('img/login4.png'); ?>'); background-size: cover; background-position: center;">

         <div class="shadow login" style="margin:auto; padding: 12px 24px; background: rgba(255,255,255,0.7);border-radius:12px;">
            <div class="vpadding center">
               <?= validation_errors('<div class="alert alert-danger alert-message">', '</div>'); ?>
               <b style="font-size: 24px; font-family: bariol_regular;">reset passwod</b>
               <p class="vpadding bariol_regular">don't have an account ? <a style="color: #0af;" href="<?= site_url('home/registrasi'); ?>">sign up now</a></p>
            </div>
            <form action="" method="post">
               <div class="input-field">
                  <input type="password" class="validate" name="pass1">
                  <label for="password"><i class="fa fa-key"></i>&nbsp;new password</label>
               </div>
               <div class="input-field">
                  <input type="password" class="validate" name="pass2">
                  <label for="password"><i class="fa fa-key"></i>&nbsp;confirm new password</label>
               </div>
               <br><br><br>
               <div>
                  <button type="submit" name="submit" value="reset" class="blue bariol_regular white-text" style="padding: 18px 0px; border: none; border-radius: 12px; font-size:18px; width: 100%;">reset</button>
               </div>
               <br>
            </form>
            <div style="clear: both;"></div>
         </div>
      </div>
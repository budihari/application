<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo $script_captcha;
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
      <div style="min-height: 550px; padding-top: 24px; display: flex; position: absolute; top: 0; left: 0; right: 0; bottom:0; background: url('<?= base_url('img/login4.png'); ?>'); background-size: cover; background-position: center;">
         <div class="shadow login" style="margin:auto; padding: 12px 24px; background: rgba(255,255,255,0.7);border-radius:12px;">
            <div class="vpadding center">
               <div style="position: fixed; top: 54.5px; left: 0; right: 0; height: auto; background: #eee;">
               <?= validation_errors('<div class="alert-message" style="margin-bottom:6px; padding:6px;">', '</div>'); ?>
               </div>
               <b style="font-size: 24px; font-family: bariol_regular;">sign up</b>
               <p class="vpadding bariol_regular">already have an account ? <a style="color: #0af;" href="<?= site_url('home/login'); ?>">login here</a></p>
            </div>
            <form action="" method="post">
               <div class="input-field">
                  <input type="text" id="username" class="validate" name="user">
                  <label for="username"><i class="fa fa-user"></i>&nbsp;username</label>
               </div>
               <div class="input-field">
                  <input type="email" id="email" class="validate" name="email">
                  <label for="email"><i class="fa fa-envelope"></i>&nbsp;email</label>
               </div>
               <div class="input-field">
                  <input type="password" id="pass" class="validate" name="pass1">
                  <label for="pass"><i class="fa fa-key"></i>&nbsp;password</label>
               </div>
               <br><br>
               <div>
                  <button type="submit" name="submit" value="Submit" class="blue bariol_regular white-text" style="padding: 18px 0px; border: none; border-radius: 12px; font-size:18px; width: 100%;">sign up</button>
               </div>
               <br>
               <div>
                  <p class="bariol-regular center" style="line-height: 18px;">
                  by registering, i agree to the <a style="color: #0af;" href="<?= site_url('home/registrasi'); ?>">terms and<br>
                  conditions</a> and <a style="color: #0af;" href="<?= site_url('home/registrasi'); ?>">privacy policy</a> of this website</p>
               </div>
            </form>
            <div style="clear: both;"></div>
         </div>
      </div>
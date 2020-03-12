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
<div class="row">
   <div class="col m10 s12 offset-m1">
      <br>
      <h1 style="font-size:32px;"><i class="fa fa-user"></i> user profile</h1>
      <br />
      <?php $this->load->view('menuprofil'); ?>
      <script>
         document.getElementsByClassName('link-profil')[2].style.color = "#0af";
         document.getElementById('pass').style.borderBottom = "solid 1px #0af";
      </script>
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="" method="post">
         <div class="col s12">
        <div>
            <p>attention! you will have to log-in again once your password is successfully changed</p>
         </div>
            <div class="hpadding row">
               <div class="input-field" style="padding:0; max-width:500px;">
                  <input id="password" type="password" class="validate" name="pass1">
                  <label for="password">new password</label>
               </div>
            </div>

            <div class="hpadding row">
               <div class="input-field" style="padding:0; max-width:500px;">
                  <input id="password" type="password" class="validate" name="pass2">
                  <label for="password">retype new password</label>
               </div>
            </div>

            <div class="hpadding row">
               <div class="input-field" style="padding:0; max-width:500px;">
                  <input id="password" type="password" class="validate" name="pass3">
                  <label for="password">old password</label>
               </div>
            </div>
            <br />
            <div class="hpadding row btn-profil">
               <button type="submit" name="submit" style="width:105px;" value="submit" class="btn">submit</button>
               <button type="button" class="btn" style="width:105px;" onclick="window.history.go(-1)">back</button>
            </div>
            <br />
         </div>
      </form>
   </div>
</div>

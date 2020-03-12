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
         document.getElementsByClassName('link-profil')[0].style.color = "#0af";
         document.getElementById('biodata').style.borderBottom = "solid 1px #0af";
      </script>
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="" method="post">
         <div class="col s12" style="padding: 12px;">
            <br>
            <div class="vpadding">
               update your personal information
            </div>
            <div class="row">
               <table style="max-width: 500px; font-size: 14px; font-family: bariol_regular;">
                  <tr style="height:48px;">
                     <td>name</td><td><input id="first_name" type="text" class="validate" style="display: inline-block; box-sizing: border-box; width: 100%;" name="nama1" value="<?= $nama; ?>"></td>
                  </tr>
                  <tr style="height:48px;">
                     <td>email</td><td><input type="email" id="email" class="validate" name="email" value="<?= $email; ?>" disabled></td>
                  </tr>
                  <tr style="height:48px;">
                     <td>gender</td><td><div class="">
                     <label>
                        <input class="with-gap" name="jk" type="radio" value="L" <?php if ($jk == "L") {
                           echo "checked";
                        } ?> />
                        <span class="nopadding" style="padding-left: 24px;">male</span>
                     </label>&nbsp;
                     <label>
                        <input class="with-gap" name="jk" type="radio" value="P" <?php if ($jk == "P") {
                           echo "checked";
                        } ?> />
                        <span class="nopadding" style="padding-left: 24px;">female</span>
                     </label>
               </div></td>
                  </tr>
                  <tr style="height:48px;">
                     <td>phone</td><td><input id="telp" type="text" class="validate" name="telp" onkeypress="return isNumberKey(event)" value="<?= $telp; ?>"></td>
                  </tr>
                  <tr style="height:48px;">
                     <td>verify your password</td><td><input id="password" type="password" class="validate" name="pass" value="" autocomplete="off"></td>
                  </tr>
               </table>
            </div>
            <br>
            <div class="row btn-profil">
               <button type="submit" style="width:105px;" name="submit" value="Submit" class="btn">submit</button>
               <button type="button" style="width:105px;" onclick="window.history.go(-1)" class="btn">back</button>
            </div>
            <br>
         </div>
      </form>
   </div>
</div>

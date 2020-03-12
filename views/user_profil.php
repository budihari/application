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
      <h3><i class="fa fa-user"></i> user profil</h3>
      <hr />
      <br />
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="" method="post">
         <div class="col s12">
            <div class="row">
               <div class="input-field col m6 s12">
                  <input id="first_name" type="text" class="validate" name="nama1" value="<?= $nama1; ?>">
                  <label for="first_name">nama depan</label>
               </div>
               <div class="input-field col m6 s12">
                  <input id="last_name" type="text" class="validate" name="nama2" value="<?= $nama2; ?>">
                  <label for="last_name">nama belakang</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <input type="text" id="username" class="validate" name="user" value="<?= $user; ?>" readonly="readonly">
                  <label for="username">username</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <input type="email" id="email" class="validate" name="email" value="<?= $email; ?>" readonly="readonly">
                  <label for="email">e-mail</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <label>jenis kelamin</label>
                  <br/>
                  <p>
                     <input class="with-gap" value="L" type="radio" id="lk" name="jk" <?php if ($jk == 'L') { echo 'checked'; } ?>/>
                     <label for="lk">laki-laki</label>
                     <input class="with-gap" value="P" type="radio" id="pr" name="jk" <?php if ($jk == 'P') { echo 'checked'; } ?>/>
                     <label for="pr">perempuan</label>
                  </p>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <input id="telp" type="number" class="validate" name="telp" value="<?= $telp; ?>">
                  <label for="telp">telp</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <select class="browser-default" name="prov" id="prov">
                     <option value="">-- pilih provinsi --</option>
                     <?php $this->load->view('prov'); ?>
                  </select>
                  
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <select name="kota" class="browser-default" id="kota">
                     <option value="">-- kota / kabupaten --</option>
                     <option value="<?php echo $kabupaten[0].','.$kabupaten[1] ;?>" selected><?php echo $kabupaten[1] ;?></option>
                  </select>
                  
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <textarea id="alamat" class="materialize-textarea" name="alamat"><?= $alamat; ?></textarea>
                  <label for="alamat">alamat</label>
               </div>
            </div>

            <div class="row">
               <div class="input-field col s12">
                  <input id="password" type="password" class="validate" name="pass" value="" autocomplete="off">
                  <label for="password">masukkan password anda</label>
               </div>
            </div>

            <div class="row right">
               <button type="submit" name="submit" value="Submit" class="btn blue waves-effect waves-light">submit <i class="fa fa-paper-plane"></i></button>
               <button type="button" onclick="window.history.go(-1)" class="btn red waves-effect waves-light">kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>

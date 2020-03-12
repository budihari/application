<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
if ($cond == "success") {
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
<div style="background:#fff; border:1px solid #f4f4f4; text-align: center; padding: 32px 0px;">
<h3 style="color:#202020">congratulations<br>your account is now active :)</h3>
<img src="<?= base_url();?>img/success.png" style="width: 100%; max-width: 150px;">
<p style="font-size:20px">thank you for verifying your email.</p>
<br />
<center><a href="<?= site_url('home/login'); ?>" style="background: rgba(10,42,59,1);" class="waves-effect waves-light btn-success white-text">login</a></center>
</div>
<?php
}
else{
?>
<div style="background:#fff; border:1px solid #f4f4f4; text-align: center; padding: 32px 0px;">
<h3 style="color:#202020">verification failed</h3>
<img src="<?= base_url();?>img/cancel.png" style="width: 100%; max-width: 150px;">
<p></p>
<br>
<center><a href="<?= site_url('home'); ?>" style="background: rgba(10,42,59,1);" class="waves-effect waves-light btn-success white-text">back to home</a></center>
</div>
<?php
}
?>
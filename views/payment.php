<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?= validation_errors('<p style="color:red">','</p>'); ?>
<div class="max-width-1140">
<?php

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
<style>
.fileUpload {
    position: relative;
    margin: 10px;
    margin-left:0px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<div style="padding: 12px 12px 18px 12px;">
<a href="<?= site_url(); ?>">home</a> > <span class="nopadding" style="color: #0af;">payment confirmation</span>
</div>
<div class="left">
  <h4>payment confirmation</h4>
</div>
<div style="clear: both;"></div>
<hr class="nomargin">
<br>
<p>please make sure the order ID is correct</p>
<div class="hpadding">
<form id="form" action="" method="post" enctype="multipart/form-data">
<table style="max-width: 700px;">
   <tr>
      <td style="min-width:80px;">order id</td><td><input type="text" name="id" value="<?php echo $id_order;?>"></td>
   </tr>
   <tr>
      <td>payment date</td><td><input type="date" name="date" max="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"></td>
   </tr>
   <tr>
      <td>sender name</td><td><input type="text" name="sender" value=""></td>
   </tr>
   <tr>
      <td>amount transferred</td><td><input id="amount" type="text" name="amount" value=""></td>
   </tr>
   <tr>
      <td>bank</td><td>
      <select id="selectbank" name="originbank" class="browser-default transparent" onchange="mybank()">
      <option value="">select bank</option>
      <option value="bca">BCA</option>
      <option value="mandiri">Mandiri</option>
      <option value="bri">BRI</option>
      <option value="others">others</option>
      </select>
      <input type="text" id="inputbank" name="a" value="" style="display: none;">
      <input type="hidden" name="tobank" value="bca">
   </td>
   </tr>

   <tr style="height: 48px;">
      <td>receipt file</td><td>
      <div style="display: flex;">
      <div class="fileUpload btn blue">
         <span>select</span>
         <input id="uploadBtn" type="file" name="file" class="upload" />
      </div>
      <input id="uploadFile" style="width:100%;" type="text" name="nothing" placeholder="Pilih File..." disabled="disabled" />
      </div>
      </td>
   </tr>
   <tr>
      <td colspan="2"><hr></td>
   </tr>
   <tr>
      <td></td><td class="right"><button class="btn blue nomargin" name="submit" value="Submit">submit</button></td>
   </tr>
</table>
</form>
<br><br>
</div>
</div>

<script>
$(document).ready(function() {
//change upload
document.getElementById("uploadBtn").onchange = function () {
document.getElementById("uploadFile").value = this.value;
};
});
</script>
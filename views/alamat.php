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
      <br>
      <h1 style="font-size:32px;"><i class="fa fa-user"></i> user profile</h1>
      <br />
      <?php $this->load->view('menuprofil'); ?>
      <script>
         document.getElementsByClassName('link-profil')[1].style.color = "#0af";
         document.getElementById('shipping').style.borderBottom = "solid 1px #0af";
      </script>
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
.add-shipping{
    background:#005;
}
.add-shipping:hover{
    background: #2196F3;
}
thead th{
   text-align: left;
}
</style>
<?= validation_errors('<p style="color:red">', '</p>'); ?>
<br>
<a href="#add-address"><button type="button" class="btn add-shipping" style="border-radius: 4px;">add shipping address</button></a>
<div class="modal" id="add-address" style="max-width:600px;">
            <form action="" method="post">
               <div class="row">
                  <div>
                     <div class="modal-content">
                        <h5><i class="fa fa-edit"></i> add shipping address</h5>
                        <br />
                        <div class="input-field" style="max-width:300px;">
                        <span>recipient's name</span><input type="text" name="receiver" value="" required="required">
                        </div>
                        <div class="input-field" style="max-width:300px;">
                        <span>phone number</span><input type="text" name="phone" value="" onkeypress="return isNumberKey(event)" required="required">
                        </div>
                        <div class="input-field" style="max-width:300px;">
                        <span class="vpadding">province</span><br>
                        <select class="select2" style="width: 100%;" name="prov" id="prov" required="required">
                              <option value="" disabled selected>select province</option>
                              <?php $this->load->view('prov'); ?>
                           </select>
                        </div>
                        <div class="input-field" style="max-width:300px;">
                        <span class="vpadding">city</span><br>
                        <select name="kota" class="select2" style="width: 100%;" id="kota" required="required">
                              <option value="" disabled selected>select city</option>
                              <option value=""></option>
                           </select>
                        </div>
                        <div class="input-field" style="max-width:300px;">
                        <span class="vpadding">subdistrict</span><br>
                        <select name="subdistrict" class="select2" style="width: 100%;" id="subdistrict" required="required">
                              <option value="" disabled selected>select subdistrict</option>
                              <?php $this->load->view('kecamatan'); ?>
                              <!--<option value="<?php echo $shipping->kota;?>" selected><?php echo $kecamatan[1];?></option>-->
                           </select>
                        </div>
                        <div class="input-field" style="max-width:150px;">
                        <span>postal code</span><input type="text" name="postal" value="" required="required">
                        </div>
                        <div class="input-field" style="max-width:300px;">
                        <span>your address</span><textarea id="textarea1" class="materialize-textarea" name="address" required="required"></textarea>
                        </div>
                        <br>
                        <div class="right">
                        <button type="submit" name="submit" value="Submit" class="modal-action btn blue">save</button>
                        </div>
                     </div>
                     <br><br>
                  </div>
               </div>
            </form>
         </div>
<br><br>
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
   if ($shipping -> num_rows() >= 1) {
      # code...
   foreach ($shipping->result() as $key) {
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
            <button style="border-radius: 4px;" onclick ="document.location = '<?= base_url();?>home/shipping/ubah/<?php echo $key->idalamat; ?>'" class="btn blue"><i class="fa fa-pencil-square-o"></i></button>
            <form action="" method="post" style="display: inline-block;">
            <button type="submit" name="hapus" value="<?php echo $key->idalamat; ?>" class="btn" style="background: rgba(10,42,59,1);border-radius: 4px;" onclick="return confirm('apakah anda yakin Ingin menghapus alamat ini?')"><i class="fa fa-close"></i></button>
            </form>
         </div>
      </th>
   </tr>
   <?php
   }
   echo "
</tbody>
</table>";
   }
   else{
echo "
</tbody>
</table>";
      ?>
   <div style="min-height: 200px; display: flex;">
      <div style="text-align: center; margin: auto;">you have not added the shipping address</div>
   </div>
   <?php
   }
   ?>
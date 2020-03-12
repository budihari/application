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
<style>
   table th{
      text-align: left;
   }
   table tr th{
      padding: 8px;
   }
   table tr td{
      padding: 18px 12px;
   }
</style>
<div class="row" style="min-height: 500px;">
   <div class="col m10 s12 offset-m1">
      <br>
      <h1 style="font-size:32px;"><i class="fa fa-user"></i> user profile</h1>
      <br />
      <?php $this->load->view('menuprofil'); ?>
      <script>
         document.getElementsByClassName('link-profil')[4].style.color = "#0af";
         document.getElementById('payment').style.borderBottom = "solid 1px #0af";
      </script>
<br>

   <?php
   if ($payment -> num_rows() >= 1) {
   ?>
   <div style="max-width: 100%; overflow-x: scroll;">
   <table class="bariol-regular bordered" style="min-width: 1000px;">
   <thead>
   <tr>
      <th scope="col" class="column-primary" data-header="payment detail"><span class="bariol-regular">payment id</span></th>
      <th scope="col">order id</th>
      <th scope="col">payment date</th>
      <th scope="col">sender name</th>
      <th scope="col">origin bank</th>
      <th scope="col">to bank</th>
      <th scope="col">payment amount</th>
      <th scope="col">proof of payment</th>
      <th class="column-primary">status</th>
   </tr>
   </thead>
   <tbody>
   <?php
   foreach ($payment->result() as $key) {
   ?>
   <tr>
      <td data-header="payment id : "><?php echo $key->idpembayaran; ?></td>
      <td data-header="order id : "><a href="<?=site_url('home/detail_transaksi/'.$key->id_order)?>" class="blue-text"><?= $key->id_order; ?></a></td>
      <td data-header="payment date : "><?= date("d - m - Y", strtotime($key->tgl_pembayaran)); ?></td>
      <td data-header="sender name : "><?php echo $key->namapengirim; ?></td>
      <td data-header="origin bank : "><?php echo $key->bank_asal; ?></td>
      <td data-header="to bank : "><?php echo $key->bank_tujuan; ?></td>
      <td data-header="jumlah transfer : ">Rp <?= number_format($key->jumlah_transfer, 0, ',', '.') ?></td>
      <td data-header="proof of payment : "><a href="<?php echo base_url().'assets/bukti/'.$key->bukti;?>" target="blank">view proof of payment</a></td>
      <th scope="row"><div class="toolbox left"><?php echo $key->status; ?></div></th>
   </tr>
   <?php
   }
   echo "
</tbody>
</table>
</div>";
   }
   else{

      ?>
   <div style="min-height: 300px; display: flex;">
      <div style="text-align: center; margin: auto;">no payments at the moment</div>
   </div>
   <?php
   }
   ?>
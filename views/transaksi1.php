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
         document.getElementsByClassName('link-profil')[3].style.color = "#0af";
         document.getElementById('order').style.borderBottom = "solid 1px #0af";
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
thead th{
   text-align: left;
   font-weight: 100;
}
</style>
<br>
   <?php
   if ($get -> num_rows() > 0) {
   ?>
   <table class="bariol-regular bordered" cellpadding="8">
   <thead>
   <tr>
      <th scope="col" class="column-primary" data-header="detail"><span class="bariol-regular">order id</span></th>
      <th scope="col">order date</th>
      <th scope="col">due date of payment</th>
      <th scope="col">total amount</th>
      <th scope="col">status</th>
      <th scope="col" class="column-primary">invoice</th>
   </tr>
   </thead>
   <tbody>
   <?php
   foreach ($get->result() as $key) {
   $total = $key->total;
   ?>
   <tr>
      <td data-header="order id"><a href="<?=site_url('home/detail_transaksi/'.$key->id_order)?>" class="blue-text"><?= $key->id_order; ?></a></td>
      <td data-header="order date"><?= date("d - m - Y", strtotime($key->tgl_pesan)); ?></td>
      <td data-header="order date"><?= date("d - m - Y", strtotime($key->bts_bayar)); ?></td>
      <td data-header="total amount" >Rp <?= number_format($total, 0, ',', '.') ?></td>
      <td data-header="status"><?php
                  $batas = (abs(strtotime($key->bts_bayar)));
                  $today = (abs(strtotime(date("Y-m-d"))));

                  if ($today > $batas && $key->status_proses == 'not paid') {
                     echo 'expired';
                     $t_order = array (
                        'status_proses' => "expired"
                     );
                     $this->db->update('t_order', $t_order, ['id_order' => $key->id_order]);
                  } else {
                     echo $key->status_proses;
                  }
                  ?></td>
      <th scope="row">
         <div class="toolbox left" style="overflow: hidden;">
            <button style="border-radius:4px;" onclick ="document.location = '<?= base_url();?>home/detail_transaksi/<?php echo $key->id_order; ?>'" class="btn blue">view invoice</button>
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
      ?>
   <div style="min-height: 300px; display: flex;">
      <div style="text-align: center; margin: auto;">no orders at the moment</div>
   </div>
   <?php
   }
   ?>
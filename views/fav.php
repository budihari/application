<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
   <div class="col s12 l4 m6 offset-l4 offset-m3">
      <?php
      //tampilkan pesan gagal
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo '<center>'.$this->session->flashdata('alert').'</center>';
         echo '</div>';
      }
      //tampilkan pesan success
      if ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      ?>
   </div>
   <div class="col s12 l12 m12">
      <h4>Item Favorite Anda</h4>
      <hr />
      <?php
      if ($data->num_rows() < 1)
      {
         echo '<h5>Anda Belum menambahkan item ke daftar favorite anda</h5>';
         echo '<br /><br /><br /><br />';
         echo '<center>';
         echo '<a href="'.site_url('home').'" class="myLink"><i class="fa fa-home"></i> Back to Home</a>';
         echo '</center>';
      }
      ?>
      <div class="row">
         <?php
         //masukkan id_item ke variabel array favorite
         if (isset($fav) && $fav->num_rows() > 0) {

            foreach ($fav->result() as $f) :

               $favorite[] = $f->id_item;

            endforeach;

         }
         ?>
         <?php foreach($data->result() as $key) : ?>
            <div class="col s12 m6 l3">
               <div class="card medium">
                  <div class="card-image">
                     <a href="<?= site_url('home/detail/'.$key->link); ?>">
                        <img src="<?= base_url('assets/upload/'.$key->gambar); ?>" class="responsive-img">
                        <span class="card-title"><?= $key->nama_item; ?></span>
                     </a>
                  </div>
                  <p class="harga">
                     Rp. <?= number_format($key->harga, 0, ',', '.'); ?>,-
                  </p>
                  <div class="card-action center">
                     <form action="<?= site_url('cart/add/'.$key->link); ?>" method="post">
                        <div class="left">
                           <?php
                           if ($this->cart->contents())
                           {
                              foreach ($this->cart->contents() as $cart) {
                                 $stok = ($cart['id'] == $key->id_item) ? ($key->stok - $cart['qty']) : $key->stok;
                              }
                           } else {
                              $stok = $key->stok;
                           }

                           if ($stok >= 10)
                           {
                              echo 'Stok : <span class="badge green white-text">'.$stok.'</span>';
                           } elseif ($stok < 10 && $stok > 0) {
                              echo 'Stok : <span class="badge orange white-text">'.$stok.'</span>';
                           } else {
                              echo 'Stok : <span class="badge red white-text">Habis</span>';
                           }
                           ?>
                        </div>
                        <input type="number" name="qty" value="1" min="1" max="<?= $key->stok; ?>" <?php if ($key->stok < 1) { echo 'disabled'; }?>>

                        <a href="<?= site_url('home/detail/'.$key->link); ?>" class="waves-effect waves-light btn blue white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lihat Detail">
                           <i class="fa fa-search-plus"></i>
                        </a>

                        <button type="submit" class="waves-effect waves-light btn green white-text tooltipped" name="submit" value="Submit" <?php if ($key->stok < 1) { echo 'disabled'; } ?> data-position="bottom" data-delay="50" data-tooltip="Tambah ke Keranjang">
                           <i class="fa fa-shopping-cart"></i>
                        </button>

                        <?php
                        if (isset($fav) && $fav->num_rows() > 0) {
                           if (in_array($key->id_item, $favorite))
                           {
                              $tooltip = 'Hapus dari Favorite';
                              $icon    = '<i class="fa fa-heart"></i>';
                           } else {
                              $tooltip = 'Tambah ke Favorite';
                              $icon    = '<i class="fa fa-heart-o"></i>';
                           }
                        } else {
                           $tooltip = 'Tambah ke Favorite';
                           $icon    = '<i class="fa fa-heart-o"></i>';
                        }
                        ?>

                        <a href="<?= site_url('home/favorite/'.$key->link); ?>" class="waves-effect waves-light btn pink white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?= $tooltip; ?>">
                           <?= $icon; ?>
                        </a>
                     </form>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</div>

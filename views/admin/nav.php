<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$profile = $profil->row();
?>
<div class="col-md-3 left_col">
   <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
         <a href="<?= base_url(); ?>administrator" class="site_title"><i class="fa fa-shopping-cart"></i> <span><?= $profile->title; ?></span></a>
      </div>

      <div class="clearfix"></div>

      <br />
      <?php
      if ($this->session->userdata('level_admin') == '11'){
      ?>
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
         <div class="menu_section">
            <ul class="nav side-menu">
               <li>
                  <a href="<?= site_url('administrator'); ?>"><i class="fa fa-home"></i> Home</a>
               </li>
               <li>
                  <a href="<?= site_url('item'); ?>"><i class="fa fa-cubes"></i> Manajemen Item</a>
               </li>
               <li>
                  <a href="<?= site_url('tag'); ?>"><i class="fa fa-tags"></i> Manajemen Kategori</a>
               </li>
               <li>
                  <a href="<?= site_url('banner'); ?>"><i class="fa fa-television"></i> Manajemen Banner</a>
               </li>
               <li>
                  <a href="<?= site_url('administrator/kupon'); ?>"><i class="fa fa-ticket"></i> Manajemen Kupon</a>
               </li>
               <li>
                  <a href="<?= site_url('transaksi'); ?>"><i class="fa fa-exchange"></i> Transaksi</a>
               </li>
               <li>
                  <a href="<?= site_url('pembayaran'); ?>"><i class="fa fa-money"></i> Pembayaran</a>
               </li>
               <li>
                  <a href="<?= site_url('user'); ?>"><i class="fa fa-users"></i> Manajemen User</a>
               </li>
               <li>
                  <a href="<?= site_url('transaksi/report'); ?>"><i class="fa fa-book"></i> Laporan</a>
               </li>
               <li>
                  <a href="<?= site_url('setting'); ?>"><i class="fa fa-cogs"></i> Setting</a>
               </li>
            </ul>
         </div>

      </div>
      <!-- /sidebar menu -->
      <?php
      }
      elseif ($this->session->userdata('level_admin') == '21'){
      ?>
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
         <div class="menu_section">
            <ul class="nav side-menu">
               <li>
                  <a href="<?= site_url('administrator'); ?>"><i class="fa fa-home"></i> Home</a>
               </li>
               <li>
                  <a href="<?= site_url('transaksi'); ?>"><i class="fa fa-exchange"></i> Transaksi</a>
               </li>
               <li>
                  <a href="<?= site_url('pembayaran'); ?>"><i class="fa fa-money"></i> Pembayaran</a>
               </li>
               <li>
                  <a href="<?= site_url('transaksi/report'); ?>"><i class="fa fa-book"></i> Laporan</a>
               </li>
            </ul>
         </div>

      </div>
      <!-- /sidebar menu -->
      <?php
      }
      ?>
   </div>
</div>

   <!-- top navigation -->
   <div class="top_nav">
      <div class="nav_menu">
         <nav class="" role="navigation">
            <div class="nav toggle">
               <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
               <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                     <i class="fa fa-user"></i> Administrator
                     <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                     <li>
                        <a href="<?= site_url('administrator/edit_profil'); ?>">
                           Update Profile
                        </a>
                     </li>
                     <li>
                        <a href="<?= site_url('administrator/update_password'); ?>">
                           Ganti Password
                        </a>
                     </li>
                     <li>
                        <a href="<?= site_url('login/logout'); ?>">
                           <i class="fa fa-sign-out pull-right"></i> Log Out
                        </a>
                     </li>
                  </ul>
               </li>
               <?php
                  if($this->session->userdata('level_admin') == '11'){
               ?>
               <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                     <i class="fa fa-envelope"></i> Pesan
                     <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right" style="overflow-x: hidden;">
                     <?php
                     $query = "SELECT * FROM pesan ORDER BY tgl DESC LIMIT 3";
                     $cek = $this->db->query($query);
                     foreach($cek->result() as $pesan) :
                     ?>
                     <li>
                        <a href="<?= base_url('user/detail_pesan/').$pesan->idpesan; ?>">
                           <?php
                           echo "<span style='white-space:normal; display:-webkit-box; overflow:hidden; -webkit-line-clamp:1; -webkit-box-orient:vertical;'>".$pesan->nama." (".$pesan->subject.")</span>
                           <span style='white-space:normal; display:-webkit-box; overflow:hidden; -webkit-line-clamp:2; -webkit-box-orient:vertical;'>".$pesan->pesan."</span>
                           <span>".$pesan->tgl."</span>";
                           ?>
                        </a>
                     </li>
                     <?php
                     endforeach;
                     ?>
                     <li style="position: sticky; bottom:0px; text-align:center;">
                        <a href="<?=base_url('user/pesan')?>">Lihat Semua</a>
                     </li>
                  </ul> 
               </li>
                     <?php
                  }
                     ?>
            </ul>
         </nav>
      </div>
   </div>
<!-- /top navigation -->

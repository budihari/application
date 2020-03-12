<div class="max-width-1140">
<?php
if ($data->num_rows() > 0)
{
    $last = $this->uri->total_segments();
    $lasturl = strlen($this->uri->segment($last));
    $lasturi = $this->uri->segment($last);
          ?>
        <div style="padding: 12px 12px 18px 12px;">
        <a href="<?= site_url(); ?>">home</a> > <span class="nopadding" style="color: #0af;">wishlist</span>
        </div>
        <div class="left">
          <h4>wishlist</h4>
        </div>
        <?php
        /*
        <div class="col m2 s12 right">
          <form action="" method="get">
          <select class="browser-default" name="sort" onchange="submit()">
              <option value="" disabled selected>-- urutkan berdasarkan --</option>
              <option value="nama_item,asc">abjad (a-z)</option>
              <option value="nama_item,desc">abjad (z-a)</option>
              <option value="harga,asc">harga termurah</option>
              <option value="harga,desc">harga termahal</option>
              <option value="">terlaris</option>
          </select>
          </form>
        </div>
        */
        ?>
        <div style="clear: both;"></div>
        <hr class="nomargin">
        <br>
        
        <div class="row">
 <?php
 if (isset($fav) && $fav->num_rows() > 0) {
    foreach ($fav->result() as $f) :
       $favorite[] = $f->id_item;
    endforeach;
 }
 ?>
<?php
//if (isset($search) || isset($url)) {
echo '<div class="hpadding" style="position: relative; text-align:left;">';
$urut=1;
foreach ($data->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
    $nama1 = str_replace("|","/",$nama[1]);
}
?>
  <div id="listproduk" class="listproduk" style="background: #fff; min-height: 150px;text-align: center; margin-top: 4px;">
                <div style="height: 150px; display: flex; cursor:pointer;" onclick="loading(), document.location='<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>'"><img style="margin:auto; max-width: 120px;max-height: 120px;" src="<?php echo base_url('assets/product/'.$foto);?>"></div>
                <a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><p style="font-family: bariol_regular; line-height: 20px; overflow-y: hidden; height: 58px;"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px;'>".strtolower($nama1);?></span></p></a><br>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b class="black-text bariol-regular"><?= 'Rp '.number_format($row->harga, 0, ',', ','); ?></b>
            </div>
<?php
/*
            <div style="width: 200px; background: #fff; min-height: 150px;margin-right:12px; display: inline-block; text-align: center; padding-top: 12px;">
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/upload/'.$foto);?>" alt="<?php echo base_url('assets/upload/'.$foto);?>" style="width: 150px;"></a></div>
                <p><?php echo $row->nama_item;?></p>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i><br>
                <b><?= 'Rp. '.number_format($row->harga, 0, ',', '.').',-'; ?></b>
            </div>
<?php
*/
}
echo '</div>';
//}
?>
<div class="right" style="padding: 12px; text-align:right;">
<?php
if($lasturl <= 5 && is_numeric($lasturi)){
    $count = $lasturi + 1;
    $count1 = $lasturi + 24;
    if($count1 > $total_row){
        $count1 = $total_row;
    }
}
else{
    $count = 1;
    $count1 = 24;
    if($count1 > $total_row){
        $count1 = $total_row;
    }
}
echo '<p>displaying products '.$count.' - '.$count1.' of '.$total_row.' in total</p>';
?>
<?=$link;?>
</div>
</div>
<?php
      } else {
          ?>
          <div style="padding: 12px 12px 18px 12px;">
          <a href="<?= site_url(); ?>">home</a> > <span class="nopadding" style="color: #0af;">wishlist</span>
          </div>
          <h4>wishlist</h4><hr class="nomargin">
          <br>
          <div style="display: flex; min-height: 300px;">
               <div style="margin: auto; text-align: center;">
                <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>">
                 <p>you have not added a wishlist</p>
                 <div id="btncari" class="btn white-text black bariol-regular" onclick="cari()">search others products</div>
               </div>
            </div>
<?php
}
?>
<br>
</div>
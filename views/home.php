<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">

   <div>
      <?php
       if (!isset($search) && !isset($url)){
        $kat = $kategori->row();
         ?>
         <div style="">
        <!--start jssor-->
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        </div>
        <div data-u="slides" class="slide" style="cursor:default;position:absolute;top:0px;left:0px;width:1300px;height: 500px;">
            <div>
            <img style="width:100%;" src="img/1.jpg" alt="slide1"/>
            </div>
            <div>
            <img style="width:100%;" src="<?=base_url();?>img/2.jpg" alt="slide2"/>
            </div>
             <div>
            <img style="width:100%;" src="<?=base_url();?>img/3.jpg" alt="slide3"/>
            </div>
            <?php
                $this->db->order_by('id', 'ASC');
                $cek = $this->db->get_where('banner', ['kategori' => 'home']);
                foreach($cek->result() as $banner){
                    ?>
                    <div>
                    <a href="<?php echo $banner->url;?>"><img style="width:100%;" src="<?php echo base_url('assets/upload/banner/') . $banner->gambar;?>" alt="<?php echo '';?>"/></a>
                    </div>
                    <?php
                }
            ?>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:50px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:13px;height:13px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" style="position:absolute; padding:12px; top:0px; left:8px; z-index:2; cursor:pointer; font-family:bariol_regular; font-size:32px; color:#fff; text-shadow: 0 0 3px #000000;" data-autocenter="2"><i class="fa fa-angle-left"></i></span>
        <span data-u="arrowright" style="position:absolute; padding:12px; top:0px; right:8px; z-index:2; cursor:pointer; font-family:bariol_regular; font-size:32px; color:#fff; text-shadow: 0 0 3px #000000;" data-autocenter="2"><i class="fa fa-angle-right"></i></span>
        </div>
        <script type="text/javascript">jssor_1_slider_init();</script>
        <!-- #endregion Jssor Slider End -->
        </div>
<?php
if($kat->masterkategori == "water pumps"){
?>
<style>
@media (min-width:768px) and (max-width:1200px){
    .listkategori {
        display: inline-block;
        width: calc(20% - 16px);
    }
}
</style>
<?php
}
?>
        <div class="background-white">
        <div class="content">
         <div style="padding: 24px 12px 12px 12px;">
         <h1 class="nopadding" style="font-size:18px; margin: 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">our products</h1>
         </div>
         <div style="padding: 0px 12px; position:relative;">
         <?php
         $x = 0;
         echo '<div class="flex" style="position:relative;">';
         $count = $kategori->num_rows() - 1;
         $margin = "";
         foreach ($kategori->result() as $kat):
          if ($x == $count) {
            $margin = "margin-right:0px;";
          }
          $skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id))->row();
          echo '
         <div class="discover" style="position:relative; display:inline-block;'.$margin.'"';?> onclick="myFunction('<?php echo $kat->masterkategori;?>', '<?php echo $x;?>')"><?php echo '<img style="width:100%;" src="'.base_url().'img/'.$kat->gambar.'" alt="'.$kat->masterkategori.'">
         <p style="font-family:bariol_regular; padding:12px 0px; text-align:center;">'.$kat->masterkategori.'</p>
         </div>';
         $x++;
       endforeach;
       echo '</div>';
       foreach ($kategori->result() as $kat):
          $skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id));
          if ($kat->masterkategori == "water filters") {
            $width = "max-width:600px;";
            $class = "subkategori";
          }
          elseif($kat->masterkategori == "water pumps") {
              $width = "max-width:900px;";
              $class = "";
              $lkwidth = "calc()";
          }
          else{
              $width = "max-width:800px;";
              $class = "";
          }
          echo '
          <div id="'.$kat->masterkategori.'" class="kategori" style="background:#fff; display:none;">
          <div class="subkategori" style="padding:12px; text-align:center; '.$width.' margin:auto;">';
         foreach ($skategori->result() as $sk):
          $kategori = str_replace(" ", "-", $kat->link);
          echo '
          <div class="listkategori" style="text-align:center; vertical-align:top; display:inline-block;"';?> onclick="loading(), document.location='<?php echo base_url().$kategori."/".$sk->url;?>'"<?php echo '>
          <div style="display:flex; height:80px; padding-top:12px;"><img style="margin:auto; max-width:100%; max-height:100%;" src="'.base_url().'assets/upload/kategori/'.$sk->foto_kategori.'" alt="'.$sk->kategori.'"></div>
          <div style="min-height:40px; display:flex;">
          <p class="text-kategori" style="padding:6px; margin:auto; max-height:36px; overflow:hidden;">'.$sk->kategori.'</p>
          </div>

          </div>
          ';
         endforeach;
         echo '
         </div>
         </div>';
       endforeach;
       ?>
<?php
/*
<svg style="position: absolute;" width="100%" height="100%">
<polygon points="0,0 0,400 400,400 200,0" style="fill:rgba(50,50,50,0.5);stroke-width:5;" />
Sorry, your browser does not support inline SVG.
</svg>
  <div style="margin:auto 0px; font-family: bariol_regular; color: white; padding: 12px 24px; z-index: 9;">
   <span style="font-size:24px; padding: 0;">Luxury Bath & Kitchen</span><br>
   <strong style="font-size: 32px;">Designer Pick</strong> 
   <p></p>
   <a style="padding: 6px 12px; color: #fff; border:solid 1px #fff;" href="">CHECK NOW -></a>
 </div>
*/
echo '
</div>
         ';
       }
      //tampilkan pesan gagal
      echo '<div style="position:fixed; z-index:9; top:54px; left:0; right:0;">';
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
      echo '</div>';
      //tampilkan header kategori
      if ($data->num_rows() > 0)
      {
?>
<hr style="border:solid 0.5px transparent">
</div>
</div>
<div class="content">
<div style="padding: 0px 12px;">
<h2 class="nopadding" style="font-size:18px; padding: 8px 0px; margin: 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">best seller</h2>
</div>
<div class="select-model random-produk">
<div class="previus" onclick="previus('best-seller')"><span> < </span></div>
<div class="next" onclick="next('best-seller')"><span> > </span></div>
<div id="best-seller" class="list-produk" style="width: 100%; overflow-x: auto; overflow-y: hidden;">
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
         ?>
<?php
//if (isset($search) || isset($url)) {
echo '<div class="home-produk">';
$where = 'terjual > 3';
$query = $this->db->order_by('terjual','desc');
$query = $this->app->select_where_limit('t_items', $where, 6, 0);
foreach ($query->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
<div class="home-list-produk" style="background: #fff; height:200px; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow-y: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px; white-space:normal;'>".$nama1;?></span></a></p>
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
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 150px;"></a></div>
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
</div>
</div>

<div style="padding:0px 12px;">
<h2 class="nopadding" style="font-size:18px; padding: 8px 0px; margin: 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">most viewed</h2>
</div>
<div class="select-model random-produk">
<div class="previus" onclick="previus('most-viewed')"><span> < </span></div>
<div class="next" onclick="next('most-viewed')"><span> > </span></div>
<div id="most-viewed" class="list-produk" style="width: 100%; overflow-x: auto; overflow-y: hidden;">
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
         ?>
<?php
//if (isset($search) || isset($url)) {
echo '<div class="home-produk">';
$query = $this->db->order_by('dilihat','desc');
$query = $this->app->select_where_limit('t_items', ['aktif' => 1], 6, 0);
foreach ($query->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
<div class="home-list-produk" style="background: #fff; height:200px; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow-y: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px; white-space:normal;'>".$nama1;?></span></a></p>
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
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 150px;"></a></div>
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
</div>
</div>

<div style="padding:0px 12px;">
<h2 class="nopadding" style="font-size:18px; padding: 8px 0px; margin: 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">weekly featured products</h2>
</div>
<div class="select-model random-produk">
<div class="previus" onclick="previus('weekly-feature')"><span> < </span></div>
<div class="next" onclick="next('weekly-feature')"><span> > </span></div>
<div id="weekly-feature" class="list-produk" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
         ?>
<?php
//if (isset($search) || isset($url)) {
echo '<div class="home-produk">';
$query = $this->db->order_by('id_item','random');
$query = $this->app->select_where_limit('t_items', ['aktif' => 1], 6, 0);
foreach ($query->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
<div class="home-list-produk" style="background: #fff; height:200px; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow-y: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px; white-space:normal;'>".$nama1;?></span></a></p>
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
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 150px;"></a></div>
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
</div>
</div>

<div style="padding:0px 12px;">
<h2 class="nopadding" style="font-size:18px; padding: 8px 0px; margin: 0px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">latest on sale</h2>
</div>

<div class="select-model random-produk">
<div class="previus" onclick="previus('latest-on-sale')"><span> < </span></div>
<div class="next" onclick="next('latest-on-sale')"><span> > </span></div>
<div id="latest-on-sale" class="list-produk" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
         ?>
<?php
//if (isset($search) || isset($url)) {
echo '<div class="home-produk">';
foreach ($data->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
$t_items = $this->db->query("SELECT i.id_item, mk.link, k.url FROM t_items i JOIN t_rkategori rk ON (rk.id_item = i.id_item) JOIN t_kategori k ON (k.id_kategori = rk.id_kategori) JOIN masterkategori mk ON (mk.id = k.id_master) WHERE i.link = '".$row->link."'")->row();
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
}
?>
<div class="home-list-produk" style="background: #fff; height:200px; text-align: center; padding-top: 12px;">
                <div style="width:150px; height: 100px; display:flex; margin:auto; position:relative;">
                    <a style="margin: auto; height:100%;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>">
                    <img src="<?php echo base_url('assets/product/'.$foto);?>" style="margin:auto; max-width: 100%; max-height: 100%;" alt="<?php echo $nama[0];?>">
                    </a>
                </div>
                <p style="font-family: bariol_regular; white-space:normal; line-height: 20px; overflow-y: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px; white-space:normal;'>".$nama1;?></span></a></p>
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
                <div style="height: 150px; display: flex;"><a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><img src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo base_url('assets/product/'.$foto);?>" style="width: 150px;"></a></div>
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
</div>
</div>

      <?php
      } else {
         if (isset($url)) {
          ?>
          <div style="padding: 12px 12px 18px 12px;">
          <a href="<?= site_url(); ?>">Home</a> > <span class="nopadding" style="color: #0af;"><?php echo $url; ?></span>
          </div>
          <h4><?php echo $url;?></h4><hr class="nomargin">
          <br>
          <div style="display: flex; min-height: 200px;">
               <div style="margin: auto; text-align: center;">
                <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>" alt="product not found">
                 <p>produk tidak di temukan :(</p>
                 <a id="btncari" class="btn white-text black" onclick="">cari produk lainnya</a>
               </div>
            </div>
          <?php
         } else {
         ?>
            <div style="display: flex; min-height: 200px;">
               <div style="margin: auto; text-align: center;">
                <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>" alt="product not found">
                 <p>produk tidak di temukan :(</p>
                 <a id="btncari" class="btn white-text black" onclick="">cari produk lainnya</a>
               </div>
            </div>
         <?php
         }
      }
      ?>
   </div>
   </div>
</div>
<script>
function myFunction(id, xx) {
  //var x = document.querySelectorAll(".kategori");
  //var i;
  //for (i = 0; i < x.length; i++) {
  //  x[i].style.display = "none";
  //}
  var xx = xx;
  var z = document.getElementById(id);
  var x = document.getElementsByClassName('discover');
  var kat = document.getElementsByClassName('kategori');
  var cek = z.style.display;
  if(cek != 'none'){
      $(z).slideUp(0);
  }
  else{
      $(".kategori").slideUp(0);
      $(z).slideDown(0);
  }
  for (i = 0; i < x.length; i++) {
    if (xx == i && cek == 'none') {
      if(i <= 1){
      kat[i].classList.add("margin-top-custom-min-45");
      }
      x[i].style.backgroundColor = "#fff";
      x[i].style.boxShadow = "0px 18px 0px 0px #fff, -4px 0px 12px 0px #ddd, 4px 0px 12px 0px #ddd, 0px -4px 12px 0px #ddd";
      x[i].style.zIndex = "5";
    }
    else{
      x[i].style.backgroundColor = "transparent";
      x[i].style.boxShadow = "";
      x[i].style.zIndex = "0";
    }
  }
}
</script>
</div>
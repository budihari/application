<div style="padding: 12px 12px 18px 12px;">
<a href="<?= site_url(); ?>">home</a> > <a href="<?= site_url()."home/kategori/".str_replace(" ", "-", $kat->masterkategori); ?>"><?php echo $kat->masterkategori;?></a> > <span class="nopadding" style="color: #0af;"><?php echo $url; ?></span>
</div>
<!--start jssor-->
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        </div>
        <div data-u="slides" class="slide" style="cursor:default;position:absolute;top:0px;left:0px;width:1300px;height: 500px;">
            <div>
           <svg style="position: absolute;" width="100%" height="100%">
           <polygon points="0,0 0,500 400,500 200,0"
           style="fill:rgba(50,50,50,0.5);stroke-width:5;" />
            </svg>
            <div style="position: absolute; top: 34%; margin:auto 0px; color: white; padding: 12px 24px; z-index: 9;">
            <span style="font-family: bariol_light; font-size:18px; padding: 0;">new product</span><br><br>
            <b style="font-size:32px; font-family:bariol_regular;">color fittings</b>
            <br><br><br>
            <a style="font-family: bariol_regular; font-size: 18px; padding: 6px 12px; color: #fff; border:solid 1px #fff;" href="">check now -></a>
          </div>
            <img style="width:100%;" src="<?=base_url();?>img/slidera6.jpg" alt="slide1"/>
            </div>
             <div>
            <img style="width:100%;" src="<?=base_url();?>img/2.jpg" alt="slide2"/>
            </div>
             <div>
            <img style="width:100%;" src="<?=base_url();?>img/3.jpg" alt="slide3"/>
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:50px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:13px;height:13px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
        </div>
        <script type="text/javascript">jssor_1_slider_init();</script>
        <!-- #endregion Jssor Slider End -->
        <div style="clear: both;"></div>
<div style="padding: 0px; position:relative;">
  <div class="mobile"><button style="background: rgba(10,42,59,1); color: #fff; border:none; padding:12px; width:100%;" onclick="showkategori()">show category</button></div>
  
  <script>
    function showkategori(){
      var kategori = document.getElementsByClassName('kategori')[0].style.display;
      if (kategori == 'block') {
        document.getElementsByClassName('kategori')[0].style.display = '';
      }
      else {
        document.getElementsByClassName('kategori')[0].style.display = 'block';
      }
    }
  </script>
         <?php
          $skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id));
          if ($kat->masterkategori == "water filters") {
            $width = "max-width:600px;";
            $class = "subkategori";
          }
          else{
              $width = "max-width:900px;";
              $class = "";
          }
          echo '
          <div id="'.$kat->masterkategori.'" class="kategori desktop" style="position:relative; background:#ddd;">
          <div style="margin:auto; max-width:1190px;">
          <h4 style="padding:12px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 4px #0af;">our pumps</h4>
          </div>
          <div class="subkategori" style="padding:12px; text-align:center; '.$width.' margin:auto;">
         ';
         $kategori = str_replace(" ", "-", $kat->masterkategori);
         $no = 0;
         foreach ($skategori->result() as $sk):
          $url2 = str_replace(" ", "-", $sk->kategori);
          if ($this->uri->segment(4) == $sk->url) {
            $color = "";
          }
          else{
            $color = "";
          }
          echo '
          <div class="listkategori" style="margin:auto; text-align:center; margin:6px 6px 6px 6px; vertical-align:top; display:inline-block;'.$color.'" ';?> onclick="load('<?php echo base_url().'home/list_product/'.$kategori."/".$sk->url;?>', '<?php echo $no;?>')"<?php echo '>
          <div class="gambarkategori" style="display:flex; height:130px; padding-top:12px;">
          <img style="margin:auto; max-width:90%; max-height:90%;" src="'.base_url().'assets/upload/'.$sk->foto_kategori.'" alt="'.$sk->kategori.'">
          </div>
          <div style="min-height:40px; display:flex;">
          <p class="text-kategori" style="padding:6px 12px; margin:auto; max-height:40px; overflow-y:hidden;">'.$sk->kategori.'</p>
          </div>
          </div>
          ';
          $no++;
         endforeach;
         echo '
         </div>
         </div>';
       ?>
</div>
<div id="div1" style="max-width:1190px; margin:auto;">
<div id="ripple" style="background:rgba(0,0,0,0.5); position:fixed; display:none; left:0; right:0; top:0; bottom:0; z-index:9;">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
<div class="left">
<h4 style="padding:12px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 4px #0af;"><?php echo $url;?></h4>
</div>
<div class="right" style="padding: 6px 18px;">
<?php
if ($url == 'shallow submersible pumps') {
?>
  <select id="filter" style="display: block;" name='sort' onchange="link('<?php echo base_url().'home/list_product/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';?>')">
    <option value="">--Pilih Berdasarkan--</option>
    <option value='SS-C' <?php if (!empty($sort) && $sort=="SS-C") {echo "selected";} ?>>Air Bersih</option>
    <option value='SS-W' <?php if (!empty($sort) && $sort=="SS-W") {echo "selected";} ?>>Air Kotor</option>
    <option value='SS-S' <?php if (!empty($sort) && $sort=="SS-S") {echo "selected";} ?>>Air Tanah</option>
    <option value='SS-M' <?php if (!empty($sort) && $sort=="SS-M") {echo "selected";} ?>>Penghancur Limbah</option>
  </select>
<?php
}
elseif ($url == 'spareparts') {
?>
  <select id="filter" style="display: block;" name='sort' onchange="link('<?php echo base_url().'home/list_product/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';?>')">
    <option value="">--Pilih Berdasarkan--</option>
    <option value='capacitor' <?php if (!empty($sort) && $sort=="capacitor") {echo "selected";} ?>>Capacitor</option>
    <option value='implr_or_difsr' <?php if (!empty($sort) && $sort=="implr_or_difsr") {echo "selected";} ?>>Impeler & Diffuser</option>
    <option value='ventr_or_ejector' <?php if (!empty($sort) && $sort=="ventr_or_ejector") {echo "selected";} ?>>Ventury & Jet Ejector</option>
    <option value='mecsl' <?php if (!empty($sort) && $sort=="mecsl") {echo "selected";} ?>>Mech Seal</option>
    <option value='bearg' <?php if (!empty($sort) && $sort=="bearg") {echo "selected";} ?>>Bearing</option>
    <option value='sctfl' <?php if (!empty($sort) && $sort=="sctfl") {echo "selected";} ?>>Suction Flange</option>
    <option value='ckvlv' <?php if (!empty($sort) && $sort=="ckvlv") {echo "selected";} ?>>Check Valve</option>
    <option value='way' <?php if (!empty($sort) && $sort=="way") {echo "selected";} ?>>3 Way</option>
    <option value='fan' <?php if (!empty($sort) && $sort=="fan") {echo "selected";} ?>>Fan</option>
  </select>
<?php
}
?>
</div>
<div style="clear: both;"></div>
<br>
<?php
if ($data->num_rows() > 0)
{
if (isset($url)) {
          ?>
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
foreach ($data->result() as $row)
{
$foto = $row->gambar;
$nama = explode(" / ",$row->nama_item);
$nama1 = "";
if(!empty($nama[1])){
    $nama1 = str_replace("/"," / ",$nama[1]);
    $nama1 = str_replace("|","/",$nama[1]);
}
?>
  <div class="listproduk" style="background: #fff; min-height: 150px;text-align: center; margin-top: 4px;">
                <div style="height: 150px; display: flex; cursor:pointer;" onclick="document.location='<?= site_url('home/detail/'.$row->link); ?>'"><img style="margin:auto; max-width: 120px;max-height: 120px;" src="<?php echo base_url('assets/upload/'.$foto);?>"></div>
                <a style="margin: auto;" href="<?= site_url('home/detail/'.$row->link); ?>"><p style="font-family: bariol_regular; line-height: 20px; overflow-y: hidden; height: 58px;"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px;'>".strtolower($nama1);?></span></p></a><br>
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
<div class="right" style="padding: 12px;">
<?=$link;?>
</div>
</div>
<?php
} // if isset $url
?>
<?php
} else {
         if (isset($url)) {
          ?>
          <div style="display: flex; min-height: 300px;">
               <div style="margin: auto; text-align: center;">
                <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>">
                 <p>produk tidak di temukan :(</p>
                 <a id="btncari" class="btn white-text black" onclick="">cari produk lainnya</a>
               </div>
            </div>
          <?php
         } else {
         ?>
            <div style="display: flex; min-height: 300px;">
               <div style="margin: auto; text-align: center;">
                <img style="max-width: 120px;" src="<?php echo base_url('img/emptycart.png');?>">
                 <p>produk tidak di temukan :(</p>
                 <a id="btncari" class="btn white-text black" onclick="">cari produk lainnya</a>
               </div>
            </div>
         <?php
         }
      }
      ?>
</div>
<script>
function link(data){
  var url = document.getElementById("filter").value;
  var link = data + url;
  $("#div1").load(link);
}
function load(data,url){
var loading = document.getElementById("ripple");
loading.style.display = "block";
  $("#div1").load(data);
  var x = document.getElementsByClassName("text-kategori");
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].style.background = "";
  }
  var xx = document.getElementsByClassName("text-kategori");
  xx[url].style.background = "#aaa";
}
</script>
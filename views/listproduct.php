<?php
$last = $this->uri->total_segments();
$lasturl = strlen($this->uri->segment($last));
$lasturi = $this->uri->segment($last);
if($lasturl <= 5 && is_numeric ($lasturi)){
echo '<script>
$(document).ready(function(){
var count = $("#div1").offset().top - 60;
    $("html, body").animate({
        scrollTop: count
    }, 0);
});
</script>
';
}
if(empty($this->uri->segment(2)) || $this->uri->segment(2) == 'page'){
    $title = "our products";
}
else{
    $title = $subkat;
}
?>
<div style="padding-top:12px; position:relative;">
<div>
<h2 style="font-size:18px; padding: 8px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 2px #0af;"><?php echo $title;?></h2>
</div>
<div style="position:absolute; right:18px; top:12px;">
<?php
$subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(2)])->row();
if(!empty($subkat->kategori2)){
    $no = 0;
    $subkategori = explode(",_,", $subkat->kategori2);
    $urlsubkategori = explode(",_,", $subkat->url2);
    if($this->uri->segment(1) == 'bath-and-kitchen'){
        $selectby = 'sort by series';
    }
    elseif($this->uri->segment(2) == 'shallow-submersible-pumps'){
        $selectby = 'sort by usage';
    }
    else{
        $selectby = 'sort by category';
    }
    echo '<select id="filter" style="display: block; font-family:bariol_regular; font-size:15px;" name="sort" onchange="link()">
    <option value="">'.$selectby.'</option>';
    foreach($subkategori as $value){
               $subkategori = explode(",/,", $value);
               $idsub = explode(".", $subkategori[0]);
    echo '<option value="'.$subkategori[0].'"';
    if($this->uri->segment(4) == $subkategori[0]){
        echo 'selected';
    }
    echo '>'.$subkategori[1].'</option>';
    } //end foreach
    echo '</select>';
}
else{
    $subkat = $this->db->get_where('t_kategori', ['url' => $this->uri->segment(3)])->row();
    if(!empty($subkat->kategori2)){
    $no = 0;
    $subkategori = explode(",_,", $subkat->kategori2);
    $urlsubkategori = explode(",_,", $subkat->url2);
    if($this->uri->segment(2) == 'bath-and-kitchen'){
        $selectby = 'sort by series';
    }
    elseif($this->uri->segment(3) == 'shallow-submersible-pumps'){
        $selectby = 'sort by usage';
    }
    else{
        $selectby = 'sort by category';
    }
    echo '<select id="filter" style="display: block;" name="sort" onchange="link()">
    <option value="">'.$selectby.'</option>';
    foreach($subkategori as $value){
               $subkategori = explode(",/,", $value);
               $idsub = explode(".", $subkategori[0]);
    echo '<option value="'.$subkategori[0].'"';
    if($this->uri->segment(4) == $subkategori[0]){
        echo 'selected';
    }
    echo '>'.$subkategori[1].'</option>';
    } //end foreach
    echo '</select>';
    }
}
?>
</div>
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
  <div class="listproduk" style="background: #fff; min-height: 150px;text-align: center; margin-top: 4px;">
                <div style="height: 150px; display: flex; cursor:pointer; position:relative;" onclick="loading(), document.location='<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>'">
                <div style="position: absolute; right:12px; top:12px; color:white;">
                <?php
                $harga = $row->harga;
                if($row->hargapromo != 0){
                    echo '<div style="background:#0af; border-radius:4px; padding:4px; margin-bottom:4px; color:white;"><p class="nopadding" style="font-size:12px;">promo</p></div>';
                    $harga = $row->hargapromo;
                }
                if($row->grosir !=0){
                    echo '<div style="background:#005; border-radius:4px; padding:4px; color:white;"><p class="nopadding" style="font-size:12px;">grocier</p></div>';
                }
                ?>
                </div>
                
                <img style="margin:auto; max-width: 120px;max-height: 120px;" src="<?php echo base_url('assets/product/'.$foto);?>" alt="<?php echo $nama[0];?>"></div>
                <p style="font-family: bariol_regular; line-height: 20px; overflow-y: hidden; height: 56px;"><a style="margin: auto;" href="<?= site_url($t_items->link.'/'.$t_items->url.'/'.$row->link); ?>"><?php echo $nama[0]."<br><span style='color:#aaa; font-size:13px;'>".strtolower($nama1);?></span></a></p>
                <?php
                /*
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                */
                ?>
                <b class="black-text bariol-regular"><?= 'Rp '.number_format($harga, 0, ',', ','); ?></b>
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
echo '<p>displaying products <b>'.$count.'</b> - <b>'.$count1.'</b> of <b>'.$total_row.'</b> in total</p>';
?>
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
                 <p>product is not found :(</p>
                 <div id="btncari" class="btn white-text black bariol-regular" onclick="cari()">search others products</div>
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
<script>
//$(document).ready(function() {
//    load_finish();
//});

function link(data){
  var isi = document.getElementById("filter").value;
  var tes = '<?php echo $this->uri->segment(1);?>, <?php echo $this->uri->segment(2);?>, <?php echo $this->uri->segment(3);?>';
  <?php
  if(!empty($this->uri->segment(3)) && !is_numeric($this->uri->segment(3))){
  ?>
  var url = "<?php echo base_url().'filter_by/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';?>";
  var pilih = "<?php echo base_url().'pilih/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';?>";
  <?php
  }
  elseif(empty($this->uri->segment(3)) || is_numeric($this->uri->segment(3))){
  ?>
  var url = "<?php echo base_url().'filter_by/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?>";
  var pilih = "<?php echo base_url().'pilih/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?>";
  <?php
  }
  ?>
  if(isi != ''){
        var link = url + isi;
        $("#div1").load(link);
  }
  else{
        $("#div1").load(pilih);
  }
}
function load(data,url){
  $("#div1").load(data);
  var x = document.getElementsByClassName("text-kategori");
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].style.background = "";
    x[i].style.boxShadow = "";
  }
  var xx = document.getElementsByClassName("text-kategori");
  xx[url].style.background = "#fff";
  xx[url].style.boxShadow = "#bbb 0px 0px 12px";
}
</script>
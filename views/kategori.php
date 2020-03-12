    <div class="background-white">
    <div class="max-width-1140" style="padding: 12px;">
    <a href="https://www.waterplus.com">home</a> > <a href="<?= site_url(); ?>">our products</a> > <span class="nopadding" style="color: #0af;"><?php echo $url; ?></span>
    </div>
    </div>
        <div style="">
        <!--start jssor-->
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        </div>
        <div data-u="slides" class="slide" style="cursor:default;position:absolute;top:0px;left:0px;width:1300px;height: 500px;">
            <?php
                $this->db->order_by('id', 'ASC');
                $cek = $this->db->get_where('banner', ['kategori' => $this->uri->segment(1)]);
                foreach($cek->result() as $banner){
                    ?>
                    <div>
                    <a href="<?php echo $banner->url;?>"><img style="width:100%;" src="<?php echo base_url('assets/upload/banner/') . $banner->gambar;?>" alt="<?php echo substr($banner->gambar,0,-4);?>"/></a>
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
        <div style="clear: both;"></div>
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
         <div style="position:relative;">
             <div class="mobile"><button style="text-align:left; background: #fff; border:none; padding: 8px 12px; width:100%;" onclick="showkategori(this)">category <i style="position:absolute; right:28px;" class="fa fa-angle-down"></i></button></div>
  
        <script>
          function showkategori(x){
            var submenu = document.getElementsByClassName('kategori-mobile')[0];
            var kategori = document.getElementsByClassName('kategori-mobile')[0].style.display;
            if (kategori == 'block') {
                $(submenu).slideUp(500);
                x.innerHTML='category <i style="position:absolute; right:28px;" class="fa fa-angle-down"></i>';
            }
            else {
              $(submenu).slideDown(500);
              x.innerHTML='category <i style="position:absolute; right:28px;" class="fa fa-angle-up"></i>';
            }
          }
        </script>
         <?php
          $skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id));
          if ($kat->masterkategori == "water filters") {
            $width = "max-width:600px;";
            $class = "subkategori";
          }
          elseif($kat->masterkategori == "water pumps") {
              $width = "max-width:900px;";
              $class = "";
          }
          else{
              $width = "max-width:800px;";
              $class = "";
          }
          echo '
          <div id="'.$kat->masterkategori.'" class="background-white kategori-mobile desktop" style="position:relative;">
          <div class="max-width-1140" style="padding-top:12px;">
          <h1 style="font-size:18px; padding: 8px 0px; margin: 0px 12px; display: inline-block; width:auto; border-bottom: solid 2px #0af;">'.$kat->masterkategori.'</h1>
          </div>
            
          <div class="subkategori" style="padding:12px; text-align:center; '.$width.' margin:auto;">
         ';
         $kategori = $kat->link;
         $no = 0;
         $total = $skategori->num_rows();
         $half = $total / 2;
         foreach ($skategori->result() as $sk):
          echo '
          <div class="listkategori" style="margin:auto; text-align:center; margin:6px 6px 6px 6px; vertical-align:top; display:inline-block;" ';?> onclick="load('<?php echo base_url().'pilih/'.$kategori."/".$sk->url;?>', '<?php echo $no;?>')"<?php echo '>
          <div class="img-kategori" style="display:flex; height:90px; padding-top:12px;">
          <img style="margin:auto; max-width:90%; max-height:90%;" src="'.base_url().'assets/upload/kategori/'.$sk->foto_kategori.'" alt="'.$sk->kategori.'">
          </div>
          <div style="min-height:40px; display:flex;">
          <p class="text-kategori" style="padding:6px; margin:auto; max-height:40px; overflow:hidden;">'.$sk->kategori.'</p>
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

<div id="div1" class="max-width-1140">
<?php $this->load->view('listproduct'); ?>
</div>
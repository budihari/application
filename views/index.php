<?php
defined('BASEPATH') OR exit('No direct script access allowed');

clearstatcache();

date_default_timezone_set("Asia/Bangkok");
$today = date("Y-m-d H:i:s");

$arr_browsers = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
  
$agent = $_SERVER['HTTP_USER_AGENT'];
  
$user_browser = '';
foreach ($arr_browsers as $browser) {
    if (strpos($agent, $browser) !== false) {
        $user_browser = $browser;
        break;
    }   
}
  
switch ($user_browser) {
    case 'MSIE':
        $user_browser = 'Internet Explorer';
        break;
  
    case 'Trident':
        $user_browser = 'Internet Explorer';
        break;
  
    case 'Edge':
        $user_browser = 'Microsoft Edge';
        break;
}

function get_operating_system() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $operating_system = 'Unknown Operating System';

    //Get the operating_system
    if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
    } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
    } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
    } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
    } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
    } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
    } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
    } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
    }
    
    return $operating_system;
}

function detectDevice(){
  $deviceName="";
  $userAgent = $_SERVER["HTTP_USER_AGENT"];
  $devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
  foreach($devicesTypes as $deviceType => $devices) {
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
  }
$device = detectDevice();

$full_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$full_time = date('Y-m-d H:i:s', time());
$tgl = date('ymd',  time());
$os = get_operating_system();
$browser = $user_browser.", ".$os.", ".$device;

if ($this->session->userdata('user') != TRUE){
	$arraydata = array(
    'user'  => time()
    );
    $this->session->set_userdata($arraydata);
}

if ($this->session->userdata('visitor') != TRUE && $os != 'Unknown Operating System'){
    $tgl = date("ymd");
    $query = $this->db->query("SELECT MAX(idvisitor) AS idvisitor FROM pengunjung where idvisitor LIKE '%$tgl%'");
    $row2 = $query->row();
    $id = $row2->idvisitor;
    if ($query->num_rows() > 0 && !empty($id)) {
        $new_id = $id + 1;
    }
    else{
        $new = $tgl;
        $new_id = $new . "001";
    }
    $new_id = $new_id;
    $iduser = $this->session->userdata('user');
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = $this->db->query("insert into pengunjung (idvisitor, waktu, halaman, iduser, browser, ip) values ('$new_id','$today','$full_url','$iduser', '$browser', '$ip')");
	$arraydata = array(
    'visitor'  => $new_id
    );
    $this->session->set_userdata($arraydata);
}
else{
    $idvisitor = $this->session->userdata('visitor');
    $iduser = $this->session->userdata('user');
    $halaman = $full_url;
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = $this->db->query("SELECT * FROM pengunjung where idvisitor = '$idvisitor' and halaman = '$halaman' and iduser = '$iduser'");
    $row2 = $query->row();
    if ($query->num_rows() == 1) {
        $query = $this->db->query("UPDATE pengunjung SET waktu='$today', browser = '$browser', ip='$ip' WHERE idvisitor = '$idvisitor' and halaman = '$halaman' and iduser = '$iduser'");
    }
    elseif ($query->num_rows() == 0 && $os != 'Unknown Operating System'){
        $query = $this->db->query("insert into pengunjung (idvisitor, waktu, halaman, iduser, browser, ip) values ('$idvisitor','$today','$full_url','$iduser', '$browser', '$ip')");
    }
}

$prof = $profil->row();
if(!empty($metadeskripsi)){
    $meta = $metadeskripsi;
}
else{
    $meta = $title;
}
if(!empty($thumbnail) && $thumbnail2 == 'item'){
    $thumbnail = base_url().'assets/product/'.$thumbnail;
}
elseif(!empty($thumbnail) && $thumbnail2 == 'kategori'){
    $thumbnail = base_url().'assets/upload/kategori/'.$thumbnail;
}
else{
    $thumbnail = base_url().'img/logowp.png';
}
// Program to display URL of current page.
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    {$uri = "https";}
else
    {$uri = "http";}
// Here append the common URL characters.
$uri .= "://";
// Append the host(domain name, ip) to the URL.
$uri .= $_SERVER['HTTP_HOST'];
// Append the requested resource location to the URL
$uri .= $_SERVER['REQUEST_URI'];
// title
if ($this->uri->segment(1) == "" || $this->uri->segment(2) == "home")
    {$title = $title . " | " . $prof->title;}
else
    {$title = $title . " | " . $prof->title;}
?>
<!DOCTYPE html>
<html lang="id">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="<?php echo $meta;?>">
      <meta property="og:url" content="<?php echo strtolower($uri);?>"/>
      <meta property="og:type" content="website"/>
      <meta property="og:title" content="<?php echo $title;?>"/>
      <meta property="og:description" content="<?php echo $meta;?>"/>
      <meta content="<?php echo $thumbnail;?>" property="og:image">
      <meta name="twitter:image" value="<?php echo $thumbnail;?>">
      <meta name="twitter:card" value="summary_large_image"/>
      <meta name="twitter:creator" value="waterplus"/>
      <meta name="twitter:url" value="<?php echo strtolower($uri);?>"/>
      <meta name="twitter:title" value="<?php echo $title;?>"/>
      <meta name="twitter:description" value="<?php echo $meta;?>" />
      <title><?php echo $title;?></title>
      <link itemprop="thumbnailUrl" href="<?php echo $thumbnail;?>">
      <link rel="shortcut icon" href="<?php echo base_url('img/favicon.png');?>"/>
      <!-- Materialize Css -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
      <link rel="stylesheet" href="<?= base_url('assets/css/materialize.min1.css'); ?>">
      <!-- Font-Awesome
      <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.css'); ?>?ver=<?php echo time(); ?>">
       -->
      <!-- flickity css -->
      <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
      <!-- customCss -->
      <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>?ver=<?php echo time(); ?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.css'); ?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/table.css'); ?>">
      <style>
      @font-face {
        font-family: bariol_light;
        src: url('<?= base_url('font/bariol/bariol_light.otf'); ?>');
        }
        @font-face {
            font-family: bariol_regular;
            src: url('<?= base_url('font/bariol/bariol_regular.otf'); ?>');
        }
         @media only screen and (max-width: 767px) {
         #myBtn {
            <?php
            if (strlen($this->uri->segment(3)) >= 5) {
               echo "bottom: 100px;";
            }
            elseif ($this->uri->segment(1) == "cart" || $this->uri->segment(1) == "checkout") {
               echo "bottom: 120px;";
            }
            else{
               echo "bottom: 70px;";
            }
            ?>
            right: 20px;
         }
         .chat-whatsapp {
            <?php
            if (strlen($this->uri->segment(3)) >= 5) {
               echo "bottom: 60px !important;";
            }
            elseif ($this->uri->segment(1) == "cart" || $this->uri->segment(1) == "checkout") {
               echo "bottom: 80px !important;";
            }
            else{
               echo "bottom: 32px;";
            }
            ?>
            right: 20px;
         }
         }
      </style>
<link href="<?= base_url('assets/css/select2.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/jssor.css'); ?>" type="text/css" rel="stylesheet">
<link href="<?= base_url('assets/css/menu.css').'?ver='.time(); ?>" type="text/css" rel="stylesheet">
<script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?= base_url('assets/js/jssor.js'); ?>"></script>
<script src="<?= base_url('assets/js/jssor.slider-22.1.9.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/chart.js'); ?>"></script>
<script src="<?= base_url('assets/js/magnifier.js'); ?>"></script>
<script>
$(document).ready(function () {
$(".select2").select2({
placeholder: "please select"
});
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Google Analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148465774-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-148465774-1');
</script>
<script type="text/javascript" src="https://www.waterplus.com/js/analytics.js"></script>
<!-- End Google Analytics -->
</head>
<body onbeforeunload="loading()">
<!--<div style="position: fixed; bottom:0px; z-index:9; width:100%; height:100px; background:#333; color:#fff;">
   <?php
   print_r($this->cart->contents());
   ?>
</div>-->
<nav class="menu-navigasi">
    <div class="menu1">
        <div id="logo" class="logo"><a href="https://www.waterplus.com/" style="margin:auto;"><img style="max-height: 50px;padding: 10px 12px;" src="<?php echo base_url();?>img/logo.png" alt="logo waterplus"/></a></div>
        <input type="checkbox" id="btn-respon" hidden/>
        <label for="btn-respon" class="btn-respon" onclick="btn('.bar')">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="close" style="display:none;">x</span>
        </label>
        <ul class="nav-menu">
        <li><a href="https://www.waterplus.com/?page=ourstory">our story</a></li>
        <li><a href="https://www.waterplus.com/?page=whyus">why us</a></li>
        <li>
            <div class="expand" style="position:absolute; padding:12px 26px; right:0;" onclick="toggle('#ourproducts', this, 2)"><span style="font-family:bariol_light; font-size:12px; margin-right:6px; font-style:italic;">show</span>
            <i class="fa fa-angle-down" style="font-size: 12px; margin:auto; color:#777;"></i></div><a class="submenu-1" style="<?php if (empty($this->uri->segment(1))) {
                    echo "color:rgba(0, 179, 227, 1);";
                }?>" href="<?php echo base_url();?>">our products</a>
        <?php
        $x=0;
        echo '<ul id="ourproducts" class="our-products">';
        foreach ($kategori->result() as $kat):
               $skategori = $this->db->get_where('t_kategori', array('id_master' => $kat->id));
               if ($this->uri->segment(1) == $kat->link) {
                    $color = "color:rgba(0, 179, 227, 1);";
                }
                else{
                    $color = "";
                }
               ?>
               <li>
                   <div class="expand" style="position:absolute; padding:8px 26px; right:0;" onclick="toggle('#submenu<?php echo $x;?>', this, 2)">
                    <i class="fa fa-angle-down" style="font-size: 12px; margin:auto; color:#777;"></i></div>
                   <a class="submenu-2" style="display:flex; <?php echo $color;?>" href="<?=site_url($kat->link);?>"><span style="margin:auto 0px;"><?=$kat->masterkategori;?></span></a>
                  <ul id="submenu<?php echo $x;?>" class="sub-ourproducts" style="padding:10.5px 0px;">
                     <?php foreach ($skategori->result() as $sk):
                        $kategori = $kat->link;
                        if ($this->uri->segment(2) == $sk->url) {
                            $color1 = "color:rgba(0, 179, 227, 1);";
                        }
                        else{
                            $color1 = "";
                        }
                     ?>
                   <li><a class="submenu-3" style="display:flex; <?php echo $color1;?>" href="<?=site_url($kategori."/".$sk->url);?>"><span style="width:33px; height:33px; display:inline-flex;"><img style="max-width:20px; max-height:20px; margin:auto;" src="<?php echo base_url().'assets/upload/kategori/'.$sk->foto_kategori;?>" alt="<?=$sk->kategori;?>"></span>&nbsp;<span style="margin:auto 0px;"><?=$sk->kategori;?></span></a>
                   </li>
                     <?php endforeach; ?>
                  </ul>
               </li>
            <?php
            $x++;
            endforeach;
            echo '</ul>';
            ?>
        </li>
        <li><a href="https://www.waterplus.com/?page=one_for_one">one for one</a></li>
        <li>
            <div class="expand" style="position:absolute; padding:12px 26px; right:0;" onclick="toggle('#menu-contact', this, 2)"><span style="font-family:bariol_light; font-size:12px; margin-right:6px; font-style:italic;">show</span>
            <i class="fa fa-angle-down" style="font-size: 12px; margin:auto; color:#777;"></i></div>
            <span class="submenu-1">contact</span>
            <ul id="menu-contact" class="our-products">
                <li><a class="submenu-2" style="display:flex;" href="https://www.waterplus.com/?page=showroom"><span style="margin:auto 0px;">showroom</span></a>
                </li>
                <li><a class="submenu-2" style="display:flex;" href="https://www.waterplus.com/?page=service_centre"><span style="margin:auto 0px;">service centers</span></a></li>
                <li><a class="submenu-2" style="display:flex;" href="https://www.waterplus.com/?page=dealer"><span style="margin:auto 0px;">dealers</span></a></li>
            </ul>
        </li>
        <?php if ($this->session->userdata('user_login')) {
        
        ?>

                  <li class="menuuser"><a onclick="toggle('#menu-user', this, 1)"><i class="fa fa-user"></i> <span class="textlogin"><?= strtolower($this->session->userdata('name')); ?></span></a>

                  <ul id="menu-user" class="submenuuser" style="text-align: left; min-width: 120px;">
                     <li><a class="submenu-2" style="display:flex;" href="<?= site_url('home/profil'); ?>"><span style="margin:auto 0px;"><i class="fa fa-user"></i> profile</span></a></li>
                     <li><a class="submenu-2" style="display:flex;" href="<?= site_url('home/wishlist'); ?>"><span style="margin:auto 0px;"><i class="fa fa-heart"></i> wish list</span></a></li>
                     <li><a class="submenu-2" style="display:flex;" href="<?= site_url('home/transaksi'); ?>"><span style="margin:auto 0px;"><i class="fa fa-exchange"></i> order</span></a></li>
                     <li><a class="submenu-2" style="display:flex;" href="<?= site_url('home/logout'); ?>"><span style="margin:auto 0px;"><i class="fa fa-sign-out"></i> logout</span></a></li>
                  </ul>
                  </li>
               <?php } else { ?>
                <li><a href="<?= site_url('home/login'); ?>"><i class="fa fa-sign-in"></i> <span class="textlogin">login</span></a></li>
               <?php }
               if (!empty($this->cart->contents())) {
               $xx = 0;
               foreach($this->cart->contents() as $key) :
               $xx++;
               $cart = $xx;
               endforeach;
               }
               else{
               $cart="";
               }
                ?>
<li style="position: relative;"><a href="<?= site_url('cart'); ?>"><i class="fa fa-shopping-cart"></i> <span class="textlogin">cart</span><span class="bariol-regular count-cart"><?php echo $cart;?></span></a></li>
</ul>
    <div id="i-search" onclick="cari()">
    <i class="fa fa-search"></i>
    </div>
    <div id="cari">
    <form action="<?= site_url('search/index'); ?>" method="get">
    <label for="search">
    <input id="search" name="search" style="width:0;" type="text" value="<?php echo isset($search) ? $search :  '';?>" placeholder="search products" onfocus="cari()" onfocusout="notsearch()" required="required"/>
    </label>
    <button id="btn-search" type="submit"><i class="fa fa-search"></i></button>
    </form>
    </div>
</div>
</nav>
<div id="load">
<div class="lds-ripple"><div></div><div></div></div>
</div>
      <main>
        <!-- start item -->
         <div>
               <?= $content; ?>
         </div>
        <!-- end item -->
      </main>
<?php
if($this->uri->segment(1) == 'signin' || $this->uri->segment(1) =='signup' || $this->uri->segment(2) =='login' || $this->uri->segment(2) =='resend' || $this->uri->segment(2) =='registrasi' || $this->uri->segment(1) =='lost_user') {
echo "";
}
else{
?>
<footer>
<div class="grid-footer max-width-1140" style="min-height: 400px;">
   <div class="subscribe">
      <h3>connect</h3>
      <p style="padding:0px 12px; font-size:14px; font-family:bariol_light;">sign up to be the first to hear about our exclusive products, promos & discounts</p>
   </div>
   <div class="form-search">
      <form action="<?php echo base_url();?>home/subscribe" method="post">
      <input type="email" name="email" style="padding:8px 0; box-sizing: border-box;" autocomplete="off" placeholder="enter your email" required="required">
      <button type="submit" name="subscribe">submit</button>
      </form>
   </div>
   <div class="medsos">
       
      <a href="http://www.twitter.com/waterplus_" target="_blank"><i class="fa fa-twitter"></i></a>
      <a href="https://www.facebook.com/waterplus.waterforall/" target="_blank"><i class="fa fa-facebook"></i></a>
      <a href="https://www.youtube.com/channel/UCF4Jrx90WL8GRYczyF_vSsg" target="_blank"><i class="fa fa-youtube"></i></a>
      <a href="http://www.pinterest.com/waterplus/" target="_blank"><i class="fa fa-pinterest"></i></a>
      <a href="http://instagram.com/waterplus.waterforall" target="_blank"><i class="fa fa-instagram"></i></a>
   </div>
   <div class="sitemap vpadding">
      <h3>sitemap</h3>
      <p style="padding: 0px 12px;"><a style="font-size: 14px;" href="https://www.waterplus.com/?page=ourstory">our story</a><br>
      <a style="font-size: 14px;" href="https://www.waterplus.com/?page=whyus">why us</a><br>
      <a style="font-size: 14px;" href="https://www.waterplus.com/?page=one_for_one">one for one</a><br>
      <a style="font-size: 14px;" href="https://www.waterplus.com/?page=showroom">showroom</a><br>
      <a style="font-size: 14px;" href="https://www.waterplus.com/?page=dealer">dealer</a><br>
      <a style="font-size: 14px;" href="https://www.waterplus.com/?page=service_centre">service center</a></p>
   </div>
   <div class="quicklinks vpadding">
      <h3>quicklinks</h3>
      <p style="padding: 0px 12px;"><a style="font-size: 14px;" href="#">terms &amp; conditions</a><br>
      <a style="font-size: 14px;" href="#">privacy policy</a><br>
      <a style="font-size: 14px;" href="#">faq</a></p>
   </div>
   <div class="reach vpadding">
      <h3>reach us at</h3>
      <div style="padding: 0px 12px; font-family:bariol_regular;">
      <div style="line-height: 22px; font-size: 14px;">head office: <span style="font-family:bariol_light;">jalan percetakan negara no.c553 jakarta 10570</span></div>
      <div style="line-height: 22px; font-size: 14px;">mail: <a style="font-family:bariol_light;" href="mailto:help@waterplus.com" target="_blank">help@waterplus.com</a><br>
      phone: <a style="font-family:bariol_light;" href="tel:0214226888" target="_blank">(021) 4226888</a></div>
      <div style="line-height: 22px; font-size: 14px;">fax: <a style="font-family:bariol_light;" href="tel:0214226442" target="_blank">(021) 4226442</a></div>
      <div style="line-height: 22px; font-size: 14px;">service center: <a style="font-family:bariol_light;" href="tel:0214228881" target="_blank">(021) 4228881</a></div>
      <div style="line-height: 22px; font-size: 14px;">whatsapp <a style="font-family:bariol_light;" href="https://wa.me/6287874539888" target="_blank">+62 878 7453 9888</a></div>
      </div>
   </div>
</div>
<div class="footer" style="background: rgba(10,42,59,1);">
   <div class="client" style="padding: 12px;">
      <img style="width: 100%;" src="<?= base_url('img/footer.png'); ?>" alt="client">
   </div>
   <div class="copyright">
      <p style="font-size: 14px; font-weight: 500; font-family: bariol_light;">copyright &copy;2019 waterplus+. all rights reserved.

</p>
   </div>
</div>
</footer>
<?php
}
?>
    <div class="chat-whatsapp" style="position:fixed; border-radius:4px; z-index:9; display:flex;">
        <a style="margin:auto;" href="https://wa.me/6287874539888" target="_blank">
            <span>chat now&nbsp;</span>
            <i class="fa fa-whatsapp white-text"></i>
        </a>
    </div>
    <div>
    <div id='tawk_5e4bb3f9a89cda5a188693b4'></div>
      <!--Start of Tawk.to Script-->
      <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/5e4bb3f9a89cda5a188693b4/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
      })();
      </script>
      <!--End of Tawk.to Script-->
    </div>
      <div onclick="topFunction()" id="myBtn" style="transform: rotateZ(-90deg);"><span style="margin:auto;">&gt;</span></div>
      <!-- materialize -->
      <script src="<?= base_url('assets/js/materialize.min.js'); ?>"></script>
      <script src="<?= base_url('assets/js/custom.js'); ?>"></script>
      <script src="<?= base_url('assets/js/scripts.js').'?ver='.time(); ?>"></script>
      <script src="<?= base_url('assets/js/jquery.mask.min.js'); ?>"></script>
      <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
      <!-- custom -->

         <script>

            $(document).ready(function() {
               function convertToRupiah(angka)
               {

                  var rupiah = '';
                  var angkarev = angka.toString().split('').reverse().join('');

                  for(var i = 0; i < angkarev.length; i++)
                    if(i%3 == 0) rupiah += angkarev.substr(i,3)+',';

                  return rupiah.split('',rupiah.length-1).reverse().join('');

               }
               <?php if(strtolower($this->uri->segment(2)) == 'profil' || strtolower($this->uri->segment(2)) == 'shipping') { ?>
               $('#prov').change(function() {
                  var prov = $('#prov').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/city",
                     method: "POST",
                     data: { prov : prov },
                     success: function(obj) {
                        $('#kota').html(obj);
                     }
                  });
               });

               $('#kota').change(function() {
                  var dest = $('#kota').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/subdistrict",
                     method: "POST",
                     data: { kabupaten : dest },
                     success: function(obj) {
                        $('#subdistrict').html(obj);
                     }
                  });
               });
               
               /*
               $('#subdistrict').change(function() {
                  var dest = $('#subdistrict').val();
                  var kurir = $('#kurir').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/getcost",
                     method: "POST",
                     data: { dest : dest, kurir : kurir },
                     success: function(obj) {
                        $('#subdistrict').html(obj);
                     }
                  });
               });
               */
            <?php }
            else if(strtolower($this->uri->segment(1)) == 'checkout') { ?>
            
            $('#addprov').change(function() {
                  var prov = $('#addprov').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/city",
                     method: "POST",
                     data: { prov : prov },
                     success: function(obj) {
                        $('#addkota').html(obj);
                     }
                  });
               });
               
               $('#addkota').change(function() {
                  var dest = $('#addkota').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/subdistrict",
                     method: "POST",
                     data: { kabupaten : dest },
                     success: function(obj) {
                        $('#addsubdistrict').html(obj);
                     }
                  });
               });
               
               $('#changeprov').change(function() {
                  var prov = $('#changeprov').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/city",
                     method: "POST",
                     data: { prov : prov },
                     success: function(obj) {
                        $('#changekota').html(obj);
                     }
                  });
               });
               
               $('#changekota').change(function() {
                  var dest = $('#changekota').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/subdistrict",
                     method: "POST",
                     data: { kabupaten : dest },
                     success: function(obj) {
                        $('#changesubdistrict').html(obj);
                     }
                  });
               });


               $('#kurir').change(function() {
                  <?php
                  if (!empty($kecamatan[0])) {
                     $kab = $kecamatan[0];
                  }
                  else{
                      $kab = '';
                  }
                  ?>
                  var dest = "<?php echo $kab;?>";
                  var kurir = $('#kurir').val()

                  $.ajax({
                     url: "<?=base_url();?>checkout/getcost",
                     method: "POST",
                     data: { dest : dest, kurir : kurir },
                     success: function(obj) {
                        $('#layanan').html(obj);
                     }
                  });
               });

               $('#layanan').change(function() {
                  var layanan = $('#layanan').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/cost",
                     method: "POST",
                     data: { layanan : layanan },
                     success: function(obj) {
                        var hasil = obj.split(",");

                        $('#ongkos').val(hasil[0]);
                        $('#total').val(convertToRupiah(hasil[1]));
                        var element = document.getElementById("totalbayar");
                        var total = convertToRupiah(hasil[1]);
                        element.innerHTML = total;
                        document.getElementById("bayar").innerHTML = total;
                        document.getElementById("ongkir").innerHTML = convertToRupiah(hasil[0]);
                        document.getElementById("ongkir2").innerHTML = convertToRupiah(hasil[0]);
                        //document.getElementById("ongkir3").innerHTML = convertToRupiah(hasil[0]);
                     }
                  });
               });

               $('#change_unique').click(function() {
                  var ongkir = $('#ongkir').text();

                  $.ajax({
                     url: "<?=base_url();?>checkout/unique",
                     method: "POST",
                     data: { layanan : ongkir },
                     success: function(obj) {
                        var hasil = obj.split(",");

                        $('#total').val(convertToRupiah(hasil[1]));
                        var element = document.getElementById("totalbayar");
                        var total = convertToRupiah(hasil[1]);
                        element.innerHTML = total;
                        document.getElementById("bayar").innerHTML   = total;
                        document.getElementById("unique").innerHTML = hasil[0];
                     }
                  });
               });
               
            <?php }

            elseif (strtolower($this->uri->segment(2)) == 'detail'){
             ?>

               <?php $key = $data->row();?>
               $('#kota').change(function() {
                  var dest = $('#kota').val();
                  var kurir = "jne";

                  $.ajax({
                     url: "<?=base_url();?>checkout/getcost",
                     method: "POST",
                     data: { dest : dest, kurir : kurir },
                     success: function(obj) {
                        var hasil = obj.split(",");

                        $('#ongkos').val(hasil[0]);
                        $('#total').val(convertToRupiah(hasil[1]));
                        var element = document.getElementById("totalbayar");
                        var total = convertToRupiah(hasil[1]);
                        element.innerHTML = total;
                        document.getElementById("ongkir").innerHTML = convertToRupiah(hasil[0]);
                     }
                  });
               });

               $('#kabupaten').change(function() {
                  var layanan = $('#layanan').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/cost",
                     method: "POST",
                     data: { layanan : layanan },
                     success: function(obj) {
                        var hasil = obj.split(",");

                        $('#ongkos').val(hasil[0]);
                        $('#total').val(convertToRupiah(hasil[1]));
                        var element = document.getElementById("totalbayar");
                        var total = convertToRupiah(hasil[1]);
                        element.innerHTML = total;
                        document.getElementById("ongkir").innerHTML = convertToRupiah(hasil[0]);
                     }
                  });
               });

            <?php } ?>
            });
         </script>
   </body>
</html>
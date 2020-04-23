<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$profile = $profil->row();

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
$browser = $user_browser.", ".get_operating_system().", ".$device;

if ($this->session->userdata('visitor') != TRUE){
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
    else{
        $query = $this->db->query("insert into pengunjung (idvisitor, waktu, halaman, iduser, browser, ip) values ('$idvisitor','$today','$full_url','$iduser', '$browser', '$ip')");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      
      <!-- Meta, title, CSS, favicons, etc. -->
      
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=550">

      <title>Dashboard <?= $profile->title; ?></title>
      <!-- Bootstrap -->
      <link href="<?= base_url('admin_assets/css/bootstrap.min.css').'?ver='.time(); ?>" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="<?= base_url('admin_assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
      <!-- Data Tables -->
      <link href="<?= base_url('admin_assets/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet">
      <link href="<?= base_url('admin_assets/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- Custom Theme Style -->
      <link href="<?= base_url('admin_assets/css/custom.min.css'); ?>" rel="stylesheet">
      <link href="<?= base_url('admin_assets/css/custom.css')."?ver".date('is',time()); ?>" rel="stylesheet">
<!-- include summernote css/js-->
<link href="<?= base_url('admin_assets/dist/summernote.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<!-- include libries(jQuery, bootstrap) -->
<script src="<?= base_url('admin_assets/js/jquery.js'); ?>"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?= base_url('admin_assets/dist/summernote.min.js'); ?>"></script>
<script src="https://cdn.ckeditor.com/4.13.0/full/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('.summernote').summernote({
        height: "300px",
        styleWithSpan: false
    });
});

function postForm() {
    $('textarea[name="content"]').html($('#summernote').code());
}
</script>
      <style media="screen">
      .product-image{
         height:120px;
         width:120px;
         border: 1px solid #c1c1c1;
         padding: 5px;
         display: flex;
         align-items: center;
         margin-top: 10px;
         margin-right: 5px;
      }
      .product-image img{
         width: 100%;
         height: auto;
      }
      .card {
         margin:5px 4px 10px 0px;
         background-color: #fff;
         transition: box-shadow .25s;
         border: 1px solid #d9d9d9;
      }

      .card .card-image {
        display: flex;
        align-items: center;
        width: 185px;
        height: 200px;
      }

      .card .card-image img{
        width: 100%;
        height: auto;
      }

      .card .card-content .card-title {
        display: block;
        line-height: 32px;
        margin-bottom: 8px;
      }

      .card .card-content .card-title i {
        line-height: 32px;
      }

      .card .card-action {
        position: relative;
        background-color: inherit;
        border-top: 1px solid rgba(160, 160, 160, 0.2);
        padding: 10px 5px;
      }

      .card-image {
         height : 180px;
         text-align: center;
      }
      .card-action .btn-flat {
         width:100%;
         margin-bottom: 5px;
         text-align: left;
      }
      .half{
            margin: auto;
            width: 50%;
         }
         .medium{
            margin: auto;
            width: 80%;
         }
         .full{
            margin: auto;
            width: 100%;
         }
      @media screen and (max-width: 400px){
         .card .card-image {
           display: flex;
           align-items: center;
           width: 100%;
           height: 280px;
         }
      }
      </style>
   </head>

   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <?= $nav; ?>

            <!-- page content -->
            <div class="right_col" role="main">
               <?= $content; ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
               <div class="pull-right">
                   <p>waterplus <?php echo date('Y',time());?></p>
               </div>
               <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
         </div>
      </div>

      <!-- Data Tables -->
      <script src="<?= base_url('admin_assets/js/jquery.dataTables.min.js'); ?>"></script>
      <script src="<?= base_url('admin_assets/js/dataTables.bootstrap.min.js'); ?>"></script>
      <script src="<?= base_url('admin_assets/js/dataTables.responsive.min.js'); ?>"></script>
      <!-- Custom Theme Scripts -->
      <script src="<?= base_url('admin_assets/js/custom.min.js'); ?>"></script>
      <script type="text/javascript">
         function addlist(obj, out) {
            var grup = obj.form[obj.name];
            var len = grup.length;
            var list = new Array();

            if (len > 1) {
               for (var i = 0; i < len; i++) {
                  if (grup[i].checked) {
                     list[list.length] = grup[i].value;
                  }
               }
            } else {
               if (grup.checked) {
                  list[list.length] = grup.value;
               }
            }

            document.getElementById(out).value = list.join(', ');

            return;
         }
         function addsub(obj, out) {
            var grup = obj.form[obj.name];
            var len = grup.length;
            var list = new Array();

            if (len > 1) {
               for (var i = 0; i < len; i++) {
                  if (grup[i].checked) {
                     list[list.length] = grup[i].value;
                  }
               }
            } else {
               if (grup.checked) {
                  list[list.length] = grup.value;
               }
            }

            document.getElementById(out).value = list.join(', ');

            return;
         }
         $('.alert-message').alert().delay(3000).slideUp('slow');
      </script>
      <?php if($this->uri->segment(1) != 'administrator' && $this->uri->segment(1) != 'setting') { ?>
         <script type="text/javascript">
         $(document).ready(function(){
            <?php
               switch ($this->uri->segment(1)) {
                  case 'item':
                     $file = 'item';
                     break;
                  case 'tag':
                     $file = 'tag';
                     break;
                  case 'banner':
                     $file = 'banner';
                     break;
                  case 'user':
                     $file = 'user';
                     break;
                  case 'transaksi':
                     $file = 'transaksi';
                     break;
                  case 'pembayaran':
                     $file = 'pembayaran';
                     break;
               }

            if($this->uri->segment(2) == ''){
            ?>
            $('#datatable').DataTable({
               "processing": true, //Feature control the processing indicator.
               "serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.

               // Load data for the table's content from an Ajax source
               "ajax": {
                  "url": "<?=base_url($file.'/ajax_list')?>",
                  "type": "POST"
               },

              //Set column definition initialisation properties.
              "columnDefs": [
              {
                  "targets": [ 0 ], //first column / numbering column
                  "orderable": false, //set not orderable
              },
              ],

          });
         
         <?php
            }
         ?>
         });
         </script>
      <?php } ?>
   </body>
</html>
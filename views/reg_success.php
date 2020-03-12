<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$user  = $this->input->post('username', TRUE);
$pass  = $this->input->post('password', TRUE);
$where = "username = '".$user."' || email = '".$user."'";
$cek   = $this->db->get_where('t_users', $where);
      if ($cek->num_rows() == 1)
		{
		    $cek = $cek->row();
		    $email = $cek->email;
		    $user = $cek->username;
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
      elseif ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      echo '</div>';
?>
<style>
        .center {
            text-align: center;
        }
        
        /*
        .box-outer {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
        }
        */
        
        .box-verify {
            padding: 12px;
            margin: auto;
            max-width: 500px;
        }
        
        .resend {
            background:#aaa;
            color: rgba(0, 179, 227, 1);
            border:none;
            border-radius: 4px;
            padding: 12px 0px;
            margin-bottom: 6px;
            cursor:pointer;
            width:100%;
        }
        .resend:hover{
            background:rgba(0, 179, 227, 1);
        }
        
        .backtologin {
            background: rgba(0, 179, 227, 1);
            color: #fff;
            border-radius: 4px;
            padding: 12px 0px;
            cursor:pointer;
        }
        .backtologin:hover{
            background: #005;
        }
    </style>
    
    <div style="min-height: 550px; display: flex; position: absolute; top: 0; left: 0; right: 0; bottom:0; background: url('<?= base_url('img/login4.png'); ?>'); background-size: cover; background-position: center;">
         <div class="shadow login" style="margin:auto; padding: 12px 12px; background: rgba(255,255,255,0.7);border-radius:12px;">
    <div class="box-outer">
        <div class="box-verify center">
            <h3>nearly done!</h3>
            <p>we've sent an email to<br>
                <b><?php echo $email;?></b>
            </p>
            <p>
                follow the link to verify your account before logging in!
            </p>
            <form action="<?php echo base_url();?>home/resend" method="post">
                <input type="hidden" name="username" value="<?php echo $user;?>">
                <input type="hidden" name="email" value="<?php echo $email;?>">
            <button type="submit" name="submit" value="resend" class="resend white-text">resend verification email</button>
            </form>
            <div class="backtologin" onclick="window.history.go(-1)">&lt; login now</div>
            <p>didn't get the email?<br>try checking your spam or junk folder.<br>if you're still having trouble, please <a href="https://waterplus.com/?page=showroom">contact us</a></p>
        </div>
    </div>
            <div style="clear: both;"></div>
         </div>
      </div>

    <script>
    $('#resend').click(function() {
                  var prov = $('#resend').val();
                  $.ajax({
                     url: "<?=base_url();?>checkout/city",
                     method: "POST",
                     data: { prov : prov },
                     success: function(obj) {
                        $('#changekota').html(obj);
                     }
                  });
               });
    </script>
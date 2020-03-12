<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'encryption','cart'));
		$this->load->model('app');
	}
	public function link()
	{
		$items = $this->app->get_where('t_users', array('username' => $this->uri->segment(3), 'reset' => $this->uri->segment(4)));
		if ($items -> num_rows() == 1) {
			$cond = "success";
			$this->session->set_flashdata('success', "congratulations<br>your account is active");
			$where = [
			'username' => $this->uri->segment(3),
			'reset' => $this->uri->segment(4)
			];
			$item = array(
				'status' => 1,
				'reset' => ""
				);
				$this->app->update('t_users', $item, $where);
				$user = $items->row();
//start email
$this->load->library('email');
$config['smtp_user'] = 'no-reply@waterplus.com'; //isi dengan email gmail
$config['smtp_pass'] = 'Waterplus2019'; //isi dengan password
$this->email->initialize($config);

$this->email->set_mailtype("html");
        $this->email->from('no-reply@waterplus.com', 'waterplus+');
        $this->email->to($user->email);
        $this->email->subject('thank you for verifying your email');
        $this->email->message(
'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Test Email Sample</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @font-face {
            font-family: bariol_light;
            src: url(https://www.waterplus.com/img/email/bariol/bariol_light.otf);
        }
        
        @font-face {
            font-family: bariol_regular;
            src: url(https://www.waterplus.com/img/email/bariol/bariol_regular.otf);
        }
        
        body {
            padding: 0;
            margin: auto;
            font-family: bariol_regular;
            white-space: normal;
            min-width: 640px;
        }
        
        p {
            white-space: normal;
            max-width: 100%;
            margin: 0;
        }
        
        a {
            text-decoration: none !important;
        }
        
        .margin-auto {
            margin: auto;
        }
        
        .menu a {
            color: #333;
        }
        
        .menu a:hover {
            color: rgba(0, 179, 227, 1);
        }
        
        .box-banner {
            margin: 8px;
        }
        
        .medsos {
            padding: 12px;
            text-align: center;
        }
        
        .medsos a {
            color: #fff;
            margin: 0px 6px;
            font-size: 24px;
        }
        
        .medsos a:hover {
            color: #aaf;
        }
        
        .text {
            padding: 16px 0px;
            color: #fff;
        }
        
        .email {
            margin: 0px;
            padding: 16px;
        }
        
        .email a {
            padding: 16px;
            background: #0af;
            color: #fff;
        }
    </style>
</head>

<body style="padding: 0; margin: auto; font-family: bariol_regular; white-space: normal; min-width: 360px;">
    <div>
        <div class="logo max-width-1024" style="height:60px; position: relative;">
            <img style="position: absolute; max-height: 100%; left: 12px; top: 12px;" src="http://www.waterplus.com/img/email/logo1.png" alt="logo waterplus">
        </div>
    </div>
    <div class="content">
        <div>
            <div style="margin: auto;"><img style="width:100%; z-index:3;" src="http://www.waterplus.com/img/email/bath.jpg"></div>
        </div>
	<div style="padding:0px 24px; position:relative; margin-top:-50px; z-index:9;">
        <div style="padding: 12px; background:#fff; max-width: 640px; margin: auto;">
            <p style="margin:6px;">
                dear '.$user->username.'!
            </p>
<br>
		<p style="margin:0px 6px; line-height:24px;">
		thank you for verifying your email!
		</p>
	    <p style="margin:0px 6px; line-height:24px;">
		here\'s is your waterplus+ user id: '.$user->username.'
	    </p>
<br>
	    <p style="margin:0px 6px; line-height:24px;">
		should you need any assistance, we will be glad to assist you at anytime during our office hours (M-F 8am - 5pm). or you can call us as 021-422-6888.
	    </p>
<br>
	    <p style="margin:0px 6px; line-height:24px;">
		happy shopping!<br>
		waterplus+
	    </p>
        </div>
	</div>
	<div style="background:#ddd;">
	   <p style="padding:12px;">&copy; copyright 2020 waterplus</p>
	</div>
    </div>
</body>

</html>
		'
          );
if ($this->email->send()) {
    $cond = "success";
    $this->session->set_flashdata('success', "congratulations<br>your account is now active :)");
    redirect('signin');
}
else {
    echo $this->email->print_debugger(array('headers'));
}

	} //end if num_rows=1
		else{
			$cond = "";
			$this->session->set_flashdata('alert', "verification failed");
		}
		redirect('signin');
		/*
		$data['cond'] 		= $cond;
      	$data['title'] 		= "verifying your email";
		$this->template->olshop('verifikasi', $data);
		*/
	}
}
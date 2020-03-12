<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lost_User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
      $this->load->library(array('template','form_validation','cart'));
      $this->load->model('app');
	}

   public function index()
   {
      if ($this->input->post('submit', TRUE) == 'Submit')
      {
         $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

         if ($this->form_validation->run() == TRUE)
         {
            $get = $this->app->get_where('t_users', array('email' => $this->input->post('email', TRUE)));

            if ($get->num_rows() > 0)
            {
               //proses
		      $profil = $this->app->get_where('t_profil', ['id_profil' => 1])->row();
                  $this->load->library('email');

                  $config['smtp_user'] = $profil->email_toko; //isi dengan email gmail
		      $config['smtp_pass'] = $profil->pass_toko; //isi dengan password
				
                  $this->email->initialize($config);
                        
               $key = md5(md5(time()));
               $user = $get->row();

               $this->email->from($profil->email_toko, $profil->title);
               $this->email->to($this->input->post('email', TRUE));
               $this->email->subject('reset your password');
               $this->email->message(
                  '
    <body style="margin:0;">
    <div style="background:#ddd; padding: 24px 0px; position:absolute; top:0; bottom:0; left:0; right:0;">
    <table style="background:#fff; border-radius:4px; min-width: 300px; width: 100%; max-width: 500px; margin: auto;">
        <tr>
            <td colspan="2" style="padding: 0px 12px; border-bottom:solid 1px #aaa;">
                <div style="display:inline-flex; height:60px;">
                    <img style="margin: auto;" src="http://www.waterplus.com/img/email/logo1.png" alt="logo waterplus">
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="padding: 12px;">
                    <p style="margin:6px; font-size: 18px;">
                        hi '.$user->username.'<br>
                        we got a request to reset your password
                    </p>
                    <a href="'.base_url().'lost_user/reset/'.$key.'" style="text-decoration:none;"><div style="border: solid 1px rgba(0, 179, 227, 1); background: rgba(0, 179, 227, 1); color: #fff; border-radius: 4px; padding: 12px 0px; cursor:pointer; text-align:center;">reset password</div></a>
                    <p style="margin:6px; font-size: 18px;">
                        if you ignore this message, your password will not be changed. if you didn\'t request a password reset, let us know.
                    </p>
                </div>
            </td>
        </tr>
    </table>
    </div>
    </body>
'
               );

               if ($this->email->send())
               {
                  $data['reset'] = $key;
                  $cond['email'] = $this->input->post('email', TRUE);
                  $this->app->update('t_users', $data, $cond);

                  $this->session->set_flashdata('success', "Email successfully sent.. please check your email");
               } else {
                  $this->session->set_flashdata('alert', "email failed to sent.. please try again..");
               }

            } else {
               //pesan
               $this->session->set_flashdata('alert', "the email you entered is not registered");
            }
         }
      }
      $data['title'] = "reset password";
		$this->template->olshop('lost_pass2', $data);
   }

	public function reset()
	{
	    $cek = $this->db->get_where('t_users', ['reset' => $this->uri->segment(3)]);
        if($cek->num_rows() == 1){
			if ($this->input->post('submit', TRUE) == 'reset')
			{
				$this->form_validation->set_rules('pass1', 'new password', 'required|min_length[5]');
            $this->form_validation->set_rules('pass2', 'confirm password', 'required|min_length[5]');
            $pass1 = $this->input->post('pass1', TRUE);
            $pass2 = $this->input->post('pass2', TRUE);
				if ($this->form_validation->run() == TRUE)
				{
					$pass = $this->input->post('pass1', TRUE);
					$data['password'] = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
					$data['reset'] = '';

					$cond['reset'] = $this->uri->segment(3);
               if ($pass1 != $pass2) {
                  $this->session->set_flashdata('alert', "confirm password is not the same");
                  echo '<script>window.history.go(-1);</script>';
               }
               else{
                   $cek = $this->db->get_where('t_users', ['reset' => $this->uri->segment(3)]);
                   if($cek->num_rows() == 1){
                       $this->app->update('t_users', $data, $cond);
                       $this->session->set_flashdata('success', "your password was successfully updated");
                       redirect('home/login');
                   }
                   else{
                       $this->session->set_flashdata('alert', "account not found");
                       redirect('home/login');
                   }

					
               }
				}
			}
         $data['title'] = "reset password";
         $this->template->olshop('form_reset', $data);
		} else {
    		$this->session->set_flashdata('alert', "link is not valid");
            redirect('home/login');
		}

	}
}

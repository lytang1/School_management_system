<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        if ($this->session->userdata('teacher_login') == 1)
            redirect(base_url() . 'index.php?teacher/dashboard', 'refresh');

        if ($this->session->userdata('administrator_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        if ($this->session->userdata('accountant_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        $this->load->view('backend/login');
    }

    //Ajax login function 
    function ajax_login() {
        $response = array();
        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = $_POST["password"];
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '') {
        $credential = array('email' => $email, 'password' => $password);

$month_of_year = date('m',now());
       $year_of_academic = date('Y',now());
       if($month_of_year>=8)
       {
        $yn = $year_of_academic +1;
        $academic_year = $year_of_academic.'-'.$yn;
       }elseif($month_of_year<8){
        $yl = $year_of_academic -1;
        $academic_year = $yl.'-'.$year_of_academic;
       }
       $session_year = $this->db->get_where('academic_year',array('academic_year'=>$academic_year))->row()->academic_year;
       if(!$session_year){
        $data['academic_year'] = $academic_year;
        $this->db->insert('academic_year',$data);
        $session_year = $academic_year;
       }
$this->session->set_userdata('academic_year',$session_year);
        // Checking login credential for admin
        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('admin_id', $row->admin_id);
            $this->session->set_userdata('role', 'admin');
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'Admin');

            return 'success';
        }

        // Checking login credential for teacher
        $query = $this->db->get_where('teacher', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('teacher_login', '1');
            $this->session->set_userdata('teacher_id', $row->teacher_id);
            $this->session->set_userdata('role', 'teacher');
            $this->session->set_userdata('login_user_id', $row->employee_id_code);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'Teacher');
            return 'success';
        }
        $query = $this->db->get_where('administrator', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('administrator_login', '1');
            $this->session->set_userdata('administrator_id', $row->id);
            $this->session->set_userdata('role', 'administrator');
            $this->session->set_userdata('login_user_id', $row->id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'Administrator');
            return 'success';
        }

        $query = $this->db->get_where('accountant', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('accountant_login', '1');
            $this->session->set_userdata('accountant_id', $row->id);
            $this->session->set_userdata('role', 'accountant');
            $this->session->set_userdata('login_user_id', $row->id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'Accountant');
            return 'success';
        }
        return 'invalid';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */
    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
        $resp                   = array();
        $resp['status']         = 'false';
        $email                  = $_POST["email"];
        $reset_account_type     = FALSE;
        //resetting user password here
        $new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'admin';
            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => $new_password));
            $resp['status']         = 'true';
        }
        
        // Checking credential for teacher
        $query = $this->db->get_where('teacher' , array('email' => $email));
        if ($query->num_rows() > 0) 
        {
            $reset_account_type     =   'teacher';
            $this->db->where('email' , $email);
            $this->db->update('teacher' , array('password' => $new_password));
            $resp['status']         = 'true';
        }

        // send new password to user email  
        if ($reset_account_type !== FALSE) $this->email_model->password_reset_email($new_password , $reset_account_type , $email);

        $resp['submitted_data'] = $_POST;

        echo json_encode($resp);
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}

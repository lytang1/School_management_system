<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public $Crud_model;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->Crud_model = new Crud_model();
        $this->load->helper('date');
        $this->load->helper("file");
       /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('accountant_login')!=1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1|| $this->session->userdata('accountant_login')==1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    function backup(){
                $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup(); 

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('mybackup.gz', $backup); 

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('mybackup.gz', $backup);
    }
    /* CHANGE THE ACADEMIC YEAR */
    function set_academic_year($page_name='',$year='')
    {
        // $year = $this->input->post('academic_year');
        $study_year = $this->db->get_where('academic_year',array('id'=>$year))->row()->academic_year;
        $this->session->set_userdata('academic_year', $study_year);
   
        redirect(base_url().'index.php?admin/'.$page_name, 'refresh');
    
    }

    function due_date_calculation()
    {
      $today          = date('Y-m-d',now());
      $month          = date('m',now());
      $day            = date('d',now());
      $year           = date('Y',now());
      $year_academic  = $year;

       if($day<=22 && $month==2){
          $day = $day +7; 
       }
       elseif($day>22 && $month==2)
       {
          $ad = 7;
          $remain_date = 29-$day;
          $day = $ad - $remain_date;
          $month = $month +1;
       }
       if(($day<=24)&& ($month ==1 ||$month ==3 ||$month ==5 ||$month ==7 ||$month ==8 ||
          $month ==10 ||$month ==12))
       {
          $day = $day +7;
       }
       elseif(($day>24)&& ($month ==1 ||$month ==3 ||$month ==5 ||$month ==7 ||$month ==8 ||
          $month ==10 ||$month ==12))
       {
          $ad =7;
          $remain1= 31-$day;
          $day = $ad - $remain1;
          $month = $month +1;
          if($month==12){
              $month =1; $year = $year +1;
          }
       }if(($day <=23) &&($month==4||$month==6||$month==9||$month==11)){
          $day = $day +7;
       }elseif(($day >23) &&($month==4||$month==6||$month==9||$month==11)){
              $ad =7;
              $remain_date = 30- $day;
              $day = $ad - $remain_date;
              $month = $month +1;
       }

       $due_date = $year.'-'.$month.'-'.$day;
       return $due_date
    }
    /***ADMIN DASHBOARD***/
    function dashboard()
    {                                     
      if (($this->session->userdata('admin_login') != 1 )&&( $this->session->userdata('accountant_login')!=1) && ($this->session->userdata('administrator_login')!=1 )&&( $this->session->userdata('teacher_login')!=1))
          redirect(base_url(), 'refresh');

      if($this->session->userdata('admin_login')==1)
      {  
        $role = 'admin';
      }
      elseif($this->session->userdata('teacher_login')==1)
      {
        $role= 'teacher';
      } 
      elseif($this->session->userdata('administrator_login')==1) 
      {
        $role='administrator';
      }
      elseif($this->session->userdata('accountant_login')==1) 
      {
        $role='accountant';
      }
        $due_date = due_date_calculation()
        $due_date = strtotime($due_date);
        $current_month          = date('m',now());
        if($current_month>=8)
        {
          $positon_of_hyphen = strrpos($this->session->userdata('academic_year'), '-');
          $year_next = substr($this->session->userdata('academic_year'), $pos+1);
          $year_pre  = substr($this->session->userdata('academic_year'), 0,$pos);
         
          $from_date = $year_pre.'-'.$m.'-'.$d;
          $from_date = strtotime($from_date);
          $to_date   = $year_next.'-'.$month.'-'.$day;
          $to_date   = strtotime($to_date);

        }
        elseif($current_month<8)
        {    
            $pos = strrpos($this->session->userdata('academic_year'), '-');
            $year_next = substr($this->session->userdata('academic_year'), $pos+1);
            $year_pre  = substr($this->session->userdata('academic_year'), 0,$pos);
          
             $from_date = $year_next.'-'.$m.'-'.$d; $from_date = strtotime($from_date);
             $to_date   = $year_pre.'-'.$month.'-'.$day; $to_date   = strtotime($to_date);
        }

        $start_date = $current_study_year.'-'.'08'.'-'.'01';
        $start_date = strtotime($start_date);


        $invoices=$this->db->get_where('invoice',array('valid_date <='=>$due_date,'status'=>'paid','creation_timestamp >='=>$from_date,'creation_timestamp >='=>$to_date))->result_array();
      
        $need_paid_invoices = $this->db->get_where('invoice',array('status !='=>'paid','creation_timestamp >='=>$from_date,'creation_timestamp >='=>$to_date))->result_array();
     
     foreach ($invoices as $invoice) {
        
       $this->db->select('invoice_id');
       $this->db->from('invoice');
       $this->db->where('student_id',$invoice['student_id']);
       $this->db->where('creation_timestamp >=',$start_date);
       $this->db->order_by('creation_timestamp','desc');
       $query1 = $this->db->get();
       $invoice_ids = $query1->result_array();
       $latest_invoice_id  = $invoice_ids[0];

       if($latest_invoice_id == $invoice['invoice_id'])
        {
            $student_name = $student_name.$this->db->get_where('student',array('student_id'=>$invoice['student_id']))->row()->name ." , ";
        }

      }
        foreach ($need_paid_invoices as $need_paid) {
            $student_need_paid = $student_need_paid.$this->db->get_where('student',array('student_id'=>$need_paid['student_id']))->row()->name.' , ';
        }

     $now = date('Y/m/d',now());
     $now = strtotime($now);
        $borrow_over_due = $this->db->get_where('borrow_list',array('return_date <='=>$now,'is_return' =>0))->result_array();
        foreach ($borrow_over_due as $borrow) {
            $borrow_name = $borrow_name. $this->db->get_where('student',array('student_id'=>$borrow['student_id']))->row()->name .", ";
        }

        $employee_ids = $this->db->get_where('contract',array('expired_date <='=>now(),'is_valid'=>1))->result_array();
       
         $this->db->select('*');
         $this->db->from('employee_info');
         $this->db->where('work_permission_exp_date <=',$due_date);
         $this->db->or_where('visa_exp_date <=',$due_date);
                        
            $wv_expired =$this->db->get()->result_array();  
                        
        $page_data['wv_expired']            = $wv_expired; //GET THE EMPLOYEE WHOSE VISA OR WORK VIERIFICATION EXPIRED DATE OVER DUE
        $page_data['employee_ids']          = $employee_ids;                
        $page_data['work_verification_exp'] = $work_verifications;
        $page_data['role']                  = $role;
        $page_data['borrow_ids']            = $borrow_over_due;
        $page_data['student_need_paid']     = $need_paid_invoices;
        $page_data['student_renew_invoice'] = $invoices;
        $page_data['page_name']             = 'dashboard';
        $page_data['page_title']            ='Admin dashboard';
        $page_data['function']              = 'dashboard';
        $this->load->view('backend/index', $page_data);
    }

   
    /* ALERT DETAIL MESSAGE OF DASHBOARD */
    function alert_dashboard($page_title ='',$data1 ='',$data2='' )
    { $i=0;

        if($page_title=='borrow'){
          $now = date('Y/m/d',now());
          $borrow_over_due = $this->db->get_where('borrow_list',array('return_date <='=>$now,'is_return' =>0))->result_array();
          foreach ($borrow_over_due as $borrow) 
          {
              $names[$i] = $this->db->get_where('student',array('student_id'=>$borrow['student_id']))->row()->name;
              $i++;
          }
                       
        }
        elseif($page_title =='need_paid'){
        $month = 07;
        $day = 01;
        $current_month = date('m',now());$y = date('Y',now());$day=date('d',now());
        if($current_month<8){
            $year_post = $current_year-1; 
            // find position of - and get the first year as from date year and the later a as to date year
            $pos = strrpos($this->session->userdata('academic_year'), '-');
            $year_post= substr($this->session->userdata('academic_year'), $pos+1);
            $year_pre  = substr($this->session->userdata('academic_year'), 0,$pos);

            $from_date = $year_post.'-'.$m.'-'.$d; $from_date = strtotime($from_date);
            $to_date   = $year_pre.'-'.$month.'-'.$day; $to_date   = strtotime($to_date);
        }
        elseif($month >=8){
            $year_post = $year_current+1;
            $pos = strrpos($this->session->userdata('academic_year'), '-');
            $year_post = substr($this->session->userdata('academic_year'), $pos+1);
            $year_pre  = substr($this->session->userdata('academic_year'), 0,$pos);

            $from_date = $year_current.'-'.$m.'-'.$d;
            $from_date = strtotime($from_date);
            $to_date   = $year_post.'-'.$month.'-'.$day;
            $to_date   = strtotime($to_date);
        }
        
        $page_data['page_title'] = 'Manage invoice/payment';
        $this->db->where('creation_timestamp >=',$from_date);
        $this->db->where('creation_timestamp <=',$to_date);
        $this->db->where('status !=','paid');
        $this->db->order_by('creation_timestamp', 'desc');
        $need_paid_invoices = $this->db->get('invoice')->result_array();

       $page_data['page_name'] = 'invoice_alert';
       $page_data['data']      = $need_paid_invoices;        
                         
        }
        elseif($page_title=='renew_invoice')
        {
          $month = date('m',now());
          $current_year = date('Y',now());
          $day=date('d',now());
          if($month<8){
            $year_pre = $current_year -1; 

            $from_date = $year_pre.'-'.$m.'-'.$d;
            $to_date   = $current_year.'-'.$month.'-'.$day;
        }
        elseif($month >=8)
        {
            $year_post = $current_year+1;

            $from_date = $current_year.'-'.$m.'-'.$d;
            $from_date = strtotime($from_date);
            $to_date   = $year_post.'-'.$month.'-'.$day;
            $to_date   = strtotime($to_date);
        }

    $due_date = due_date_calculation();
    $due_date = strtotime($due_date);
    $invoices=$this->db->get_where('invoice',array('valid_date <='=>$due_date,'status'=>'paid','creation_timestamp >='=>$from_date,'creation_timestamp <='=>$to_date))->result_array();

     $page_data['page_name'] = 'invoice_alert';
     $page_data['data']      = $invoices;        



      }
      elseif($page_title=='renew_con')
      {
        $employee_ids = $this->db->get_where('contract',array('expired_date <='=>now(),'is_valid'=>1))->result_array();
        $i=0;
        foreach ($employee_ids as $row_emp) 
        {
          $arr_employee_id[$i] = $row_emp['employee_id'];
          $i++;
        }

        $this->db->select('employee.*,contract.expired_date as expired_date');
        $this->db->from('employee');
        $this->db->join('contract','contract.employee_id = employee.employee_id');
        $this->db->where_in('employee.employee_id',$arr_employee_id);
        $this->db->where('is_valid',1);
        $page_data['data']      = $this->db->get()->result_array();
        
        $page_data['page_name'] = 'contract_alert';
         
      }
      elseif($page_title=='renew_work_verification')
      {
        $due_date = due_date_calculation();
                         
        $this->db->where('work_permission_exp_date <=',$due_date);
        $this->db->or_where('visa_exp_date <=',$due_date);
        $w_expired_emp_ids =$this->db->get('employee_info')->result_array();

       $page_data['page_name'] = 'visa_alert';
       $page_data['data']      = $w_expired_emp_ids; 
      }
    $page_title = str_replace('_',' ', $page_title);
      
    $page_data['page_title']  = ucfirst($page_title);
    
    $page_data['function']    = 'dashboard';
    $this->load->view('backend/index',$page_data);
  }

    /*----ATTENDANCE----*/
    function attendance_class($param1 ='', $param2 ='', $param3 ='')
    {
      if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('teacher_login')!= 1)
          redirect('dashboard', 'refresh');
    
      if($param1 =='create')
      {
        $students = $this->db->get_where('student',array('class_id'=>$param2))->result_array();
        $cd_id = $this->db->get_where('class_name',array('id'=>$param2))->row()->class_detail_id;
        $study_time = $this->db->get_where('class_detail',array('class_detail_id'=>$cd_id))->row()->study_time;

        foreach ($students as $student) {
            $data['first_session']      = 0;
            $data['second_session']     = 0;
            $data['third_session']      = 0;
            $data['forth_session']      = 0;
            $data['fifth_session']      = 0;
            $data['sixth_session']      = 0;
            $first_session = $this->input->post($student['student_id'].'first_session');
            $second_session = $this->input->post($student['student_id'].'second_session');
            $third_session = $this->input->post($student['student_id'].'third_session');
      
            if($study_time=='Full time' ||$study_time=='Part time afternoon'){
                $forth_session = $this->input->post($student['student_id'].'forth_session');
                $fifth_session = $this->input->post($student['student_id'].'fifth_session');
                $sixth_session = $this->input->post($student['student_id'].'sixth_session');
            }
            $data['first_session'] = $first_session;
            $data['second_session'] = $second_session;
            $data['third_session'] = $third_session;

           if($study_time=='Full time'||$study_time=='Part time afternoon'){
              $data['forth_session'] = $forth_session;
              $data['fifth_session'] = $fifth_session;
              $data['sixth_session'] = $sixth_session;
            }
            $is_exist1 = $this->db->get_where('attendance',array('student_id'=>$student['student_id'],'date'=>str_replace('/','-', $this->input->post('att_day'))))->row()->attendance_time_id;
       
            if($is_exist1 =='')
            {
                $this->db->insert('attendance_time',$data);
                $at_id = $this->db->insert_id();
            }elseif($is_exist1 !=''){
                
                $this->db->where('attendance_time_id',$is_exist1);
                $this->db->update('attendance_time',$data);
                $at_id = $is_exist1;
            }
                $data1['attendance_time_id'] = $at_id;
                
           $today = str_replace('/', '-', $this->input->post('att_day'));
           $current_year = date('Y',now());
           $month= date('m',now());

           $is_exist = $this->db->get_where('attendance',array('student_id'=>$student['student_id'],'class_id'=>$param2,'date'=>$today))->row()->attendance_id;

          if($is_exist!='')
          {
            $this->db->where('student_id',$student['student_id']);
            $this->db->where('class_id',$param2);
            $this->db->where('date',$today);
            $this->db->update('attendance',$data1);
          }
          elseif($is_exist=='')
          {
            $data1['student_id'] = $student['student_id'];
            $data1['class_id']   = $param2;
            $data1['date']       = $today;
            if($month>=8)
            {
              $year_next = $current_year +1;
              $data1['scholar_year'] = $current_year.'-'.$year_next;
            }
            elseif($month<8)
            { 
              $year_last = $current_year -1;
              $data1['scholar_year']= $year_last.'-'.$current_year;
            }
            $this->db->insert('attendance',$data1);   
           
            }
        }
            $class_name = $this->db->get_where('class',array('class_id'=>$param2))->row()->name;

             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "note attendance of class".'\''.$class_name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);

             $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/attendance_class/'.$param2.'/'.$param3, 'refresh');
        }
        $this->db->get('class_name')->result_array();

        $this->db->select('*');
        $this->db->from('class_name');
        $this->db->order_by('name','desc');
        $class=$this->db->get();
        
        $page_data['classes_name']    = $class->result_array();
     
        if($this->session->userdata('teacher_login')==1)
        {
          $teacher_id = $this->db->get_where('teacher_info_detail',array('employee_id_code'=>$this->session->userdata('login_user_id'),'year'=>$this->session->userdata('academic_year')))->result_array();
          $index =0;
          foreach ($teacher_id as $row_t) 
          {
             $arr_class_id[$index] = $row_t['class_name_id'];$index++;
          }

          $this->db->where_in('id',$arr_class_id);
          $this->db->order_by('name','desc');
          $classes = $this->db->get('class_name')->result_array();
          $page_data['classes_name'] = $classes;
        }
        $page_data['page_name']  = 'attendance_class';
        $page_data['page_title'] = 'Note attendance';
        $page_data['function']   = 'attendance_class';
        $this->load->view('backend/index', $page_data); 

      }

    /* ---- MAKR ATTENDANCE ----*/
    // THE VIEW THAT'S USED TO DISPLAY THE ATTENDANCE OF THE CLASS THAT NEED TO MARK
    function attendance_note($param1 ='',$param2 ='')
    {
      if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('teacher_login') != 1)
      {  
        redirect('login', 'refresh');
      }
      $class_id = $this->input->post('class_id');
    
      $date = str_replace('/','-', $this->input->post('date'));
    
      $date1 = $date;
     
      $y = date('Y',now());
      $m = date('m',now());
         
      $this->db->select ('*');
      $this->db->from('student');
      $this->db->join('class_student','class_student.student_id=student.student_id AND class_student.class_id = student.class_id');
      $this->db->where('student.class_id',$class_id);
      $this->db->where('study_year',$this->session->userdata('academic_year'));
      $query=$this->db->get();
    
          

      if ($date =='') 
      {
         $date = date('Y-m-d',now());
      }
      $this->db->select('*');
      $this->db->from('class_name');
      $this->db->order_by('name','desc');
      $class=$this->db->get();

      $page_data['classes_name']    = $class->result_array();

      if($this->session->userdata('teacher_login')==1)
      {
        $teacher_id = $this->db->get_where('teacher_info_detail',array('employee_id_code'=>$this->session->userdata('login_user_id'),'year'=>$this->session->userdata('academic_year')))->result_array();
       $index =0;
       foreach ($teacher_id as $row_t) {
           $arr_class_id[$index] = $row_t['class_name_id'];$index++;
       }

       $this->db->where_in('id',$arr_class_id);
       $this->db->order_by('name','desc');
       $classes = $this->db->get('class_name')->result_array();
       $page_data['classes_name'] = $classes;
      }
      $students = $query->result_array();
      $teacher_id = $this->db->get_where('teacher_class',array('class_name_id'=>$class_id,'year'=>$this->session->userdata('academic_year')))->row()->teacher_id;
      
      $teacher = $this->db->get_where('employee',array('employee_id'=>$teacher_id))->row()->name.' '.$this->db->get_where('employee',array('employee_id'=>$teacher_id))->row()->family_name;
    
      $page_data['teacher_name'] = $teacher;
      $page_data['students']   = $students;
      $page_data['page_name']  = 'mark_attendance';
      $page_data['page_data_title'] = 'Attendance';
      $page_data['function']   = 'attendance_class';
      $page_data['date']            = $date;
      $page_data['date1']           = $date1;

      if($class_id==''){$class_id= $param1;}
      $page_data['class_a']    = $class_id;
      if($study_time=='')
      {
          $study_time = $param2;
      }
      $page_data['study_time']   = $study_time; 
      $page_data['language']  = $language;
      $this->load->view('backend/index',$page_data); 
    }


    /* ---- VIEW ATTENDANCE  ----*/
    function view_weekly($param1 ='', $param2 ='',$param3 = '')
    {
      if($param1!='search')
      { 
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8){
            $year = $y-1;
            $year_last = $current_year-1;
            $scholar_year= $year_last.'-'.$current_year;
        }
        if($current_month>=8){
            $year = $current_year;
            $year_next = $current_year+1;
            $scholar_year = $current_year.'-'.$year_next;
        }
        $month = '08';
        $day = "01";
        $daate = strtotime($day.'/'.$month.'/'.$year);  
       
        $date = $year.'-'.$month.'-'.'01';
        $date = date('Y-m-d',strtotime($date));

       $attendances = $this->db->get_where('attendance',array('date >='=>$date,'scholar_year'=>$scholar_year,'student_id'=>$param1))->result_array();

        if($current_month>=8){$year_next = $current_year +1; $study_year = $current_year.'-'.$year_next;}
        if($current_month<8){$year_last = $current_year -1; $study_year = $year_last.'-'.$current_year;}
        $grade_id   = $this->db->get_where('class_info',array('id'=>$param2))->row()->class_id;
        $grade_name = $this->db->get_where('class',array('class_id',$grade_id))->row()->name;

        $page_data['student_name'] = $this->db->get_where('student',array('student_id'=>$param1))->row()->name;
        $page_data['class_name']   = $this->db->get_where('class_name',array('id'=>$param2))->row()->name;
        $page_data['study_time'] = $this->db->get_where('class_student',array('student_id'=>$param1,'study_year'=>$this->session->userdata('academic_year')))->row()->study_time;
        $page_data['language']   = $this->db->get_where('class_student',array('student_id'=>$param1,'study_year'=>$this->session->userdata('academic_year')))->row()->language;
        $page_data['attendances']= $attendances; 
        $page_data['grade_name'] = $grade_name;
        $page_data['page_name']  = 'view_attendance';
        $page_data['page_title'] = 'Attendance detail';
        $page_data['student_id'] = $param1;
        $page_data['function']   = 'view_weekly';
        $this->load->view('backend/index',$page_data);  
      }

      if($param1 =='search') 
      {
        $from = $this->input->post('from_date');
        $to   = $this->input->post('to_date');

        $from = str_replace('/', '-',$from);
        $to   = str_replace('/', '-',$to);
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8){
            $year = $current_year-1;
            $year_last = $current_year-1;
            $scholar_year= $year_last.'-'.$current_year;
        }
        if($current_month>=8){
            $year = $current_year;
            $year_next = $current_year+1;
            $scholar_year = $current_year.'-'.$year_next;
        }
        $attendances = $this->db->get_where('attendance',array('date >='=>$from,'date <='=>$to,'scholar_year'=>$scholar_year,'student_id'=>$param2))->result_array();

        $page_data['student_name'] = $this->db->get_where('student',array('student_id'=>$param2))->row()->name;
        $class_id = $this->db->get_where('class_student',array('student_id'=>$param2))->row()->class_id;
        $page_data['class_name']   = $this->input->post('cname');
        $page_data['study_time'] = $this->db->get_where('class_student',array('student_id'=>$param2,'study_year'=>$scholar_year))->row()->study_time;
        $page_data['attendances']=  $attendances; 
        $page_data['page_name']  = 'view_attendance';
        $page_data['page_title'] = 'Attendance detail';
        $page_data['student_id'] = $param2;
        $page_data['from_date']  = $from;
        $page_data['to_date']    = $to;
        $page_data['function']   = 'view_weekly';
        $this->load->view('backend/index',$page_data);  
        }
    }

/*------ADD BOOK --------*/
    function add_book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('administrator_login') != 1)
            redirect('login', 'refresh');
            
        if($param1 == 'create')
        {
          $data['name']           = $this->input->post('title');
          $data['author']         = $this->input->post('author_name');
          $data['isbn']           = $this->input->post('isbn');
          $data['quantity']       = $this->input->post('copies');
          $data['edition']        = $this->input->post('edition');
          $data['description']    = $this->input->post('description');
          $data['author2']        = $this->input->post('author_name2');
          $data['author3']        = $this->input->post('author_name3');
          $this->db->insert('book',$data);

          $myfile = fopen('log.txt','a+');
          $text   = $this->session->userdata('name').'\\'."\t";
          fwrite ($myfile,$text);
          $text   = "add new book ".'\''.$data['name'].'\''."\t".'\\';
          fwrite ($myfile,$text);
          $text   = date('d M,Y',now());
          fwrite ($myfile, $text);
          $text   = "\n";
          fwrite($myfile, $text);
          fclose ($myfile);
          $this->session->set_flashdata('flash_message' , 'Data updated');
          redirect(base_url() . 'index.php?admin/add_book/', 'refresh');
        }
        $page_data['books']      = $this->crud_model->get_all_book();
        $page_data['page_name']  = 'add_book';
        $page_data['page_title'] = 'Book list';
        $page_data['function']   = 'add_book';
        $this->load->view('backend/index', $page_data);       
    }

    /* -- VIEW BOOK -- */
    function view_book($param1 ='')
    {
      $page_data['books'] = $this->db->get_where('book',array('book_id'=>$param1))->result_array();
      $page_data['page_name'] = 'view_book';
      $page_data['page_title']= 'Book information';
      $page_data['function']  = 'view_book';
      $this->load->view('backend/index',$page_data);
    }

/*---EDIT BOOK INFO ---*/
    function edit_book($param1 ='',$param2 ='')
    {
      if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('administrator_login') != 1)
          redirect('login', 'refresh');
      if($param1 =='do_update')
      {
        $data['name']           = $this->input->post('title');
        $data['author']         = $this->input->post('author_name');
        $data['isbn']           = $this->input->post('isbn');
        $data['quantity']       = $this->input->post('copies');
        $data['edition']        = $this->input->post('edition');
        $data['description']    = $this->input->post('description');
        $data['author2']        = $this->input->post('author_name2');
        $data['author3']        = $this->input->post('author_name3');
        $this->db->where('book_id',$param2);
        $this->db->update('book',$data);
          $myfile = fopen('log.txt','a+');
         $text   = $this->session->userdata('name').'\\'."\t";
         fwrite ($myfile,$text);
         $text   = "edit book ".'\''.$data['name'].'\''."\t".'\\';
         fwrite ($myfile,$text);
         $text   = date('d M,Y',now());
         fwrite ($myfile, $text);
         $text   = "\n";
         fwrite($myfile, $text);
         fclose ($myfile);

        $this->session->set_flashdata('flash_message' , 'Data updated');
        redirect(base_url() . 'index.php?admin/add_book/', 'refresh');
      }
      $page_data['book_info'] = $this->crud_model->get_book_info($param1);
      $page_data['function']   = 'edit_book';
      $page_data['page_name']  = 'edit_book';
      $page_data['page_title'] = 'Edit book';
      $this->load->view('backend/index', $page_data); 
    }

    /*----DELETE BOOK ----*/
    function delete_book($param1 ='')
    {
      if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('administrator_login') != 1)
          redirect('login', 'refresh');
      $is_exist =$this->db->get_where('borrow_list',array('book_id'=>$param1))->row()->id;
      if($is_exist){
           $this->session->set_flashdata('flash_message' , 'Cannot be deleted');
          redirect(base_url() . 'index.php?admin/add_book/', 'refresh');
      }
      elseif($is_exist=='')
      {
        $myfile = fopen('log.txt','a+');
        $text   = $this->session->userdata('name').'\\'."\t";
        fwrite ($myfile,$text);
        $text   = "delete book ".'\''.$this->db->get_where('book',array('book_id'=>$param1))->row()->name.'\''."\t".'\\';
        fwrite ($myfile,$text);
        $text   = date('d M,Y',now());
        fwrite ($myfile, $text);
        $text   = "\n";
        fwrite($myfile, $text);
        fclose ($myfile);

        $this->db->where('book_id',$param1);
        $this->db->delete('book');
        $this->session->set_flashdata('flash_message' , 'Delete complete');
        redirect(base_url() . 'index.php?admin/add_book/', 'refresh');
      }
    }

/*-----BORROW FORM ----*/
    function borrow_form()
    {
      $page_data['students']   = $this->db->get('student')->result_array();
      $page_data['day']        = $this->db->get_where('settings',array('type'=>'borrow_book_period'))->row()->description;
      $page_data['page_name']  = 'borrow_form';
      $page_data['page_title'] = 'Borrow list';
      $page_data['function']   = 'borrow_book';
      $this->load->view('backend/index', $page_data); 
    }

    function borrow_date_calculation($borrow_day)
    { 
      $current_day = date('d',now());
      $current_month = date('m',now());
      $curent_year = date('Y',now());
      if($current_day+$borrow_day<=29 && $current_month==2)
      {
        $current_day = $current_day +$borrow_day; 
      }
      elseif($current_day+$borrow_day>29 && $current_month==2)
      {
        $ad = $borrow_day;
        $remain1 = 29-$current_day;
        $current_day = $ad - $remain1;
        $current_month = $current_month +1;
      }
     if(($current_day+$borrow_day<=31)&& ($current_month ==1 ||$current_month ==3 ||$current_month ==5 ||$current_month ==7 ||$current_month ==8 ||
        $current_month ==10 ||$current_month ==12))
     {
        $current_day = $current_day +$borrow_day;
     }
     elseif(($current_day+$borrow_day>31)&& ($current_month ==1 ||$current_month ==3 ||$current_month ==5 ||$current_month ==7 ||$current_month ==8 ||
                    $current_month ==10 ||$current_month ==12))
     {
      $ad =$borrow_day;
      $remain1= 31-$current_day;
      $current_day = $ad - $remain1;
      $current_month = $current_month +1;
      if($current_month==12)
      {
        $current_month =1; $current_year = $current_year +1;
      }
     }if(($current_day+$borrow_day <=30) &&($current_month==4||$current_month==6||$current_month==9||$current_month==11))
     {
        $current_day = $current_day +$borrow_day;
     }
     elseif(($current_day +$borrow_day >30) &&($current_month==4||$current_month==6||$current_month==9||$current_month==11))
     {
        $ad =$borrow_day;
        $remain1 = 30- $current_day;
        $current_day = $ad - $remain1;
        $current_month = $current_month +1;
     }
     $return_date = $current_year.'/'.$current_month.'/'.$current_day;
     return ($return_date)
    }
/*---- BORROW BOOK ----*/
    function borrow_book($param1 ='',$param2 = '')
    {
      if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('administrator_login') != 1)
          redirect('login', 'refresh');
          
      if($param1 == 'create')
      {
        $now = date('Y/m/d',now());
        $now = strtotime($now);
        $quantity_of_book=0;

        $stu = $this->input->post('student_id');
        $stu_id_pos = strrpos($stu, '#');
        $student_id_code = substr($stu, $stu_id_pos+1);
        $student_id = $this->db->get_where('student',array('student_id_code'=>$student_id_code))->row()->student_id;
        $quantity_of_book_borrow = $this->db->get_where('borrow_list',array('student_id'=>$student_id,'is_return'=>0))->result_array();
        foreach ($quantity_of_book_borrow as $b) {
            $quantity_of_book = $quantity_of_book + 1;
        }
        $quantity_of_book =  $quantity_of_book +1;
        if(($this->input->post('book_id2')!=''&& $this->input->post('return_date2')=='')
           ||($this->input->post('book_id3')!=''&& $this->input->post('return_date3')=='')
           ||($this->input->post('book_id4')!=''&& $this->input->post('return_date4')=='')
           ||($this->input->post('book_id5')!=''&& $this->input->post('return_date5')=='')
           ||($this->input->post('book_id')!=''&& $this->input->post('return_date')=='')
            )
        {
           $this->session->set_flashdata('flash_message' ,'Borrow deny return date not be set');
        redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
        }
        if(($this->input->post('book_id2')==''&& $this->input->post('return_date2')!='')
             ||($this->input->post('book_id3')==''&& $this->input->post('return_date3')!='')
             ||($this->input->post('book_id4')==''&& $this->input->post('return_date4')!='')
             ||($this->input->post('book_id5')==''&& $this->input->post('return_date5')!='')
             ||($this->input->post('book_id')==''&& $this->input->post('return_date')!='')
            ) {
            $this->session->set_flashdata('flash_message' ,'Borrow deny book title has not been set');
        redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
        }
        if($this->input->post('book_id2')!=''){$quantity_of_book = $quantity_of_book +1;}
        if($this->input->post('book_id3')!=''){$quantity_of_book = $quantity_of_book +1;}
        if($this->input->post('book_id4')!=''){$quantity_of_book = $quantity_of_book +1;}
        if($this->input->post('book_id5')!=''){$quantity_of_book = $quantity_of_book +1;}  
        if($quantity_of_book>5){
          $this->session->set_flashdata('flash_message' ,'Book borrow up to five, please return the book before borrow more');
          redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
        }
        if($quantity_of_book<=5)
        {
          $data['student_id'] = $student_id;
          $book = $this->input->post('book_id');
          $position = strrpos($book,'_by');

          $book_title = substr($book, 0,$position-1);
          $book_author = substr($book, $position+4);

          if($this->db->get_where('book',array('name'=>$book_title))->row()->book_id =='')
          {
            $this->session->set_flashdata('flash_message' ,'Book borrow not exist, please input the correct book title');
            redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
          }
          $data['book_id']    = $this->db->get_where('book',array('name'=>$book_title,'author'=>$book_author))->row()->book_id;
          
          $data['borrow_date']= $now;
           // Test if the return date is set//
          if($this->input->post('return_date')=='' ){
               $this->session->set_flashdata('flash_message' , 'borrow deny return date not set');
          redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
          }
          if($this->input->post('return_date')<1)
          {
            $this->session->set_flashdata('flash_message' , 'borrow deny return date cannot be set before today');
            redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
          }
          $borrow_day = $this->input->post('return_date');
            
          $return_date = borrow_date_calculation($borrow_day);
          $return_date = strtotime($return_date);

          $data['return_date']= $return_date;
          $data['is_return']  = 0;
          $this->db->insert('borrow_list',$data);
          //---UPDATE BOOK TABLE TO MINUS ONE QUANTITY THAT HAS BEEN BORROW---//
          $quantity = $this->db->get_where('book',array('book_id'=>$data['book_id']))->row()->quantity;
          $data1['quantity'] = $quantity - 1;
          $this->db->where('book_id',$data['book_id']);
          $this->db->update('book',$data1);

/* TEST IF USER BORROW MORE THAN ONE BOOK*/
            if($this->input->post('book_id2')!='')
            {
              $data['student_id'] = $student_id;
              $data['borrow_date']= $now;
              $book = $this->input->post('book_id2');
              $position = strrpos($book,'_by');
              $book_title = substr($book, 0,$position-1);
              $book_author = substr($book, $position+4);
        
              $data['book_id']    = $this->db->get_where('book',array('name'=>$book_title,'author'=>$book_author))->row()->book_id;

             // Test if the return date is set//
              if($this->input->post('return_date2')=='' ){
                 $this->session->set_flashdata('flash_message' , 'borrow deny return date not set');
                redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
              }
              if($this->input->post('return_date2')<1)
              {
                $this->session->set_flashdata('flash_message' , 'borrow deny return date cannot be set before today');
                redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
              }
              $borrow_day = $this->input->post('return_date2');
            $return_date = borrow_date_calculation($borrow_day);
            $return_date = strtotime($return_date);
            $data['return_date']= $return_date;
            $data['is_return']  = 0;
            $this->db->insert('borrow_list',$data);
            //---UPDATE BOOK TABLE TO MINUS ONE QUANTITY THAT HAS BEEN BORROW---//
            $quantity = $this->db->get_where('book',array('book_id'=>$data['book_id']))->row()->quantity;
            $data1['quantity'] = $quantity - 1;
            $this->db->where('book_id',$data['book_id']);
            $this->db->update('book',$data1);
            }

            if($this->input->post('book_id3') !='')
            {
              $data['student_id'] = $student_id;
              $data['borrow_date']= $now;
              $book = $this->input->post('book_id3');
              $position = strrpos($book,'_by');
              $book_title = substr($book, 0,$position-1);
              $book_author = substr($book, $position+4);

              $data['book_id']    = $this->db->get_where('book',array('name'=>$book_title,'author'=>$book_author))->row()->book_id;
            // Test if the return date is set//
           if($this->input->post('return_date3')=='' ){
              $this->session->set_flashdata('flash_message' , 'borrow deny return date not set');
              redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
            }
           if($this->input->post('return_date3')<1)
           {
             $this->session->set_flashdata('flash_message' , 'borrow deny return date cannot be set before today');
             redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
           }
            $borrow_day = $this->input->post('return_date3');
            
            $return_date = borrow_date_calculation($borrow_day);
            $return_date = strtotime($return_date);
            $data['return_date']= $return_date;
            $data['is_return']  = 0;
            $this->db->insert('borrow_list',$data);
            //---UPDATE BOOK TABLE TO MINUS ONE QUANTITY THAT HAS BEEN BORROW---//
            $quantity = $this->db->get_where('book',array('book_id'=>$data['book_id']))->row()->quantity;
            $data1['quantity'] = $quantity - 1;
            $this->db->where('book_id',$data['book_id']);
            $this->db->update('book',$data1);

            }

            if($this->input->post('book_id4')!='')
            {
              $data['student_id'] = $student_id;
              $data['borrow_date']= $now;
              $book = $this->input->post('book_id4');
              $position = strrpos($book,'_by');
              $book_title = substr($book, 0,$position-1);
              $book_author = substr($book, $position+4);

              $data['book_id']    = $this->db->get_where('book',array('name'=>$book_title,'author'=>$book_author))->row()->book_id;
             // Test if the return date is set//
           if($this->input->post('return_date4')=='' ){
                 $this->session->set_flashdata('flash_message' , 'borrow deny return date not set');
            redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
            }
            if($this->input->post('return_date4')<1){
                 $this->session->set_flashdata('flash_message' , 'borrow deny return date cannot be set before today');
            redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
            }
            $borrow_day = $this->input->post('return_date4');
            $return_date = borrow_date_calculation($borrow_day);
            $return_date = strtotime($return_date);
            $data['return_date']= $return_date;
            $data['is_return']  = 0;
            $this->db->insert('borrow_list',$data);
            //---UPDATE BOOK TABLE TO MINUS ONE QUANTITY THAT HAS BEEN BORROW---//
            $quantity = $this->db->get_where('book',array('book_id'=>$data['book_id']))->row()->quantity;
            $data1['quantity'] = $quantity - 1;
            $this->db->where('book_id',$data['book_id']);
            $this->db->update('book',$data1);
            }
             if($this->input->post('book_id5')!='')
            {
              $data['student_id'] = $student_id;
              $data['borrow_date']= $now;
              $book = $this->input->post('book_id5');
              $position = strrpos($book,'_by');

              $book_title = substr($book, 0,$position-1);
              $book_author = substr($book, $position+4);
              $data['book_id']    = $this->db->get_where('book',array('name'=>$book_title,'author'=>$book_author))->row()->book_id;
             // Test if the return date is set//
            if($this->input->post('return_date5')=='' )
            {
              $this->session->set_flashdata('flash_message' , 'borrow deny return date not set');
              redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
            }
            if($this->input->post('return_date5')<1)
            {
              $this->session->set_flashdata('flash_message' , 'borrow deny return date cannot be set before today');
              redirect(base_url() . 'index.php?admin/borrow_form/' , 'refresh');
            }
            $borrow_day = $this->input->post('return_date5');
            $return_date = borrow_date_calculation($borrow_day);
            $return_date = strtotime($return_date);
            $data['return_date']= $return_date;
            $data['is_return']  = 0;
            $this->db->insert('borrow_list',$data);
            //---UPDATE BOOK TABLE TO MINUS ONE QUANTITY THAT HAS BEEN BORROW---//
            $quantity = $this->db->get_where('book',array('book_id'=>$data['book_id']))->row()->quantity;
            $data1['quantity'] = $quantity - 1;
            $this->db->where('book_id',$data['book_id']);
            $this->db->update('book',$data1);
            }
        }
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "note borrow book of student ".'\''.$this->db->get_where('student',array('student_id'=>$student_id))->row()->name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/borrow_book/' , 'refresh');
        }
        if($param1=='delete'){
            $books = $this->db->get_where('borrow_list',array('student_id'=>$param2))->result_array();
            foreach ($books as $book) {
                $quantity = $this->db->get_where('book',array('book_id'=>$book['book_id']))->row()->quantity;
                $data['quantity']  = $quantity +1;
                $this->db->where('book_id',$book['book_id']);
                $this->db->update('book',$data);
            }
            $this->db->where('student_id',$param2);
            $this->db->delete('borrow_list');
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "delete a borrow info "."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/borrow_book/' , 'refresh');
        }
        $page_data['function']   = 'borrow_book';
        $page_data['students']   = $this->db->get('student')->result_array();
        $page_data['books']      = $this->crud_model->get_all_borrow_book();
        $page_data['page_name']  = 'borrow_book';
        $page_data['page_title'] = 'Borrow list';
        $this->load->view('backend/index', $page_data); 
    }



/*----RETURN BOOK ----*/
    function return_book($param1 = '', $param2 = '',$param3 = ''){
        if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('administrator_login') != 1)
            redirect('login', 'refresh');

        if($param1 =='create')
        {
          $book_id = $this->input->post('return_id');
          foreach ($book_id as $return_id) {
             $data['is_return'] = 1;
             $this->db->where('book_id',$return_id);
             $this->db->where('student_id',$param2);
             $this->db->update('borrow_list',$data);

             $quantity = $this->db->get_where('book',array('book_id'=>$return_id))->row()->quantity;
             $data1['quantity']  = $quantity + 1;
             $this->db->where('book_id',$return_id);
             $this->db->update('book',$data1);
          }
          $myfile = fopen('log.txt','a+');
          $text   = $this->session->userdata('name').'\\'."\t";
          fwrite ($myfile,$text);
          $text   = "note return book of student".'\''.$this->db->get_where('student',array('student_id'=>$param2))->row()->name.'\''."\t".'\\';
          fwrite ($myfile,$text);
          $text   = date('d M,Y',now());
          fwrite ($myfile, $text);
          $text   = "\n";
          fwrite($myfile, $text);
          fclose ($myfile);
          $this->session->set_flashdata('flash_message' , 'Data updated');
          redirect(base_url() . 'index.php?admin/borrow_book/' , 'refresh');
        }

        $page_data['function']   = 'return_book';
        $page_data['page_name']  = 'return_book';
        $page_data['page_title'] =  'Return_book';
        $page_data['books']      = $this->crud_model->get_student_borrow_book($param2);
        $this->load->view('backend/index',$page_data);
    }

/* ----EMPLOYEE VIEW DETAIL ----*/
    function employee_view($param1  =''){
        $page_data['page_name']     = 'employee_detail';
        $page_data['page_title']    = '';
        $page_data['employee']      = $this->db->get_where('employee',array('employee_id'=>$param1))->result_array();
        $page_data['function']      = 'employee_view';
        $this->load->view('backend/index',$page_data);
    }


/*-----MANAGE EMPLOYEE -------*/
    function employee_add($param1 ='', $param2 ='', $param3 ='')
    {
        if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');
          
        if($param1 =='create')
        {  
          if($this->input->post('visa_status')!='' && $this->input->post('work_permission') !='')
          {
            $data2['visa_status']        = $this->input->post('visa_status');
            $data2['visa_exp_date']      = $this->input->post('visa_date');
            $data2['work_permission_status'] = $this->input->post('work_permission');
            $data2['work_permission_exp_date'] = $this->input->post('work_permission_date');
            $this->db->insert('work_verification',$data2);
            $work_verification_id = $this->db->insert_id();
          }
          $data['name']               = $this->input->post('first_name');
          $data['family_name']        = $this->input->post('last_name');
          $data['dob']                = strtotime($this->input->post('birthday'));
          $data['cell_phone']         = $this->input->post('cell_phone');
          $data['home_phone']         = $this->input->post('home_phone');
          $data['email']              = $this->input->post('mail');
          $data['address']            = $this->input->post('address');
          $data['position']           = $this->input->post('job_title');
          $data['work_hour']          = $this->input->post('work_hour');
          $data['salary']             = $this->input->post('monthly_salary');
          $data['previous_place']     = $this->input->post('previous_place');
          $data['name_relative_in_org'] = $this->input->post('friend_in_org');
          $data['work_verification_id'] = $work_verification_id;
            
          if($this->input->post('annual_salary')!='')
          { 
            $data['annual_salary']      = $this->input->post('annual_salary');
          }
          if($this->input->post('semi_month_salary')!='')
          {
            $data['semi_monthly_salary']= $this->input->post('semi_month_salary');
          }
          if($this->input->post('hourly_salary')!=''){
            $data['hourly_salary']      = $this->input->post('hourly_salary');
          }
          $data['work_hour']          = $this->input->post('work_hour');
          $data['employ_date']        = strtotime($this->input->post('date_employed'));
          $data['salary']             = $this->input->post('monthly_salary');
          $data['gender']             = $this->input->post('sex');
          $data['date_available_work']= strtotime($this->input->post('d_available'));
          $this->db->order_by('employee_id','desc');
          $query = $this->db->get('employee');
          $emp_id = $query->row()->employee_id;
           
          if($emp_id=='' || $emp_id==0)
          {
            $emp_id =1;
          }
          else
          {
            $emp_id+=1;
          }
          $emp_id = sprintf("%03d", $emp_id);
          $current_month = date('m',now());
          $current_year = date('y',now());
          $data['employee_id_code'] = 'TSIA'.$current_month.$current_year.$emp_id;

          $this->db->insert('employee',$data);
          $data1['name'] = $data['name'].$data['family_name'];
          if($data['email']!='')
          {$data1['email'] = $data['email'];}
          elseif($data['email']=='')
          {
              $data1['email']= strtolower($data1['name']).'@tsia.edu.kh';
          }
          $data1['password'] = '1234';
          $data1['employee_id_code']= $data['employee_id_code'];
          if(strtolower($data['position'])=='teacher')
          {
            $this->db->insert('teacher',$data1);
          }
          elseif(strtolower($data['position'])=='accountant' || strtolower($data['position'])=='account')
          {
            $this->db->insert('accountant',$data1);
          }
          elseif(strtolower($data['position'])=='administrator' || strtolower($data['position'])=='admin')
          {
            $this->db->insert('administrator',$data1);
          }

          $myfile = fopen('log.txt','a+');
           $text   = $this->session->userdata('name').'\\'."\t";
           fwrite ($myfile,$text);
           $text   = "add employee ".'\''.$data['name'].$data['family_name'].'\''."\t".'\\';
           fwrite ($myfile,$text);
           $text   = date('d M,Y',now());
           fwrite ($myfile, $text);
           $text   = "\n";
           fwrite($myfile, $text);
           fclose ($myfile);
          $this->session->set_flashdata('flash_message' , 'Data added successfully');
          redirect(base_url() . 'index.php?admin/employee_add/', 'refresh');
        }
        if($param1 =='do_update'){
          $data['name']               = $this->input->post('first_name');
          $data['family_name']        = $this->input->post('last_name');
           if(strtotime($this->input->post('birthday'))!='')
           {
            $data['dob']                = strtotime($this->input->post('birthday'));
           }
            $data['cell_phone']         = $this->input->post('cell_phone');
            $data['home_phone']         = $this->input->post('home_phone');
            $data['email']              = $this->input->post('mail');
            $data['address']            = $this->input->post('address');
            $data['position']           = $this->input->post('job_title');
            $data['work_hour']          = $this->input->post('work_hour');
            $data['salary']             = $this->input->post('monthly_salary');
           $data['hire_by']             = $this->input->post('hired_by');
           if(strtotime($this->input->post('date_employed'))!='')
           {
            $data['salary_date']        = strtotime($this->input->post('date_employed'));
            }
            $data['work_hour']          = $this->input->post('work_hour');

            if(strtotime($this->input->post('date_employed'))!=''){
            $data['employ_date']        = strtotime($this->input->post('date_employed'));
            }
            $data['salary']             = $this->input->post('monthly_salary');
            $data['gender']             = $this->input->post('sex');
            $this->db->where('employee_id',$param2);
            $this->db->update('employee',$data);

            $wp_id = $this->db->get_where('employee',array('employee_id'=>$param2))->row()->work_verification_id;
            if($wp_id){
              $data2['visa_status'] = $this->input->post('visa_status');
              $data2['visa_exp_date'] = $this->input->post('visa_date');
              $data2['work_permission_status'] = $this->input->post('work_permission');
              $data2['work_permission_exp_date'] = $this->input->post('work_permission_date');
              $this->db->where('id',$wp_id);
              $this->db->update('work_verification',$data2);
            }
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "update employee ".'\''.$data['name'].$data['family_name'].'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);

            $employee_code = $this->db->get_where('employee',array('employee_id'=>$param2))->row()->employee_id_code;
            $data1['email'] =$data['email'];
            $data1['password'] = md5('1234');
            if(strtolower($data['position'])=='teacher')
            {
              $data1['name']  = $data['name'].' '.$data['family_name'];
              $this->db->where('employee_id_code',$employee_code);
              $this->db->update('teacher',$data1);
            }
            elseif(strtolower($data['position'])=='administrator'||strtolower($data['position'])=='admin')
            {
              $this->db->update('administrator',$data1);
            }
            elseif(strtolower($data['position'])=='accountant'|| strtolower($data['position'])=='account')
            {
              $this->db->update('accountant',$data1);
            }
            redirect(base_url() . 'index.php?admin/employee_information_list/', 'refresh');

        }
        if($param1 =='delete'){
            $teachers =$this->db->get_where('subject',array('teacher_id'=>$param2))->result_array();
            if($teachers!=''){
              foreach ($teachers as $teacher) {
                 $data['teacher_id'] = 0;
                 $this->db->where('teacher_id',$teacher['teacher_id']);
                 $this->db->update('subject',$data);
              }
            } 
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "delete employee ".'\''.$this->db->get_where('employee',array('employee_id'=>$param2))->row()->name.$this->db->get_where('employee',array('employee_id'=>$param2))->row()->family_name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);

             $position = $this->db->get_where('employee',array('employee_id'=>$param2))->row()->position;
             $employee_id_code = $this->db->get_where('employee',array('employee_id'=>$param2))->row()->employee_id_code;
             if($position == 'teacher')
            { 
              $this->db->where('employee_id_code',$employee_id_code);
              $this->db->delete('teacher');

              $this->db->where('teacher_id',$employee_id_code);
              $this->db->delete('teacher_class');
            }
            elseif($position =='admin' || $position=='administrator')
            {
              $this->db->where('employee_id_code',$employee_id_code);
              $this->db->delete('administrator');
            }
            elseif($position =='account' || $position == 'accountant')
            {
              $this->db->where('employee_id_code',$employee_id_code);
              $this->db->delete('accountant');
            }
            $work_p_id = $this->db->get_where('employee',array('employee_id',$param2))->row()->work_verification_id;
            if($work_p_id)
            {
              $this->db->where('id',$work_p_id);
              $this->db->delete('work_verification');
            }
            $this->db->where('employee_id',$param2);
            $this->db->delete('employee');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/employee_information_list', 'refresh');
        }
        $page_data['function']   = 'employee_add';
        $page_data['page_name']  = 'employee_add';
        $page_data['page_title'] = 'Add employee';
        $this->load->view('backend/index', $page_data);
    }
    /* ----EMPLOYEE CONTRACT ----*/
    function employee_contract($param1 ='', $param2 ='', $param3='')
    {
     if ($this->session->userdata('admin_login') != 1)
      { 
       redirect('login', 'refresh');
      }
        if($param1 =='create')
        {
         $file_name = $_FILES["contract"]["name"];
         $extension = substr($file_name, -4);

         $this->db->select('*');
         $this->db->from('contract');
         $this->db->where('employee_id',$param2);
         $count = $this->db->count_all_results();

        $is_move=move_uploaded_file($_FILES['contract']['tmp_name'], 'uploads/document/contract/' . $param2.$count. $extension);
        if($this->db->get_where('contract',array('employee_id'=>$param2))->result_array()!=''){
            $old_contract['is_valid'] = 0;
            $this->db->where('employee_id',$param2);
            $this->db->update('contract',$old_contract);
        }

          $data['expired_date']   = strtotime($this->input->post('expired_date'));
          $data['employee_id']    = $param2;
          $data['contract_url']   = 'uploads/contract/'. $param2.$count. $extension;
          $data['is_valid']       = 1;
          $this->db->insert('contract',$data);
          $this->session->set_flashdata('flash_message' , 'Data updated');
          redirect(base_url() . 'index.php?admin/employee_information_list', 'refresh');
        } 
          $page_data['page_name']     = 'employee_contract';
          $page_data['page_title']    = 'Employee contract';
          $page_data['employee_id']   = $param1;
          $page_data['function']      = 'employee_contract';
          $this->load->view('backend/index', $page_data);
    }

    /*---- EMPLOYEE EDIT ----*/
    function employee_edit($param1 =''){
         if ($this->session->userdata('admin_login') != 1)
        {    
          redirect('login', 'refresh');
        }
        $wv_id = $this->db->get_where('employee',array('employee_id'=>$param1))->row()->work_verification_id;
        $page_data['employees']    = $this->db->get_where('employee',array('employee_id'=>$param1))->result_array();
        $page_data['work_verifications'] = $this->db->get_where('work_verification',array('id'=>$wv_id))->result_array();
        $page_data['page_name']   = 'employee_edit';
        $page_data['page_title']  = 'Update employee information';
        $page_data['function']      = 'employee_edit';
        $this->load->view('backend/index',$page_data);
    }

     function employee_information_list()
    {
      if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');

      $this->db->select('*');
      $this->db->from('employee');
      $query_emp = $this->db->get();
      $page_data['employees']     =  $query_emp->result_array();
      $page_data['page_name']     = 'employee';
      $page_data['page_title']    = 'Employee list';
      $page_data['function']      = 'employee_information_list';                                    
      $this->load->view('backend/index', $page_data);
    }

    /* ----EMPLOYEE ATTENDANCE ----*/
     function employee_attendance($param1 ='',$param2 ='')
     {
      if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');

      if($param1 =="create"){
        $employees = $this->input->post('teacher_id');
        $sby_p = $this->input->post('standby_name');

        $emp_id_pos = strrpos($employees, '#');
        $employee_id_code = substr($employees, $emp_id_pos+1);       
        $sby_id_pos = strrpos($sby_p,'#');
        $sby_id_code = substr($sby_p,$sby_id_pos+1);
        $stand_by_person_id = $sby_id_code;
        $number = $this->input->post('number_of_day');
        $from_date = $this->input->post('from_date');
        $return_date = $this->input->post('to_date');
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8){
            $year_last = $current_year-1;
            $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8){
            $year_next = $current_year +1;
            $year = $current_year.'-'.$year_next;
        }
       
        $data['reason'] = $this->input->post('p_reason');
        $data['employee_id'] = $employee_id_code;
        $data['p_standby_id'] = $sby_id_code;
        $data['permission_type'] = $this->input->post('p_type');
        $data['year']        = $year;
        $data['from_date']   = strtotime($from_date);
        $data['return_date'] = strtotime($return_date);
        $data['days']        = $number;
        $this->db->insert('employee_attendance',$data);
        $this->session->set_flashdata('flash_message' , 'Data updated');
      redirect(base_url() . 'index.php?admin/employee_attendance', 'refresh');

      }
      if($param1 =="do_update")
      {
        $employees = $this->input->post('employee_id');
        $sby_p = $this->input->post('standby_name');
        $emp_id_pos = strrpos($employees, '#');
        $employee_id_code = substr($employees, $emp_id_pos+1);
        $sby_id_pos = strrpos($sby_p,'#');
        $sby_id_code = substr($employees,$sby_id_pos+1);
        $stand_by_person_id = $sby_id_code;
        $number = $this->input->post('number_of_day');
        $from_date = $this->input->post('from_date');
        $return_date = $this->input->post('to_date');

        $current_month = date('m',now());
        $current_year = date('Y',now());
       if($current_month<8)
       {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }
        $data['reason'] = $this->input->post('p_reason');
        $data['employee_id'] = $employee_id_code;
        $data['p_standby_id'] = $sby_id_code;
        $data['permission_type'] = $this->input->post('p_type');
        $data['year']        = $year;
        $data['from_date']   = strtotime($from_date);
        $data['return_date'] = strtotime($return_date);
        $data['days']        = $number;
        $this->db->where('id',$param2);
        $this->db->update('employee_attendance',$data);
        $this->session->set_flashdata('flash_message' , 'Data updated');
        redirect(base_url() . 'index.php?admin/employee_attendance', 'refresh');
      }
      if($param1 =='delete')
      {
        $this->db->where('id',$param2);
        $this->db->delete('employee_attendance');
        $this->session->set_flashdata('flash_message' , 'data_deleted');
        redirect(base_url() . 'index.php?admin/employee_attendance', 'refresh');
      }

      $current_month = date('m',now());
      $current_year = date('Y',now());
      if($current_month<8)
      {
        $year_last = $current_year-1;
        $year = $year_last.'-'.$current_year;
      }
      elseif($current_month>=8)
      {
        $year_next = $current_year +1;
        $year = $current_year.'-'.$year_next;
      }

      $page_data['function']      = 'employee_attendance';
      $page_data['employee_attendances'] = $this->db->get_where('employee_attendance',array('year'=>$this->session->userdata('academic_year')))->result_array();
      $page_data['page_name']  = 'employee_attendance';
      $page_data['page_title'] = 'Employee attendance';
      $this->load->view('backend/index',$page_data);
     }

     /* SORT THE EMPLOYEE LEAVE FORM BY DATE */
     function employee_attendance_search()
     {
        if($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');
         
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');

        $page_data['function']      = 'employee_attendance';
        $page_data['employee_attendances'] = $this->db->get_where('employee_attendance',array('year'=>$this_session->userdata('academic_year')))->result_array();
        $page_data['page_name']  = 'employee_attendance';
        $page_data['page_title'] = 'Employee attendance';
        $this->load->view('backend/index',$page_data);
     }

     function employee_attendance_edit($param1 ='', $param2='')
     {
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8)
        {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }

        $page_data['param2']          = $param1;
        $page_data['edit_data'] =$this->db->get_where('employee_attendance',array('id' => $param1,'year'=>$year))->result_array();
    
        $page_data['page_name'] = 'employee_attendance_edit';
        $page_data['page_title'] = 'Edit permit form';
        $page_data['function']   = 'employee_attendance_edit';
        $this->load->view('backend/index',$page_data);
     }

    function employee_attendance_permission($param1 ='',$param2 ='')
    {
      if ($this->session->userdata('admin_login') != 1)
      redirect('login', 'refresh');
 
      $page_data['function']   = 'employee_attendance_permission';
      $page_data['page_name'] = 'employee_attendance_permission';
      $page_data['page_title'] = 'Leave permit';
      $this->load->view('backend/index',$page_data);
    }
    
    /****MANAGE STUDENTS CLASSWISE*****/
    function student_add()
    {
      if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('administrator_login') != 1 && $this->session->userdata('accountant_login') != 1)
        redirect(base_url(), 'refresh');
      
      $page_data['function']   = 'student_add';    
      $page_data['page_name']  = 'student_add';
      $page_data['page_title'] = 'Add student';
      $this->load->view('backend/index', $page_data);
    }
    
    function student_information($class_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $page_data['page_name']     = 'student_information';
        $page_data['page_title']    = 'Student_information'. " - ".'class'." : ".
          $this->crud_model->get_class_name($class_id);
        $page_data['class_id']  = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_profile($student_id = '')
    {
      if ($this->session->userdata('admin_login')!= 1 &&$this->session->userdata('administrator_login') != 1 &&$this->session->userdata('teacher_login') != 1 && $this->session->userdata('accountant_login') != 1)
        redirect('login', 'refresh');
        $page_data['descriptions']  = $this->crud_model->get_description($student_id);
         
        $page_data['page_name']     = 'student_profile';
        $page_data['function']       = 'student_information_all';
        $page_data['student_id']    = $student_id;
        $this->load->view('backend/index', $page_data);
    }
    
     function student_edit($student_id = '')
    {
      if ($this->session->userdata('admin_login')!= 1 &&$this->session->userdata('administrator_login') != 1)
        redirect('login', 'refresh');

      $class = $this->db->get_where('student',array('student_id'=>$student_id))->row()->class_id;
      $class_detail = $this->db->get_where('class_name',array('id'=>$class))->row()->class_detail_id;
      $class_id = $this->db->get_where('class_detail',array('class_detail_id'=>$class_detail))->row()->class_id;

      $page_data['class_id']      = $class_id;
      $page_data['page_name']     = 'student_edit';
      $page_data['function']      = 'student_edit';
      $page_data['student_id']    = $student_id;
      $this->load->view('backend/index', $page_data);
    }

     function student_information_all()
    {
      if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('administrator_login') != 1&& $this->session->userdata('accountant_login') != 1)
          redirect('login', 'refresh');
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8)
       {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }
        $page_data['classes']       = $this->db->get('class')->result_array();
                                      $this->db->select('*');
                                      $this->db->from('class_name');
                                      $this->db->order_by('name','desc');
        $page_data['class_names']   = $this->db->get()->result_array();         
        $page_data['page_name']     = 'student_information_all';
        $page_data['page_title']    = 'Student information';
        $this->db->select('*');
        $this->db->from('class_student');
        $this->db->join('student','class_student.student_id=student.student_id');
        $this->db->where('study_year',$this->session->userdata('academic_year'));
        $page_data['students']       = $this->db->get()->result_array();
        $page_data['function']       = 'student_information_all';
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet($class_id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');
          
      $page_data['page_name']  = 'student_marksheet';
      $page_data['page_title']    = 'Student marksheet'. " - ".'class'." : ".
                                          $this->crud_model->get_class_name($class_id);
      $page_data['class_id']  = $class_id;
      $this->load->view('backend/index', $page_data);
    }

    function enroll($param1 ='',$param2 = '', $param3 = '')
    {
      if($this->session->userdata('admin_login')!= 1)
        redirect('login','refresh');
      if ($param2 == 'do_update') {
        $data['name']        = $this->input->post('name');

        $class_detail_id = $this->db->get_where('class_name',array('id'=>$this->input->post('enroll_class_id')))->row()->class_detail_id;
        $study_time = $this->db->get_where('class_detail',array('class_detail_id'=>$class_detail_id))->row()->study_time;
        $language   = $this->db->get_where('class_detail',array('class_detail_id'=>$class_detail_id))->row()->language;

        $data['attendance_status_type'] = $study_time;
        $data['class_id']    = $this->input->post('enroll_class_id');      
        $this->db->where('student_id', $param3);
        $this->db->update('student', $data);

        $myfile = fopen('log.txt','a+');
         $text   = $this->session->userdata('name').'\\'."\t";
         fwrite ($myfile,$text);
         $text   = "enroll student ".'\''.$data['name'].'\''."\t".'\\';
         fwrite ($myfile,$text);
         $text   = date('d M,Y',now());
         fwrite ($myfile, $text);
         $text   = "\n";
         fwrite($myfile, $text);
         fclose ($myfile);
          move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
          $this->crud_model->clear_cache();
           $iids= $this->db->get('invoice')->result_array();
           foreach ($iids as $row3 ) {
              $iid = $row3['invoice_id'];
           }
         $enroll_fee = $this->crud_model->get_class_enroll_fee($data['class_id']);
         $iid= $iid+1;


         $sids = $this->db->get_where('student',array('student_id'=>$param3))->result_array();
         foreach ($sids as $row ) {
             $sid = $row['student_id_code'];
         }
         $date_exist = $this->db->get_where('class_student',array('student_id'=>$param3,'class_id'=>$this->input->post('current_class')))->row()->study_year;


        $year = date("Y",now());
        $month = date('m',now());
        $year_next = $year + 1;
        $last_year = $year -1;
        if($month>=8){
         $data5['study_year'] = $year .'-'.$year_next;   
        }
        if($month<8){
            $data5['study_year'] = $last_year .'-'.$year;
        }

        if($date_exist!=$data5['study_year'])
        {
         $data5['student_id'] = $param3;
         $data5['class_id']   = $data['class_id'];
        
         $data5['language']   = $language;
         $data5['study_time'] = $study_time;  
         $this->db->insert('class_student',$data5);
        }
        if($date_exist == $data5['study_year'])
        {
           $data5['class_id']   = $data['class_id'];
           $data5['language']   = $language;
           $this->db->where('student_id',$param3);
           $this->db->where('study_year',$date_exist);
           $this->db->update('class_student',$data5);
        }
        $data2['invoice_id_code']    = '#tsiai'.$iid;      
        $data2['student_id']         = $param3;   
        $data2['due_amount']         = 0;
        $data2['amount_paid']        = 0;
        $data2['payment_method']     = "n\a";
        $data2['status']             ='unpaid';
        $data2['creation_timestamp'] = now();
        $data2['discount']           = 0;

        $this->db->insert('invoice', $data2);
        $this->session->set_flashdata('flash_message' , 'Data updated');
        redirect(base_url() . 'index.php?admin/student_information_all/' , 'refresh');
        } 
    }

    /* POTENTIAL CUSTOMER ADD FORM*/
    function add_potential_customer($param1 ='')
    {
      if(($this->session->userdata('admin_login') !=1)&&($this->session->userdata('administrator_login')!=1)&&($this->session->userdata('accountant_login')!=1))
      redirect('login','refresh');

      if($param1=='create')
      {
        $data['name'] = $this->input->post('customer_name');
        $data['phone']= $this->input->post('phone');
        $data['email']= $this->input->post('email');
        $data['date'] = str_replace('/','-', $this->input->post('date'));
        $data['purpose'] = $this->input->post('purpose');

        $this->db->insert('potential_customer',$data);
         $this->session->set_flashdata('flash_message' , 'Data added successfully');
        redirect(base_url() . 'index.php?admin/potential_customer_list/' , 'refresh');
      }
      $page_data['function']       = 'add_potential_customer';
      $page_data['page_name']      = 'add_potential_customer';
      $page_data['page_title']     = 'Add potential customer';
       $this->load->view('backend/index', $page_data);
    }

    /* EDIT POTENTIAL CUSTOMER */
    function edit_potential_customer($param1 ='', $param2=''){
      if(($this->session->userdata('admin_login') !=1)&&($this->session->userdata('administrator_login')!=1)&&($this->session->userdata('accountant_login')!=1))
      redirect('login','refresh');

      if($param1=='update')
      {
          $data['name'] = $this->input->post('customer_name');
          $data['phone']= $this->input->post('phone');
          $data['email']= $this->input->post('email');
          $data['date'] = str_replace('/','-', $this->input->post('date'));
          $data['purpose'] = $this->input->post('purpose');
          $this->db->where('id',$param2);
          $this->db->update('potential_customer',$data);
           $this->session->set_flashdata('flash_message' , 'Data updated');
          redirect(base_url() . 'index.php?admin/potential_customer_list/' , 'refresh');
      }
      $page_data['p_id']           = $param1;
      $page_data['edit_data']      = $this->db->get_where('potential_customer',array('id'=>$param1))->result_array();
      $page_data['function']       = 'potential_customer_list';
      $page_data['page_name']      = 'edit_potential_customer';
      $page_data['page_title']     = 'Edit potential customer';
      $this->load->view('backend/index', $page_data);
    }

    /*DELETE POTENTIAL CUSTOMER*/
    function delete_potential_customer($id ='')
    {
      if(($this->session->userdata('admin_login') !=1)&&($this->session->userdata('administrator_login')!=1)&&($this->session->userdata('accountant_login')!=1))
      redirect('login','refresh');

      $this->db->where('id',$id);
      $this->db->delete('potential_customer');
        

      $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/potential_customer_list/' , 'refresh');
    }
    /*EMPLOYEE PERFORMANCE FORM*/
    function e_performance_form_add($parma1='',$p_id='')
    {
      $page_data['row']       = $this->db->get_where('employee_performance_form',array('id'=>$p_id))->result_array();
      $page_data['form_id']   = $p_id;
      $page_data['questions'] = $this->db->get('employee_performance_question')->result_array();
       $page_data['function'] = 'e_performance_form_add';
      $page_data['page_title']= 'Manage performance form';
      if(!$p_id)
      { $page_data['page_name'] = 'e_performance_add';}
      elseif($p_id){
       $page_data['page_name'] = 'e_performance_edit';
      }
      $this->load->view('backend/index',$page_data);
    }
    /* NOTE EMPLOYEE PERFORMANCE */
    function e_performance_note($param1='',$form_id='',$em_id='')
    {
       if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');
      if($param1 == 'create')
      {
          $data['form_id'] = $form_id;
          $data['employee_id'] = $em_id;//EMPLOYEE ID HERE MEAN EMPLOYEE ID CODE NOT THE AUTO INCREMENT  
          $questions = $this->input->post('question');
          $length = $this->input->post('q_num');
          $j=1;
          $data['date'] = date('Y-m-d',now());
          foreach ($questions as $question) {
              $data['question_id'] = $question;
              $data['answer_point'] = $this->input->post('mark'.$j);
              $this->db->insert('employee_performance',$data);

              $j++;
        }
        $this->session->set_flashdata('flash_message' , 'Data added successfully');
        redirect(base_url() . 'index.php?admin/e_performance_note/' , 'refresh');
      }
      if($param1=='view')
      {
        $form_id1 = $this->input->post('form_id');
        $this->db->select('employee_performance_question.id as q_id,question');
        $this->db->from('employee_performance_question');
        $this->db->join('employee_performance_form_question','employee_performance_form_question.e_question_id=employee_performance_question.id');
        $this->db->where('employee_performance_form_question.e_performance_form_id',$form_id1);
        $questions= $this->db->get()->result_array();

        $employee = $this->input->post('employee_id');
        $pos = strrpos( $employee,'#');
        $employee_id_code = substr($employee,$pos+1);
        
        $page_data['function'] = 'e_performance_note';
        $page_data['questions'] = $questions;
        $page_data['employee_name'] = substr($employee,0,$pos);
        $page_data['employee_id']   = $employee_id_code;
        $page_data['employees'] = $this->db->get('employee')->result_array();
        $page_data['form_id'] = $form_id1;
        $page_data['form'] = $this->db->get('employee_performance_form')->result_array();
        $page_data['page_name'] = 'e_performance_note';
        $page_data['page_title']= 'Note performance';
        $this->load->view('backend/index',$page_data);
      }
      if(!$param1)
      {    
        $page_data['function'] = 'e_performance_note';
        $page_data['employees'] = $this->db->get('employee')->result_array();
        $page_data['form'] = $this->db->get('employee_performance_form')->result_array();
        $page_data['page_name'] = 'e_performance_note';
        $page_data['page_title']= 'Note performance';
        $this->load->view('backend/index',$page_data);
      }
    }

    /* EMPLOYEE PERFORMANCE FORM */
    function e_performance_form($param1 ='', $id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
        redirect('login', 'refresh');
      if($param1=='create')
      {
        $data1['form_title'] = $this->input->post('form_name');
        $questions = $this->input->post('question');
        $date= now();
        $data1['creation_date']     = $date;

        $this->db->insert('employee_performance_form',$data1);
        $e_performance_id=$this->db->insert_id();
        $data['e_performance_form_id'] = $e_performance_id;

        foreach ($questions as $row) {
            $data['e_question_id'] = $row;
            
            $this->db->insert('employee_performance_form_question',$data);

        }
         $this->session->set_flashdata('flash_message' , 'Data added successfully');
        redirect(base_url() . 'index.php?admin/e_performance_form/' , 'refresh');
      }
      if($param1 =='update')
      {
        $this->db->where('e_performance_form_id',$id);
        $this->db->delete('employee_performance_form_question');
        $data1['form_title'] = $this->input->post('form_name');
        $questions = $this->input->post('question');
        $date= now();
        $data1['creation_date']     = $date;
        $this->db->where('id',$id);
        $this->db->update('employee_performance_form',$data1);
        $e_performance_id=$id;
        $data['e_performance_form_id'] = $e_performance_id;

        foreach ($questions as $row) {
          $data['e_question_id'] = $row;
          $this->db->insert('employee_performance_form_question',$data);
        }
         $this->session->set_flashdata('flash_message' , 'Data updated successfully');
        redirect(base_url() . 'index.php?admin/e_performance_form/' , 'refresh');
        }
        if($param1=='delete')
        {
          $this->db->where('e_performance_form_id',$id);
          $this->db->delete('employee_performance_form_question');
          $this->db->where('id',$id);
          $this->db->delete('employee_performance_form');
          $this->session->set_flashdata('flash_message' , 'Data deleted');
          redirect(base_url() . 'index.php?admin/e_performance_form/' , 'refresh');
        }

        $page_data['function'] = 'e_performance_form';
        $page_data['forms']     = $this->db->get('employee_performance_form')->result_array();
        $page_data['page_name'] = 'e_performance_form';
        $page_data['page_title']= 'Performance form ';
       $this->load->view('backend/index', $page_data);
    }

    /* POTENTIAL CUSTOMER LIST*/
    function potential_customer_list()
    {
      if(($this->session->userdata('admin_login') !=1)&&($this->session->userdata('administrator_login')!=1) &&($this->session->userdata('accountant_login')!=1))
      redirect('login','refresh');

      $page_data['customers'] = $this->db->get('potential_customer')->result_array();
      $page_data['page_name'] = 'potential_customer';
      $page_data['page_title']= 'Potential customer list';
      $page_data['function'] = 'potential_customer_list';
      $this->load->view('backend/index', $page_data);   
    }

    function e_performance_question_list()
    {
      if($this->session->userdata('admin_login')!=1)
      {
        redirect('login','refresh');
      }
      $page_data['questions'] = $this->db->get('employee_performance_question')->result_array();
      $page_data['page_name'] = 'e_performance_question_list';
      $page_data['page_title']= 'Question list';
      $page_data['function'] = 'e_performance_question_list';
      $this->load->view('backend/index',$page_data);
    }

    /* PERFORMANCE QUESTION MANAGE*/
    function e_performance_question($param1='',$id='')
    {
      if($this->session->userdata('admin_login') !=1)
      redirect('login','refresh');

      if($param1 == 'create')
      {
        $questions = $this->input->post('question');
        foreach ($questions as $row) {
          $data['question'] =$row;
          if($row!='')
          {
            $this->db->insert('employee_performance_question',$data);
          }  
        }
        $this->session->set_flashdata('flash_message' , 'Data added successfully');
        redirect(base_url() . 'index.php?admin/e_performance_question_list', 'refresh');
       }
      if($param1 =='edit')
      {    
        $data['question'] = $this->input->post('question');
        $this->db->where('id',$id);
        $this->db->update('employee_performance_question',$data);
        $this->session->set_flashdata('flash_message' , 'Data updated');
        redirect(base_url() . 'index.php?admin/e_performance_question_list', 'refresh');
       }
      if($param1 == 'delete')
      {
        $this->db->where('id',$id);
        $this->db->delete('employee_performance_question');
        $this->db->where('e_question_id',$id);
        $this->db->delete('employee_performance_form_question');
        $this->session->set_flashdata('flash_message' , 'Data deleted');
        redirect(base_url() . 'index.php?admin/e_performance_question_list', 'refresh');
      }
      $page_data['function'] = 'e_performance_question';
      $page_data['page_name'] = 'add_question';
      $page_data['page_title']= 'Manage question';
      $this->load->view('backend/index',$page_data);
    }
    /* EMPLOYEE PERFORMANCE DETAIL */
    function employee_performance_detail($employee_id='')
    {
        if($this->session->userdata('admin_login') !=1)
        redirect('login','refresh');

        $this->db->select('*');
        $this->db->from('employee_performance');
        $this->db->join('employee_performance_form_question','employee_performance_form_question.e_performance_form_id =employee_performance.form_id AND employee_performance_form_question.e_question_id= employee_performance.question_id');
        $this->db->join('employee_performance_form','employee_performance_form.id= employee_performance_form_question.e_performance_form_id');
        $this->db->join('employee_performance_question','employee_performance_question.id =employee_performance_form_question.e_question_id');
        $this->db->where('employee_id',$employee_id);
        $query = $this->db->get();

        $employee_name = $this->db->get_where('employee',array('employee_id_code'=>$employee_id))->row()->name.' '.$this->db->get_where('employee',array('employee_id_code'=>$employee_id))->row()->family_name;
       
        $page_data['function'] = 'employee_performance_detail';
        $page_data['performances']  = $query->result_array();
        $page_data['employee_name'] = $employee_id.' '.$employee_name;
        $page_data['page_name']     = 'employee_performance_detail';
        $page_data['page_title']    = '';
        $this->load->view('backend/index',$page_data);
    }

    /* EMPLOYEE PERFORMANCE*/
    function employee_performance($employee_id ='')
    {
       if($this->session->userdata('admin_login') !=1)
        redirect('login','refresh');

        $this->db->select('employee_id');
        $this->db->from('employee_performance');
        $this->db->distinct();
        $query = $this->db->get();
        $performances=$query->result_array();


       $row=0;$column=0;
       $month = date('m',now());
       $year  = date('Y',now());
       if($month<8)
       {
        $year = $year -1;
       }
       $d='01';$m=8;
       foreach ($performances as $performance) {
       $column=0;$m=8;
         for ($i=1; $i <=12 ; $i++) 
         { 
            $number=0;
            $point=0;$grade ="";
            $m=$m+$i-1;
           if($m>12)
           {
            $m = $m-12;
           }
           if(($m==1)||($m==3)||($m==5)||($m==7)||($m==8)||($m==10)||($m==12))
           {
            $day=31;
           }elseif(($m==4)||($m==6)||($m==9)||($m==11))
           {
            $day=30;
           }elseif(($m==2))
           {
            $day=29;
           }
           if($m<8){
            $year1 =$year +1;
           }elseif($m>=8){
            $year1 = $year ;
           }

           $p_date = $this->db->get_where('employee_performance',array('date >='=>$year1.'-'.$m.'-'.$d,'date <='=>$year.'-'.$m.'-'.$day,'employee_id'=>$performance['employee_id']))->result_array();
           foreach ($p_date as $mark) {$number++;
               $point = $point+$mark['answer_point'];
           }
          $point = $point/$number;

           if($point<=10 && $point>=8.1){
            $grade ='A';
           }elseif($point<=8 && $point>=6.1)
           {
            $grade = 'B';
           }elseif($point<=6 && $point>=4.1)
           {
            $grade = 'C';
           }elseif($point <=4 && $point>=2.1)
           {
            $grade = 'D';
           }elseif($point>=2 && $point >0)
           {
            $grade = 'E';
           }
           $marks[$row][$column] = $grade;
           $column++;
         }
           $row++;
       }
      $page_data['employees'] = $this->db->get('employee')->result_array();
      $page_data['marks'] = $marks;
      $page_data['function'] = 'employee_performance';
      $page_data['performances']= $performances;
      $page_data['page_name'] = 'employee_performance';
      $page_data['page_title']= 'Employee performance';
      $this->load->view('backend/index', $page_data);
    }

    function employee($param1 = '', $param2 = '', $param3 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
          redirect('login', 'refresh');
      if ($param1 == 'create') 
      {
         $myfile = fopen('log.txt','a+');
         $text   = $this->session->userdata('name').'\\'."\t";
         fwrite ($myfile,$text);
         $text   = "admission student ".'\''.$name.'\''."\t".'\\';
         fwrite ($myfile,$text);
         $text   = date('d M,Y',now());
         fwrite ($myfile, $text);
         $text   = "\n";
         fwrite($myfile, $text);
         fclose ($myfile);
         $file_name = $_FILES["userfile"]["name"];
         $extension = substr($file_name, -4);
        $is_move=move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . $extension);
         if($file_name)
         {
           $image['teacher_id'] = $teache_id;
           $image['image_url'] = 'uploads/student_image/'.$student_id.$extension;
           $this->db->insert('image',$image);
         }
      }
      if ($param2 == 'do_update') 
        {
          $data['name']   = $this->input->post('name');
          $data['gender'] = $this->input->post('gender');
          $data['position'] = $this->input->post('position');
          $data['address']  = $this->input->post('address');
          $data['mobile']   = $this->input->post('mobile');
          $data['salary']   = $this->input->post('salary');
          $data['work_time']= $this->input->post('work_time');//IT ILLUSTRATE THE TIME EMPLOYEES WORK FULL TIME OR PART TIME
          $data['contract_due_date'] = $this->input->post('contract_date');
          $data['email']    = $this->input->post('email');
          $this->db->where('id',$param3);
          $this->db->update('employee');
        }
       if ($param1 == 'delete') 
         {
            $this->db->where('id', $param2);
            $this->db->delete('employee');
            $image = $this->db->get_where('image',array('id'=>$param2))->row()->image_url;
            $image =  './'.$image;

            $this->db->where('id',$param2);
            $this->db->delete('image');

            unlink($image);
            $myfile = fopen('log.txt','a+');
            $text   = $this->session->userdata('name').'\\'."\t";
            fwrite ($myfile,$text);
            $text   = "delete student ".'\''.$this->db->get_where('student',array('student_id'=>$param2))->row()->name.'\''."\t".'\\';
            fwrite ($myfile,$text);
            $text   = date('d M,Y',now());
            fwrite ($myfile, $text);
            $text   = "\n";
            fwrite($myfile, $text);
            fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/student_information_all', 'refresh');
         }
    }


    
    function student($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('administrator_login') != 1&&$this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') 
        {
          $lastname = $this->input->post('last_name');
          $firstname = $this->input->post('first_name');
          $name=$lastname . ' ' . $firstname;
        //get the info of guardian and insert into table 
         $data1['guardian_name']         = $this->input->post('guardian_name');
         $data1['guardian_gender']       = $this->input->post('guardian_gender');   
         $data1['guardian_home_phone']   = $this->input->post('home_phone');
         $data1['guardian_work_phone']   = $this->input->post('work_phone');
         $data1['guardian_profession']   = $this->input->post('profession');
         $data1['guardian_email']        = $this->input->post('email');
         $data1['guardian_address']      = $this->input->post('gaddress');
             
         $parent_exist=$this->Crud_model->get_parent_info($data1['guardian_name'],$data1['guardian_address']);
          if($parent_exist==null)
          {$this->db->insert('parent',$data1);
          $parent_id1 = $this->db->insert_id();
          }
          if($parent_exist!=null)
          {
             $parent_id1=$parent_exist;
          }       
          if ($this->input->post('guardian_name2') != '') {

              $data4['guardian_name']         = $this->input->post('guardian_name2');
              $data4['guardian_gender']       = $this->input->post('guardian_gender2');   
              $data4['guardian_home_phone']   = $this->input->post('home_phone2');
              $data4['guardian_work_phone']   = $this->input->post('work_phone2');
              $data4['guardian_profession']   = $this->input->post('profession2');
              $data4['guardian_email']        = $this->input->post('email2');
              $data4['guardian_address']      = $this->input->post('gaddress2');
             
           $parent_exist=$this->Crud_model->get_parent_info($data4['guardian_name'],$data4['guardian_address']);
              if($parent_exist==null)
              {
                $this->db->insert('parent',$data4);
                $parent_id2 = $this->db->insert_id();
              }
              if($parent_exist!=null)
              {
                 $parent_id2=$parent_exist;
              }       
          }
         $file_name = $_FILES["userfile"]["name"];
         $extension = substr($file_name, -4);
         if($file_name){
            $image_last_id                = $this->crud_model->get_last_id('image');
            $data['image_id']              =  $image_last_id +1    ;
         }
            $data['name']                   = $name;
            $data['birthday']               = strtotime($this->input->post('birthday'));
            $data['sex']                    = $this->input->post('sex');
            $data['address']                = $this->input->post('address');
            $data['number_sibling']         = $this->input->post('num_sibling');
            $data['nationality']            = $this->input->post('nationality');
            $data['ethnicity']              = $this->input->post('ethnicity');
            $data['emergency_address']      = $this->input->post('emergencyaddr');
            $data['emergency_contact_two']  = $this->input->post('emergencyphone1');
            $data['attendance_status_type'] = $this->input->post('study_type');
            $data['emergency_relation']     = $this->input->post('relation');
            $data['emergency_contact_name']= $this->input->post('emergencyContactName');
            $data['emergency_contact_number']= $this->input->post('emergencyphone');
            
            $ids=$this->db->get('student')->result_array();
            foreach ($ids as $row ) {
                $id = $row['student_id'];
            }
           $id = $id +1;
           $id = sprintf("%04d", $id);
           $y = date('y',now());
           $cl_id = $this->input->post('class_group');
           if($cl_id=='') 
           {
             $data7['class_id']   = $this->input->post('class_id');
             $data7['language']   = $this->input->post('language');
             $data7['study_time'] = $this->input->post('study_type');
             $class_d_id = $this->db->get_where('class_detail',array('class_id'=>$data7['class_id'],'language'=>$data7['language'],
                'study_time'=>$data7['study_time']))->row()->class_detail_id;
              
              if($class_d_id=='')
              {
                  $this->db->insert('class_detail',$data7);
                  $class_d_id = $this->db->insert_id();  
              }
              $cl_id = $this->db->get_where('class_name',array('class_detail_id'=>$class_d_id))->row()->id;
              if($cl_id=='')
              {
                $cl_id = $this->crud_model->get_last_id('class_name')+1;
                $cl_name = $this->crud_model->get_class_name($data7['class_id']);
                $class_name_tb['name'] = $cl_name.'-'.$cl_id;
                $class_name_tb['class_detail_id'] = $class_d_id;
                $this->db->insert('class_name',$class_name_tb);
                $cl_id = $this->db->insert_id();
              }    
            }
            $data['class_id'] = $cl_id;
            $data['student_id_code'] = $y.$id; 
            $data['parent_id_one']  = $parent_id1;
            $data['parent_id_two']  = $parent_id2;
            if($data['class_id']==''){
                $data['class_id']=0;
            }
            $this->db->insert('student', $data);
            $c_id = $this->input->post('class_id');
            $student_id = $this->db->insert_id();

            $year = date("Y",now());
            $month = date('m',now());
            $yearn = $year + 1;
            $lyear = $year -1;
            if($month>=8){
             $data5['study_year'] = $year .'-'.$yearn;   
            }
            if($month<8){
                $data5['study_year'] = $lyear .'-'.$year;
            }
           $data5['student_id'] = $student_id;
           $data5['class_id']   = $data['class_id'];
           
           $data5['language']   = $this->input->post('language');
           $data5['study_time'] = $this->input->post('study_type');  
             
           $this->db->insert('class_student',$data5);
           $fee = $this->crud_model->get_class_fee( $c_id );
           $iids= $this->db->get('invoice')->result_array();
           foreach ($iids as $row3 ) {
              $iid = $row3['invoice_id'];
           }
            $iid= $iid+1;
            $data2['invoice_id_code']    = '#tsiai'.$iid;      
            $data2['student_id']         = $student_id;   
            $data2['due_amount']         = 0;
            $data2['amount_paid']        = 0;
            $data2['status']             ='unpaid';
            $data2['creation_timestamp'] = now();
            $data2['discount']           = 0;

            $this->db->insert('invoice', $data2);

             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "admission student ".'\''.$name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
             $file_name = $_FILES["userfile"]["name"];
             $extension = substr($file_name, -4);
             $is_move=move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . $extension);
             if($file_name){
             $image['image_url'] = 'uploads/student_image/'.$student_id.$extension;
             $this->db->insert('image',$image);
            }
            if($is_move)
            {$this->session->set_flashdata('flash_message' , 'Data addedsuccessfully');}
            if(!$is_move){
                $this->session->set_flashdata('flash_message','Data addedsuccessfully no photo uploaded or upload photo permission deny');
            }
            redirect(base_url() . 'index.php?admin/student_add/' . $data['class_id'], 'refresh');
        }
        if ($param2 == 'do_update') 
        {
          $data['name']        = $this->input->post('name');
          $data['birthday']    = strtotime($this->input->post('birthday'));
          $data['sex']         = $this->input->post('sex');
          $data['address']     = $this->input->post('address');
          $data['ethnicity']   = $this->input->post('ethnicity');
          $data['nationality'] = $this->input->post('nationality');
          $data['emergency_contact_name']   = $this->input->post('emergency_contact_name');
          $data['emergency_contact_number'] = $this->input->post('phone');
          $data['emergency_address']        = $this->input->post('emergency_contact_address');
          if($this->input->post('phone 2')!='')
          {
            $data['emergency_contact_two'] = $this->input->post('phone2');
          }
          $parent_id_one=$this->db->get_where('student',array('student_id'=>$param3))->row()->parent_id_one;
          $parent_id_two=$this->db->get_where('student',array('student_id'=>$param3))->row()->parent_id_two;
          $data1['guardian_name']       = $this->input->post('parent_id_one');
          $data1['guardian_home_phone'] = $this->input->post('phone_one');
          if($this->input->post('work_phone')!=''){
            $data1['work_phone']          = $this->input->post('work_phone');
          }
          $data1['guardian_gender']     = $this->input->post('ggender1');
          $data1['guardian_address']    = $this->input->post('gaddress');

          $this->db->where('parent_id',$parent_id_one);
          $this->db->update('parent',$data1);
          if($parent_id_two)
          {
            $data2['guardian_name']       = $this->input->post('parent_id_two');
            $data2['guardian_home_phone'] = $this->input->post('phone_two');
            if($this->input->post('work_phone2')!=''){
              $data2['work_phone']          = $this->input->post('work_phone2');
            }
            $data2['guardian_gender']     = $this->input->post('ggender2');
            $data2['guardian_address']    = $this->input->post('gaddress2');

            $this->db->where('parent_id',$parent_id_two);
            $this->db->update('parent',$data2);
          }
          elseif (!$parent_id_two) 
          {
            $data2['guardian_name']       = $this->input->post('parent_id_two');
            $data2['guardian_home_phone'] = $this->input->post('phone_two');
            if($this->input->post('work_phone2')!='')
            {
              $data2['work_phone']        = $this->input->post('work_phone2');
            }
            $data2['guardian_gender']     = $this->input->post('ggender2');
            $data2['guardian_address']    = $this->input->post('gaddress2');
 
            $this->db->insert('parent',$data2);
            $data['parent_id_two'] = $this->db->insert_id();
          }
            $tmp_name = $_FILES["userfile"]["name"];
            $extension = substr($tmp_name, -4);
            $file_name=$param3.$extension;
            if($tmp_name)
            {
              $is_image_exist = $this->crud_model->get_image_id($param3);
              if($is_image_exist == 0)
              {
                $image_last_id                = $this->crud_model->get_last_id('image');
                $data['image_id']              =  $image_last_id+1;
              }
            }
            $this->db->where('student_id', $param3);
            $this->db->update('student', $data);
            $myfile = fopen('log.txt','a+');
            $text   = $this->session->userdata('name').'\\'."\t";
            fwrite ($myfile,$text);
            $text   = "edit student ".'\''.$data['name'].'\''."\t".'\\';
            fwrite ($myfile,$text);
            $text   = date('d M,Y',now());
            fwrite ($myfile, $text);
            $text   = "\n";
            fwrite($myfile, $text);
            fclose ($myfile);
            $y = date('Y',now());
            $ye = $y -1;
            $study_year = $ye.'-'.$y;         
           $is_move = move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $file_name);
    
          if($tmp_name)
          {
            $image['image_url'] = 'uploads/student_image/'.$file_name;
            $image['id']        = $data['image_id'] ;
            if($is_image_exist > 0)
            {
              $this->db->where('id',$is_image_exist);
              $this->db->update('image',$image);
            }
            if($is_image_exist==0){
              $this->db->insert('image',$image);
            }
          }
          $this->crud_model->clear_cache();
          if($is_move)
          {$this->session->set_flashdata('flash_message' , 'Data updated');}
          else if(!$is_move){
                  $this->session->set_flashdata('flash_message' , 'Data updated no photo updated or upload photo permission deny ');
          }
          redirect(base_url() . 'index.php?admin/student_information_all/' . $param1, 'refresh');
        } 
        if ($param1 == 'delete') 
        {
            $this->db->where('student_id', $param2);
            $this->db->delete('student');
            $myfile = fopen('log.txt','a+');
            $text   = $this->session->userdata('name').'\\'."\t";
            fwrite ($myfile,$text);
            $text   = "delete student ".'\''.$this->db->get_where('student',array('student_id'=>$param2))->row()->name.'\''."\t".'\\';
            fwrite ($myfile,$text);
            $text   = date('d M,Y',now());
            fwrite ($myfile, $text);
            $text   = "\n";
            fwrite($myfile, $text);
            fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/student_information_all', 'refresh');
        }
    }
    
    /****MANAGE TEACHERS*****/
    function teacher($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['password']    = $this->input->post('password');
            $this->db->insert('teacher', $data);
            $teacher_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            $this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            
            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        } else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('teacher', array(
                'teacher_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        }
        $page_data['function']   = 'teacher';
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = 'Manage teacher';
        $this->load->view('backend/index', $page_data);
    }
    
    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $teacher_info = $this->input->post('teacher_id');
            $pos = strrpos($teacher_info,'#');
            $teacher_id_code = substr($teacher_info,$pos+1);           
            $data['teacher_id'] = $this->db->get_where('employee',array('employee_id_code'=>$teacher_id_code))->row()->employee_id;
            $data['study_time'] = $this->input->post('study_hour');
            $data['language']   = $this->input->post('language');
            $this->db->insert('subject', $data);
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/subject/'.$data['class_id'], 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
             $teacher_info = $this->input->post('teacher_id');
            $pos = strrpos($teacher_info,'#');
            $teacher_id_code = substr($teacher_info,$pos+1);
            $data['teacher_id'] = $this->db->get_where('employee',array('employee_id_code'=>$teacher_id_code))->row()->employee_id;
            $data['study_time'] = $this->input->post('study_hour');
            $data['language']   = $this->input->post('language');
            
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/subject/'.$data['class_id'], 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/subject/'.$param3, 'refresh');
        }
        $page_data['function']   = 'subject';
        $page_data['subjects']   = $this->db->get('subject')->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = 'Manage subject';
        $this->load->view('backend/index', $page_data);
    }
    
    /****MANAGE CLASSES*****/
    function classes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            $data['description']  = $this->input->post('description');       
            $this->db->insert('class', $data);
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "add class ".'\''.$data['name'].'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            $data['description']  = $this->input->post('description');
            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "update class ".'\''.$data['name'].'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $class_detail_ids = $this->db->get_where('class_detail',array('class_id'=>$param2))->result_array();
            $num=0;
            foreach ($class_detail_id as $row_class) {
              $arr_class_detail[$num] = $row_class['class_detail_id'];$num++;
            }
            $this->db->where('class_id',$param2);
            $this->db->delete('class_detail');

            $this->db->where_in('class_detail_id',$arr_class_detail);
            $this->db->delete('class_name');

            $class_details = $this->db->get_where('class_detail',array('class_id'=>$param2))->row()->class_detail_id;
            foreach ($class_details as $class_detail_id) {
                $this->db->where('class_detail_id',$class_detail_id);
                $this->db->delete('class_name');
            }
            $this->db->where('class_id',$param2);
            $this->db->delete('class_detail');
            $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "delete class ".'\''.$this->db->get_where('class',array('class_id'=>$param2))->row()->name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        $page_data['function']   = 'classes';
        $page_data['classes']    = $this->db->get('class')->result_array();
        $page_data['page_name']  = 'class';
        $page_data['page_title'] = 'Manage class';
        $this->load->view('backend/index', $page_data);
    }

    /* MANAGE CLASS GROUP */
    function manage_group($param1 ='', $param2 ='',$param3 ='')
    {
        if ($this->session->userdata('admin_login') != 1)
          redirect(base_url(), 'refresh');
        $class_details = $this->db->get_where('class_detail',array('class_id'=>$param1))->result_array();
        $i=sizeof($class_details);$l=0;
       for ($j=0;$j<$i; $j++) 
       {  
          $class_name1[$j] = $class_details[$j]['class_detail_id'];
          $class_name_id[$j] = $this->db->get_where('class_name',array('class_detail_id'=>$class_name1[$j]))->result_array();
          $k = sizeof($class_name_id[$j]);
          for ($h=0; $h <$k ; $h++) { 
            $class_name_ids[$l] = $class_name_id[$j][$h]['id'];
            $class_group_names[$l] = $class_name_id[$j][$h]['name'];
            $l++;
          }
        }
        $page_data['function']       = 'manage_group';
        $page_data['class_group_id'] = $class_name_ids;
        $page_data['class_group_name'] = $class_group_names;
        $page_data['page_name'] = "manage_group";
        $page_data['page_title']= "Manage group";
        $page_data['class_id']   = $param1;
         $this->load->view('backend/index', $page_data);
    }

    /* CHANGE STUDENT CLASS GROUP */
    function change_class_group($param1 ='' ){
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $student_ids = $this->input->post('student');
        $class_ids   = $this->input->post('class_id');
        $length = sizeof($student_ids);
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8)
       {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }
        for($i=0;$i<$length;$i++)
        {
          $cd_id = $this->db->get_where('class_name',array('id'=>$class_ids[$i]))->row()->class_detail_id;
          $language = $this->db->get_where('class_detail',array('class_detail_id'=>$cd_id))->row()->language;
          $study_time = $this->db->get_where('class_detail',array('class_detail_id'=>$cd_id))->row()->study_time;
          $data1['language'] = $language;
          $data1['study_time'] = $study_time;
          $data1['class_id'] = $class_ids[$i];
          $data['class_id'] = $class_ids[$i];
          $data['attendance_status_type'] = $study_time;
          $this->db->where('student_id',$student_ids[$i]);
          $this->db->update('student',$data);

          $cd_id = $this->db->get_where('class_name',array('id'=>$class_ids[$i]))->row()->class_detail_id;
          $language = $this->db->get_where('class_detail',array('class_detail_id'=>$cd_id))->row()->language;
          $study_time = $this->db->get_where('class_detail',array('class_detail_id'=>$cd_id))->row()->study_time;
          $data1['language'] = $language;
          $data1['study_time'] = $study_time;
          $data1['class_id'] = $class_ids[$i];

           $this->db->where('student_id',$student_ids[$i]);
           $this->db->where('study_year',$year);
           $this->db->update('class_student',$data1);
        }
        $this->session->set_flashdata('flash_message' , 'Data updated');
        redirect(base_url() . 'index.php?admin/manage_group/'.$param1, 'refresh');
    }
    /* ADD CLASS GROUP  */
    function class_group($param1 ='',$param2='',$param3=''){
      if ($this->session->userdata('admin_login') != 1)
        redirect(base_url(), 'refresh');
      if($param1=='create'){
        $data['class_id'] = $this->input->post('class_id');
        $data['language'] = $this->input->post('language');
        $data['study_time'] = $this->input->post('study_time');

        $cd_id = $this->db->get_where('class_detail',array('class_id'=>$data['class_id'],'language'=>$data['language'],'study_time'=>$data['study_time']))->row()->class_detail_id;
        if($cd_id ==''){
            $this->db->insert('class_detail',$data);
            $cd_id = $this->db->insert_id();
        }
        $data1['name']              = $this->input->post('group_name');
        $data1['class_detail_id']   = $cd_id;
        $this->db->insert('class_name',$data1);
        $class_name_id = $this->db->insert_id();
        $teacher_info = $this->input->post('teacher_id');
        $pos = strrpos($teacher_info,'#');
        $teacher_id_code = substr($teacher_info,$pos+1);
        $teacher_id = $this->db->get_where('employee',array('employee_id_code'=>$teacher_id_code))->row()->employee_id;
        $data2['teacher_id']    = $teacher_id;
        $data2['class_name_id'] = $class_name_id;
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8)
        {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }
        $data2['year'] = $year;
        $this->db->insert('teacher_class',$data2);
        $this->session->set_flashdata('flash_message' ,'Data updated');
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
      }
      if($param1=='do_update')
      {
        $data['class_id'] = $this->input->post('class_id');
        $data['language'] = $this->input->post('language');
        $data['study_time'] = $this->input->post('study_time');
        $cd_id = $this->db->get_where('class_detail',array('class_id'=>$param2,'language'=>$data['language'],'study_time'=>$data['study_time']))->row()->class_detail_id;
        if($cd_id ==''){
            $this->db->insert('class_detail',$data);
            $cd_id = $this->db->insert_id();
        }
        $data1['name'] = $this->input->post('group_name');
        $data1['class_detail_id'] = $cd_id;
        $this->db->where('id',$param3);
        $this->db->update('class_name',$data1);

        $teacher_info = $this->input->post('teacher_id');
        $pos = strrpos($teacher_info,'#');
        $teacher_id_code = substr($teacher_info,$pos+1);
       
        $teacher_id = $this->db->get_where('employee',array('employee_id_code'=>$teacher_id_code))->row()->employee_id;

        $data2['teacher_id']    = $teacher_id;
        $data2['class_name_id'] = $param3;
        $current_month = date('m',now());
        $current_year = date('Y',now());
        if($current_month<8)
        {
          $year_last = $current_year-1;
          $year = $year_last.'-'.$current_year;
        }
        elseif($current_month>=8)
        {
          $year_next = $current_year +1;
          $year = $current_year.'-'.$year_next;
        }
        $data2['year'] = $year;
        $is_tc_exist = $this->db->get_where('teacher_class',array('class_name_id'=>$param3,'year'=>$year))->row()->id;
        if($is_tc_exist!=''){
          $this->db->where('id',$is_tc_exist);
          $this->db->update('teacher_class',$data2);
        } 
        elseif($is_tc_exist=='')
        {
          $this->db->insert('teacher_class',$data2);
        }
        $this->session->set_flashdata('flash_message' ,'Data updated');
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
      }
      if($param1 == 'delete')
      {
        $this->db->where('id',$param2);
        $this->db->delete('class_name');
        $this->db->where('class_name_id',$param2);
        $this->db->delete('teacher_class');
        $this->session->set_flashdata('flash_message' ,'Data deleted');
        redirect(base_url() . 'index.php?admin/classes/', 'refresh');
      }
    }

    /****MANAGE SECTIONS*****/
    function section($class_id = '')
    {
      if ($this->session->userdata('admin_login') != 1)
          redirect(base_url(), 'refresh');
      if ($class_id == '')
          $class_id           =   $this->db->get('class')->first_row()->class_id;
      $page_data['function']   = 'section';
      $page_data['page_name']  = 'section';
      $page_data['page_title'] = 'Manage sections';
      $page_data['class_id']   = $class_id;
      $this->load->view('backend/index', $page_data);    
    }
    /****MANAGE EXAMS*****/
    function exam($param1 = '', $param2 = '' , $param3 = '')
    {
      if ($this->session->userdata('admin_login') != 1)
          redirect(base_url(), 'refresh');
      if ($param1 == 'create') {
          $data['name']    = $this->input->post('name');
          $data['date']    = $this->input->post('date');
          $data['comment'] = $this->input->post('comment');
          $data['exam_type'] = $this->input->post('exam_type');
          $data['subject_id']= $this->input->post('subject');


          $this->db->insert('exam', $data);
          $this->session->set_flashdata('flash_message' ,'Data added successfully');
          redirect(base_url() . 'index.php?admin/exam/', 'refresh');
      }
      if ($param1 == 'edit' && $param2 == 'do_update') {
          $data['name']    = $this->input->post('name');
          $data['date']    = $this->input->post('date');
          $data['comment'] = $this->input->post('comment');
          $data['exam_type'] = $this->input->post('exam_type');
          $data['subject_id']= $this->input->post('subject');


          $this->db->where('exam_id', $param3);
          $this->db->update('exam', $data);
          $this->session->set_flashdata('flash_message' , 'Data updated');
          redirect(base_url() . 'index.php?admin/exam/', 'refresh');
      } else if ($param1 == 'edit') {
          $page_data['edit_data'] = $this->db->get_where('exam', array(
              'exam_id' => $param2
          ))->result_array();
      }
      if ($param1 == 'delete') {
          $this->db->where('exam_id', $param2);
          $this->db->delete('exam');
          $this->session->set_flashdata('flash_message' , 'Data deleted');
          redirect(base_url() . 'index.php?admin/exam/', 'refresh');
      }

      $page_data['function']   = 'exam';
      $page_data['exams']      = $this->db->get('exam')->result_array();
      $page_data['page_name']  = 'exam';
      $page_data['page_title'] = 'Manage exam';
      $this->load->view('backend/index', $page_data);
    }

//SERVICES 
    /*ADD SERVICE TO INVOICE */
    function add_service($invoice_id =''){
      if ($this->session->userdata('admin_login') != 1 &&$this->session->userdata('accountant_login') != 1)
          redirect(base_url(), 'refresh');

        $page_data['function']   = 'add_service';
        $page_data['param2']      = $invoice_id;
        $page_data['page_name']  = 'add_service';
        $page_data['page_title'] =  'Services';
        $this->load->view('backend/index', $page_data);
    }

     function service($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']    = $this->input->post('service_name');
            $data['cost']    = $this->input->post('cost');
            $quantity        = $this->input->post('has_quantity');
            if($quantity){
                $data['has_quantity'] = 1;
            }else{
                $data['has_quantity'] = 0;
            }
            $this->db->insert('service', $data);

            $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "add service ".'\''.$data['name'].'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/service/', 'refresh');
        }
        if ($param1== 'do_update') {
            $data['name']    = $this->input->post('service_name');
            $data['cost']    = $this->input->post('cost');
            $quantity        = $this->input->post('has_quantity');

            if($quantity){
                $data['has_quantity'] = 1;
            }else{
                $data['has_quantity'] = 0;
            }
            
            $this->db->where('service_id', $param2);
            $this->db->update('service', $data);

            $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "edit service ".'\''.$data['name'].'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);

            $this->session->set_flashdata('flash_message' ,'Data updated');
            redirect(base_url() . 'index.php?admin/service/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('service', array(
                'service_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
           
            $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "delete service ".'\''.$this->db->get_where('service',array('service_id'=>$param2))->row()->name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);

            $this->db->where('service_id', $param2);
            $this->db->delete('service');


            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/service/', 'refresh');
        }
         $page_data['function']   = 'service';
        $page_data['service']      = $this->db->get('service')->result_array();
        $page_data['page_name']  = 'service';
        $page_data['page_title'] ='Service';
        $this->load->view('backend/index', $page_data);
    }
    /* EDIT MARKS */
    function edit_marks($param1=''){
         if($this->session->userdata('admin_login') != 1 && $this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($param1 =='view')
        {
          $class_id    = $this->input->post('class_grade');
          $class_group = $this->input->post('class_group');
          $score_type  = $this->input->post('score_type');
          $exam_type   = $this->input->post('exam_type');
          $month       = $this->input->post('month');
          $semester    = $this->input->post('semester');
          $subject_id  = $this->input->post('subject');
            
          $exam = $this->db->get_where('exam_percentage',array('id'=>$exam_type))->row()->name;
          $this->db->where('class_detail_id',$class_id);
          $class_names = $this->db->get('class_name')->result_array();
          $c=0;
          foreach ($class_names as $row_class_name) {
             $class_name_ids[$c] = $row_class_name['id'];
             $c++;
          }
            if(!$class_group)
            {
              if(!$exam_type)
              {
                $this->db->select('student_class.*,mark.score_obtain as score,mark.comment as comment,date, subject_id');
                $this->db->from('student_class');
                $this->db->join('mark','mark.student_id = student_class.student_id');
                $this->db->where('study_year',$this->session->userdata('academic_year'));
                $this->db->where('score_type_id',$score_type);
                $this->db->where('subject_id',$subject_id);
                $this->db->where('semester',$semester);
                $this->db->where_in('student_class.class_id',$class_name_ids);

                $students = $this->db->get()->result_array();
              }
                if($exam_type)
                {
                  if($exam=='monthly')
                  {
                  $this->db->select('student_class.*,mark.exam_type_id,mark.score_obtain as score,mark.comment as comment, subject_id');
                  $this->db->from('student_class');
                  $this->db->join('mark','mark.student_id = student_class.student_id');
                  $this->db->where('study_year',$this->session->userdata('academic_year'));
                  $this->db->where('mark.score_type_id',$score_type);
                  $this->db->where('subject_id',$subject_id);
                  $this->db->where('exam_type_id',$exam_type);
                  $this->db->where('semester',$semester);
                  $this->db->where('month',$month);
                  $this->db->where_in('student_class.class_id',$class_name_ids);
                  $students = $this->db->get()->result_array();
                }
                if($exam!='monthly')
                 {
                    $this->db->select('student_class.*,mark.semester,mark.score_obtain as score,mark.comment as comment,date, subject_id');
                    $this->db->from('student_class');
                    $this->db->join('mark','mark.student_id = student_class.student_id');
                    $this->db->where('study_year',$this->session->userdata('academic_year'));
                    $this->db->where('mark.score_type_id',$score_type);
                    $this->db->where('subject_id',$subject_id);
                    $this->db->where('exam_type_id',$exam_type);
                    $this->db->where('semester',$semester);
                    $this->db->where_in('student_class.class_id',$class_name_ids);
                    $students = $this->db->get()->result_array();
                  }
              }
            }
            elseif($class_group)
            {  
              if($exam_type=='')
              {
                $this->db->select('student_class.*,mark.score_obtain as score,mark.comment as comment,subject_id');
                $this->db->from('student_class');
                $this->db->join('mark','mark.student_id = student_class.student_id');
                $this->db->where('study_year',$this->session->userdata('academic_year'));
                $this->db->where('student_class.class_id',$class_group);
                $this->db->where('mark.score_type_id',$score_type);
                $this->db->where('semester',$semester);
                $this->db->where('subject_id',$subject_id);
                $students = $this->db->get()->result_array();
              }
              if($exam_type!=''){
                 if($exam=='monthly'){
                  $this->db->select('student_class.*,mark.score_obtain as score,mark.comment as comment,subject_id');
                  $this->db->from('student_class');
                  $this->db->join('mark','mark.student_id = student_class.student_id');
                  $this->db->where('study_year',$this->session->userdata('academic_year'));
                  $this->db->where('student_class.class_id',$class_group);
                  $this->db->where('mark.score_type_id',$score_type);
                  $this->db->where('subject_id',$subject_id);
                  $this->db->where('exam_type_id',$exam_type);
                  $this->db->where('semester',$semester);
                  $this->db->where('month',$month);
                  $students = $this->db->get()->result_array();
                }
                if($exam!='monthly'){
                $this->db->select('student_class.*,mark.score_obtain as score,mark.comment as comment,subject_id');
                $this->db->from('student_class');
                $this->db->join('mark','mark.student_id = student_class.student_id');
                $this->db->where('study_year',$this->session->userdata('academic_year'));
                $this->db->where('student_class.class_id',$class_group);
                $this->db->where('mark.score_type_id',$score_type);
                $this->db->where('subject_id',$subject_id);
                $this->db->where('exam_type_id',$exam_type);
                $this->db->where('semester',$semester);
                $students = $this->db->get()->result_array();
                }
              }
            }
// SELECT THE CLASS DETAIL INFORMATION 
            $this->db->select('class.name,class_detail.*');
            $this->db->from('class');
            $this->db->join('class_detail','class.class_id = class_detail.class_id');
            $this->db->order_by('name','desc');
            $page_data['classes']     = $this->db->get()->result_array();
             if($this->session->userdata('teacher_login') == 1)
            {
              $login_tid   = $this->db->get_where('employee',array('employee_id_code'=>$this->session->userdata('login_user_id')))->row()->employee_id;
              $class_names = $this->db->get_where('teacher_class',array('teacher_id'=>$login_tid))->result_array();
              $num=0;
              foreach ($class_names as $row_cname_id) {
                $arr_class_nid[$num] = $row_cname_id['class_name_id'];$num++;
              }
              $this->db->select('*');
              $this->db->distinct('class_detail_id');
              $this->db->where_in('id',$arr_class_nid);
              $c_detail_ids = $this->db->get('class_name')->result_array();
              $number=0;
              foreach ($c_detail_ids as $row_cd_id) {
                $arr_class_did[$number]= $row_cd_id['class_detail_id'];$number++;
              }
            $this->db->select('class.name,class_detail.*');
            $this->db->from('class');
            $this->db->join('class_detail','class.class_id = class_detail.class_id');
            $this->db->where_in('class_detail_id',$arr_class_did);
            $this->db->order_by('name','desc');
            $page_data['classes']     = $this->db->get()->result_array();

            }
        //GET THE CLASS GROUP THAT RELATE TO CLASS GRADE
        $this->db->select('*');
        $this->db->where_in('class_id',$class_id);
        $page_data['class_groups']   = $this->db->get('class_info')->result_array();
        $page_data['exam_type']   = $exam_type;
        $page_data['score_type']  = $score_type;
        $page_data['class_id']    = $class_id;
        $page_data['class_grade'] = $class_group;

        $this->db->where('class_detail_id',$class_id);
        $class_detail_info = $this->db->get('class_detail')->result_array();
        foreach ($class_detail_info as $cd_info) {
            $class_     = $cd_info['class_id'];
            $language   = $cd_info['language'];
            $study_time = $cd_info['study_time'];
            if($cd_info['study_time']=='Part time morning' || $cd_info['study_time']=='Part time afternoon')
            {$study_time = 'Part time';}
        }
        $page_data['subjects']    = $this->db->get_where('subject',array('class_id'=>$class_,'language'=>$language,'study_time'=>$study_time))->result_array();
        $page_data['subject_id']  = $subject_id;
        $page_data['semester']    = $semester;
        $page_data['month']       = $this->input->post('month');
        $page_data['exam_types']  = $this->db->get('exam_percentage')->result_array();
        $page_data['students']    = $students;
        $page_data['page_name']   = 'edit_mark_note';
        $page_data['page_title']  = 'Manage marks';
        $page_data['function']    = 'edit_marks';
        $this->load->view('backend/index',$page_data);
        }
        if($param1=='')
        {
          $this->db->select('class.name,class_detail.*');
          $this->db->from('class');
          $this->db->join('class_detail','class.class_id = class_detail.class_id');
          $this->db->order_by('name','desc');
          $page_data['classes']     = $this->db->get()->result_array();
          $this->db->select('*');
          $page_data['class_groups']= $this->db->get('class_info')->result_array();
          $page_data['score_types']  = $this->db->get('score_percentage')->result_array();
          $this->db->select('exam_type_id');
            $this->db->distinct('exam_type_id');
            $exam_type_id=$this->db->get('mark')->result_array();
            $time=0;
            foreach ($exam_type_id as $row_et) {
              if($row_et['id']!=' ')
              {$exam_type_ids[$time] = $row_et['exam_type_id'];$time++;}
            }

            $this->db->select('*');
            $this->db->where_in('id',$exam_type_ids);
         $page_data['exam_types']  = $this->db->get('exam_percentage')->result_array();

         $this->db->select('subject.*,mark.class_id as s_cid');
         $this->db->distinct('subject.subject_id');
         $this->db->from('subject');
         $this->db->join('mark','mark.subject_id = subject.subject_id');
         $subjects = $this->db->get()->result_array();
         $page_data['subjects']    = $subjects;
         $page_data['page_name']   = 'edit_mark';
         $page_data['page_title']  = 'Edit marks';
         $page_data['function']    = 'edit_marks';

        if($this->session->userdata('teacher_login') == 1)
        {
          $login_tid   = $this->db->get_where('employee',array('employee_id_code'=>$this->session->userdata('login_user_id')))->row()->employee_id;
          $class_names = $this->db->get_where('teacher_class',array('teacher_id'=>$login_tid))->result_array();
          $num=0;
          foreach ($class_names as $row_cname_id) {
            $arr_class_nid[$num] = $row_cname_id['class_name_id'];$num++;
          }
          $this->db->select('*');
          $this->db->distinct('class_detail_id');
          $this->db->where_in('id',$arr_class_nid);
          $c_detail_ids = $this->db->get('class_name')->result_array();
          
          $number=0;
          foreach ($c_detail_ids as $row_cd_id) {
            $arr_class_did[$number]= $row_cd_id['class_detail_id'];$number++;
          }
          $this->db->select('class.name,class_detail.*');
          $this->db->from('class');
          $this->db->join('class_detail','class.class_id = class_detail.class_id');
          $this->db->where_in('class_detail_id',$arr_class_did);
          $this->db->order_by('name','desc');
          $page_data['classes']     = $this->db->get()->result_array();

        }
         $this->load->view('backend/index',$page_data);
        }
    }

    /* REPORT OF THE SYSTEM */
    // WE SPECIFIC ON TWO REPORT ATTENDANCE AND SCORE
    function report_attendance($param1 ='',$param2 =''){
        if($this->session->userdata('admin_login') != 1&&$this->session->userdata('teacher_login') != 1)
        {redirect(base_url(), 'refresh');}
            if($param1==''){
                $this->db->select('*');
                $this->db->from('class_name');
                $this->db->order_by('name','desc');
                $page_data['classes']   = $this->db->get()->result_array();
                $page_data['page_name'] = 'attendance_report';
                $page_data['page_title']= 'Attendance report';
                $page_data['function']  = 'report_attendance';
                $this->load->view('backend/index',$page_data);
            }
            if($param1 =='view'){
                $class_id = $this->input->post('class_id');
                $month    = $this->input->post('month');
                if(($month==1) || ($month==3) || ($month==5) || ($month==7) || ($month==8) || ($month==10) || ($month==12))
                {
                    $end_day = 31;
                }elseif(($month==4) || ($month==6) || ($month==9) || ($month==11) || ($month==12))
                {
                    $end_day = 30;
                }elseif ($month==2) {
                    $end_day = 29;
                }

                $academic_year = $this->session->userdata('academic_year');
                $pos   = strpos($academic_year, '-');
                $yearl = substr($academic_year,0,$pos);
                $yearn = substr($academic_year,$pos+1);
                if($month<8){
                    $year = $yearn;
                } elseif($month>=8){
                    $year = $yearl;
                }
                $from_date = $year.'-'.$month.'-'.'01';
                $to_data   = $year.'-'.$month.'-'.$end_day;

        $this->db->from('student');
        $this->db->join('class_student','student.student_id=class_student.student_id');
        $this->db->where('study_year',$this->session->userdata('academic_year'));
        $this->db->where('class_student.class_id',$class_id);
        $this->db->order_by('student.student_id');
        $attendances =$this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('class_name');
        $this->db->order_by('name','desc');
        $page_data['classes']  = $this->db->get()->result_array();
        $page_data['class_id']      = $class_id;
        $page_data['month_text']    = date('F',strtotime($from_date));
        $page_data['date1']         = $date;
        $page_data['month']         = $month;
        $page_data['year']          = $year;
        $page_data['end_day']       = $end_day;
        $page_data['attendances']   = $attendances;
        $page_data['class_name']    = $this->db->get_where('class_name',array('id',$class_id))->row()->name;
        $page_data['page_name']     = 'list_attendance';
        $page_data['page_title']    = 'View monthly attendance';
        $page_data['function']      = 'report_attendance';
        $this->load->view('backend/index',$page_data);
      }   
    }

    function report_semescore($param1=''){
      if($this->session->userdata('admin_login') != 1)
        {redirect(base_url(), 'refresh');}
      if($param1 ==''){
            $this->db->select('class.name,class_detail.*');
            $this->db->from('class');
            $this->db->join('class_detail','class.class_id = class_detail.class_id');
            $this->db->order_by('name','desc');
            $page_data['classes']     = $this->db->get()->result_array();

            $this->db->select('*');
            $this->db->distinct('class_id');
            $this->db->where('year',$this->session->userdata('academic_year'));
            $mc_ids = $this->db->get('mark')->result_array();
            foreach ($mc_ids as $mc_row) {
              $class_name_ids[$i] = $mc_row['class_id'];$i++;
            }
             $this->db->select('*');
             $this->db->where_in('class_detail_id',$class_name_ids);
             $page_data['class_groups']= $this->db->get('class_info')->result_array();
           
            $page_data['page_name']  = 'score_semester_report';
            $page_data['page_title'] = 'Score report'; 
            $this->load->view('backend/index',$page_data);
      }
      if($param1=='view'){
        $class_grade = $this->input->post('class_grade');
        $class_group = $this->input->post('class_name');
        $semester    = $this->input->post('semester');
        $language = $this->db->get_where('class_detail',array('class_detail_id'=>$class_grade))->row()->language;
        $study_time  = $this->db->get_where('class_detail',array('class_detail_id'=>$class_grade))->row()->study_time;
        $class_id    = $this->db->get_where('class_detail',array('class_detail_id'=>$class_grade))->row()->class_id;
        if($study_time =='Part time morning' || $study_time =='Part time afternoon'){
          $study_time = 'Part time';
        }
        if($class_group!=' ')
        {
            $students = $this->db->get_where('student_class',array('grade_id'=>$class_grade,'study_year'=>$this->session->userdata('academic_year')))->result_array();
         }
        elseif($class_group==' '){
            $students = $this->db->get_where('student_class',array('class_id'=>$class_group,'study_year'=>$this->session->userdata('academic_year')))->result_array();
        }
        $score_types = $this->db->get('score_percentage')->result_array();
        $exam_types  = $this->db->get('exam_percentage')->result_array();
        $i=0;
        foreach ($score_types as $s_row) {
          if($s_row['name']=='exam'){
            $score_type_exam_id = $s_row['id'];
          }
          else{
            $score_type[$i] =$s_row['id'];
          $i++;
          }
        }
        $i=0;
        foreach ($exam_types as $x_row) {
          if($x_row['name']=='monthly'){
            $month_exam_id = $x_row['id'];
          }else
          {
            $exam_type[$i] = $x_row['id'];$i++;
          }
         } 
        $average[][]=0;
        $score_num = sizeof($score_type);
        $exam_num  = sizeof($exam_type);
        $x_score =0;
        $sub_num =0;

        $subject_ids = $this->db->get_where('subject',array('class_id'=>$class_id,'language'=>$language,'study_time'=>$study_time))->result_array();
        foreach ($subject_ids as $sub_row) {
          for ($i=0;$i<$score_num;$i++) {
            $stu_num =0;
            foreach ($students as $stu_row) {
                $score_mark = $this->db->get_where('score_detail',
                  array('student_id'=>$stu_row['student_id'],
                    'year'=>$this->session->userdata('academic_year'),
                    'semester'=>$semester,
                    'score_type_id'=>$score_type[$i],
                    'subject_id'=>$sub_row['subject_id']))->row()->score_obtain;
                if($score_mark==''){
                  $score_mark =0;
                }
                $average[$sub_num][$stu_num] = $average[$sub_num][$stu_num] + $score_mark /100* $this->db->get_where('score_percentage',array('id'=>$score_type[$i]))->row()->percentage; 
              $stu_num++;
            }// END FOREACH OF STUDENT
          }//END SOCRE AVERAGE SCORE EXCLUDE EXAM SCORE
          $stu_num=0;
          foreach ($students as $stu_row) {
            $x_month = $this->db->get_where('exam_score',array('exam_type_id'=>$month_exam_id,
              'subject_id'=>$sub_row['subject_id'],
              'student_id'=>$stu_row['student_id'],
              'semester'=>$semester,
              'year'=>$this->session->userdata('academic_year'),
              ))->result_array();
            $number_month = sizeof($x_month);
            foreach ($x_month as $xm_row) {
              $score_xm = $score_xm + $xm_row['score_obtain'];
            }
            $score_xm = $score_xm/$number_month;
            if($score_xm==''||$number_month==0){
              $score_xm =0;
            }
            $exam_score[$x_score] = $score_xm /100*$this->db->get_where('exam_percentage',array('id'=>$month_exam_id))->row()->percentage;
            $x_score++;
          }//END MONTHLY EXAM SCORE
          $x_score=0;
          for ($i=0; $i <$exam_num ; $i++) { 
            foreach ($students as $stu_row) {
              $score_ex = $this->db->get_where('exam_score',array('student_id'=>$stu_row['student_id'],
                'semester'=>$semester,
                'subject_id'=>$sub_row['subject_id'],
                'year'=>$this->session->userdata('academic_year'),
                'exam_type_id'=>$exam_type[$i]
                ))->row()->score_obtain;
              if($score_ex==''){$score_ex=0;}
              $exam_score[$x_score] = $exam_score[$x_score]+ $score_ex /100* $this->db->get_where('exam_percentage',array('id'=>$exam_type[$i]))->row()->percentage;
            }
          }
          $exam_score_num = sizeof($exam_score);
          for ($i=0; $i <$exam_score_num ; $i++) { 
             $average[$sub_num][$stu_num] =  $average[$sub_num][$stu_num] + $exam_score[$i]/100* $this->db->get_where('score_percentage',array('id'=>$score_type_exam_id))->row()->percentage;
            $stu_num++;
          }
          $sub_num++;
        }//END SUBJECT LOOP
        if($class_group==''){
              $class_groups = $this->db->get_where('class_name',array('class_detail_id'=>$class_grade))->result_array();
            }
            foreach ($class_groups as $cg) {
              $class_names = $class_names.' '.$cg['name'].',';
            }
            if($class_group!=''){
              $class_names = $class_group;
            }
        $grade_name  = $this->db->get_where('class',array('class_id'=>$class_id))->row()->name;
        $page_data['grade_name']   = $grade_name;
        $page_data['language']     = $language;
        $page_data['study_time']   = $study_time;
        $page_data['page_name']    = 'semseter_score_report';
        $page_data['page_title']   = 'Semester score';
        $page_data['class_name']  = $class_names;
        $page_data['average_score']= $average;
        $page_data['subjects']     = $subject_ids;
        $page_data['students']     = $students;
        $page_data['function']     = 'report_semescore';
        $this->load->view('backend/index',$page_data);
      } 
    }

    function report_subscore($param1='',$param2='',$param3='')
    {
      if($this->session->userdata('admin_login') != 1)
        {redirect(base_url(), 'refresh');}
      if($param1=='')
      {
        $this->db->select('class.name,class_detail.*');
        $this->db->from('class');
        $this->db->join('class_detail','class.class_id = class_detail.class_id');
        $this->db->order_by('name','desc');
        $page_data['classes']     = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->distinct('class_id');
        $this->db->where('year',$this->session->userdata('academic_year'));
        $mc_ids = $this->db->get('mark')->result_array();
        foreach ($mc_ids as $mc_row) {
          $class_name_ids[$i] = $mc_row['class_id'];$i++;
        }
         $this->db->select('*');
         $this->db->where_in('class_detail_id',$class_name_ids);
         $page_data['class_groups']= $this->db->get('class_info')->result_array();
       

        $this->db->select('subject.*,mark.class_id as c_id');
        $this->db->distinct('subject_id');
        $this->db->from('subject');
        $this->db->join('mark','subject.subject_id=mark.subject_id');
        $this->db->where('mark.year',$this->session->userdata('academic_year'));
        $page_data['subjects']   = $this->db->get()->result_array();

        $page_data['page_name']  = 'score_report';
        $page_data['page_title'] = 'Score report';
        $this->load->view('backend/index',$page_data);
      }
      if($param1=='view'){
        $semester    = $this->input->post('semester');
        $class_grade = $this->input->post('class_grade');
        $class_group = $this->input->post('class_name');
        $subject_id  = $this->input->post('subject');

      $average[]=0;
      $score_types = $this->db->get('score_percentage')->result_array();
      if($class_group!=' ')
      {
        $students = $this->db->get_where('student_class',array('grade_id'=>$class_grade,'study_year'=>$this->session->userdata('academic_year')))->result_array();
     
     }
      elseif($class_group==' '){
        $students = $this->db->get_where('student_class',array('class_id'=>$class_group,'study_year'=>$this->session->userdata('academic_year')))->result_array();
      }
     
      $num=0;
      foreach ($score_types as $row_st) {
        if($row_st['name']!='exam'){
          $score_type[$num] = $row_st['id'];$num++;
        }
        if($row_st['name']=='exam'){
          $score_exam_type_id = $row_st['id'];
        }
      }
      $exam_types = $this->db->get('exam_percentage')->result_array();
      $ex=0;
      //GET THE EXAM SCORE SEPERATE INTO MONTHLY TEST AND OTHER 
      foreach ($exam_types as $ex_row) {
        if($ex_row['name']!='monthly')
         {$exam_t_id[$ex] = $ex_row['id'];$ex++;}
       if($ex_row['name']=='monthly'){
        $month_test_id = $ex_row['id'];
       }
      }
      $m_t=0;
      $ex_num = sizeof($exam_t_id);//LENGTH OF EXAM ID EXCLUDE MONTHLY TEST
      $score_num = sizeof($score_type);//LENGTH OF SCORE ID EXCLUDE EXAM

      foreach ($students as $stu_row) {
       $stus = $this->db->get_where('exam_score',array('exam_type_id'=>$month_test_id,'student_id'=>$stu_row['student_id'],'semester'=>$semester,'subject_id'=>$subject_id))->result_array();
        foreach ($stus as $stu) {
          $score = $score + $stu['score_obtain'];
        }
        $num_month = sizeof($stus);
        $month_exam[$m_t] = $score/$num_month;
        if($score==''){
          $month_exam[$m_t] =0;
        }
        $average[$m_t] = $score/100 * $this->db->get_where('exam_percentage',array('id'=>$month_test_id))->row()->percentage;
        $score=0;
        $m_t++;
      }
      $i=0;$k=0;
      for ($j=0; $j < $ex_num; $j++) { 
        foreach ($students as $stu_row) {
            //STORE ONLY THE SCORE
          $x_score[$i][$k] = $this->db->get_where('exam_score',array('student_id'=>$stu_row['student_id'],'exam_type_id'=>$exam_t_id[$j],'year'=>$this->session->userdata('academic_year'),'subject_id'=>$subject_id,'semester'=>$semester))->row()->score_obtain;
          if($x_score[$i][$k]==''){
            $x_score[$i][$k]=0;
          }
          
          $average[$k]     = $average[$k]+$x_score[$i][$k]/100*$this->db->get_where('exam_percentage',array('id'=>$exam_t_id[$j]))->row()->percentage; 
          $k++;
        }
        $i++;$k=0;
      }
      $avg_num=0;
      $avg_length = sizeof($average);
      $x_p = $this->db->get_where('score_percentage',array('id'=>$score_exam_type_id))->row()->percentage;
      for($i=0;$i<$avg_length;$i++) 
      {
        $average[$i] = $average[$i] * $x_p/100;
      }
      $ot_i=0;$ot_k=0;
      for ($j=0; $j < $score_num; $j++) { 
        foreach ($students as $stu_row) {
            //STORE ONLY THE SCORE
          $ot_score[$ot_i][$ot_k] = $this->db->get_where('score_detail',array('student_id'=>$stu_row['student_id'],'score_type_id'=>$score_type[$j],'year'=>$this->session->userdata('academic_year'),'subject_id'=>$subject_id,'semester'=>$semester))->row()->score_obtain;
           if($ot_score[$ot_i][$ot_k]==''){
            $ot_score[$ot_i][$ot_k]=0;
          }
            $average[$ot_i]         = $average[$ot_i] + $ot_score[$ot_i][$ot_k]/100* $this->db->get_where('score_percentage',array('id'=>$score_type[$j]))->row()->percentage;
            $ot_k++;
        }
        $ot_i++;$ot_k=0;
      }
      if($class_group==''){
        $class_groups = $this->db->get_where('class_name',array('class_detail_id'=>$class_grade))->result_array();
      }
      foreach ($class_groups as $cg) {
        $class_names = $class_names.' '.$cg['name'].',';
      }
      if($class_group!=''){
        $class_names = $class_group;
      }
      $page_data['class_name']    = $class_names;
      $page_data['students']      = $students;
      $page_data['score_titles']  = $this->db->get_where('score_percentage',array('id !='=>$score_exam_type_id))->result_array();
      $page_data['exam_titles']   = $this->db->get('exam_percentage')->result_array();
      $page_data['averages']      = $average;
      $page_data['score_marks']   = $ot_score;
      $page_data['monthly_scores']= $month_exam;
      $page_data['exam_scores']   = $x_score;
      $page_data['page_name']     = 'subject_score_view';
      $page_data['page_title']    = $this->db->get_where('subject',array('subject_id'=>$subject_id))->row()->name.' score';
      $this->load->view('backend/index',$page_data);
      }
    }

    function report_score($param1='',$param2='',$param3=''){
         if($this->session->userdata('admin_login') != 1)
        {redirect(base_url(), 'refresh');}
        if($param1 =='')
        {
           $this->db->select('name,period_id,subject_id,class_id');
           $this->db->distinct('name');
           $page_data['score_names']  = $this->db->get('score')->result_array();
           $tmp = $page_data['score_name'];
           $i=0;
           foreach ($tmp as $row) {
               $class_id[$i] = $this->db->get_where('subject',array('subject_id'=>$row['subject_id']))->row()->class_id;
              $i++;
           }
           $this->db->select('*');
           $this->db->where_in('class_id',$class_id);
          $page_data['class_groups']= $this->db->get('class_info')->result_array();
          $this->db->select('class.name,class_detail.*');
          $this->db->from('class');
          $this->db->join('class_detail','class.class_id = class_detail.class_id');
          $this->db->order_by('name','desc');
          $page_data['classes']     = $this->db->get()->result_array();
          
          $this->db->select('score.class_id,period.id as p_id, period.name as pname,period.start_date as start_date, period.end_date as end_date, period.year as p_year');
          $this->db->distinct('period_id');
          $this->db->from('period');
          $this->db->join('score','score.period_id= period.id');
          $this->db->where('period.year',$this->session->userdata['academic_year']);

          $page_data['periods']  = $this->db->get()->result_array();
          $page_data['page_name']   = 'score_report';
          $page_data['page_title']  = 'Score report';
          $page_data['function']    = 'report_score';
          $this->load->view('backend/index',$page_data);
        }
        if($param1 =='view')
        {
          $class_id    = $this->input->post('class_grade');
          $class_group = $this->input->post('class_group');
          $period_id   = $this->input->post('period');
          $score_names = $this->input->post('score_name');
          if($class_group==''){
              $class_group_ids= $this->db->get_where('class_name',array('class_detail_id'=>$class_id))->result_array();
              $i=0;
              foreach ($class_group_ids as $class_group_row) 
              {
                $arr_class_group_id[$i] = $class_group_row['id'];$i++;
                $class_selected = $class_selected.' '.$class_group_row['name'];
              }
                $this->db->where_in('class_id',$arr_class_group_id);
                $this->db->where('study_year',$this->session->userdata('academic_year'));
                $students=$this->db->get('student_class')->result_array();
          }//CLOSE IF CLASS GROUP NOT EXIST
          if($class_group){
              $students = $this->db->get_where('student_class',array('study_year'=>$this->session->userdata('academic_year'),'class_id'=>$class_group))->result_array();
              $arr_class_group_id = $class_group;
              $class_selected = $this->db->get_where('class_name',array('id'=>$class_group))->row()->name;
          }
          $this->db->select('*');
          $this->db->from('score');
          $this->db->distinct('name,period_id,subject_id');
          $this->db->where_in('name',$score_names);
          $this->db->where('period_id',$period_id);
          $subject_ids = $this->db->get()->result_array();
          $j=0;
          foreach ($subject_ids as $subject) {
              $arr_subject[$j] = $subject['subject_id'];
              $j++;
          }
          $class_language = $this->db->get_where('class_detail',array('class_detail_id'=>$class_id))->row()->lanugage;
           $class_study_time = $this->db->get_where('class_detail',array('class_detail_id'=>$class_id))->row()->study_time;

          $this->db->where_in('subject_id',$arr_subject);
          $subjects = $this->db->get('subject')->result_array();

          $this->db->where_in('name',$score_names);
          $this->db->where('period_id',$period_id);
          $this->db->where_in('class_id',$arr_class_group_id);
          $score_names = $this->db->get('score')->result_array();

          $grade_id = $this->db->get_where('class_detail',array('class_detail_id'=>$class_id))->row()->class_id;
          $grade_name = $this->db->get_where('class',array('class_id'=>$grade_id))->row()->name;
          $page_data['grade_name']  = $grade_name;
          $page_data['language']    = $class_language;
          $page_data['study_time']  = $class_study_time;
          $page_data['subject_ids'] = $subjects;
          $page_data['students']    = $students;
          $page_data['period_name'] = $this->db->get_where('period',array('id'=>$period_id))->row()->name;
          $page_data['period_id']   = $period_id;
          $page_data['class_name']  = $class_selected;
          $page_data['page_name']   = 'score_report_view';
          $page_data['page_title']  = 'Score report';
          $page_data['function']    = 'report_score';
          $this->load->view('backend/index',$page_data);
      }//CLOSE SCORE REPORT VIEW
        //CLOSE SCORE REPORT
    }

    /* MANAGE PERIOD */
    function score_percentage($param1='',$param2=''){
     if($this->session->userdata('admin_login') != 1&& $this->session->userdata('teacher_login') != 1)
        {
          redirect(base_url(), 'refresh');
        }
          if($param1 =='create')
          {
             $score_names       = $this->input->post('name');
             $score_percentages = $this->input->post('percentage');
             $scores = $this->db->get('score_percentage')->result_array();
             foreach ($scores as $score_row) {
               $name = $this->input->post($score_row['name']);
               $percentage = $this->input->post($score_row['name'].'_percentage');
               $total_p = $total_p + $percentage;
             }
             $length = sizeof($score_names);
             for ($i=0; $i < $length; $i++) { 
               if($score_names[$i]!='' && $score_percentages[$i]!=''){ 
                $total_p = $total_p + $score_percentages[$i];
               }
             }
             if($total_p!=100){
                 $this->session->set_flashdata('flash_message' , "Error score total must be equal 100%");
                 redirect(base_url() . 'index.php?admin/score_percentage/manage_score' , 'refresh');
               }
             if($total_p==100){
               foreach ($scores as $score_row) {
                 $name = $this->input->post($score_row['name']);
                 $percentage = $this->input->post($score_row['name'].'_percentage');
                 if($name==''){
                  $this->db->where('name',$score_row['name']);
                  $this->db->delete('score_percentage');

                 }
                 elseif($name!=''){
                  $data['name'] = $name;
                  $data['percentage']= $percentage;
                  $this->db->where('name',$score_row['name']);
                  $this->db->update('score_percentage',$data);
                 }
               }
               $length = sizeof($score_names);
               for ($i=0; $i < $length; $i++) { 
                 if($score_names[$i]!='' && $score_percentages[$i]!='')
                 {
                    $data['name'] = $score_names[$i];
                    $data['percentage']= $score_percentages[$i];
                    $this->db->insert('score_percentage',$data);
                 }
                }
             }
            $this->session->set_flashdata('flash_message' , "Data added successfully");
            redirect(base_url() . 'index.php?admin/manage_period' , 'refresh');  
          }
          if($param1 =='do_update')
          {
            $data['name']       = $this->input->post('name');
            $data['start_date'] = $this->input->post('start_date');
            $data['end_date']   = $this->input->post('end_date');
            $this->db->where('id',$param2);
            $this->db->update('period',$data);

            $this->session->set_flashdata('flash_message' , "Data updated");
            redirect(base_url() . 'index.php?admin/manage_period' , 'refresh');
          }
          if($param1 =='delete')
          {
            $this->db->where('id',$param2);
            $this->db->delete('period');
            $this->session->set_flashdata('flash_message' , "Data deleted");
           redirect(base_url() . 'index.php?admin/manage_period' , 'refresh');
          }
          if(!$param1)
          {
            $score_percentage = $this->db->get('score_percentage')->result_array();
            $page_data['exam_percentages']  = $this->db->get('exam_percentage')->result_array();
            $page_data['score_percentages'] = $score_percentage;
            $page_data['periods']   = $this->db->get_where('period',array('year'=>$this->session->userdata('academic_year')))->result_array();
            $page_data['page_name'] = 'manage_period';
            $page_data['page_title']= 'Score percentage';
            $page_data['function']  = 'score_percentage';
            $this->load->view('backend/index',$page_data);
          }
         if($param1 == 'manage_score')
         {
            $score_percentage = $this->db->get('score_percentage')->result_array();
            $page_data['score_percentages'] = $score_percentage;
            $page_data['page_name'] = 'manage_score';
            $page_data['page_title']= 'Manage score';
            $page_data['function']  = 'score_percentage';
            $this->load->view('backend/index',$page_data);
         }
    }

    function exam_percentage($param1 =''){
      if($this->session->userdata('admin_login') != 1 && $this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 =='create'){
          $exam_names = $this->db->get('exam_percentage')->result_array();
          foreach ($exam_names as $exam_row) {
            $total_percentage = $total_percentage + $this->input->post($exam_row['name'].'_percentage');
          }
          if($total_percentage != 100){
            $this->session->set_flashdata('flash_message' , "Error score total must be equal 100%");
            redirect(base_url() . 'index.php?admin/exam_percentage' , 'refresh');
          }
          elseif($total_percentage ==100)
          {
            foreach ($exam_names as $exam_row) {
              $data['name']       = $this->input->post($exam_row['name']);
              $data['percentage'] = $this->input->post($exam_row['name'].'_percentage');
              $this->db->where('name',$exam_row['name']);
              $this->db->update('exam_percentage',$data);
            }
          }
          $this->session->set_flashdata('flash_message' , "Data update successfully");
          redirect(base_url() . 'index.php?admin/manage_period' , 'refresh');
        }
        $page_data['exam_scores'] = $this->db->get('exam_percentage')->result_array();
        $page_data['page_name']   = 'exam_percentage';
        $page_data['page_title']  = 'Exam percentage';
        $page_data['function']    = 'exam_percentage';
        $this->load->view('backend/index',$page_data);
    }


    /* MANAGE MARKS WITHOUT EXAM */
    function manage_marks($param1 ='',$period_id='',$score_name ='',$subject_selected ='',$class_grade_id='')
    {
        if($this->session->userdata('admin_login') != 1 && $this->session->userdata('teacher_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 =='view')
        {
          $class_id    = $this->input->post('class_grade');
          $class_group = $this->input->post('class_group');
          $score_type  = $this->input->post('score_type');
          $subject_id  = $this->input->post('subject');
          $class_ids = $this->db->get_where('class_name',array('class_detail_id'=>$class_id))->result_array();
          $k=0;
          foreach ($class_ids as $row_class) {
              $array_class_id[$k] = $row_class['id'];
              $k++;
          }

          if(!$class_group)
          {
              $this->db->select('*');
              $this->db->where_in('class_id',$array_class_id);
              $this->db->where('study_year',$this->session->userdata('academic_year'));
              $students = $this->db->get('student_class')->result_array();
          }elseif($class_group){
              $students = $this->db->get_where('student_class',array('study_year'=>$this->session->userdata('academic_year'),'class_id'=>$class_group))->result_array();
          }

          $this->db->select('class.name,class_detail.*');
          $this->db->from('class');
          $this->db->join('class_detail','class.class_id = class_detail.class_id');
          $this->db->order_by('name','desc');
          $page_data['classes']     = $this->db->get()->result_array();
          
          if($this->session->userdata('teacher_login') == 1)
          {
            $login_tid   = $this->db->get_where('employee',array('employee_id_code'=>$this->session->userdata('login_user_id')))->row()->employee_id;
            $class_names = $this->db->get_where('teacher_class',array('teacher_id'=>$login_tid))->result_array();
            $num=0;
            foreach ($class_names as $row_cname_id) {
              $arr_class_nid[$num] = $row_cname_id['class_id'];$num++;
            }
            $this->db->select('*');
            $this->db->distinct('class_detail_id');
            $this->db->where_in('id',$arr_class_nid);
            $c_detail_ids = $this->db->get('class_name')->result_array();
            
            $num=0;
            foreach ($c_detail_ids as $row_cd_id) {
              $arr_class_did[$num]= $row_cd_id['class_detail_id'];$num++;
            }
            $this->db->select('class.name,class_detail.*');
            $this->db->from('class');
            $this->db->join('class_detail','class.class_id = class_detail.class_id');
            $this->db->where('class_detail_id',$arr_class_did);
            $this->db->order_by('name','desc');
            $page_data['classes']     = $this->db->get()->result_array();
          }
            $page_data['class_groups']= $this->db->get('class_info')->result_array();
            $page_data['class_id']    = $class_id;
            $page_data['class_grade'] = $class_group;

            $this->db->where('class_detail_id',$class_id);
            $class_detail_info = $this->db->get('class_detail')->result_array();
            foreach ($class_detail_info as $cd_info) {
                $class_     = $cd_info['class_id'];
                $language   = $cd_info['language'];
                $study_time = $cd_info['study_time'];
                if($cd_info['study_time']=='Part time morning' || $cd_info['study_time']=='Part time afternoon')
                {$study_time = 'Part time';}
            }
            $page_data['exam_types']  = $this->db->get('exam_percentage')->result_array();
            $page_data['subject_id']  = $period_id;//this period id here is selected subject id
            $page_data['score_type']  = $score_type;
            $page_data['subjects']    = $this->db->get_where('subject',array('class_id'=>$class_,'language'=>$language,'study_time'=>$study_time))->result_array();            
            $page_data['students']    = $students;
            $page_data['score_types'] = $this->db->get('score_percentage')->result_array();
            $page_data['page_name']   = 'manage_mark';
            $page_data['page_title']  = 'Manage marks';
            $page_data['function']    = 'manage_marks';
            $this->load->view('backend/index',$page_data);
          }
          if($param1 == 'create'){
            $student_ids              = $this->input->post('students');
            $current_date             = date('Y-m-d',now());
            $data['date']             = $current_date;
            $data['year']             = $this->session->userdata('academic_year');
            $data['subject_id']       = $this->input->post('subject');
            $data['score_type_id']    = $this->input->post('score_type');
            $data['class_id']         = $this->input->post('score_class_id');
            $data['semester']         = $this->input->post('semester');
            if($this->db->get_where('score_percentage',array('id'=>$data['score_type_id']))->row()->name=='exam')
            {
              $data['exam_type_id']     = $this->input->post('exam_type');
              if($this->db->get_where('exam_percentage',array('id'=>$data['exam_type_id']))->row()->name=='monthly'){
                $data['month'] = $this->input->post('month');
              }
            }
            $exist_sname_pid          = $this->db->get_where('score',array('name'=>$data['name'],'class_id'=>$data['class_id'],'subject_id'=>$data['subject_id']))->row()->period_id;
            $exist_sname_pids          = $this->db->get_where('score',array('class_id'=>$data['class_id'],'subject_id'=>$data['subject_id']))->result_array();
           $data_exist ='false';
          foreach ($student_ids as $student_id) {
              $data['student_id']   = $student_id;
              $data['score_obtain'] = $this->input->post('score'.$student_id);
              $data['comment']      = $this->input->post('comment'.$student_id);
              $this->db->insert('mark',$data);
            }
             $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "note score of subject".'\''.$this->db->get_where('subject',array('subject_id'=>$subject_id))->row()->name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , "Data added successfully");
            redirect(base_url() . 'index.php?admin/manage_marks' , 'refresh');
          }
          if($param1 == 'update'){
            $student_ids              = $this->input->post('students');
            $semester                 = $this->input->post('semester_old');
            $data['semester']         = $this->input->post('semester');
            $data['subject_id']       = $this->input->post('subject');
            $exam_type_id             = $this->input->post('exam_type');
            if($this->db->get_where('score_percentage',array('id'=>$data['score_type_id']))->row()->name=='exam')
            {
              $data['exam_type_id']     = $exam_type_id;
            }if($this->db->get_where('exam_percentage',array('id'=>$exam_type_id))->row()->name=='monthly')
            {
              $month = $this->input->post('month_old');
              $data['month']  = $this->input->post('month');
            }
            foreach ($student_ids as $student_id) {  
                $data['score_obtain'] = $this->input->post('score'.$student_id);
                $data['comment']      = $this->input->post('comment'.$student_id);
                if($month){
                $this->db->where('student_id',$student_id);
                $this->db->where('score_type_id',$period_id);
                $this->db->where('class_id',$class_grade_id);
                $this->db->where('subject_id',$subject_selected);
                $this->db->where('exam_type_id',$exam_type_id);
                $this->db->where('semester',$semester);
                $this->db->where('month',$month);
                $this->db->where('year',$this->session->userdata('academic_year'));
                $this->db->update('mark',$data);
            }
            if(!$month){
               $this->db->where('student_id',$student_id);
                $this->db->where('score_type_id',$period_id);
                $this->db->where_in('class_id',$class_groups);
                $this->db->where('subject_id',$subject_selected);
                $this->db->where('exam_type_id',$exam_type_id);
                $this->db->where('semester',$semester);
                $this->db->where('year',$this->session->userdata('academic_year'));
                $this->db->update('mark',$data);
            }
          }
              $myfile = fopen('log.txt','a+');
             $text   = $this->session->userdata('name').'\\'."\t";
             fwrite ($myfile,$text);
             $text   = "update score of subject".'\''.$this->db->get_where('subject',array('subject_id'=>$this->input->post('subject_id')))->row()->name.'\''."\t".'\\';
             fwrite ($myfile,$text);
             $text   = date('d M,Y',now());
             fwrite ($myfile, $text);
             $text   = "\n";
             fwrite($myfile, $text);
             fclose ($myfile);
            $this->session->set_flashdata('flash_message' , "Data updated ");
            redirect(base_url() . 'index.php?admin/edit_marks' , 'refresh');
        }
        if($param1=='')
        { 
            $this->db->select('class.name,class_detail.*');
            $this->db->from('class');
            $this->db->join('class_detail','class.class_id = class_detail.class_id');
            $this->db->order_by('name','desc');
            $page_data['classes']     = $this->db->get()->result_array();
             if($this->session->userdata('teacher_login') == 1)
            {
              $login_tid   = $this->db->get_where('employee',array('employee_id_code'=>$this->session->userdata('login_user_id')))->row()->employee_id;
              $class_names = $this->db->get_where('teacher_class',array('teacher_id'=>$login_tid))->result_array();
              $num=0;
              foreach ($class_names as $row_cname_id) {
                $arr_class_nid[$num] = $row_cname_id['class_name_id'];$num++;
              }
              $this->db->select('*');
              $this->db->distinct('class_detail_id');
              $this->db->where_in('id',$arr_class_nid);
              $c_detail_ids = $this->db->get('class_name')->result_array(); 
              $number=0;
              foreach ($c_detail_ids as $row_cd_id) {
                $arr_class_did[$number]= $row_cd_id['class_detail_id'];$number++;
              }
              $this->db->select('class.name,class_detail.*');
              $this->db->from('class');
              $this->db->join('class_detail','class.class_id = class_detail.class_id');
              $this->db->where_in('class_detail_id',$arr_class_did);
              $this->db->order_by('name','desc');
              $page_data['classes']     = $this->db->get()->result_array();
            }
         $page_data['score_types']  = $this->db->get('score_percentage')->result_array();
         $page_data['class_groups']= $this->db->get('class_info')->result_array();
         $page_data['page_name']   = 'manage_mark';
         $page_data['page_title']  = 'Manage marks';
         $page_data['function']    = 'manage_marks';
         $this->load->view('backend/index',$page_data);
        }
    }

    /****MANAGE EXAM MARKS*****/
    function marks($exam_id = '', $class_id = '', $subject_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['subject_id'] = $this->input->post('subject_id');
            
            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'index.php?admin/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'index.php?admin/marks/', 'refresh');
            }
        }
        if ($this->input->post('operation') == 'update') {
            $data['mark_obtained'] = $this->input->post('mark_obtained');
            $data['comment']       = $this->input->post('comment');
            
            $this->db->where('mark_id', $this->input->post('mark_id'));
            $this->db->update('mark', $data);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/marks/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['function']   = 'marks';
        $page_data['page_info'] = 'Exam marks';
        
        $page_data['page_name']  = 'marks';
        $page_data['page_title'] = 'Manage exam marks';
        $this->load->view('backend/index', $page_data);
    }
    
    
    /****MANAGE GRADES*****/
    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            $data['comment']     = $this->input->post('comment');
            $this->db->insert('grade', $data);
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            $data['comment']     = $this->input->post('comment');
            
            $this->db->where('grade_id', $param2);
            $this->db->update('grade', $data);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('grade', array(
                'grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        }
         $page_data['function']   = 'grade';
        $page_data['grades']     = $this->db->get('grade')->result_array();
        $page_data['page_name']  = 'grade';
        $page_data['page_title'] = 'Manage grade';
        $this->load->view('backend/index', $page_data);
    }
    
    /****** DAILY ATTENDANCE *****************/
    function manage_attendance($date='',$month='',$year='',$class_id='')
    {
        if($this->session->userdata('admin_login')!=1)redirect('login' , 'refresh');
        if($_POST)
        {
            // Loop all the students of $class_id
            $students   =   $this->db->get_where('student', array('class_id' => $class_id))->result_array();
            foreach ($students as $row)
            {
                $attendance_status  =   $this->input->post('status_' . $row['student_id']);
                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('date' , $this->input->post('date'));
                $this->db->update('attendance' , array('status' => $attendance_status));
            }
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/manage_attendance/'.$date.'/'.$month.'/'.$year.'/'.$class_id , 'refresh');
        }
        $page_data['date']     =    $date;
        $page_data['month']    =    $month;
        $page_data['year']     =    $year;
        $page_data['class_id'] =    $class_id;
        $page_data['function']   = 'manage_attendance';
        $page_data['page_name']  =  'manage_attendance';
        $page_data['page_title'] =  'Manage daily attendance';
        $this->load->view('backend/index', $page_data);
    }

    function attendance_selector()
    {
        redirect(base_url() . 'index.php?admin/manage_attendance/'.$this->input->post('date').'/'.
                    $this->input->post('month').'/'.
                        $this->input->post('year').'/'.
                            $this->input->post('class_id') , 'refresh');
    }

//PAYMENT SERVICE

     function paymentservice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1&&$this->session->userdata('accountant_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $array_id=array();
            $service_due_amount=0;
            $due_amount=0;
            $array_id                   = $this->input->post('service');
            $free_id                    = $this->input->post('free');
            $discount_id                = $this->input->post('discount');
            $service_names = null;
            $amount_paid=0;
            $data3 = array();
            $data_exist='false';
            $all_service_names;
            $is_free =0;

            $fee = $this->db->get_where('invoice',array('invoice_id'=>$param2))->result_array();
          foreach ($fee as $row1 ) {
            $due_amount  =  $row1['due_amount'];
            $student_id  = $row1['student_id'];
            $amount_paid = $row1['amount_paid'];
            $iid         = $row1['invoice_id_code'];
            $description = $row1['description'];
          }
          //--DELETE SERVICE LIST TO PAY ---//
          $this->db->where('id_invoice',$param2);
          $this->db->delete('service_list_to_pay');
            $service_cost=$this->db->get('service')->result_array();
           foreach ($service_cost as $row ) {   
              foreach ($array_id as $selected_service) {
                      $data_exist = 'false';//TEST IF THE CONTENT IS FREE IF TRUE PREICE IS FREE 
                      $is_free    = 0; // IS FREE USED TO INSERT INTO THE DATABASE 1 FREE 0 NOT FREE
                   $service_free = $this->input->post('free'.$row['service_id']); 
                  if($selected_service == $row['service_id'])
                   {   $service_names      = $row['name'];
                      $all_service_names   = $all_service_names.$service_names;
                          if($row['has_quantity']==0)
                          {
                           if($service_free!='')
                           {    
                              $service_amount     = 'free';
                              $is_free =1;
                              $free = $service_free; 
                            }
                           if($service_free==''){ 
                              $service_amount     = $row['cost']; 
                            }
                            $quantity =1;
                           }
                       if($row['has_quantity']==1)
                       {
                          $quantity = $this->input->post('quantity'.$row['service_id']);
                          $free = $this->input->post('free'.$row['service_id']);
                       }
                       if($quantity ==''){
                            $quantity = 1;
                          }
                       if($free==''){
                            $free =0;
                          }
                       for ($i=0; $i < $quantity; $i++) { 
                           if($row['has_quantity']==0)
                           {$free = $this->input->post('free'.$row['service_id']);}

                          if($free!=''&& $free>0){
                            $is_free =1;
                            $service_amount = 'free';
                          }
                          else
                         {
                            $is_free=0;
                            $service_amount = $row['cost'];
                         }
                        $discount =0;
                        $discount = $this->input->post($selected_service);

//ADD DISCOUNT IN SERVICE PRICE                         
                        $service_amount = $service_amount - $service_amount*$discount/100;
                        $service_total_amount   = $service_total_amount+$service_amount;

                         $data3['id_invoice']   = $param2;
                         $data3['timestamp']    = now();
                         $data3['discount']     = $discount;
                         $data3['amount']       = $service_amount;
                         $data3['is_free']      = $is_free;
                         $data3['service']  = $service_names;
                        $this->db->insert('service_list_to_pay',$data3);

                        $myfile = fopen('log.txt','a+');
                        $text   = $this->session->userdata('name').'\\'."\t";
                        fwrite ($myfile,$text);
                        $text   = "add service to invoice ".'\''.$this->db->get_where('invoice',array('invoice_id'=>$param2))->row()->invoice_id_code.'\''."\t".'\\';
                        fwrite ($myfile,$text);
                        $text   = date('d M,Y',now());
                        fwrite ($myfile, $text);
                        $text   = "\n";
                        fwrite($myfile, $text);
                        fclose ($myfile);
                        $data['payment_id']         = $param2;//invoice_id
                        $data['service_id']         = $row['service_id'];
                        $this->db->insert('payment_service', $data);
                        $free--;
                      }
                    }
                 }
            }
              $due_amount=  $service_total_amount;
            if(($due_amount-$amount_paid)==0){
              $status = 'paid';
            }
            elseif(($due_amount-$amount_paid)==$due_amount){
              $status = 'unpaid';
            }
            elseif(($due_amount-$amount_paid)>0){
              $status = 'partial paid';
            }
              $data2['due_amount']         =   $due_amount;
              $data2['modified_timestamp'] =   now();
              $data2['status']             = $status;
              $this->db->where('invoice_id',$param2);
              $this->db->update('invoice',$data2);

              $this->session->set_flashdata('flash_message' , 'Data added successfully');
              redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['amount_paid']             = $this->input->post('amount');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $invoice_info = array();
            $invoice_info =   $this->db->get_where('invoice' , array('invoice_id' => $param2) )->result_array();
            foreach ($invoice_info as $row ) {
                $due_amount=$row['due_amount'];
            }
            $remain = $due_amount - $data['amount_paid'];

            if($remain==0){
                $data['status']="paid";
            }elseif($remain==$due_amount){
                $data['status']="unpaid";
            }elseif($remain>0){
                $data['status']="partial paid";
            }
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
            } else if ($param1 == 'edit') {
                $page_data['edit_data'] = $this->db->get_where('invoice', array(
                    'invoice_id' => $param2
                ))->result_array();
            }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);
            $data2['amount_paid']   =   $this->input->post('amount');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');
            $this->session->set_flashdata('flash_message' , 'Payment successfully');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        $page_data['function']   = 'invoice';
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = 'Manage invoice/payment';
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function discount($param1 ='')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        $data['discount'] =$this->input->post('discount');;
        $due_amount = $this->db->get_where('invoice',array('invoice_id'=>$param1))->row()->due_amount;
        $to_paid = $due_amount-$due_amount*$data['discount']/100 - $this->db->get_where('invoice',array('invoice_id'=>$param1))->row()->amount_paid;
        if($to_paid==0){
            $data['status'] = 'paid';
        }elseif($to_paid==$due_amount){
            $data['status'] = 'unpaid';
        }elseif($to_paid>0){
            $data['status'] = 'partial_paid';
        }
          $this->db->where('invoice_id', $param1);
          $this->db->update('invoice', $data);

          $myfile = fopen('log.txt','a+');
           $text   = $this->session->userdata('name').'\\'."\t";
           fwrite ($myfile,$text);
           $text   = "add discount to invoice ".'\''.$this->db->get_where('invoice',array('invoice_id'=>$param1))->row()->invoice_id_code.'\''."\t".'\\';
           fwrite ($myfile,$text);
           $text   = date('d M,Y',now());
           fwrite ($myfile, $text);
           $text   = "\n";
           fwrite($myfile, $text);
           fclose ($myfile);
           $this->session->set_flashdata('flash_message' , 'Data added successfully');
          redirect(base_url() . 'index.php?admin/invoice', 'refresh');
    }

    /******MANAGE BILLING / INVOICES WITH STATUS*****/

    function invoice_valid_date($param1 = ''){
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('accountant_login')!=1)
            redirect(base_url(), 'refresh');
        $data['valid_date']  = strtotime($this->input->post('deadline'));

        $this->db->where('invoice_id',$param1);
        $this->db->update('invoice',$data);
         $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
    }

    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('accountant_login')!=1)
            redirect(base_url(), 'refresh');
        
        if($this->session->userdata('admin_login') == 1){
            $role='admin';
        }elseif($this->session->userdata('accountant_login') == 1){
            $role='accountant';
        }
        if ($param1 == 'create') {
            $invoice_id = $this->db->get('invoice')->result_array();
            foreach ($invoice_id as $row4) {
                $iid = $row4['invoice_id'];
            }
            $students   = $this->db->get_where('student',array('student_id'=>$this->input->post('student_id')))->result_array();
            $stu  = $this->input->post('student_id');
            $position = strrpos($stu,'#');
            $student_id_code = substr($stu, $position+1);
            $data['discount']           = 0;
            $data['student_id']         = $this->db->get_where('student',array('student_id_code'=>$student_id_code))->row()->student_id;
            $data['invoice_id_code']    = '#tsiai'.$iid;
            $data['due_amount']         = 0;
            $data['amount_paid']        = 0;
            $data['status']             = 'unpaid';     
            $data['creation_timestamp'] = now();
            $data['payment_method']     = 'n/a';
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'do_update') {
            $amount_paid=0;
            $data['student_id']         = $this->db->get_where('student',array('student_id'=>$this->input->post('student_name')))->row()->student_id;
            $data['amount_paid']        = $this->input->post('amount');
            $data['modified_timestamp'] = now();

            $invoice_info = array();
            $invoice_info =   $this->db->get_where('invoice' , array('invoice_id' => $param2) )->result_array();
            foreach ($invoice_info as $row ) {
                $due_amount  =$row['due_amount'];
                $amount_paid =$row['amount_paid'];
                $iid         =$row['invoice_id_code'];
                $discount    =$row['discount'];
            }
            $amount_paid = $amount_paid + $data['amount_paid'];
            $remain = $due_amount - $amount_paid;
            $data['amount_paid']=$amount_paid;
            if($remain==0){
                $data['status']="paid";
                $data3['method']='full paid';
            }elseif($remain==$due_amount- ($due_amount*$discount)){
                $data['status']="unpaid";
            }elseif($remain>0){
                $data['status']="partial paid";
                $data3['method']='Partial paid';
            }

//TO DO UPDATE PAYMENT METHOD TO BE AUTO GENERATE
            $due_amount = $due_amount + $tuition_amount;
           
            $data['due_amount']     = $due_amount;
            $data['payment_method'] = $data3['method'];

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
//END UPDATE INVOICE
            $service_name = null;
            $services = $this->db->get_where('payment_service',array('payment_id'=>$param2))->result_array();
            foreach ($services as $service) {
                $service_data = $this->db->get_where('service',array('service_id'=>$service['service_id']))->result_array();
                foreach ($service_data as $ser ) {
                    $service_name = $service_name.$ser['name'];
                }              
            }
            $data3['payment_type'] = "income";
            $data3['invoice_id']   = $param2;
            $data3['student_id']   = $data['student_id'];
            $data3['discount_id']  = $discount;
            $data3['total_amount'] = $this->input->post('amount');
            $data3['paid_amount']  = $this->input->post('amount');
            if($service_name==''){
                $service_name='Tuition Fee';
            }
            $data3['description']  = $service_name;
            $data3['timestamp']    = now();
            $this->db->insert('payment',$data3);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);

            $data2['amount_paid']   =   $this->input->post('amount');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , 'Payment successfully');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if(!$param1){
          $m = 07;
          $d = 01;
          $month = date('m',now());$y = date('Y',now());$day=date('d',now());
          if($month<8){
              $y1 = $y-1; 
            // find position of - and get the first year as from date year and the later a as to date year
            $pos = strrpos($this->session->userdata('academic_year'), '-');
            $y1 = substr($this->session->userdata('academic_year'), $pos+1);
            $y  = substr($this->session->userdata('academic_year'), 0,$pos);

            $from_date = $y1.'-'.$m.'-'.$d;
            $to_date   = $y.'-'.$month.'-'.$day;
        }elseif($month >=8){
            $y1 = $y+1;

            $pos = strrpos($this->session->userdata('academic_year'), '-');
            $y1 = substr($this->session->userdata('academic_year'), $pos+1);
            $y  = substr($this->session->userdata('academic_year'), 0,$pos);

            $from_date = $y.'-'.$m.'-'.$d;
            $from_date = strtotime($from_date);
            $to_date   = $y1.'-'.$month.'-'.$day;
            $to_date   = strtotime($to_date);
        }
        
        $page_data['role']       = $role;
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = 'Manage invoice/payment';
        $this->db->where('creation_timestamp >=',$from_date);
        $this->db->where('creation_timestamp <=',$to_date);
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get_where('invoice')->result_array();
        $page_data['paid_invoices'] = $this->db->get_where('invoice',array('status'=>'paid'))->result_array();
        $page_data['unpaid_invoices'] = $this->db->get_where('invoice',array('status'=>'unpaid'))->result_array();
        $page_data['ppaid_invoices'] = $this->db->get_where('invoice',array('status'=>'partial paid'))->result_array();
         $page_data['function']   = 'invoice';
        $this->load->view('backend/index', $page_data);
        }elseif($param1 =='search'){
            $to_date = $this->input->post('to_date');
            $from_date = $this->input->post('from_date');
            $status  = $this->input->post('status');

            if(!$to_date){
                $to_date = date('Y-m-d',now());
            }
            $to_date = str_replace('/','-',$to_date);
            $from_date = str_replace('/','-',$from_date);
            $to_date1 = strtotime($to_date);
            $from_date1 = strtotime($from_date);
        $page_data['status_selected'] = $status;
        $page_data['role']       = $role;
        $page_data['from_date']  = $from_date;
        $page_data['to_date']    = $to_date;
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = 'Manage invoice/payment';
        $this->db->where('creation_timestamp >=',$from_date1);
        $this->db->where('creation_timestamp <=',$to_date1);
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $page_data['paid_invoices'] = $this->db->get_where('invoice',array('status'=>'paid'))->result_array();
        $page_data['unpaid_invoices'] = $this->db->get_where('invoice',array('status'=>'unpaid'))->result_array();
        $page_data['ppaid_invoices'] = $this->db->get_where('invoice',array('status'=>'partial paid'))->result_array();
         $page_data['function']   = 'invoice';

         $this->load->view('backend/index', $page_data);
        }
    }


    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['price']       = $this->input->post('price');
            $data['author']      = $this->input->post('author');
            $data['class_id']    = $this->input->post('class_id');
            $data['status']      = $this->input->post('status');
            $this->db->insert('book', $data);
            $this->session->set_flashdata('flash_message' , 'Data added successfully');
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['price']       = $this->input->post('price');
            $data['author']      = $this->input->post('author');
            $data['class_id']    = $this->input->post('class_id');
            $data['status']      = $this->input->post('status');
            
            $this->db->where('book_id', $param2);
            $this->db->update('book', $data);
            $this->session->set_flashdata('flash_message' , 'Data updated');
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('book', array(
                'book_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , 'Data deleted');
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        $page_data['function']   = 'book';
        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = 'Manage library books';
        $this->load->view('backend/index', $page_data);
        
    }
 
    
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {  
        if ($param1 == 'do_update') {
             
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type' , 'text_align');
            $this->db->update('settings' , $data);

             $data['description'] = $this->input->post('borrow_book_period');
            $this->db->where('type' , 'borrow_book_period');
            $this->db->update('settings' , $data);
            
            $this->session->set_flashdata('flash_message' , 'Data updated'); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', 'Settings updated');
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , 'Theme selected'); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh'); 
        }
        $page_data['function']   = 'system_settings';
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = 'System settings';
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    
    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile']  = $param2;  
        }
        if ($param1 == 'update_phrase') {
            $language   =   $param2;
            $total_phrase   =   $this->input->post('total_phrase');
            for($i = 1 ; $i < $total_phrase ; $i++)
            {
                $this->db->where('phrase_id' , $i);
                $this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/'.$language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', 'Settings updated');
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', 'Settings updated');
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);
            
            $this->session->set_flashdata('flash_message', 'Settings updated');
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', 'Settings updated');
            
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['function']         = 'manage_language';
        $page_data['page_name']        = 'manage_language';
        $page_data['page_title']       = 'Manage language';
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data); 
    }
    
    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        $page_data['function']   = 'backup_restore';
        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = 'Manage backup restore';
        $this->load->view('backend/index', $page_data);
    }
    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            
            if($this->session->userdata('admin_login')==1)
            {$this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', $data);
            }elseif($this->session->userdata('administrator_login')==1)
            {
                $this->db->where('id', $this->session->userdata('administrator_id'));
            $this->db->update('administrator', $data);
            }elseif($this->session->userdata('accountant_login')==1)
            {
                $this->db->where('id', $this->session->userdata('accountant_id'));
            $this->db->update('accountant', $data);
            }elseif($this->session->userdata('teacher_login')==1)
            {
                $this->db->where('id', $this->session->userdata('teacher_id'));
            $this->db->update('teacher', $data);}

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $this->session->userdata('admin_id') . '.jpg');
            $this->session->set_flashdata('flash_message','Account updated');
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');

            if($this->session->userdata('admin_login')==1)
           { $current_password = $this->db->get_where('admin', array(
                           'admin_id' => $this->session->userdata('admin_id')
                       ))->row()->password;}

             if($this->session->userdata('administrator_login')==1)
           { $current_password = $this->db->get_where('administrator', array(
                           'id' => $this->session->userdata('administrator_id')
                       ))->row()->password;}

            if($this->session->userdata('accountant_login')==1)
           { $current_password = $this->db->get_where('accountant', array(
                           'id' => $this->session->userdata('accountant_id')
                       ))->row()->password;}
          if($this->session->userdata('teacher_login')==1)
           { $current_password = $this->db->get_where('teacher', array(
                           'id' => $this->session->userdata('teacher_id')
                       ))->row()->password;}

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                if($this->session->userdata('admin_login')==1)
                {$this->db->where('admin_id', $this->session->userdata('admin_id'));
                                $this->db->update('admin', array(
                                    'password' => $data['new_password']
                                ));}
                elseif($this->session->userdata('administrator_login')==1)
                {$this->db->where('id', $this->session->userdata('administrator_id'));
                                $this->db->update('administrator', array(
                                    'password' => $data['new_password']
                                ));}

                elseif($this->session->userdata('accountant_login')==1)
                {$this->db->where('id', $this->session->userdata('accountant_id'));
                                $this->db->update('accountant', array(
                                    'password' => $data['new_password']
                                ));}
                elseif($this->session->userdata('teacher_login')==1)
                {$this->db->where('id', $this->session->userdata('teacher_id'));
                                $this->db->update('teacher', array(
                                    'password' => $data['new_password']
                                ));}

                $this->session->set_flashdata('flash_message', 'Password updated');
            } else {
                $this->session->set_flashdata('flash_message', 'Password mismatch');
            }
            redirect(base_url() . 'index.php?admin/manage_profile/ ', 'refresh');
        }
        $page_data['function']   = 'manage_profile';
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = 'Manage profile';
       if($this->session->userdata('admin_login')==1)
       { $page_data['edit_data']  = $this->db->get_where('admin', array(
                   'admin_id' => $this->session->userdata('admin_id')
               ))->result_array();}

        elseif ($this->session->userdata('administrator_login')==1){
           $page_data['edit_data']  = $this->db->get_where('administrator', array(
                   'id' => $this->session->userdata('administrator_id')
               ))->result_array();}

        elseif ($this->session->userdata('accountant_login')==1){
           $page_data['edit_data']  = $this->db->get_where('accountant', array(
                   'id' => $this->session->userdata('accountant_id')
               ))->result_array();}
           elseif ($this->session->userdata('teacher_login')==1){
           $page_data['edit_data']  = $this->db->get_where('teacher', array(
                   'teacher_id' => $this->session->userdata('teacher_id')
               ))->result_array();
          }
        
        $this->load->view('backend/index', $page_data);
    }
}
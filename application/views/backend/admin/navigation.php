<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="entypo-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class="<?php
        if ($page_name == 'student_add' ||
                $page_name == 'student_bulk_add' ||
                $page_name == 'student_information_all' ||
                $page_name == 'student_marksheet')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span>Student</span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_add">
                        <span><i class="entypo-dot"></i> Admit student</span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information_all') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_information_all/">
                        <span><i class="entypo-dot"></i> Student information</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--ATTENDANCE-->
        <li class="<?php if ($page_name == 'attendance_class') echo 'opened active '; ?> ">

            <a href="<?php echo base_url(); ?>index.php?admin/attendance_class">
                <i class="entypo-check"></i>
                <span> Attendance </span>
            </a>
            <!-- <ul>
                    <li class="<?php if ($page_name == 'attendance_class') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/attendance_class">
                    <i class="entypo-dot"></i>
                    <span>Note attendance</span>
                </a>
                    </li>
                   
            </ul> -->

        </li>

        <!-- SERVICE -->
         <li class="<?php if ($page_name == 'service') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/service">
                <i class="entypo-bag"></i>
                <span>Service</span>
            </a>
        </li>

        <!-- CLASS -->
        <li class="<?php
        if ($page_name == 'class' ||
                $page_name == 'manage_group')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span>Class</span>
            </a>

             <ul>
                        <li><a href="<?php echo base_url(); ?>index.php?admin/classes">
                <i class="entypo-dot"></i>
                <span> Class list</span>
            </a>
                        </li>
                        <li><a href="<?php echo base_url();?>index.php?admin/manage_group">
                            <i class='entypo-dot'></i>
                            <span>Class group</span>
                            </a>
                        </li>
                   </ul>

        </li>
         <!-- SUBJECT -->
          <li class="<?php if ($page_name == 'subject') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/subject">
                <i class="entypo-docs"></i>
                <span>Subject</span>
            </a>
        </li>
<!-- SCORE -->
    <li class="<?php if($page_name=='manage_mark' ||
                        $page_name=='edit_mark'||
                        $page_name=='manage_period')echo 'opened active';?>">
        <a href="#">
                <i class="entypo-chart-line"></i>
                <span>Manage score</span>
            </a>
        <ul>   
        <li class="<?php if($page_name=='mange_period')echo 'active';?>">
         <a href="<?php echo base_url(); ?>index.php?admin/score_percentage">
                <i class="entypo-dot"></i>
                <span>Score percentage</span>
            </a>
        </li>  
        <li class="<?php if($page_name=='manage_mark')echo 'active';?>">
         <a href="<?php echo base_url(); ?>index.php?admin/manage_marks">
                <i class="entypo-dot"></i>
                <span>Note marks</span>
            </a>
        </li>
        <li class="<?php if($page_name=='edit_mark')echo 'active';?>">
            <a href="<?php echo base_url(); ?>index.php?admin/edit_marks">
                <i class="entypo-dot"></i>
                <span>Edit marks</span>
            </a>
        </li>
        </ul>
    </li>

       
        <!-- EXAMINATION -->
           <!--  <li class="<?php if(($page_name == 'exam_list')
                    ||($page_name =='exam_edit')
                    ||($page_name=='mark_exam')
                     ||($page_name=='display_mark'))
               echo 'opened active' ?>">
               <a href="#">
                    <i class="entypo-calendar"></i>
                    <span>Exam</span>
               </a>
                   <ul>
                        <li><a href="<?php echo base_url();?>index.php?admin/exam">
                            <i class='entypo-dot'></i>
                            <span>Exam list</span>
                            </a>
                        </li>
                        <li><a href="<?php echo base_url();?>index.php?admin/marks">
                            <i class='entypo-dot'></i>
                            <span>Manage exam mark</span>
                            </a>
                        </li>
                   </ul>
               </li> -->
               <!-- REPORT -->
               <li class="<?php if(($page_name == 'attendance_report')
                    ||($page_name =='list_attendance')
                    ||($page_name=='score_report')
                    ||($page_name=='display_mark')
                    ||($page_name=='subject_score'))
               echo 'opened active' ?>">
               <a href="#">
                    <i class="entypo-clipboard"></i>
                    <span>Report</span>
               </a>
                   <ul>
                        <li><a href="<?php echo base_url();?>index.php?admin/report_attendance">
                            <i class='entypo-dot'></i>
                            <span>Attendance report</span>
                            </a>
                        </li>
                        <li ><a>
                            <i class='entypo-dot'></i>
                            <span>Score report</span>
                            </a>
                            <ul >
                                <li><a href="<?php echo base_url();?>index.php?admin/report_subscore">
                            <i class='entypo-dot'></i>
                            <span>Subject score</span>
                            </a></li>
                             <li><a href="<?php echo base_url();?>index.php?admin/report_semescore">
                            <i class='entypo-dot'></i>
                            <span>Semester score</span>
                            </a></li>
                            </ul>
                        </li>
                   </ul>
               </li>
        <!-- PAYMENT -->
        <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/invoice">
                <i class="entypo-credit-card"></i>
                <span>Payment</span>
            </a>
        </li>
        
        <!-- EMPLOYEE -->
        <!-- <li class="<?php if ($page_name == 'employee') echo 'active'; ?> ">
            <a href="#">
                <i class="entypo-vcard"></i>
                <span><?php echo get_phrase('employee'); ?></span>
            </a>
        </li> -->
        <li class="<?php
        if (
                $page_name == 'employee_add' ||
                $page_name == 'employee'||
                $page_name == 'employee_performance'||
                $page_name == 'employee_information_list'||
                $page_name == 'employee_attendance_permission')
            echo 'opened active ';
        ?> ">
            <a href="#">
                <i class="entypo-vcard"></i>
                <span> Employee</span>
            </a>
            <ul>
                <!-- ADD EMPLOYEE -->
                <li class="<?php if ($page_name == 'employee_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/employee_add">
                        <span><i class="entypo-dot"></i> <?php echo 'Add employee'; ?></span>
                    </a>
                </li>

                <!-- EMPLOYEE INFORMATION -->
                <li class="<?php if ($page_name == 'employee_information_list') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/employee_information_list/">
                        <span><i class="entypo-dot"></i> <?php echo 'Employee information'; ?></span>
                    </a>
                </li>
                <!-- EMPLOYEE ATTENDANCE -->
                <li class="<?php if ($page_name == 'employee_attendance_permission') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/employee_attendance/">
                        <span><i class="entypo-dot"></i> Employee attendance</span>
                    </a>
                </li>
                <!-- EMPLOYEE PERFORMANCE -->
                <li class="<?php if ($page_name == 'employee_performance') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/employee_performance/">
                        <span><i class="entypo-dot"></i> Employee performance</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'library' ||
                $page_name == 'add_book' ||
                $page_name == 'borrow_form'||
                $page_name == 'borrow_book'||
                $page_name == 'view_book' ||
                $page_name == 'edit_book')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-book"></i>
                <span>Library</span>
            </a>
            <ul>
                <!-- ADD BOOK -->
                <li class="<?php if ($page_name == 'add_book') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/add_book">
                        <span><i class="entypo-dot"></i> <?php echo 'Book list'; ?></span>
                    </a>
                </li>

                <!-- BORROW INFO -->
                <li class="<?php if ($page_name == 'borrow_list') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/borrow_book/">
                        <span><i class="entypo-dot"></i> <?php echo 'Borrow list'; ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- POTENTIAL CUSTOMER -->
        <li class="<?php
        if ($page_name == 'potential_customer')
                        echo 'opened active';
        ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/potential_customer">
                <i class="entypo-book-open"></i>
                <span>Potential customer</span>
            </a>
            <ul>
                <!--  ADD INFO CUSTOMER-->
                <li class="<?php if ($page_name == 'add_potential_customer') echo 'active'; ?> ">
                  <a href="<?php echo base_url(); ?>index.php?admin/add_potential_customer">
                        <span><i class="entypo-dot"></i> Add potential customer</span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'potential_customer_list') echo 'active'; ?> ">
                  <a href="<?php echo base_url(); ?>index.php?admin/potential_customer_list">
                        <span><i class="entypo-dot"></i> Potential customer list</span>
                    </a>
                </li>
                </ul>
        </li>
        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' ||
                $page_name == 'manage_language' ||
                    $page_name == 'sms_settings')
                        echo 'opened active';
        ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                <i class="entypo-tools"></i>
                <span>Settings</span>
            </a>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span>Account</span>
            </a>
        </li>

    </ul>

</div>

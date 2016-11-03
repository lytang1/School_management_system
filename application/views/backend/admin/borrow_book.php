<div class="row">
    <div class="col-md-12">
    
        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
                    Borrow list
                        </a></li>
            <li>
                <a href="<?php echo base_url();?>index.php?admin/borrow_form/" ><i class="entypo-plus-circled"></i>
                    Borrow book
                        </a></li>
        </ul>
        <!------CONTROL TABS END------>
        
        <div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                
                <table class="table table-bordered datatable" id="table_export" style="text-align:center">
                    <thead>
                        <tr>
                            <th><div><center>#</center></div></th>
                            <th><div><center>Student</center></div></th>
                             <th><div><center>Books borrowed </center></div></th>
                            <th><div><center>Quantity</center></div></th>
                            <th><div><center>Borrow date</center></div></th>
                            <th><div><center>Return date</center></div></th>
                            
                            <!-- <th><div>Book title</div></th>
                            <th><div>Borrow date</div></th> -->
                            <!-- <th><div><?php echo get_phrase('price');?></div></th>
                            <th><div><?php echo get_phrase('class');?></div></th> -->
                        <!--     <th><div>Return date</div></th>
                            <th><div><?php echo get_phrase(' status_');?></div></th> -->
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;foreach($books as $row): $book_title='';?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?></td>
                            <?php $borrow_ids = $this->crud_model->get_student_borrow_book($row['student_id']);
                            foreach ($borrow_ids as $borrow) {
                                
                                    $book_title = $book_title.$this->db->get_where('book',array('book_id'=>$borrow['book_id']))->row()->name ;
                                    $book_title = $book_title." | ";
                                }?>
                            <td><?php echo $book_title;?></td>
                            <td><?php echo $row['quantity'];?></td>
                            <td><?php echo date('Y-m-d',$row['borrow_date']);?></td>
                            <td><?php echo date('Y-m-d',$row['return_date']);?></td>
                            <!--<td><span class="label label-<?php if($row['is_return']==1){$status='Return'; echo 'success';}else {$status='Borrow'; echo 'secondary';}?>"><?php echo $status;?></span></td>
                             --><td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                     <!-- DETAIL LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_borrow_book_detail/<?php echo $row['student_id'];?>');">
                                            <i class="entypo-list"></i>
                                                Detail
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                   
                                    <!-- RETURN BOOK -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/return_book/<?php echo $row['book_id'];?>/<?php echo $row['student_id'];?>"  >
                                            <i class="entypo-pencil"></i>
                                                Return
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                   
                                    
                                    <!-- DELETION LINK -->
                                    <li>                                    
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/borrow_book/delete/<?php echo $row['student_id'];?>');">
                                            <i class="entypo-trash"></i>
                                               Delete
                                            </a>
                                                    </li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
            
            
            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="borrow" style="padding: 5px">
                <div class="box-content">
       
        <?php echo form_open(base_url() . 'index.php?admin/borrow_book/create/', array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Student :</label>
                    <div class="col-sm-3">
                        <input list='studentlist' name="student_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                        <datalist id="studentlist">
                                            <?php 
                                            $students = $this->db->get('student')->result_array();
                                            foreach($students as $row):
                                            ?>
                                                <option value="<?php echo $row['name'].' #'.$row['student_id_code'];?>">
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                                </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title 1: </label>
                    <div class="col-sm-3" >
                       <input list='booklist'  name="book_id" class="form-control"  data-validate="required" data-message-required="<?php echo 'Value required';?>" >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                                        

                                      
                    </div>

                         <label class="col-sm-2 control-label">Return date (#1):</label>
                    <div class="col-sm-2">
                        <input type="text"  class="form-control datepicker"  name="return_date" value="" data-start-view="3"  data-validate="required" data-message-required="<?php echo 'Value required';?>">
                    </div>
                    </div>
                   
                    
                </div>
               <!--  <div class="form-group">
                   
                </div> -->
                <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title 2: </label>
                    <div class="col-sm-3" >
                    <input list='booklist' style="border-color:#ebebeb" name="book_id2" class="form-control"  >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                       
                    </div>

                         <label class="col-sm-2 control-label">Return date (#2):</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control datepicker" name="return_date2" value="" data-start-view="3">
                    </div>
                    </div>
                   
                    
                </div>


               <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title 3: </label>
                    <div class="col-sm-3" >
                       <input list='booklist' style="border-color:#ebebeb" name="book_id3" class="form-control"   >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Return date (#3):</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control datepicker"  name="return_date3" value="" data-start-view="3">
                    </div>
                    </div>
                   
                    
                </div>
                <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title 4: </label>
                    <div class="col-sm-3" >
                        <input list='booklist' style="border-color:#ebebeb" name="book_id4" class="form-control"  >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Return date (#4):</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control datepicker"  name="return_date4" value="" data-start-view="3">
                    </div>
                    </div>
                   

                    
                </div>
                 <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title 5: </label>
                    <div class="col-sm-3" >
                        <input list='booklist' style="border-color:#ebebeb" name="book_id5" class="form-control"   >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Return date (#5):</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control datepicker"  name="return_date5" value="" data-start-view="3">
                    </div>
                    </div>
                    <br>
                <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-5">
                      <button type="submit" class="btn btn-info">Confirm borrow</button>
                  </div>
                </div>
        </form>
        
    </div>               
            </div>
            <!----CREATION FORM ENDS-->
        </div>
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>


<script type="text/javascript">

    jQuery(document).ready(function($)
    {
 

        var datatable = $("#table_export").dataTable();
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

      




</script>
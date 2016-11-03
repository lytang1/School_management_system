<div class="row">
    <div class="col-md-12">
    
        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
                    Class list
                        </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    Add class
                        </a></li>
        </ul>
        <!------CONTROL TABS END------>
        
        <div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div>#</div></th>
                            <th><div><?php echo ' Class name';?></div></th>
                        <!--      <th><div><?php echo get_phrase(' decription_');?></div></th> -->
                       <!--     <th><div><?php echo get_phrase(' enroll_fee');?></div></th>
                            <th><div><?php echo get_phrase(' term_tuition_fee');?></div></th>
                            <th><div><?php echo get_phrase(' semester_tuition_fee');?></div></th>
                            <th><div><?php echo get_phrase(' year_tuition_fee');?></div></th> -->
                        <th><div><?php echo 'Options';?></div></th> 
                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;foreach($classes as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td style="width:75%" > <a class="dropdown-toggle" style="opacity: 1;">
   <span class="menu-text"><?php echo $row['name'];?></span>
</a><ul type="none" class="class_name">
<?php  $this->db->select('*');
        $this->db->from('class_detail');
        $this->db->join('class_name','class_name.class_detail_id = class_detail.class_detail_id');
        $this->db->where('class_id',$row['class_id']);
        $query= $this->db->get();
        $row1 = $query->result_array();
        $length = sizeof($row1); 
    for($i=0;$i<$length;$i++) :?>
<li class="row" style="padding:5px;" >
        <span class="col-sm-2"><?php echo $row1[$i]['name'];?></span>
        <span class="col-sm-2"><?php echo $row1[$i]['language'];?></span>
        <span class="col-sm-3"><?php echo $row1[$i]['study_time'];?></span>
        <span class="col-sm-2"><?php $t_id= $this->db->get_where('teacher_class',array('class_name_id'=>$row1[$i]['id']))->row()->teacher_id;
                                $t_name= $this->db->get_where('employee',array('employee_id'=>$t_id))->row()->name.' '.$this->db->get_where('employee',array('employee_id'=>$t_id))->row()->family_name;
                                if($t_name==' '){echo 'Not yet set';} else echo $t_name;?>
        </span>
        <span class="col-sm-2"> <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                  
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_class_group/<?php echo $row['class_id'];?>/<?php echo $row1[$i]['id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                Edit
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/class_group/delete/<?php echo $row1[$i]['id'];?>');">
                                            <i class="entypo-trash"></i>
                                                Delete
                                            </a>
                                                    </li>
                                                
                                </ul>
                            </div></span>

</li><?php endfor;?>
                            </ul></td>
                            <td> <center><div class="btn-group">
                            
                                <button type="button" style="valign:center" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                            
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                 <!-- ADD LINK -->
                                     <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_class/<?php echo $row['class_id'];?>/<?php echo $row1[$i]['id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                Add group
                                            </a>
                                                    </li>
                                
                                    <!-- EDITING LINK -->
                                 
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_class/<?php echo $row['class_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                Edit
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/classes/delete/<?php echo $row['class_id'];?>');">
                                            <i class="entypo-trash"></i>
                                                Delete
                                            </a>
                                     </li>
                                </ul>
                            </div></center></td>
                        <!--    <td><?php echo $row['study_time'];?></td>
                            <td><?php echo $row['enroll_fee'].'$';?></td>
                            <td><?php echo $row['term_tuition'].'$';?></td>
                            <td><?php echo $row['semester_tuition'].'$';?></td>
                            <td><?php echo $row['year_tuition'].'$';?></td> -->
                           
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
            
            
            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'index.php?admin/classes/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo ' Name';?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo 'Value required';?>"/>
                                </div>
                            </div>

                           <!-- <div class="form-group">
                                <label class="col-sm-3 control-label">Study time</label>
                                <div class="col-sm-5">
                                     <select name="study_time" class="form-control" data-validate="required" id="class_id" 
                                    data-message-required="<?php echo get_phrase('value_required');?>"
                                        onchange="return get_class_sections(this.value)">
                                        <option value=""><?php echo get_phrase('select');?></option>  
                                        <option value="Full time">Full time</option>
                                        <option value="Part time">Part time</option>
                                    </select>
                                </div>
                            </div>
 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Language</label>
                                <div class="col-sm-5">
                                     <select name="language" class="form-control" data-validate="required" id="class_id" 
                                    data-message-required="<?php echo get_phrase('value_required');?>"
                                        onchange="return get_class_sections(this.value)">
                                        <option value=""><?php echo get_phrase('select');?></option>  
                                        <option value="Monolingual">Monolingual</option>
                                        <option value="Bilingual">Bilingual</option>
                                    </select>
                                </div>
                            </div> -->


                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="" name="description" data-validate="required" data-message-required="<?php echo 'Value required';?>"/>
                                </div>
                            </div>

                           <!--  <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Tuition_Fee/Semester');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="0" name="semester" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Tuition_Fee/Year');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="0" name="year" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('enroll_fee');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="enroll_fee"/>
                                </div>
                            </div>
 -->
                        
                        <div class="form-group">
                              <div class="col-sm-offset-5 col-sm-5">
                                  <button type="submit" class="btn btn-info"> Add class</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>                   
<script type="text/javascript">

    jQuery(document).ready(function($)
    { $('.class_name').slideToggle()
        $('.dropdown-toggle').on('click', function(event) {
  $(this).siblings('ul').slideToggle();
});

        var datatable = $("#table_export").dataTable();
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
        
</script>
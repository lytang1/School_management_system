 <?php 

foreach ( $edit_data as $row):
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    Edit employee leave 
                </div>
            </div>
            <div class="panel-body">
                
                <?php echo form_open(base_url() . 'index.php?admin/employee_attendance/do_update/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
               
    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name</label>
                        
                        <div class="col-sm-3">
                        <?php $name = $this->db->get_where('employee',array('employee_id_code'=>$row['employee_id']))->row()->name;
                            $family_name = $this->db->get_where('employee',array('employee_id_code'=>$row['employee_id']))->row()->family_name;
                            ?>
                            <input list='teacherlist' value="<?php echo $name.' '.$family_name.' #'.$row['employee_id'];?> " name="employee_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                    <datalist id="teacherlist">
                                   
                                        
                                        <?php 
                                        $teachers = $this->db->get('employee')->result_array();
                                        foreach($teachers as $row1):
                                        ?>
                                            <option value="<?php echo $row1['name'].' '.$row1['family_name'].' #'.$row1['employee_id_code'];?>"></option>
                                        <?php
                                        endforeach;
                                        ?>
                                   </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Permission type</label>
                        
                        <div class="col-sm-3">
                           <select name="p_type" class="form-control">
                                        <option value="" >Select</option>
                                        <option value="Annual leave" <?php if($row['permission_type']=='Annual leave') echo 'selected';?>>Annual leave</option>
                                        <option value="Sick leave" <?php if($row['permission_type']=='Sick leave') echo 'selected';?>>Sick leave</option>
                                        <option value="Special leave" <?php if($row['permission_type']=='Special leave') echo 'selected';?>>Special leave</option>
                                        <option value="Maternity leave" <?php if($row['permission_type']=='Maternity leave') echo 'selected';?>>Maternity leave</option>
                                        <option value="Unpaid leave" <?php if($row['permission_type']=='Unpaid leave') echo 'selected';?>>Unpaid leave</option>
                                </select>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Number of leaving days</label>
                        
                        <div class="col-sm-3">
                            <input type="text" name='number_of_day' value="<?php echo $row['days'];?>" class="form-control">
                        </div> 
                    </div>


                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">From date</label>
                        
                        <div class="col-sm-3">
                            <input type="text" value="<?php echo date('Y/m/d',$row['from_date']);?>"  data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required';?>"  data-start-view="2" name="from_date" >
                        </div> 
                    </div>

                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Return date</label>
                        
                        <div class="col-sm-3">
                            <input  name="to_date" value="<?php echo date('Y/m/d',$row['return_date']);?>" type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>"  data-start-view="2">
                        </div> 
                    </div>
                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Reason</label>
                        
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $row['reason'];?>"  data-validate="required" data-message-required="<?php echo 'Required ';?>" name="p_reason"   >
                        </div> 
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"></label>
                        
                    </div> -->
                    
                    
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Stand by person during leave Name</label>
                        <div class="col-sm-3">
                           <?php $name = $this->db->get_where('employee',array('employee_id_code'=>$row['p_standby_id']))->row()->name;
                            $family_name = $this->db->get_where('employee',array('employee_id_code'=>$row['p_standby_id']))->row()->family_name;
                            ?>
                            <input list='teacherlist' value="<?php echo $name.' '.$family_name.' #'.$row['p_standby_id'];?> " name="standby_name" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                    <datalist id="teacherlist">
                                   
                                        
                                        <?php 
                                        $teachers = $this->db->get('employee')->result_array();
                                        foreach($teachers as $row2):
                                        ?>
                                            <option value="<?php echo $row2['name'].' '.$row2['family_name'].' #'.$row2['employee_id_code'];?>"></option>
                                        <?php
                                        endforeach;
                                        ?>
                                   </datalist>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info">Save</button>
                        </div>
                    </div>
                    <?php
endforeach;
?>

                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


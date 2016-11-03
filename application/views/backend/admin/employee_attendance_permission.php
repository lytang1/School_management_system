
                
                <?php echo form_open(base_url() . 'index.php?admin/employee_attendance/create/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
               
    <br>
                    <div class="form-group row">
                        <label for="field-1" class="col-sm-3 control-label">Name</label>
                        
                        <div class="col-sm-3">
                            <input list='teacherlist' value="" name="teacher_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
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

                    <div class="form-group row">
                        <label for="field-2" class="col-sm-3 control-label">Permission type</label>
                        
                        <div class="col-sm-3">
                           <select name="p_type" class="form-control">
                                        <option value="" >Select</option>
                                        <option value="Annual leave" >Annual leave</option>
                                        <option value="Sick leave" >Sick leave</option>
                                        <option value="Special leave" >Special leave</option>
                                        <option value="Maternity leave" >Maternity leave</option>
                                        <option value="Unpaid leave" >Unpaid leave</option>
                                </select>
                        </div> 
                        <label for="field-2" class="col-sm-3 control-label">Number of leaving days</label>
                        
                        <div class="col-sm-3">
                            <input type="text" name='number_of_day' value="" class="form-control">
                        </div> 
                    </div>


                    
                    <div class="form-group row">
                        <label for="field-2" class="col-sm-3 control-label">From date</label>
                        
                        <div class="col-sm-3">
                            <input type="text" value=""  data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>"  data-start-view="2" name="from_date" >
                        </div> 
                         <label for="field-2" class="col-sm-3 control-label">Return date</label>
                        
                        <div class="col-sm-3">
                            <input  name="to_date" value="" type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>"  data-start-view="2">
                        </div> 
                    </div>

                    
                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label">Reason</label>
                        
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value=""  data-validate="required" data-message-required="<?php echo 'Required ';?>" name="p_reason"   >
                        </div> 
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"></label>
                        
                    </div> -->
                    
                    
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Stand by person during leave Name</label>
                        <div class="col-sm-3">
                            <input list='employeelist' value=" " name="standby_name" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                    <datalist id="employeelist">
                                   
                                        
                                        <?php 
                                        $teacher1s = $this->db->get('employee')->result_array();
                                        foreach($teacher1s as $row2):
                                        ?>
                                            <option value="<?php echo $row2['name'].' '.$row2['family_name'].' #'.$row2['employee_id_code'];?>"></option>
                                        <?php
                                        endforeach;
                                        ?>
                                   </datalist>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </div>
  

                <?php echo form_close();?>
          
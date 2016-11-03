
                
                <?php echo form_open(base_url() . 'index.php?admin/add_potential_customer/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
               
    <br>
                    <div class="form-group row">
                        <label for="field-1" class="col-sm-3 control-label">Customer Name</label>
                        
                        <div class="col-sm-3">
                            <input  value="" name="customer_name" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                   
                        </div>
                    </div>

                    <div class="form-group row">
                         <div class=" form-group">
                            <label for="field-2" class="col-sm-3 control-label">Phone</label>
                            
                            <div class="col-sm-3">
                               <input class="form-control" type="tel" name="phone"  data-validate="required" data-message-required="<?php echo 'Value required';?>">
                            </div> 
                        </div>
                        <div class=" form-group">
                               <label for="field-2" class="col-sm-3 control-label">Email</label>
                            
                            <div class="col-sm-3">
                                <input type="text" value="" name="email" class="form-control"    >
                            </div> 
                        </div>
                    </div>


                    
                    <div class="form-group row">
                        <label for="field-2" class="col-sm-3 control-label">Purpose</label>
                        
                        <div class="col-sm-3">
                            <textarea value="" name="purpose" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>"></textarea>
                        </div> 
                       
                    </div>

                    <div class="form-group row">
                      <label for="field-2" class="col-sm-3 control-label">Date</label>
                        
                        <div class="col-sm-3">
                            <input  name="date" value="" type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>"  data-start-view="2">
                        </div> 
                   </div>
                    

                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </div>
  

                <?php echo form_close();?>
          
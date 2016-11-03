<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<!-- <div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('addmission_form');?>
            	</div>
            </div>
			 --><div class="panel-body">
				<?php foreach ($employees as $employee):?>
					
                <?php echo form_open(base_url() . 'index.php?admin/employee_add/do_update/' .$employee['employee_id'], array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
       				<div >
       				<h4>PERSONAL INFORMATION </h4>
       				<hr>
       					
       					<div>
	       					<div>
								<div class="form-group">
							
								
									<label for="field-1" class="col-sm-3 col-lg-3 col-sm-pull-1 control-label " > Last name* </label>
		                        
									<div class="col-sm-3 col-sm-pull-1">
										<input type="text" class="form-control" name="last_name" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="<?php echo $employee['family_name'];?>" autofocus>
									</div>
								

								
									<label for="field-1" class="col-sm-2 col-lg-2 control-label"> First name* </label>
		                        
									<div class="col-sm-3">
										<input type="text" class="form-control" name="first_name" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="<?php echo $employee['name'];?>" autofocus>
									</div>
								
								
								
								</div>

							<div class="form-group">
							
							
						
								<label for="field-2" class="col-sm-2 col-lg-2   control-label" ><?php echo 'Gender*';?></label>
	                        
								<div class="col-sm-3 ">
								<select name="sex" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Male" <?php if($employee['gender']=='Male')echo 'selected';?>><?php echo 'Male';?></option>
	                              <option value="Female" <?php if($employee['gender']=='Female')echo 'selected';?>><?php echo 'Female';?></option>
	                          </select>
							</div> 
								

							</div>


		               

							<div class="form-group" >

								
									<label for="field-2" class="col-sm-2 col-lg-2   control-label "> Date of birth* </label>
			                		<div class="col-sm-3 col-lg-3 ">
										<input type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="birthday" value="<?php echo date('Y/M/d',$employee['dob']);?>" data-start-view="2">
									</div> 
			                 </div>	
							

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" > Address*</label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="address" value="<?php echo $employee['address'];?>" >
								</div> 
						</div>

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Home phone</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control" style="border-color:#ebebeb" name="home_phone" value="<?php echo $employee['home_phone'];?>" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3 control-label" >Cell phone *</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" value="<?php echo $employee['cell_phone'];?>" class="form-control" name='cell_phone' data-validate="required" data-message-required="<?php echo 'Required ';?>">
								</div> 
						</div>
						<div class="form-group row">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Email</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="mail" value="<?php echo $employee['email'];?>" >
								</div> 

								
						</div>

						<?php foreach ($work_verifications as $work_verification):?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Visa status</label>
							<div class="col-sm-3">
								
								<input type="radio" onclick="verify('visa',1);" data-validate="required" data-message-required="<?php echo 'Required ';?>" <?php if($work_verification['visa_status']==1) echo "checked";?> name='visa_status' value='1'>
								<label>Valid</label>
								<input type="radio" onclick="verify('visa',0);" data-validate="required" data-message-required="<?php echo 'Required ';?>" <?php if($work_verification['visa_status']==0) echo "checked";?> name='visa_status' value="0">
								<label>Expired</label>
							</div>
							<div  id="visa_exp" class="">
							<label class="col-sm-3 control-label" >Expired date</label>
							<div class="col-sm-3">
								<input type="text" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="<?php echo $work_verification['visa_exp_date'];?>" id="visa_date" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name='visa_date' data-start-view="2">

						</div>
						</div>

					</div>
					<div class="form-group">
							<label class="col-sm-2 control-label">Work permission status</label>
							<div class="col-sm-3">
								
								<input type="radio" data-validate="required" data-message-required="<?php echo 'Required ';?>" onclick="verify('work',1);" <?php if($work_verification['work_permission_status']==1) {echo "checked";}?> name='work_permission' value='1'>
								<label>Valid</label>

								<input type="radio" data-validate="required" data-message-required="<?php echo 'Required ';?>" onclick="verify('work',0);" <?php if($work_verification['work_permission_status']==0) {echo "checked";}?> name='work_permission' value="0">
								<label>Expired</label>
							</div>
							<div  id="work_exp" class="">
							<label class="col-sm-3 control-label" >Expired date</label>
							<div class="col-sm-3">
								<input type="text" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="<?php echo $work_verification['work_permission_exp_date'];?>" id="work_date" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name='work_permission_date' data-start-view="2">

						</div>
						</div>

					</div>
						
						<?php endforeach;?>

					</div>
					


				</div>
					


				<div>
					<h4>EMPLOYMENT INFORMATION</h4>
					<hr>
					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Employed date*</label>
								<div class="col-sm-3" >
									<input type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="date_employed" value="<?php echo date('d/M/Y',$employee['employ_date']);?>" data-start-view="2">

								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label " >  Job title* </label>
								<div class="col-sm-3" >
										<input type="text" class="form-control "  data-validate="required" data-message-required="<?php echo 'Required ';?>" name="job_title" value=" <?php echo ucfirst($employee['position']);?>" >

								</div> 
					</div>

					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Work hour* </label>
								<div class="col-sm-3" >
									<select class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="work_hour" value="" id='select_hour'>
											<option value="" selected>Select</option>
											<option value='Full time' <?php if($employee['work_hour']=='Full time')echo 'selected';?>><label>Full time</label></option>
											<option value='Part time' <?php if($employee['work_hour']=='Part time')echo 'selected';?>><label>Part time</label></option>
											<option value='Hourly' <?php if($employee['work_hour']=='Hourly')echo 'selected';?>><label>Hourly</label></option>
							</select>
								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label hour" >  Hours per week </label>
								<div class="col-sm-3 hour" >
										<input type="text" class="form-control "  style="border-color:#ebebeb"  name="hour_per_week" value="" >

								</div> 
					</div>

					<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Salary annual</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  style="border-color:#ebebeb"  name="annual_salary" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3 control-label" >Salary monthly*</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  data-validate="required" data-message-required="<?php echo 'Required ';?>" name="monthly_salary" value="<?php echo $employee['salary'];?>" >
								</div> 

						</div>


					<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label nulltop-padding" >Salary semi-monthly</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"   name="semi_month_salary" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3 control-label" >Salary hourly</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"   name="hourly_salary" value="" >
								</div> 

						</div>

						<div class="form-group">
							<label for="field-2" class="col-sm-2 col-md-2 control-label" >Hired by</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"   name="hired_by" value="" >
								</div> 
						</div>

					</div>

						

                 

				</div>


                    <div >
                    
						<div class="col-sm-offset-4 col-sm-5">
						<br>
							<button type="submit" class="btn btn-info"> Save</button>
						</div>
					</div>
                <?php echo form_close();?>

            <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script >




	
	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

  function disable(){
  	$(#morning).disabled;
  
  }

    	


</script>
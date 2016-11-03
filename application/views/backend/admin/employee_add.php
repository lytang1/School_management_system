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
				
                <?php echo form_open(base_url() . 'index.php?admin/employee_add/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
       				<div >
       				<h4>PERSONAL INFORMATION </h4>
       				<hr>
       					
       					<div>
	       					<div>
								<div class="form-group">
							
								
									<label for="field-1" class="col-sm-3 col-lg-3 col-sm-pull-1 control-label " > Last name* </label>
		                        
									<div class="col-sm-3 col-sm-pull-1">
										<input type="text" class="form-control" name="last_name" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="" autofocus>
									</div>
								

								
									<label for="field-1" class="col-sm-2 col-lg-2 control-label"> First name* </label>
		                        
									<div class="col-sm-3">
										<input type="text" class="form-control" name="first_name" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="" autofocus>
									</div>
								
								
								
								</div>

							<div class="form-group">
							
							
						
								<label for="field-2" class="col-sm-2 col-lg-2   control-label" >Gender*</label>
	                        
								<div class="col-sm-3 ">
								<select name="sex" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Male"><?php echo 'Male';?></option>
	                              <option value="Female"><?php echo 'Female';?></option>
	                          </select>
							</div> 
								

							</div>


		               

							<div class="form-group" >

								
									<label for="field-2" class="col-sm-2 col-lg-2   control-label "> Date of birth* </label>
			                		<div class="col-sm-3 col-lg-3 ">
										<input type="text" data-start-view="2" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="birthday" value="" >
									</div> 
			                 </div>	
							

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Address*';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="address" value="" >
								</div> 
						</div>

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Home phone</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control" style="border-color:#ebebeb" name="home_phone" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3 control-label" >Cell phone *</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control" name='cell_phone' data-validate="required" data-message-required="<?php echo 'Required ';?>">
								</div> 
						</div>
						<div class="form-group row">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Email</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="mail" value="" >
								</div> 

								
						</div>

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label nulltop-padding" >Provious employed place</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="previous_place" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3  control-label nulltop-padding" >Name of friend or relatives in this organization</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="friend_in_org" value="" >
								</div> 
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Visa status</label>
							<div class="col-sm-3">
								
								<input type="radio" onclick="verify('visa',1);" name='visa_status' value='1'>
								<label>Valid</label>
								<input type="radio" onclick="verify('visa',0);" name='visa_status' value="0">
								<label>Expired</label>
							</div>
							<div  id="visa_exp" class="hide">
							<label class="col-sm-3 control-label" >Expired date</label>
							<div class="col-sm-3">
								<input type="text" id="visa_date" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name='visa_date' data-start-view="2">

						</div>
						</div>

					</div>
					<div class="form-group">
							<label class="col-sm-2 control-label">Work permission status</label>
							<div class="col-sm-3">
								
								<input type="radio" onclick="verify('work',1);" name='work_permission' value='1'>
								<label>Valid</label>

								<input type="radio" onclick="verify('work',0);" name='work_permission' value="0">
								<label>Expired</label>
							</div>
							<div  id="work_exp" class="hide">
							<label class="col-sm-3 control-label" >Expired date</label>
							<div class="col-sm-3">
								<input type="text" id="work_date"  data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>" name='work_permission_date' data-start-view="2">

						</div>
						</div>

					</div>
					


				</div>
					

			

				<div >

				<h4>WORK PREFERENCES </h4>
					
				<hr>
					<div class="form-group">
						
						<label for="field-2" class="col-sm-2 control-label" >Position desired*</label>
                        
						<div class="col-sm-3" >
							<input type="text" name="position_desire" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>"  >
							
						</div> 

						<label for="field-2" class="col-sm-3  control-label" >  Location preferred </label>
						<div class="col-sm-3" >
							 <input type="text" class="form-control"  style="border-color:#ebebeb" name="location" >

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label">Date available to work*</label>
                        
						<div class="col-sm-3" >
							<input type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required';?>" name="d_available" value="" data-start-view="2">
						</div> 
						<label for="field-2" class="col-sm-3 control-label">Salary desired*</label>
                        
						<div class="col-sm-3" >
							<input type="text" class="form-control " style="border-color:#ebebeb"  name="salary_desired" value="" data-validate="required" data-message-required="<?php echo 'Required';?>">

						</div> 

					</div>

					<div class="form-group row">
						
						 <label for="field-2" class="col-sm-2  control-label" > Hours desired* </label>
						<div class="col-sm-3">
							<select class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="hour" value=""  id='desire_hour'>
											<option value="" selected>Select</option>
											<option value='Full time'><label>Full time</label></option>
											<option value='Part time'><label>Part time</label></option>
											<option value="Hourly">Hourly</option>
							</select>
						</div> 

								<label for="field-2" class="col-sm-3 col-lg-3 control-label dhour" >  Hours per week </label>
								<div class="col-sm-3 dhour" >
										<input type="text" class="form-control "  style="border-color:#ebebeb"  name="hour_per_week" value="" >

								</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2  control-label"  >Referred by</label>
						<div class="col-sm-3">
							<select class="form-control"  name="referred_by" value="" >
											<option value="" selected>Select</option>
											<option value='Ad'><label>Ad</label></option>
											<option value='Agency'><label>Agency</label></option>
											<option value='Employee'><label>Employee</label></option>
											<option value='School'><label>School</label></option>
											<option value='Walk-in'><label>Walk-in</label></option>
											<option value='Electronic posting'><label>Electronic posting</label></option>
											<option value='other'><label>Other</label></option>
							</select>
						</div>
						
						<label for="field-2" class="col-sm-3  control-label" >  Referal source </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " style="border-color:#ebebeb" name="referal_source" value="" >

						</div> 
						
					</div>

					<div class="form-group">
							
								<label for="field-2" class="col-sm-5 col-md-5 control-label nulltop-padding" >Have you applied to this organization before?</label>
	                        
								<div class="col-sm-3 col-md-3">
									<label>Yes</label>
									<input type="radio"  id="select_yes" onclick="display_more('yes');" name="apply_before" value="Yes" >
									<label>No</label>
									<input type="radio"  id="select_no" onclick="display_more('no');" name="apply_before" value="No" >
								</div> 

					</div>
					<div class="form-group" id="yes">
						<label class="col-sm-2 col-md-2 control-label">When </label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="p_apply">
						</div>

						<label class="col-sm-2 col-md-2 control-label">Position </label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="p_position">
						</div>

					</div>

				</div>
			
				<h4>PROFESSIONAL REFERENCE</h4>
				<hr>
				<div>

					<div class="form-group">
						
						<label for="field-2" class="col-sm-2 control-label" >Name</label>
                        
						<div class="col-sm-3" >
							<input type="text" name="referee_name" class="form-group">
						</div> 
						<label for="field-2" class="col-sm-3  control-label" > Telephone </label>
						<div class="col-sm-3" >
							<input type="text" name="referee_phone" class="form-group">

						</div> 

					</div>

					<div class="form-group row">
						<label class="col-sm-2 control-label" >Title/Employer</label>
						<div class="col-sm-3" >
							<input type="text" name="referee_title" class="form-group">

						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label">Name</label>
                        
						<div class="col-sm-3" >
							<input type="text" name="referee_name2" class="form-group">
						</div> 
						<label for="field-2" class="col-sm-3  control-label" >  Telephone </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " name="referee_phone2" value="" >

						</div> 

					</div>

					<div class="form-group row">
						<label class="col-sm-2 control-label" >Title/Employer</label>
						<div class="col-sm-3" >
							<input type="text" name="referee_title2" class="form-group">

						</div> 
					</div>

					

					</div>
				

				<div>
					<h4>TO BE COMPLETEED BY HUMAN RESOURCES</h4>
					<hr>
					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Employed date*</label>
								<div class="col-sm-3" >
									<input type="text" data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required';?>" name="date_employed" value="" data-start-view="2">

								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label " >  Job title* </label>
								<div class="col-sm-3" >
										<input type="text" class="form-control "  data-validate="required" data-message-required="<?php echo 'Required';?>" name="job_title" value="" >

								</div> 
					</div>

					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Work hour* </label>
								<div class="col-sm-3" >
									<select class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>" name="work_hour" value="" id='select_hour'>
											<option value="" selected>Select</option>
											<option value='Full time'><label>Full time</label></option>
											<option value='Part time' ><label>Part time</label></option>
											<option value='Hourly' ><label>Hourly</label></option>
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
									<input type="text" class="form-control"  data-validate="required" data-message-required="<?php echo 'Required ';?>" name="monthly_salary" value="" >
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
							<button type="submit" class="btn btn-info"> Add employee</button>
						</div>
					</div>
                <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


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
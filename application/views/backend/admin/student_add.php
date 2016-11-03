<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<!-- <div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					Addmission form
            	</div>
            </div>
			 --><div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
       				<div >
       				<h4>STUDENT PERSONAL INFORMATION </h4>
       				<hr>
       					<div class="col=lg-9 col-sm-9">
       					<div>
	       					<div>
								<div class="form-group">
							
								
									<label for="field-1" class="col-sm-3 col-lg-3 col-sm-pull-1 control-label " > Last name* </label>
		                        
									<div class="col-sm-3 col-sm-pull-1">
										<input type="text" class="form-control" name="last_name" data-validate="required" data-message-required="<?php echo 'Required';?>" value="" autofocus>
									</div>
								

								
									<label for="field-1" class="col-sm-2 col-lg-2 control-label"> First name* </label>
		                        
									<div class="col-sm-3">
										<input type="text" class="form-control" name="first_name" data-validate="required" data-message-required="<?php echo 'Required ';?>" value="" autofocus>
									</div>
								
								
								
								</div>

							<div class="form-group">
							
							
						
								<label for="field-2" class="col-sm-2 col-lg-2   control-label" ><?php echo 'Gender*';?></label>
	                        
								<div class="col-sm-3 ">
								<select name="sex" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Male"><?php echo 'Male';?></option>
	                              <option value="Female"><?php echo 'Female';?></option>
	                          </select>
							</div> 
								<label for="field-2" class="col-sm-3 col-md-3  control-label" >  Number of siblings </label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="num_sibling" value=""  >
								</div> 

							</div>


		               

							<div class="form-group" >

								
									<label for="field-2" class="col-sm-2 col-lg-2   control-label "> Date of birth* </label>
			                		<div class="col-sm-3 col-lg-3 ">
										<input type="text" min='2014-01-01' class="form-control datepicker" data-date-format="yyyy/mm/dd" data-validate="required" data-message-required="<?php echo 'Required';?>" name="birthday" value="" data-start-view="2">
									</div> 
			                 </div>	
							

						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Address*';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>" name="address" value="" >
								</div> 
						</div>


						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" >Current school name</label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="current_school" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3  control-label" ><?php echo ' Grade';?></label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="grade" value="" >
								</div> 
						</div>


						<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo 'Nationality';?></label>
	                        
								<div class="col-sm-3 col-md-3">
									<input type="text" class="form-control"  name="nationality" value="" >
								</div> 

								<label for="field-2" class="col-sm-3 col-md-3 control-label" ><?php echo ' Ethnicity';?></label>
	                        
								<div class="col-sm-3 col-md-3">
									<select class="form-control"  name="ethnicity" value="" >
											<option value='' selected>Select</option>
											<option value='asian'><label>Asian</label></option>
											<option value='white'><label>White</label></option>
											<option value='other'><label>Other</label></option>
									</select>
								</div> 
						</div>


					</div>
					


				</div>
					

						
			

				<div >

				<h4> FAMILY INFORMATION (PARENTS/GUARDIAN #1) </h4>
					
				<hr>
					<div class="form-group">
						
						<label for="field-2" class="col-sm-2 control-label" ><?php echo "Parent/Guardian*";?></label>
                        
						<div class="col-sm-3" >
							<select class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>" name="guardian" >
											<option value="" selected>Select</option>
											<option value='parents'><label>Parents</label></option>
											<option value='white'><label>Guardian</label></option>
							</select>
						</div> 
						<label for="field-2" class="col-sm-3  control-label" >  Parents/Guardian gender* </label>
						<div class="col-sm-3" >
							<select name="guardian_gender" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Male"><?php echo 'Male';?></option>
	                              <option value="Female"><?php echo 'Female';?></option>
	                          </select>

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"><?php echo "Title *";?></label>
                        
						<div class="col-sm-3" >
							<select name="title" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Mr."><?php echo 'Mr.';?></option>
	                              <option value="Ms"><?php echo 'Ms';?></option>
	                          </select>
						</div> 
						<label for="field-2" class="col-sm-3  control-label" > Full name* </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " data-validate="required" data-message-required="<?php echo 'Required';?>" name="guardian_name" value="" >

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"><?php echo "Profession *";?></label>
                        
						<div class="col-sm-3" >
							<input type="text" class="form-control "  data-validate="required" data-message-required="<?php echo 'Required';?>" name="profession" value="" >

						</div> 
						<label for="field-2" class="col-sm-3  control-label"  ><?php echo " Email";?></label>
						<div class="col-sm-3">
							<input type="text" class="form-control "   name="email" value="" >

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"> Home phone* </label>
                        
						<div class="col-sm-3" >
							<input type="text" class="form-control "  data-validate="required" data-message-required="Required" name="home_phone" value="" >

						</div> 
						
						<label for="field-2" class="col-sm-3  control-label" >  Work phone </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " style="border-color:#ebebeb" name="work_phone" value="" >

						</div> 
						
					</div>

					<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Address*';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>" name="gaddress" value="" >
								</div> 
						</div>

				</div>
			
				<h4>FAMILY INFORMATION (PARENT/GUARDIAN #2)</h4>
				<hr>
				<div>

							<div class="form-group">
						
						<label for="field-2" class="col-sm-2 control-label" ><?php echo "Parent/Guardian";?></label>
                        
						<div class="col-sm-3" >
							<select class="form-control"  name="guardian2" value="" >
											<option value="" selected>Select</option>
											<option value='parents'><label>Parents</label></option>
											<option value='guardian'><label>Guardian</label></option>
							</select>
						</div> 
						<label for="field-2" class="col-sm-3  control-label" > Parents/Guardian gender </label>
						<div class="col-sm-3" >
							<select name="guardian_gender2" class="form-control" >
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Male"><?php echo 'Male';?></option>
	                              <option value="Female"><?php echo 'Female';?></option>
	                          </select>

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"><?php echo "Title ";?></label>
                        
						<div class="col-sm-3" >
						<select name="title2" class="form-control" >
	                              <option value=""><?php echo 'Select';?></option>
	                              <option value="Mr."><?php echo 'Mr.';?></option>
	                              <option value="Ms"><?php echo 'Ms';?></option>
	                          </select>

						</div> 
						<label for="field-2" class="col-sm-3  control-label" >  Full name </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " name="guardian_name2" value="" >

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"><?php echo "Profession";?></label>
                        
						<div class="col-sm-3" >
							<input type="text" class="form-control "  name="profession2" value="" >

						</div> 
						<label for="field-2" class="col-sm-3  control-label" ><?php echo " Email";?></label>
						<div class="col-sm-3">
							<input type="text" class="form-control " name="email2" value="" >

						</div> 

					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-2 control-label"> Home phone </label>
                        
						<div class="col-sm-3" >
							<input type="text" class="form-control "   name="home_phone2" value="" >

						</div> 
						<label for="field-2" class="col-sm-3  control-label" >  Work phone </label>
						<div class="col-sm-3">
							<input type="text" class="form-control " name="work_phone2" value="" >

						</div> 

					</div>

					<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Address';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control"  name="gaddress2" value="" >
								</div> 
						</div>

					</div>
				

				<div>
					<h4>EMERGENCY CONTACT INFORMATION</h4>
					<hr>
					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Full name* </label>
								<div class="col-sm-3" >
									<input type="text" class="form-control " data-validate="required" data-message-required="<?php echo 'Required';?>" name="emergencyContactName" value="" >

								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label " >  Relationship to child* </label>
								<div class="col-sm-3" >
										<input type="text" class="form-control "  data-validate="required" data-message-required="<?php echo 'Required';?>" name="relation" value="" >

								</div> 
					</div>

					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Primary phone* </label>
								<div class="col-sm-3" >
									<input type="text" class="form-control " data-validate="required" data-message-required="<?php echo 'Required';?>" name="emergencyphone" value="" >

								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label " >  Secondary phone </label>
								<div class="col-sm-3" >
										<input type="text" class="form-control "  style="border-color:#ebebeb"  name="emergencyphone1" value="" >

								</div> 
					</div>

					<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Address*';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>"  name="emergencyaddr" value="" >
								</div> 
						</div>


					<div class="form-group">					
								
		                        <label for="field-2" class="col-sm-2 control-label "> Signature of parent/guardian: </label>
								<div class="col-sm-3" >
									<hr>
									<label>Name</label>
								</div> 
								
								<label for="field-2" class="col-sm-3 col-lg-3 control-label " >  Current date </label>
								<div class="col-sm-3" >
										<input type="text" class="form-control "  value="<?php echo date("Y /M/ d", now());?>" >

								</div> 
					</div>
								
				</div>

				

						<div >

							<h4><b>Enrollment</b></h4>
							<hr>
							<div class="form-group">	
								
							
									
									<label for="field-2" class=" col-sm-2  	control-label" >  Grade level* </label>
										
										<div class="col-sm-3 "  >
											
										<select name="class_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
			                              <option value=""><?php echo 'Select';?></option>
			                              <?php $classes=$this->db->get('class')->result_array(); 
										 foreach ($classes as $row0 ): 
										 ?>	
			                              <option value="<?php echo $row0['class_id']?>"><?php echo $row0['name'];?></option>
			                             <?php endforeach; ?> 
			                         	 </select>
											
										</div>
										
										
									

									
							
									
									<label for="field-2" class="col-sm-3 control-label"> Attendance status* </label>
									 <div class="col-sm-3" >
										<select name="study_type" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
					                              <option value=""><?php echo 'Select';?></option>
					                              
					                              <option value="Full time">Full Time</option>
					                            	<option value="Part time morning">Part Time (Morning)</option>
					                            	<option value="Part time afternoon">Part Time (Afternoon)</option>
					                         	 </select>

									


									</div>


								 
						    </div>


						    <div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Language *';?></label>
	                        
								<div class="col-sm-3 col-md-3">
									<select name="language" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
					                              <option value=""><?php echo 'Select';?></option>
					                              
					                              <option value="Monolingual">Monolingual</option>
					                            	<option value="Bilingual">Bilingual</option>
					                            	
					                         	 </select>
								</div> 
						   </div>
						   

							<div class="form-group">
							
								<label for="field-2" class="col-sm-2 col-md-2 control-label" ><?php echo ' Comment';?></label>
	                        
								<div class="col-sm-9 col-md-9">
									<input type="text" class="form-control"  name="comment" value="" >
								</div> 
						   </div>
             
                  </div>
</div>
                  <div class="col-lg-3 col-sm-3" style="height:210px">
                  
							<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ' Photo';?></label>
                        
						<div class="col-sm-8">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>

					</div>

				</div>


                    <div >
                    
						<div class="col-sm-offset-4 col-sm-5">
						<br>
							<button type="submit" class="btn btn-info"> Add student</button>
						</div>
					</div>
                <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

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
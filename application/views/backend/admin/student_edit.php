<?php 
$edit_data		=	$this->db->get_where('student' , array('student_id' => $student_id) )->result_array();
foreach ( $edit_data as $row):
?>

<!-- error place include data -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					Edit student
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/'.$row['class_id'].'/do_update/'.$row['student_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
    <!--IMAGE EDIT-->  
					<div class="col-sm-3">
				<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Photo</label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" alt="...">
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
	<!--END IMAGE EDIT-->
					<div class="col-sm-9">
					<h4><b>Student information</b></h4>
					<hr>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Name</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo 'Value required';?>" value="<?php echo $row['name'];?>">
						</div>
					</div>



						<!-- <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class_');?></label>
                        
						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" id="class_id" 
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select_');?></option>
                              <?php 
									$classes1 = $this->db->get('class')->result_array();
									foreach($classes1 as $row3):
										?>
                                		<option value="<?php echo $row3['class_id'];?>"
                                        	<?php if($class_id == $row3['class_id'])echo 'selected';?>>
													<?php echo $row3['name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div> -->

					<!-- <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">class group</label>
                        
						<div class="col-sm-5">
							<select name="class_group_id" class="form-control" data-validate="required" id="class_id" 
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select_');?></option>
                              <?php $cl_idds = $this->db->get_where('class_name',array('id'=>$row['class_id']))->row()->class_detail_id;

									$classes = $this->db->get_where('class_name',array('class_detail_id'=>$cl_idds))->result_array();
									
									foreach($classes as $row2):
										?>
                                		<option value="<?php echo $row2['id'];?>"
                                        	<?php if($row['class_id'] == $row2['id']){ echo 'selected';}?>>
													<?php echo $row2['name'].$row['id'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div> -->

					<!-- <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Language_');?></label>
                        
					<div class="col-sm-5">
						<select name='language' class="form-control" data-validate = "required" 
						data-message-required ='Value required'>
						<option value="">Select</option>
						<option value="Monolingual" <?php if($this->db->get_where('class_student',array('student_id'=>$row['student_id']))->row()->language=='Monolingual'){echo 'selected';} ?>>Monolingual</option>
						<option value="Bilingual" <?php if($this->db->get_where('class_student',array('student_id'=>$row['student_id']))->row()->language=='Bilingual'){echo 'selected';}?> >Bilingual</option>
						</select>
					</div>
					</div> -->
					
					<!-- <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Attendance status</label>
                        
					<div class="col-sm-5">
						<select name='study_type' class="form-control" data-validate = "required" 
						data-message-required ='Value required'>
						<option value="">Select</option>
						<option value="Full time" <?php if($row['attendance_status_type']=='Full time'||$row['attendance_status_type']=='full_time'){echo 'selected';}?>>Full time</option>
						<option value="Part time morning" <?php if($row['attendance_status_type']=='Part time morning'||$row['attendance_status_type']=='part_time_morning'){echo 'selected';}?>>Part time (morning)</option>
						<option value="Part time afternoon" <?php if($row['attendance_status_type']=='Part time afternoon'||$row['attendance_status_type']=='part_time_afternoon'){echo 'selected';}?>>Part time (afternoon)</option>
						</select>
					</div>
					</div> -->



					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Date of birth</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" data-date-format="yyyy/mm/dd" name="birthday" value="<?php echo date('Y/m/d',$row['birthday']);?>" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Gender</label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control">
                              <option value="">Select</option>
                              <option value="Male" <?php if($row['sex'] == 'male'||$row['sex'] =='Male')echo 'selected';?>>Male</option>
                              <option value="Female"<?php if($row['sex'] == 'female'||$row['sex'] =='Female')echo 'selected';?>>Female</option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Nationality</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control " name="nationality" value="<?php echo $row['nationality'];?>">
						</div> 
					</div>


					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Ethnicity</label>
                        
					<div class="col-sm-5">
						<select name='ethnicity' class="form-control" data-validate = "required" 
						data-message-required ='Value required'>
						<option value="">Select</option>
						<option value="asian" <?php if($this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->ethnicity=='asian'){echo 'selected';} ?>>Asian</option>
						<option value="white" <?php if($this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->ethnicity=='white'){echo 'selected';}?> >White</option>
						<option value="other" <?php if($this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->ethnicity=='other'){echo 'selected';}?> >Other</option>
						</select>
					</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Address</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="<?php echo $row['address'];?>" >
						</div> 
					</div>
					
<!--GUARDIAN #1 EDIT-->
					<h4><b>Guardian #1 information</b></h4>
					<hr>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian#1</label>
                        
						<div class="col-sm-5">
							<input type="text" name="parent_id_one" class="form-control" data-validate="required" data-message-required="<?php echo 'value required';?>"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_name; ?>">
                       
						</div> 

					</div>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"> Home phone </label>
                        
						<div class="col-sm-5">
							<input type="text" name="phone_one" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_home_phone; ?>">
                             
            
                       
						</div> 
					</div>

					

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian gender</label>
                        
						<div class="col-sm-5">
							<select name="ggender1" class="form-control">
                              <option value="">Select</option>
                              <option value="male" <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_gender== 'male')echo 'selected';?>>Male</option>
                              <option value="female"<?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_gender == 'female')echo 'selected';?>>Female</option>
                          </select>
						</div> 
					</div>

					<div class="form-group">	
						<?php if($this->db->get_where('parent',array('parent_id'=>'parent_id_one'))->row()->guardian_work_phone!=''):?>
						<label for="field-2" class="col-sm-3 control-label">Phone</label>
                        
						<div class="col-sm-3">
							<input type="text" name="work_phone" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone; ?>">
           
						</div> 
						
					</div>
					<?php endif;?>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian address</label>
                        
						<div class="col-sm-5">
							<input type="text" name="gaddress" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_address; ?>">
						</div> 
						
					</div>

<!--GUARDIAN #2 EDIT-->
				<h4><b>Guardian #2 information</b></h4>
				<hr>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian#2</label>
                        
						<div class="col-sm-5">
							<input type="text" name="parent_id_two" class="form-control" 
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_name; ?>">
                       
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"> Home phone </label>
                        
						<div class="col-sm-5">
							<input type="text" name="phone_two" class="form-control"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_home_phone; ?>">
                             
            
                       
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian gender</label>
                        
						<div class="col-sm-5">
							<select name="ggender2" class="form-control">
                              <option value="">Select</option>
                              <option value="male" <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_gender== 'male')echo 'selected';?>>Male </option>
                              <option value="female"<?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_gender == 'female')echo 'selected';?>>Female </option>
                          </select>
						</div> 
					</div>
					
						<?php if($this->db->get_where('parent',array('parent_id'=>'parent_id_two'))->row()->guardian_work_phone!=''):?>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"> Work Phone </label>
                        
						<div class="col-sm-5">
							<input type="text" name="work_phone2" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone; ?>">
           
						</div> 		
					</div>
						<?php endif;?>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Parent/Guardian address</label>
                        
						<div class="col-sm-5">
							<input type="text" name="gaddress2" class="form-control"
								value="<?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_address; ?>">
						</div> 
						
					</div>
					
		<!--EMERGENCY EDIT-->		
					
                    <h4><b>Emergency information</b></h4>
                    <hr>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Emergency contact name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="emergency_contact_name" value="<?php echo $row['emergency_contact_name'];?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Emergency contact phone</label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="<?php echo $row['emergency_contact_number'];?>" >
						</div> 
					</div>
					<?php if($row['emergency_contact_two']!=''): ?>
                    	<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label">Emergency contact secondary phone</label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="phone2" value="<?php echo $row['emergency_contact_two'];?>" >
						</div> 
					</div>

				<?php endif;?>

<!--END EMERGENCY EDIT-->
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Emergency contact Address</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="emergency_contact_address" value="<?php echo $row['emergency_address'];?>">
						</div>
					</div>
			</div>


                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">Save</button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>

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

    var class_id = $("#class_id").val();
    
    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });


</script>
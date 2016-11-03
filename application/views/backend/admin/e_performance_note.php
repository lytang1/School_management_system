<!--USE TO SELECT THE PERFORMANCE FORM AND EMPLOYEE THEN NOTE THE GRADE OF EMPLOYEE DUE TO QUESTIONS-->

<style >
	.attendance-select{
		 background:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='50px' height='50px'><polyline points='46.139,15.518 25.166,36.49 4.193,15.519'/></svg>");
  background-color:#F0F0F1;
  background-repeat:no-repeat;
  background-position: right 4px top 10px;
  background-size: 8px 8px;
  color:black !important;

padding-top:4px;
padding-bottom: 4px;
 
  font-family:arial,tahoma;
  font-size:12px;
  color:#fff;
  text-align:center;
  text-shadow:0 -1px 0 rgba(0, 0, 0, 0.25);

  -webkit-appearance: none;
  border:0;
  outline:0;
 

	}
	.note-attendance{
		padding-left:30px;
	}
</style>

<?php echo form_open(base_url() . 'index.php?admin/e_performance_note/view', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
		<div class="row form-group">
		
				<label class="col-sm-1 control-label"><b>Form</b></label>
				<div class="col-sm-2 ">
				<select name="form_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
					<option value="">Select</option>
					<?php foreach ($form as $row):?>
						<option value="<?php echo $row['id'];?>" 
						<?php if($form_id == $row['id'])echo 'selected';?>><?php echo $row['form_title'];?></option>
					<?php endforeach;?>
				
				</select>
				</div>
		
		
			
		
			<label class="col-sm-1 control-label">Employee</label>
			<div class="col-sm-2">
				 <input list='teacherlist' value="<?php if($employee_name!='')echo $employee_name.'#'.$employee_id;?>" name="employee_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                    <datalist id="teacherlist">
                                   
                                        
                                        <?php 
                                       
                                        foreach($employees as $row1):
                                        ?>
                                            <option value="<?php echo $row1['name'].' '.$row1['family_name'].' #'.$row1['employee_id_code'];?>" ></option>
                                        <?php
                                        endforeach;
                                        ?>
                                   </datalist>
			</div>
		
		
		
			
				<div class="col-sm-5 ">
				
					<button type="submit" class="btn btn-info ">Mark performance</button>
				</div>
		</div>		
				</form>

		
			<br>
			<?php if($employee_name) :?>
				<h4>Date <?php echo date('Y/m/d',now());?></h4>
		 	
		 		<h4>Employee: <?php echo $employee_name;?></h4>
		 	
<?php echo form_open(base_url() . 'index.php?admin/e_performance_note/create/'.$form_id.'/'.$employee_id, array('class' => 'form-horizontal form-groups-bordered validate'));?>
			<br>
			<input type="hidden" value="<?php echo $form_id;?>" name='form'>
			<input type="hidden" value="<?php echo $employee_id;?>" name='employee'>
		 <?php $j=0; foreach ($questions as $question): $j++;?>
			<section class='form-group'>
				<label class="control-label col-sm-4"><h4><?php echo $question['question']?></h4></label>
				<input type="hidden" name="question[]" value="<?php echo $question['q_id']?>">
				
				<label class="control-label radio-inline"><h4><input type="radio" name="<?php echo 'mark'.$j;?>" value=9.5><?php echo 'A';?></h4></label>
				<label class="radio-inline"><h4><input type="radio" name="<?php echo 'mark'.$j?>"   value=7.5 ><?php echo 'B';?></h4></label>
				<label class="radio-inline"><h4><input type="radio" name="<?php echo 'mark'.$j?>"  value=5.5 ><?php echo 'C';?></h4></label>
				<label class="radio-inline"><h4><input type="radio" name="<?php echo 'mark'.$j?>"  value=3.5 ><?php echo 'D';?></h4></label>
				<label class="radio-inline"><h4><input type="radio" name="<?php echo 'mark'.$j?>" data-validate="required" data-message-required="<?php echo 'Value required';?>"  value=0.5 ><?php echo 'E';?></h4></label>
			</section>
		<?php endforeach;?>
		<input type="hidden" name='q_num' value="<?php echo $j;?>">
			<div class="form-group ">
				<div class="col-sm-5 col-sm-offset-6">
					<button type="submit" class="btn btn-info ">Save</button>
				</div>
			</div>
		</form>
	<?php endif;?>
		
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
		<script>
		  
			 jQuery(document).ready(function($)
		    {
	

		    	// $('select').change(function(){
		    	// 	var selected_value = $('select').val();
		    	// 	if(selected_value == '1')
		    	// 	{
		    	// 		$('select').css("background-color", "#cc2424");
		    	// 	}
		    	// 	if(selected_value == '2')
		    	// 	{
		    	// 		$('select').css("background-color", "#ffb400");
		    	// 	}
		    	// });
		    	
			  
			});
		</script>
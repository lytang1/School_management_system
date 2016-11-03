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

<?php echo form_open(base_url() . 'index.php?admin/attendance_note/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
		<div class="row form-group">
		
				<label class="col-sm-1 control-label"><b>Class</b></label>
				<div class="col-sm-2 ">
				<select name="class_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
					<option value="">Select</option>
					<?php foreach ($classes_name as $row):?>
						<option value="<?php echo $row['id'];?>" 
						<?php if($class_a == $row['id'])echo 'selected';?>><?php echo $row['name'];?></option>
					<?php endforeach;?>
				
				</select>
				</div>
		
		
			
		
			<label class="col-sm-1 control-label">Date</label>
			<div class="col-sm-2">
				<input type="text" style="border-color:#ebebeb" data-date-format="yyyy/mm/dd" class="form-control datepicker" value="<?php echo date('Y/m/d',strtotime($date));?>" name="date"  data-start-view="2">
			</div>
		
		
		
			
				<div class="col-sm-5 ">
				
					<button type="submit" class="btn btn-info ">Manage attendance</button>
				</div>
		</div>		
				</form>

		
			<br>
			<h4>Date <?php echo $date1;?></h4>
		 	<?php  if($teacher_name):?><h4>Teacher: <?php echo $teacher_name;?></h4><?php endif;?>
<?php echo form_open(base_url() . 'index.php?admin/attendance_class/create/'.$class_a, array('class' => 'form-horizontal form-groups-bordered validate'));?>
			<br>
			<input type="hidden" value="<?php echo $study_time;?>" name='study_time'>
			<input type="hidden" value="<?php echo $date;?>" name='att_day'>
		<?php if($students[0]):?>
		<table class="table "  style="text-align:center" id='both'>
			<tr>
				
				<th ></th>
				<th colspan="6"><center>Time</center></th>
				<th ><center>Option</center></th>
			</tr>
			<tr>
				<td>Student name</td>
				<td>8 AM - 9 AM</td>
				<td>9 AM - 10 AM</td>
				<td>10 AM -11 AM</td>
				<td>1 PM - 2 PM</td>
				<td>2 PM - 3 PM</td>
				<td>3 PM - 4 PM</td>
				<td></td>
			</tr>
		
			<?php foreach ($students as $row):?>
				<?php $is_exist = $this->db->get_where('attendance',array('student_id'=>$row['student_id'],'date'=>$date1))->row()->attendance_time_id;?>
			<tr>
				<td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?> </td>
				
				<td><?php if($row['attendance_status_type']!='Part time afternoon'):?>
				<select name="<?php echo $row['student_id'];?>first_session" class='attendance-select btn   ' >
				
					<option value="0" <?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->first_session ==0)echo 'selected';?>>P</option>
					<option value="1" 
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->first_session ==1)echo 'selected';?>
					>A</option>
					<option value="2" 
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->first_session ==2)echo 'selected';?>
					>AP</option>
				</select>
			<?php endif;?>
				</td>
				<td><?php if($row['attendance_status_type']!='Part time afternoon'):?> 
					<select name="<?php echo $row['student_id'];?>second_session" class='attendance-select btn   ' >
				
					<option value="0" 
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->second_session ==0)echo 'selected';?>
					>P</option>
					<option value="1"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->second_session ==1)echo 'selected';?>
					>A</option>
					<option value="2"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->second_session ==2)echo 'selected';?>
					>AP</option>
				</select>
				<?php endif; ?></td>
				<td><?php if($row['attendance_status_type']!='Part time afternoon'):?>
					<select name="<?php echo $row['student_id'];?>third_session" class='attendance-select btn   ' >
				
					<option value="0"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->third_session ==0)echo 'selected';?>
					>P</option>
					<option value="1"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->third_session ==1)echo 'selected';?>
					>A</option>
					<option value="2"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->third_session ==2)echo 'selected';?>
					>AP</option>
				</select>
				<?php endif; ?></td>
				
				
			
				<td><?php if($row['attendance_status_type'] != 'Part time morning'):?>
					<select name="<?php echo $row['student_id'];?>forth_session" class='attendance-select btn   ' >
				
					<option value="0"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->forth_session ==0)echo 'selected';?>
					>P</option>
					<option value="1"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->forth_session ==1)echo 'selected';?>
					>A</option>
					<option value="2"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->forth_session ==2)echo 'selected';?>
					>AP</option>
				</select>
				<?php endif;?></td>
				<td><?php if($row['attendance_status_type'] != 'Part time morning'):?>
					<select name="<?php echo $row['student_id'];?>fifth_session" class='attendance-select btn   ' >
				
					<option value="0"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->fifth_session ==0)echo 'selected';?>
					>P</option>
					<option value="1"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->fifth_session ==1)echo 'selected';?>
					>A</option>
					<option value="2"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->fifth_session ==2)echo 'selected';?>
					>AP</option>
				</select>
				<?php endif;?></td>
				<td><?php if($row['attendance_status_type'] != 'Part time morning'):?>
					<select name="<?php echo $row['student_id'];?>sixth_session" class='attendance-select btn   ' >
				
					<option value="0"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->sixth_session ==0)echo 'selected';?>
					>P</option>
					<option value="1"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->sixth_session ==1)echo 'selected';?>
					>A</option>
					<option value="2"
					<?php if($this->db->get_where('attendance_time',array('attendance_time_id'=>$is_exist))->row()->sixth_session ==2)echo 'selected';?>
					>AP</option>
				</select>
				<?php endif;?></td>
				 <td>
				 	 <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    
                                <!-- VIEW ATTENDANCE WEEKLY --> 
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/view_weekly/<?php echo $row['student_id'];?>/<?php echo $class_a;?>" >
                                            <i class="entypo-bookmarks"></i>
                                                View detail
                                        </a>
                                    </li>
                                    <li class="divider"></li>
      
                                </ul>
                            </div>
				 </td>
				
			</tr>
		<?php endforeach;?>
		</table>

		
			<div class="form-group ">
				<div class="col-sm-5 col-sm-offset-6">
					<button type="submit" class="btn btn-info ">Save</button>
				</div>
			</div>
			<h4 class="note-attendance">P = Presence, A = Absence, AP = Absence with permission</h4>
			<?php endif;?>
		</form>
		
		
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
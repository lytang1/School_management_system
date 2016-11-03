<div class="contain">
	<div class="row">
	<?php echo form_open(base_url() . 'index.php?admin/attendance_note/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
		<div class="row form-group">
		
				<label class="col-sm-1 control-label"><b>Class</b></label>
				<div class="col-sm-2 ">
				<select name="class_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
					<option value="">Select</option>
					<?php foreach ($classes_name as $row):?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
					<?php endforeach;?>
				
				</select>
				</div>
		
			
			<label class="col-sm-1 control-label">Date</label>
			<div class="col-sm-2">
				<input type="text" style="border-color:#ebebeb" data-date-format="yyyy/mm/dd"  class="form-control datepicker" value="<?php echo date('Y/m/d',now());?>" name="date" value="" data-start-view="2">
			</div>
			<div class="col-sm-4  ">
				
					<button type="submit" class="btn btn-info ">Manage attendance</button>
				</div>	

		</div>	

				
				</form>
			</div>
		
	</div>
</div>


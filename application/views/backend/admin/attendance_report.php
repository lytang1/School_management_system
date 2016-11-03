<?php echo form_open(base_url() . 'index.php?admin/report_attendance/view', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
		<div class="row form-group">
		<div class="col-sm-6">
			<div class="form-group col-sm-6">
				<label class="col-sm-2 control-label"><b>Class</b></label>
				<div class="col-sm-10 ">
				<select name="class_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
					<option value="">Select</option>
					<?php foreach ($classes as $row):?>
						<option value="<?php echo $row['id'];?>" 
						<?php if($class_id == $row['id'])echo 'selected';?>><?php echo $row['name'];?></option>
					<?php endforeach;?>
				
				</select>
				</div> 
			</div>
		
			<div class="form-group col-sm-6">
		
			<label class="col-sm-2 control-label">Month</label>
			<div class="col-sm-10">
				<select name="month" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
					<option value="">Select</option>
					<option value="01" <?php if($month=="01")echo 'selected';?>>January</option>
					<option value="02" <?php if($month=="02")echo 'selected';?>>February</option>
					<option value="03" <?php if($month=="03")echo 'selected';?>>March</option>
					<option value="04" <?php if($month=="04")echo 'selected';?>>April</option>
					<option value="05" <?php if($month=="05")echo 'selected';?>>May</option>
					<option value="06" <?php if($month=="06")echo 'selected';?>>June</option>
					<option value="07" <?php if($month=="07")echo 'selected';?>>July</option>
					<option value="08" <?php if($month=="08")echo 'selected';?>>August</option>
					<option value="09" <?php if($month=="09")echo 'selected';?>>September</option>
					<option value="10" <?php if($month=="10")echo 'selected';?>>October</option>
					<option value="11" <?php if($month=="11")echo 'selected';?>>November</option>
					<option value="12" <?php if($month=="12")echo 'selected';?>>December</option>
				</select>
			</div>
		</div>
		</div>
		
			
				<div class="col-sm-5 ">
				
					<button type="submit" class="btn btn-info ">Display attendance</button>
				</div>
		</div>		
				</form>

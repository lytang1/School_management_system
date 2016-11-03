<div class="panel-body">
	
<?php echo form_open(base_url() . 'index.php?admin/employee_contract/create/'.$employee_id , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

<div class="form-group row">
	<label class ="control-label col-sm-2">Employee name</label>
	<div class="col-sm-3">
		<input type='text' readonly="readonly" value="<?php echo $this->db->get_where('employee',array('employee_id'=>$employee_id))->row()->name.' '.$this->db->get_where('employee',array('employee_id'=>$employee_id))->row()->family_name;?>" class="form-control" >

	</div>
</div>

<div class="form-group row">
	<label class ="control-label col-sm-2">Contract expired date</label>
	<div class="col-sm-3">
		<input type='text' name='expired_date' data-date-format="yyyy/mm/dd" class="form-control datepicker" data-validate="required" data-message-required="<?php echo 'Required ';?>">

	</div>
</div>

<div class="form-group row">
	<label class = 'control-label col-sm-2'>Upload contract</label>
	<div class="col-sm-3">
		<input type='file' name='contract' accept=".pdf,.doc,.docx" class='form-control' >

	</div>
</div>
<div class="col-sm-6 col-sm-offset-3">
	<button  type="submit" class="btn btn-info">Save</button>
 </div>
 <?php echo form_close();?>
</div>
<!--Page used to add the questions to  the performance form-->

<?php echo form_open(base_url() . 'index.php?admin/e_performance_form/create'.$form_id , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

<br>
<section class='col-md-offset-2'>
<section class='form-group '>
<br>
	<label class="control-label col-sm-2">Form title</label>
	<section class='col-sm-3'>
		<input type='text' class='form-control' name='form_name'  value='<?php echo $row[0]['form_title'];?>'>
	</section>
</section>
</section>
<h4 >Please check the questions that you wish to add into the form</h4>
<!--LIST ALL THE QUESTIONS THAT AVAILABLE IN THE QUESTION TABLES-->
<section class='col-md-offset-3'>

<?php foreach($questions as $question):?>

<section class='form-group ' style='padding-left:20px;'>


	
	<input type='checkbox' name='question[]' value="<?php echo $question['id'];?>"> <?php echo $question['question'];?>
</section>

<?php endforeach;?>


</section>

<section class=' col-sm-12'>
	<div class='col-md-offset-6 '>
	<br><br>
	<button class='btn btn-info'>Save</button>
	</div>
</section>
<?php echo form_close();?>
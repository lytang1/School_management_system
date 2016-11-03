<?php $students = $this->db->get_where('student',array('student_id'=>$student_id))->result_array(); 
	

	foreach ($students as $row):

		?>
	<style type="text/css">
	.rowspan-center{
		vertical-align:middle !important;
	}
	</style>


<div>

	<div class="form-group" >
			
			
		<div class="form-group">
			<div class="col-sm-3 " style="height=150px">
				<h3><?php echo ucfirst(strtolower($row['name']));?></h3>
				<h5>Student Id : <?php echo $row['student_id_code'];?></h5>

			<a href="#" class="profile-picture">
				<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" 
                	class="img-responsive img-circle" style="height:200px;width:200"/>
			</a>
			
		
				
			</div>
		</div>

		<br>
	
	<h4><b>Personal Information</b></h4>
	
	
		<div class="content col-sm-9" >
			   <table class="table ">
			   	<tr>
			   		<td>Class</td>
			   		<td>Gender</td>
			   	</tr>
			   	<tr>
			   		<td><h4><b><?php echo $this->db->get_where('class_name',array('id'=>$row['class_id']))->row()->name;?></b></h4></td>
			   		<td><h4><b><?php echo  ucfirst($row['sex']);?></b></h4></td>
			   	</tr>
			   	<tr>
			   		<td>Date of birth</td>
			   		<td>Age</td>
			   	</tr>

			   	<tr>
			   		<td><h4><b><?php echo date('Y/M/d',$row['birthday']);?> </b></h4></td>
			   		<td><h4><b><?php $y=date('Y',$row['birthday']); $now = date('Y',now()); $age=$now-$y; echo $age;?></b></h4></td>
			   	</tr>
			   	<tr>
			   		
			   		<td colspan="2">Address</td>
			   	</tr>
			   	<tr>
			   		
			   		<td colspan="2"><h4><b><?php echo $row['address'];?></b></h4></td>
			   	</tr>
			   	<?php if($row['nationality'] !='' && $row['ethnicity']!=''):?>
			   	<tr>
			   		<td>Nationality</td>
			   		<td >Ethnicity</td>
			   	</tr>

			   	<tr>
			   		<td ><h4><b><?php echo ucfirst($row['nationality']);?></b></h4></td>
			   		<td ><h4><b><?php echo ucfirst($row['ethnicity']);?></b></h4></td>
			   	</tr>
			   <?php endif;?>
			   	<tr>
			   		<td>Guardian/Parents Name#1 </td>
			   		<td>Phone</td>
			   	</tr>

			   	<tr>
			   		<td  class="rowspan-center" <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone !=''){echo 'rowspan=2';}?>><h4><b><?php echo ucfirst(strtolower($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_name));?> </b></h4></td>
			   		<?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_home_phone !=''):?>
			   		<td><h4><b>
							
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_home_phone;?><?php echo '(Home) '?></b></h4></td>
							 	<?php endif;?>
				</tr>
				<tr>
							 <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone !=''):?>
					<td><h4><b> 
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone;?><?php echo '(Work)'?></b></h4></td>
			   				<?php endif;?>
			   	</tr>

			<?php if($row['parent_id_two']!=''):?>	
			   <tr>
			   		<td>Guardian/Parents Name#2 </td>
			   		<td>Phone</td>
			   	</tr>

			   	<tr>
			   		<td class="rowspan-center" <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone !=''){echo 'rowspan=2';}?>><h4><b><?php echo ucfirst(strtolower($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_name));?> </b></h4></td>
			   		<?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_home_phone !=''):?>
			   		<td><h4><b>
							
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_home_phone;?><?php echo '(Home)'?></b></h4></td>
							 	<?php endif;?>
				</tr>
				<tr>
							 <?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone !=''):?>
					<td><h4><b> 
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone;?><?php echo '(Work)'?></b></h4></td>
			   				<?php endif;?>
			   	</tr>
			<?php endif;?>


				<tr>
					<td>Emergency contact name</td>
					<td>Emergency phone </td>
				</tr>

				<tr>
			   		<td class="rowspan-center" <?php if($row['emergency_contact_two']!=''){echo 'rowspan=2';}?>><h4><b><?php echo ucfirst(strtolower($row['emergency_contact_name']));?></b></h4></td>
			   		<td ><h4><b><?php echo $row['emergency_contact_number'];?> </b></h4></td>
			   	</tr>
			   		<?php if($row['emergency_contact_two']!=''):?>
			   		<tr>
			   		<td><h4><b><?php echo $row['emergency_contact_two'];?> </b></h4></td>
			   	<?php endif;?>
			   	</tr>

			   </table>
		

				
				
				
	 
  
</div>

	
<!-- <div class="form-group">
<h3>Study History</h3>
	<table class="responsive_table table-bordered table-hover" width=100%>
		<tr>
			<th>Grade </th>
			<th>Study Year</th>
			
			<th>Score</th>
		</tr>

	</table>
</div>	
 -->

<div class="col-sm-6">
	<h3>Invoice</h3>
	
	<table class="responsive_table table-bordered table-hover table" >

	 <tr>
		<th>Invoice num  </th>
		<th>Status</th>
		<th> Description </th>
		<th>Amount</th>
		<th>Created date</th>
		
		
	</tr>
<?php $invoices = $this->db->get_where('invoice',array('student_id'=>$row['student_id']))->result_array();
	
	foreach ($invoices as $invoice):?>
	<?php foreach ($descriptions as $description){?>
	<?php	
	 if($description['id_invoice']==$invoice['invoice_id']){$desc = $desc.$description['service'].', ';}
	 ?>
	 <?php }?>
	 
	<tr class='clickable-row' data-href='<?php echo base_url(); ?>index.php?admin/invoice'>
		
		 <td>	
				<?php echo $invoice['invoice_id_code'];?>
		 </td>
		 <td>	
		 		<?php echo $invoice['status'];?>
		 </td>
		 <td>	
		 		<?php echo $desc;?>
		</td>
		<td>	
				<?php echo $invoice['due_amount'];?>$
		</td>
		<td>	
				<?php echo date('Y-m-d',$invoice['creation_timestamp']) ;?>
		</td>
		
	</tr>
	
	<?php $desc ='';?>
	<?php endforeach;?>
	
</table>


</div>

<!--STUDENT RECORD-->

<div class="col-sm-6">
	<h3>Study record</h3> 
	<table class="responsive_table table-bordered table-hover table" >
	 <tr>
		<!-- <th>Name </th> -->
		<th>Class</th>
		<th>Language</th>
		<th>Attendance status</th>
		<th> Academic year </th>
		
		
	</tr>
<?php $records = $this->db->get_where('class_student',array('student_id'=>$row['student_id']))->result_array();
	
	foreach ($records as $record):?>
	<tr>
		
		<td><?php echo $this->db->get_where('class',array('class_id'=>$record['class_id']))->row()->name;?></td>
		<td><?php echo $record['language'];?></td>
		<td><?php echo $record['study_time'];?>
		 </td>
		<!-- <td><?php echo $invoice['status'];?></td>
		<td><?php echo $desc;?>
								 </td>
		<td><?php echo $invoice['due_amount'];?></td>
		 -->
		 <td><?php echo $record['study_year'] ;?></td>
		
	</tr>
	<?php endforeach;?>
	
</table>

<?php endforeach;?>

</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>
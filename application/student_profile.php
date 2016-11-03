<?php $students = $this->db->get_where('student',array('student_id'=>$student_id))->result_array(); 
	

	foreach ($students as $row):
$invoice1 =$this->db->get_where('invoice',array('student_id'=>$row['student_id']))->row()->invoice_id_code;
	$descriptions=$this->db->get_where('payment',array('invoice_id'=>$invoice1))->result_array();
	$desc=null;
	foreach ($descriptions as $description){
		$desc =$desc.$description['description']."<br>";
	}
		?>
	
							
								
							
								
<div >

	<div class="form-group" >
			
			
		<div class="form-group">
			<div class="col-sm-3 " style="height=150px">
				<h3><?php echo $row['name'];?></h3>
				<h5>Student Id : <?php echo $row['student_id_code'];?></h5>

			<a href="#" class="profile-picture">
				<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" 
                	class="img-responsive img-circle" style="height:200px;width:200"/>
			</a>
			
		
				
			</div>
		</div>

		<br>
	
	<h4>Personal Information</h4>
	<hr>
	
		<div class="form-group">
			<div class="col-sm-4">
			   
		

				<p>Class</p>
				<h4><b><?php echo $this->db->get_where('class',array('class_id'=>$row['class_id']))->row()->name;?></b></h4>
				
				<p>Date Of Birth </p>
				<h4><b><?php echo $row['birthday'];?> </b></h4>
				
				<p>Number of Sibling </p>
				<h4><b><?php echo $row['number_sibling'];?> </b></h4>
				
				<p>Guardian/Parents Name#1 </p>
				<h4><b><?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_name;?></b> </h4>
				<br>
			<?php if($row['parent_id_two']!=''):?>	
				
				<p>Guardian Name #2 </p>
				<h4><b><?php echo $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_name;?></b> </h4>
				<br>
			<?php endif;?>	
			

				<p>Emergency Contact name </p>
				<h4><b><?php echo $row['emergency_contact_name'];?></b> </h4>
				
				
				
			</div>
		</div>

	<div class="form-group">
		<div class="form-group">
			<div class="col-sm-5">
				
				<p>gender </p>	
				<h4><b><?php echo $row['sex'];?></b></h4>
				<p>age</p>
				<h4><b><?php  $age= date('y',now())-date('y',strtotime($row['birthday'])); ?>
						<?php if($age<'0'):?>
						<?php $age = 100+$age;?>
						<?php endif;?><?php echo $age ;?>
				</b></h4>
				<p>address </p>
				<h4><b><?php echo $row['address'];?></b></h4>
				<p>Phone </p>
				<h4><b><?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_home_phone !=''):?>
							<?php echo get_phrase('Home: ')?>
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_home_phone;?></b></h4>
							<?php endif;?>
				<h4><b><?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone !=''):?>
							<?php echo get_phrase('Work : ')?> 
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_one']))->row()->guardian_work_phone;?></b></h4>
							<?php endif;?>
<?php if($row['parent_id_two']!=''): ?>

				<p>Phone </p>
				<h4><b><?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_home_phone !=''):?>
							<?php echo get_phrase('Home: ')?>
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_home_phone;?></b></h4>
							<?php endif;?>
				<h4><b><?php if($this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone !=''):?>
							<?php echo get_phrase('Work : ')?> 
							 <?php echo  $this->db->get_where('parent',array('parent_id'=>$row['parent_id_two']))->row()->guardian_work_phone;?></b></h4>
							<?php endif;?>
<?php endif;?>

				<p>phone </p>
				<h4><b><?php echo $row['emergency_contact_number'];?> </b></h4>
				
<br>
			</div>
		</div>
	 </div>
   </div>
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
	<table class="responsive_table table-bordered table-hover" width=100%>
	 <tr>
		<th>Invoice Num : </th>
		<th>status</th>
		<th> Description </th>
		<th>Amount</th>
		<th>Create Date</th>
		
		
	</tr>
<?php $invoices = $this->db->get_where('invoice',array('student_id'=>$row['student_id']))->result_array();
	
	foreach ($invoices as $invoice):?>
	<tr>
		
		<td><?php echo $invoice['invoice_id_code'];?> </td>
		<td><?php echo $invoice['status'];?></td>
		<td><?php echo $desc;?>
								 </td>
		<td><?php echo $invoice['due_amount'];?></td>
		<td><?php echo date('d-m-y',$invoice['creation_timestamp']) ;?></td>
		
	</tr>
	<?php endforeach;?>
	
</table>


</div>

<!--STUDENT RECORD-->

<div class="col-sm-6">
	<h3>Student record</h3>
	<table class="responsive_table table-bordered table-hover" width=100%>
	 <tr>
		<!-- <th>Name </th> -->
		<th>Class</th>
		<th> Study year </th>
		
		
	</tr>
<?php $records = $this->db->get_where('class_student',array('student_id'=>$row['student_id']))->result_array();
	
	foreach ($records as $record):?>
	<tr>
		
		<td><?php echo $this->db->get_where('class',array('class_id'=>$record['class_id']))->row()->name;?> </td>
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

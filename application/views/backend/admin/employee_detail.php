
<div >

	<div class="form-group" >
			
	<?php foreach ($employee as $row):?>
	
	
		<div class="form-group">
			<div class="col-sm-12">
			   <h4><b>Personal Information</b></h4>
	<hr>
				<div class="form-group row">
					<div class="col-sm-6">
						<p>Name</p>
						
							<h4 class="data"><b><?php echo $row['name'] ;?></b></h4>
					</div>	
					<div class="col-sm-6">
						<p>Family name </p>
						
						<h4 class="data"><b><?php echo $row['family_name'];?> </b></h4>
						
					</div>	
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<p>Gender</p>
					
						<h4 class="data"><b><?php echo $row['gender'];?> </b></h4>
					</div>
					<div class="col-sm-6">
						<p>Date of birth</p>
						<h4 class="data"><b><?php echo date('Y-m-d',$row['dob']);?></b> </h4>
					</div>
				</div>
					
			<div class="form-group row">
				<?php if($row['cell_phone']!=''):?>
				<div class="col-sm-6">
					<p>Cell phone</p>
					<h4 class="data"><b><?php echo $row['cell_phone'];?></b> </h4>
				</div>
				<?php endif;?>
				<?php if($row['home_phone']!=''):?>
				<div class="col-sm-6">	
					<p>Home phone</p>
					<h4 class="data"><b><?php echo $row['home_phone'];?></b></h4>
				</div>
				<?php endif;?>
			</div>

			<div class="form-group row">
					<div class="col-sm-6">
						<p>Address</p>
						<h4 class="data"><b><?php echo $row['address'];?></b></h4>
					</div>
			</div>
			
			<div class="form-group row">
				<?php if($row['email']!=''):?>
				<div class="col-sm-6">
					<p>Email</p>
					<h4 class="data"><b><?php echo $row['email'];?></b></h4>
				</div>
				<?php endif;?>
			</div>	
				<div class="form-group row">
				<?php if($row['previous_place']!=''):?>
				<div class="col-sm-6">
					<p>Previous work place</p>
					<h4 class="data"><b><?php echo $row['previous_place'];?></b></h4>
				</div>
				<?php endif;?>
			</div>	

			<?php if($row['name_relative_in_org']!=''):?>
			<div class="form-group row">
				
				<div class="col-sm-6">
					<p>Name of friend or relatives in this organization</p>
					<h4 class="data"><b><?php echo $row['name_relative_in_org'];?></b></h4>
				</div>
				
			</div>	
			<?php endif;?>
				


		</div>

		
			
		
		

		<div class="col-sm-12">
		<h4><b>Employment information</b></h4>
				<hr>
		<div class="form-group row">
			<div class="col-sm-6">
				
				<p>Position </p>	
				<h4 class="data"><b><?php echo $row['position'];?></b></h4>
			</div>
			<div class="col-sm-6">
				<p>Employed date</p>
				<h4 class="data"><b><?php echo date('Y-m-d',$row['employ_date']);?></b></h4>
			</div>
		</div>
		<div class="form-group row">
			<!-- <div class="col-sm-6">		
				<p>Salary day</p>
				<h4 class="data"><b>The <?php echo date('d',$row['employ_date']);?><?php if(date('d',$row['employ_date'])==1)echo 'st';
				 elseif(date('d',$row['employ_date'])==2)echo 'nd';elseif(date('d',$row['employ_date'])==3)echo 'rd';else echo 'th';?> of the month</b></h4>
			</div> -->
			<?php if($row['annual_salary']!='' && $row['annual_salary']!=0):?>
			<div class="col-sm-6">	
				<p>Annual salary</p>
				<h4 class="data"><b>$<?php echo $row['annual_salary'] ;?>
				</b></h4>
			</div>
			<?php endif;?>
		</div>
		<div class="form-group row">
			
			<div class="col-sm-6">		
				<p>Monthly salary </p>
				<h4 class="data"><b>$<?php echo $row['salary'];?></b></h4>
			</div>
			<?php if($row['semi_monthly_salary']!='' && $row['semi_monthly_salary']!=0):?>
			<div class="col-sm-6">	
				<p>Semi-monthly salary </p>
				<h4 class="data"><b>	$<?php echo $row['semi_monthly_salary'];?></b></h4>
			</div>
			<?php endif;?>
		</div>
		<div class="form-group row">	
			<?php if($row['hourly_salary']!=''&& $row['hourly_salary']!=0):?>
			<div class="col-sm-6">	
				<p>Hourly salary </p>
				<h4 class="data"><b>$<?php echo $row['hourly_salary'];?> </b></h4>
			</div>
			<?php endif;?>
			
			<div class="col-sm-6">
				<p>Work hours</p>
				<h4 class="data"><b><?php echo $row['work_hour'];?></b></h4>
			</div>
		</div>

		<div class="form-group row">	
			<?php if($this->db->get_where('contract',array('employee_id'=>$row['employee_id']))->row()->expired_date!=0):?>
			<div class="col-sm-6">	
				<p>Contract expired date </p>
				<h4 class="data"><b><?php echo date('Y-m-d',$this->db->get_where('contract',array('employee_id'=>$row['employee_id']))->row()->expired_date);?> </b></h4>
			</div>
			<?php endif;?>
			
			
		</div>
		<?php if($row['work_verification_id']!=''):?>
		<div class="form-group row">	
			
			<div class="col-sm-6">	
				<p>Visa expired date</p>
				<h4 class="data"><b><?php echo $this->db->get_where('work_verification',array('id'=>$row['work_verification_id']))->row()->visa_exp_date;?> </b></h4>
			</div>
				<div class="col-sm-6">	
				<p>Work permission expired date</p>
				<h4 class="data"><b><?php echo $this->db->get_where('work_verification',array('id'=>$row['work_verification_id']))->row()->work_permission_exp_date;?> </b></h4>
			</div>
			
			
		</div>
		
		<?php endif;?>
		</div>
	 <?php endforeach;?>
   </div>
</div>







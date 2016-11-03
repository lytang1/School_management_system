<div class="row">
	<div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
    	<img src="<?php echo base_url();?>assets/images/tsialogo.png" /><br /> <br />
		<h2 style="font-weight:200; margin:0px;"><?php echo $system_name;?></h2>
    </div>
	<!-- Raw Links -->
	<div class="col-md-12 col-sm-12 clearfix ">
		
        <ul class="list-inline links-list pull-left">
        <!-- Language Selector -->			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        	<i class="entypo-user"></i> <?php echo $this->session->userdata('login_type');?>
                    </a>

				<?php if ($account_type != 'parent'):?>
				<ul class="dropdown-menu <?php if ($text_align == 'right-to-left') echo 'pull-right'; else echo 'pull-left';?>">
					<li>
						<a href="<?php echo base_url();?>index.php?<?php echo $account_type;?>/manage_profile">
                        	<i class="entypo-info"></i>
							<span> 'Edit profile'</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url();?>index.php?<?php echo $account_type;?>/manage_profile">
                        	<i class="entypo-key"></i>
							<span>'Change password'</span>
						</a>
					</li>
				</ul>
				<?php endif;?>
				<?php if ($account_type == 'parent'):?>
				<ul class="dropdown-menu <?php if ($text_align == 'right-to-left') echo 'pull-right'; else echo 'pull-left';?>">
					<li>
						<a href="<?php echo base_url();?>index.php?parents/manage_profile">
                        	<i class="entypo-info"></i>
							<span>'Edit profile'</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url();?>index.php?parents/manage_profile">
                        	<i class="entypo-key"></i>
							<span>'Change password'</span>
						</a>
					</li>
				</ul>
				<?php endif;?>

				<a href="<?php echo base_url();?>index.php?login/logout">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>

        </ul>
        
        
		<ul class="list-inline links-list pull-right">
			
			<!-- Language Selector 			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i class="entypo-globe"></i> language
                    </a>
				
				<ul class="dropdown-menu <?php if ($text_align == 'left-to-right') echo 'pull-left'; else echo 'pull-right';?>">
					<?php
                            $fields = $this->db->list_fields('language');
                            foreach ($fields as $field)
                            {
                                if($field == 'phrase_id' || $field == 'phrase')continue;
                                ?>
                                    <li class="<?php if($this->session->userdata('current_language') == $field)echo 'active';?>">
                                        <a href="<?php echo base_url();?>index.php?multilanguage/select_language/<?php echo $field;?>">
                                            <img src="assets/images/flag/<?php echo $field;?>.png" style="width:16px; height:16px;" />	
												 <span><?php echo $field;?></span>
                                        </a>
                                    </li>
                                <?php
                            }
                            ?>
                    
				</ul>
				
			</li>
			-->
			<!--<li class="sep"></li>-->
			<!-- SELECT THE ACADEMIC YEAR THAT USER WANT AND AFTER SELECTED THE DATA WILL DISPLAY ONLY THAT 
				ACADEMIC YEAR AND BY DEFAULT IT DEPLAYS CURRENT STUDY YEAR
			-->
			<?php if($this->session->userdata('teacher_login')!=1):?>
			<li>
				
					Academic year  
					<select name="academic_year" id='academic_year' onchange="change_year('<?php echo $function;?>');">
						<option value=" ">Select</option>
						<?php $y = $this->db->get('academic_year')->result_array();?>
						<?php foreach ($y as $year_row):?>
						<option value="<?php echo $year_row['id'];?>" <?php if($this->session->userdata('academic_year')==$year_row['academic_year'])echo 'selected';?>><?php echo $year_row['academic_year'];?></option>
					<?php endforeach;?>
					</select>
					<!--SET WHEN CHANGE -->
				
			</li>
		<?php endif;?>
		</ul>
	</div>
	<input type="hidden" value="<?php echo base_url();?>" id='link'>
</div>
<script>
	function change_year(page){
		
		var v = $('#academic_year').val();
		var link = $('#link').val();
		window.location= link+'/index.php?admin/set_academic_year/' + page+'/'+v;
	}
</script>
<hr style="margin-top:0px;" />
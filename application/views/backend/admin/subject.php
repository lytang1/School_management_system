<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					Subject list
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					Add subject
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>Class</div></th>
                    		<th><div>Subject name</div></th>
                    		<th><div>Teacher</div></th>
                    		<th><div>Options</div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($subjects as $row):?>
                        <tr>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']).' '.$row['language'].' '.$row['study_time'];?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $this->db->get_where('employee',array('employee_id'=>$row['teacher_id']))->row()->name.' '.$this->db->get_where('employee',array('employee_id'=>$row['teacher_id']))->row()->family_name;?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_subject/<?php echo $row['subject_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                Edit
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/subject/delete/<?php echo $row['subject_id'];?>/<?php echo $class_id;?>');">
                                            <i class="entypo-trash"></i>
                                                Delete
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(base_url() . 'index.php?admin/subject/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name :</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo 'Value required';?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Class:</label>
                                <div class="col-sm-5">
                                    <select name="class_id" class="form-control select_class" data-validate="required" data-message-required="<?php echo 'Value required';?>" style="width:100%;" id='select_class'>
                                    	<option value="">Select</option>
                                        <?php 
										$classes = $this->db->get('class')->result_array();
										foreach($classes as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group " id='language'>
                                <label class="col-sm-3 control-label">Language:</label>
                                <div class="col-sm-5">
                                    <select name="language" data-validate="required" data-message-required="<?php echo 'Value required';?>" class="form-control" style="width:100%;">
                                       
                                        <option value="Monolingual">Monolingual</option>
                                        <option value="Bilingual">Bilingual</option>


                                    </select>
                                </div>
                            </div>
                            <div class="form-group " >
                                <label class="col-sm-3 control-label">Class hour:</label>
                                <div class="col-sm-5">
                                    <select name="study_hour" data-validate="required" data-message-required="<?php echo 'Value required';?>" class="form-control" style="width:100%;">
                                       <option value=''>Select</option>
                                        <option value="Full time">Full time</option>
                                        <option value="Part time">Part time</option>
                                       <!--  <option value="Part time(afternoon)">Part time(afternoon)</option>
 -->

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Teacher:</label>
                                <div class="col-sm-5">
                                    <input list='teacherlist' id="teacher" name="teacher_id" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                                    <datalist id="teacherlist">
                                   
                                    	
                                        <?php 
										$teachers = $this->db->get_where('employee',array('position like'=>'%teacher%'))->result_array();
										foreach($teachers as $row):
										?>
                                    		<option value="<?php echo $row['name'].' '.$row['family_name'].' #'.$row['employee_id_code'];?>"></option>
                                        <?php
										endforeach;
										?>
                                   </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-5 col-sm-5">
                                  <button type="submit" class="btn btn-info">Add subject</button>
                              </div>
						   </div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>                   
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
         var availableTags = $('#teacherlist').find('option').map(function () {
            return this.value;
        }).get();
        $('#teacher').autocomplete({ source: availableTags });
		
        $('#language').hide();
		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});

    $('#select_class').change(function(){
         var data = $('#select_class').val();
            if(data<3){
                $('#language').hide();
            }else{
                $('#language').show();
            }

    })
	});

    
		
</script>
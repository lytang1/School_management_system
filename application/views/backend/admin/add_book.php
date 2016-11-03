<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					Book list
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					Add book
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                            <th><div>Book title</div></th>
                            <th><div><?php echo ' Author';?></div></th>
                            <th><div><?php echo ' Description';?></div></th>
                            <!-- <th><div><?php echo get_phrase('price');?></div></th>
                            <th><div><?php echo get_phrase('class');?></div></th> -->
                            <th><div>Quantity </div></th>
                            <th><div><?php echo ' Status';?></div></th>
                            <th><div><?php echo ' Options';?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($books as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['author'];?><?php if($row['author2']!='') echo '& '.$row['author2'];?><?php if($row['author3']!='') echo '& '.$row['author3'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo $row['quantity'];?></td>
                            <td><span class="label label-<?php if($row['quantity']>0){$status='available'; echo 'success';}else {$status='unavailable'; echo 'secondary';}?>"><?php echo $status;?></span></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    <!-- VIEW BOOK DETAIL LINK -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/view_book/<?php echo $row['book_id'];?>" > 
                                        <i class="entypo-book-open"></i>
                                        <?php echo 'View';?>
                                        </a>
                                    </li>
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/edit_book/<?php echo $row['book_id'];?>" >
                                            <i class="entypo-pencil"></i>
                                                <?php echo 'Edit';?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/delete_book/<?php echo $row['book_id'];?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo 'Delete';?>
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
                	<?php echo form_open(base_url() . 'index.php?admin/add_book/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Title* :</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo 'Value required';?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >Author name*:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" class="form-control" name="author_name" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	    <lable class="col-sm-2 control-label" >ISBN #*:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" class="form-control" name="isbn" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >2nd Author name:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" style="border-color:#ebebeb" class="form-control" name="author_name2" >
                           	    </div>
                           	    <lable class="col-sm-2 control-label" >Edition*:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text"  class="form-control" name="edition" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >3nd Author name:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" style="border-color:#ebebeb" class="form-control" name="author_name3" >
                           	    </div>
                           	    <lable class="col-sm-2 control-label" ># of copies*:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" class="form-control" name="copies" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 

                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Description :</label>
                                <div class="col-sm-5">
                                    <textarea type="text" class="form-control" value="" name="description"  rows=4></textarea>
                                </div>
                            </div>

                           <!--  <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Tuition_Fee/Semester');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="0" name="semester" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Tuition_Fee/Year');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="0" name="year" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('enroll_fee');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="enroll_fee"/>
                                </div>
                            </div>
 -->
                        
                        <div class="form-group">
                              <div class="col-sm-offset-5 col-sm-5">
                                  <button type="submit" class="btn btn-info"> Add book</button>
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
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>
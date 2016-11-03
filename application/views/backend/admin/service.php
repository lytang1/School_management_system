<hr />
            <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_service_add/');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	Add new service
                </a> 
                <br /> <br /><br />
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           	<th><div>Service id</div></th>
                            <th><div>Service name</div></th>
                            <th><div>Cost</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $services	=	$this->db->get('service' )->result_array();
                                foreach($services as $row):?>
                        <tr>
                            <td><?php echo$row['service_id'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td>$<?php echo $row['cost'];?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- teacher EDITING LINK -->
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_service_edit/<?php echo $row['service_id'];?>');">
                                            	<i class="entypo-pencil"></i>
													Edit
                                               	</a>
                                        				</li>
                                        <li class="divider"></li>
                                        
                                        <!-- teacher DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/service/delete/<?php echo $row['service_id'];?>');">
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



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	
</script>


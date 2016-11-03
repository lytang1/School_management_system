
           
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div>Id</div></th>
                            <th><div>Name</div></th>
                            <th><div>Family name</div></th>
                            <th><div>Position</div></th>
                            <th><div> Cell phone</div></th>
                           
                            <th><div>Employed date</div></th>
                            <!-- <th><div>Salary day</div></th> -->
                            <th><div>Address</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                               
                                foreach($employees as $row):?>
                        <tr>
                            <td><?php echo $row['employee_id_code'];?></td>
                            <td><?php echo ucfirst($row['name']);?></td>
                            <td><?php echo ucfirst($row['family_name']);?></td>
                            <td><?php echo ucfirst($row['position']);?></td>
                            <td><?php echo $row['cell_phone'];?></td>
                           
                            <td><?php echo date('Y/M/d',$row['employ_date']);?></td>  
                            <!-- <td><?php echo date('d',$row['salary_date']);?></td> --> 
                            <td><?php echo $row['address'];?></td>
                            
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        <!-- EMPLOYEE VIEW DETAIL -->
                                        <li>
                                        	<a href="<?php echo base_url();?>index.php?admin/employee_view/<?php echo $row['employee_id'];?>" >
                                            	<i class="entypo-pencil"></i>
													View
                                               	</a>
                                        				</li>
                                        <li class="divider"></li>
                                        <!-- EMPLOYEE CONTRACT LINK -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?admin/employee_contract/<?php echo $row['employee_id'];?>" >
                                                <i class="entypo-doc-text"></i>
                                                    Contract
                                                </a>
                                                        </li>
                                        <li class="divider"></li>

                                        <!-- EMPLOYEE EDITING LINK -->
                                        <li>
                                        	<a href="<?php echo base_url();?>index.php?admin/employee_edit/<?php echo $row['employee_id'];?>" >
                                            	<i class="entypo-pencil"></i>
													Edit
                                               	</a>
                                        				</li>
                                        <li class="divider"></li>
                                        
                                        <!-- EMPLOYEE DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/employee_add/delete/<?php echo $row['employee_id'];?>');">
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



<!---  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<!---
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						"mColumns": [1,2]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(0, false);
							datatable.fnSetColumnVis(3, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(0, true);
									  datatable.fnSetColumnVis(3, true);
								  }
							});
						},
						
					},
				]
			},
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

-->

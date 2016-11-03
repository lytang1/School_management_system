<section>

	<table class='table table-bordered datatable' id="table_export">
		<thead>
			<tr>
			<th><center>No</center></th>
			<th><center>Name</center></th>
			<th><center>Phone</center></th>
			<th><center>Email</center></th>
			<th><center>Date</center></th>
			<th><center>Purpose</center></th>
			<th><center>Option </center></th>
			</tr>
		</thead>
		<tbody>
		<?php $c=0; foreach ($customers as $row): $c++; ?>
				<tr>
					
						<td><?php echo $c;?></td>
						<td><?php echo $row['name'];?></td>
						<td><?php echo $row['phone'];?></td>
						<td><?php echo $row['email'];?></td>
						<td><?php echo $row['date'];?></td>
						<td><?php echo $row['purpose'];?></td>
						<td><div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                       
                                        <li>
                                            <a href="<?php echo base_url(); ?>index.php?admin/edit_potential_customer/<?php echo $row['id']; ?>">
                                                <i class="entypo-pencil"></i>
                                                    Edit
                                                </a>
                                        </li>
                                        <li class="divider"></li>
                                        
                                        <!-- STUDENT DELETION LINK -->
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/delete_potential_customer/<?php echo $row['id'];?>');">
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
	
</section>


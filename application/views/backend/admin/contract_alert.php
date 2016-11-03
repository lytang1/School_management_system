 <table  class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th style="cursor: pointer;"><div>Employee id</div></th>
                            <th style="cursor: pointer;"><div>Employee name</div></th>
                            <th style="cursor: pointer;"><div>Position</div></th>
                            <th style="cursor: pointer;"><div>Phone</div></th>
                            <th style="cursor: pointer;"><div>Contract due date</div></th>
                            <th style="cursor: pointer;"><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody id='all'>
                        <?php foreach($data as $row):?>
                        <tr >
                            <td><?php echo $row['employee_id'];?></td>
                             <td>
                               <?php echo $row['name'].' '.$row['family_name'];?>
                            </td>
                            <td><?php echo $row['position'];?></td>
                            
                            <td>
                                <?php echo $row['cell_phone'];?>   
                            </td>
                              <td><?php echo date('Y/m/d',$row['expired_date']);?></td>
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
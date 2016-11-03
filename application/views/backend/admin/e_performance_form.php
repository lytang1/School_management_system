<!-- DISPLAY ALL THE EXIST PERFORMANCE FORM-->

<section class='row'>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_form_add/" >New form
</a>

</section>
<br>
 <div class="tab-pane box active" id="list">
                
                <table class="table table-bordered datatable" id="table_export" style="text-align:center">
                    <thead>
                        <tr>
                            <th><div><center>#</center></div></th>
                            <th><div><center>Form title</center></div></th>
                            <th><div><center>Number of question</center></div></th>
                             <th><div><center>Options</center></div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;foreach($forms as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['form_title'];?></td>
                            <td><?php $this->db->select('*');
                            $this->db->from('employee_performance_form_question');
                            $this->db->where('e_performance_form_id',$row['id']);
                            $count_question=$this->db->count_all_results();
                            echo $count_question;?></td>
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                     <!-- EDIT QUESTION -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/e_performance_form_add/edit/<?php echo $row['id'];?>" >
                                            <i class="entypo-list"></i>
                                                Edit
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                   
                                    
                                    <!-- DELETION LINK -->
                                    <li>                                    
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/e_performance_form/delete/<?php echo $row['id'];?>');">
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
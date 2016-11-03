<!--LIST ALL THE EXIST QUESTIONS-->

<section class='row'>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_question/" >New question
</a>

</section>
<br>
 <div class="tab-pane box active" id="list">
                
                <table class="table table-bordered datatable" id="table_export" style="text-align:center">
                    <thead>
                        <tr>
                            <th><div><center>#</center></div></th>
                            <th><div><center>Question</center></div></th>
                             <th><div><center>Options</center></div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;foreach($questions as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['question'];?></td>
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                     <!-- EDIT QUESTION -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_question_edit/<?php echo $row['id'];?>');">
                                            <i class="entypo-list"></i>
                                                Edit
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                   
                                    
                                    <!-- DELETION LINK -->
                                    <li>                                    
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/e_performance_question/delete/<?php echo $row['id'];?>');">
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
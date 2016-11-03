<hr />
<div class="row">
    <div class="col-md-12">
         <center>
    <a onClick="PrintElem('#print')" class="btn btn-default btn-icon icon-left hidden-print pull-left">
        Print 
        <i class="entypo-print"></i>
    </a>
</center> 
       
            <section class='pull-right col-sm-3'>
                <label for="field-2" class="col-sm-3 control-label" style="text-align:right;padding-top:5px">Group</label>
                <section class='col-sm-9    '>
                    <select class="form-control" id="group_id">
                        <option value="all">All</option>
                        <?php 
                         foreach ($class_names as $r1): $c = $c.$r1['id'].' '; ?> 
                         <?php $c_d_id=$this->db->get_where('class_name',array('id'=>$r1['id']))->row()->class_detail_id;
                            $c_id = $this->db->get_where('class_detail',array('class_detail_id'=>$c_d_id))->row()->class_id;
                            $c_name = $this->db->get_where('class',array( 'class_id'=>$c_id))->row()->name;?>
                        <option value="<?php echo $r1['id'];?>" class="<?php echo str_replace(' ', '',$c_name);?>"><?php echo $r1['name'];?></option>
                    <?php endforeach;?>
                    </select>
                </section>
            </section>
        <section class='row '>
            <section class='pull-right col-sm-4'>
                <label for="field-2" class="col-sm-6 control-label" style="text-align:right;padding-top:5px">Class</label>
                <section class='col-sm-6'>
                    <select id="class_id" class="form-control">
                        <option value="all" class="lvl">All</option>
                        <?php
                         foreach ($classes as $r): $c= $c.$r['name'].' ';?>

                        <option value="<?php echo str_replace(' ', '', $r['name']);?>" class="lvl"><?php echo $r['name'];?></option>
                    <?php endforeach;?>
                    </select>
                </section>
            </section>

        </section>
        <div class="tab-content">
            <div class="tab-pane active" id="home">
              
<section id='print'>
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr class="<?php echo $c;?>">
                            <th width="80"><div>Student id</div></th>
                            <th width="80"><div>Photo</div></th>
                            <th><div> Name</div></th>
                            <th class="span3"><div> Address</div></th>
                            <th><div>Emergency Contact Number</div></th>
                            
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                             
                                foreach($students as $row):?>
                                <?php $cl_id = $this->db->get_where('class_detail',array('class_detail_id'=>$this->db->get_where('class_name',array('id'=>$row['class_id']))->row()->class_detail_id))->row()->class_id;
                                $clas_name = $this->db->get_where('class',array('class_id'=>$cl_id))->row()->name;?>
                        <tr  class="<?php echo str_replace(' ', '', $clas_name).' '.$row['class_id'];?>">
                            <td><?php echo $row['student_id_code'];?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo ucfirst(strtolower($row['name']));?></td>
                            <td><?php echo $row['address'];?></td>
                            <td><?php echo $row['emergency_contact_number'];?></td>

                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="<?php echo base_url(); ?>index.php?admin/student_profile/<?php echo $row['student_id']; ?>" >
                                                <i class="entypo-user"></i>
                                                    Profile
                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT ENROLL LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_enroll/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    Enroll
                                                </a>
                                        </li>
                                       
                                         <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="<?php echo base_url(); ?>index.php?admin/student_edit/<?php echo $row['student_id']; ?>">
                                                <i class="entypo-pencil"></i>
                                                    Edit
                                                </a>
                                        </li>
                                        <li class="divider"></li>
                                        
                                        <!-- STUDENT DELETION LINK -->
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/student/delete/<?php echo $row['student_id'];?>');">
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
            </div>
       
            </div>
  
        </div>
        
        
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        $('#class_id').change(function(){
            $v = $('#class_id').val();
            var val = ".".concat($v);
            if($v!='all'){
                $("tr:not(val)").hide();
                $("option:not(val)").hide();
                $(".lvl").show();
        $(val).show();
            }else{
                $("tr:not(val)").show();
            }

        })

        $('#group_id').change(function (){
            $v1 = $('#group_id').val();
            var val1 = ".".concat($v1);
            if($v1 != 'all'){
                $("tr:not(val1)").hide();
                $(val1).show();
            }else{
                $("tr:not(val)").show();
            }
        })

 

   
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
        
</script>
<script >
     // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Student list</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body><center><h4>Student list</h4></center><br><br><br><br><br><br><br>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
  

</script>
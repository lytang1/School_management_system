<div>
<br><br>
    <?php echo form_open(base_url().'index.php?admin/manage_marks/view',array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
    <section class=' row'>
    <section class='form-group col-sm-5'>
        <label class="col-sm-5 control-label">Class</label>
        <section class='col-sm-7'>
        <select name="class_grade" id="class_grade" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
                <option value="">Select</option>
                <?php foreach ($classes as $class):?>
                    <option value="<?php echo $class['class_detail_id'];?>" <?php if($class_id==$class['class_detail_id']) echo 'selected';?>><?php echo $class['name'].' - '.$class['language'].' - '.$class['study_time'];?></option>
                <?php endforeach;?>
        </select>
        </section> 
    </section>

    <section class='form-group col-sm-3'>
        <label class="col-sm-5 control-label">Class group</label>
        <section class='col-sm-7'>
        <select name="class_group" class="form-control" >
                <option value="">All</option>
                <?php foreach ($class_groups as $class_group):?>
                    <option value="<?php echo $class_group['id'];?>" <?php if($class_grade==$class_group['id'])echo 'selected';?> class="<?php echo $class_group['class_detail_id'];?> 
                    <?php if($class_group['class_id']!=$class_id)echo 'hide';?>"><?php echo $class_group['name'];?></option>
                <?php endforeach;?>
        </select>
        </section>
    </section>

     <section class='form-group col-sm-3'>
        <label class="col-sm-5 control-label">Score type</label>
        <section class='col-sm-7'>
        <select name="score_type" class="form-control" >
                <option value="">All</option>
                <?php foreach ($score_types as $score_row):?>
                    <option value="<?php echo $score_row['id'];?>" <?php if($score_type==$score_row['id'])echo 'selected';?> >
                    <?php echo ucfirst($score_row['name']);?></option>
                <?php endforeach;?>
        </select>
        </section>
    </section>
    

    <section class='form-group col-sm-1'>
        <button class="btn btn-info"> Manage marks</button>
    </section>
</section>
<?php echo form_close();?>
    <?php if($students):?>
        <br><hr>
<section>
         <?php echo form_open(base_url().'index.php?admin/manage_marks/create',array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
   <section>
    <input type="hidden" value="<?php echo $class_id;?>" name="score_class_id">
    <input type ='hidden' value = '<?php echo $score_type;?>' name='score_type'>
   <section class = ' row'>
    <section class='form-group col-md-5 '>
     <label class="label-control col-md-5 " style="text-align:right">Subject</label>
          <section class='col-md-7'>
        <select class="form-control" name="subject" data-validate="required" data-message-required="<?php echo 'Required ';?>">
                <option value="">Select</option>
                <?php foreach ($subjects as $subject):?>
                    <option value="<?php echo $subject['subject_id'];?>" ><?php echo $subject['name'];?></option>
                <?php endforeach;?>
        </select>
        </section>
          </section>
  <section class='form-group col-sm-5' id='semester'>
        <label class="col-sm-3 control-label">Semester/Time</label>
        <section class='col-sm-8'>
        <select name="semester" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
                <option value="">Select</option>
                <option value='semester one'>Semester one</option>
                <option value="semester two">Semester two</option>
        </select>
        </section>
    </section>
    </section>

    <section class='row'>
       
     <?php if($this->db->get_where('score_percentage',array('id'=>$score_type))->row()->name=='exam'):?>
   <section class='form-group col-sm-5'>
   

        <label class="label-control col-md-5" style="text-align:right">Exam type</label>
        <section class='col-md-7'>
        <select id='exam_type' class="form-control" name="exam_type" data-validate="required" data-message-required="<?php echo 'Required ';?>">
            <option value="">Select</option>
            <?php foreach ($exam_types as $e_row):?>
                <option value="<?php echo $e_row['id'];?>"><?php echo ucfirst($e_row['name']);?></option>
            <?php endforeach;?>
        </select>
    </section>

           
 
    </section>
<?php endif;?>
    <section class='form-group hide col-sm-5' id='month'>
        <label class="col-sm-3 control-label">Month</label>
        <section class='col-sm-8'>
        <select id='m_val' name="month" class="form-control" data-validate="required" data-message-required="<?php echo 'Required';?>">
                <option value="">Select</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
        </select>
        </section>
</section>


    </section>


    </section>
    <br>
<h4><b> Note score</b></h4>
<br>
        <table class="table">
            <tr>
                <th>Student name</th>
                <th>Score</th>
                <th>Comment</th>
            </tr>
            <?php foreach ($students as $student):?>
                <tr>
                    <td><?php echo $student['name'];?><input type="hidden" name="students[]" value="<?php echo $student['student_id'];?>"></td>
                    <td><input type="number" value="0" min=0 max=100 data-validate="required" data-message-required="<?php echo 'Required ';?>" class="form-group" name="<?php echo 'score'.$student['student_id'];?>"></td>
                    <td><input type="text"  class="form-group" style="width:235px;" name="<?php echo 'comment'.$student['student_id'];?>"></td>
                </tr>
            <?php endforeach;?>
        </table>
            <section class='col-md-offset-5'>
                <button class="btn btn-info"> Save</button>
            </section>
            <?php echo form_close();?>
            </section>
    <?php endif;?>
</div>
<script>
$(document).ready(function(){
    $initial=0;
})
    $('#class_grade').change(function(){
        if($initial==0){
            $last_class="";$initial++;
        }
  
        $class_id = $('#class_grade').val();
        $class_id = '.'.concat($class_id);
        $($class_id).removeClass('hide');
if($last_class)
       { $($last_class).addClass('hide');}
        $last_class = $class_id;
    })
    $('#exam_type').change(function(){
        var v1=$('#exam_type option:selected').text();
        if(v1=='Monthly'){
            $('#month').removeClass('hide');
        }
        if(v1!='Monthly'){
            $('#month').addClass('hide');
          
        }
       
    })
    
</script >
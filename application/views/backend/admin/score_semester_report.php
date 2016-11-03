<div>
	<br><br>
    <?php echo form_open(base_url().'index.php?admin/report_semescore/view', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
    <section class=' row'>
    <section class='form-group col-sm-4'>
        <label class="col-sm-4 control-label">Class</label>
        <section class='col-sm-8'>
        <select name="class_grade" id="class_grade" class="form-control" data-validate="required" data-message-required="<?php echo 'Required ';?>">
                <option value="">Select</option>
                <?php foreach ($classes as $class):?>
                    <option value="<?php echo $class['class_detail_id'];?>" <?php if($class_id==$class['class_detail_id']) echo 'selected';?>><?php echo $class['name'].' - '.$class['language'].' - '.$class['study_time'];?></option>
                <?php endforeach;?>
        </select>
        </section>
    </section>

    <section class='form-group col-sm-4'>
        <label class="col-sm-4 control-label">Class group</label>
        <section class='col-sm-8'>
        <select name="class_group" class="form-control">
                <option value="">All</option>
                <?php foreach ($class_groups as $class_group):?>
                    <option value="<?php echo $class_group['class_id'];?>"  class="<?php echo $class_group['class_detail_id'];?> hide"><?php echo $class_group['name'];?></option>
                <?php endforeach;?>
        </select>
        </section>
    </section>

  
        
    <section class='form-group col-sm-4'>
        <label class="col-sm-4 control-label">Semester</label>
        <section class='col-sm-8'>
       <select name="semester" class="form-control" id="semester" data-validate="required" data-message-required="<?php echo 'Required ';?>">
                <option value="">Select</option>
                 <option value='semester one'>Semester one</option>
                <option value="semester two" >Semester two</option>
        </select>
        </section>
    </section>
 </section>

    
<section class='row'>
    <section class='form-group col-sm-12'>
        <button class="btn btn-info col-md-offset-5"> View score</button>
    </section>
   </section>


</div>

<script>
$(document).ready(function(){
    $initial=0;$s_init=0;
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

  

// SHOULD CALL FUNCTION WHEN ONCHANGE BETTER THAN THIS AND THROW THE NAME OF PERIOD 
 $('#period').change(function(){

 	if($sname_ini==0){
 		$last_sname=""; $sname_ini++;
 	}
    $c_id = $('#class_grade').val();
 	$p_id = $('#period').val(); 
 	$p_id = ".period_".concat($p_id);
    $p_id = $p_id.concat("_");
    $p_id = $p_id.concat($c_id);
 
 	$($p_id).removeClass('hide');
 	if($last_sname){
 		$($last_sname).addClass('hide');
 	}
 	$last_sname=$p_id;

 })

</script>
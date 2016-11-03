<!--FORM TO ADD NEW QUESTIONS MAXIMUM 10 QUESTIONS-->

<section class='row'>
<div class="col-sm-1 pull-right" style="margin-top:5px;">
                        <a id='add' class="btn btn-info " ><i class="fa fa-plus"> Add more</i></a>
                    </div>
</section>
<?php echo form_open(base_url() . 'index.php?admin/e_performance_question/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
	
	
	<?php for ($i=1; $i <=5 ; $i++) :?>
	<section class='row form-group ' id='<?php echo $i;?>'>
		<label class="control-label col-sm-2">Question </label>
		<section class='col-sm-5'>
			<input type="text" class="form-control" name='question[]' id="<?php echo 't'.$i;?>">
		</section>
		 <?php if($i>1):?>
         <div class="col-sm-1" style="margin-top:5px;">
                         <a  class="btn btn-info " onclick="delete_row('<?php echo $i;?>','<?php echo 't'.$i;?>');" ><i class=" entypo-cancel"></i></a>
         </div>
     <?php endif;?>
	</section>
	<?php endfor;?>
	

	<?php for ($i=6; $i <=10 ; $i++) :?>
	<section class='row form-group hide <?php echo "q".$i;?>' id='<?php echo $i;?>'>
		<label class="control-label col-sm-2">Question </label>
		<section class='col-sm-5'>
			<input type="text" class="form-control" name='question[]' id="<?php echo 't'.$i;?>">
		</section>
		<div class="col-sm-1" style="margin-top:5px;">
                         <a  class="btn btn-info " onclick="delete_row('<?php echo $i;?>','<?php echo 't'.$i;?>');" ><i class=" entypo-cancel"></i></a>
         </div>
	</section>
	<?php endfor;?>
	<section class="col-md-offset-5">
			<button class="btn btn-info">Save</button>
	</section>
<?php echo form_close();?>


<script>
	$(document).ready(function($)
    { $q6 = 0;
    $q7 = 0;
    $q8 = 0;
    $q9 = 0;
    $q10= 0;
})
$('#add').click(function(){
   

    if($q6 ==0){
    $("#6").removeClass('hide');
    $('#6').show();
    
    $q6 =1;
}

    else if($q6==1 && $q7==0){
        $("#7").removeClass('hide');
    $('#7').show();
        $q7=1;
    }
    else if($q6==1 && $q7==1 && $q8==0){
         $("#8").removeClass('hide');
         $('#8').show();
            $q8=1;
    }
    else if($q6==1 && $q7 ==1 && $q8==1 && $q9==0){
        $("#9").removeClass('hide');
        $('#9').show();
        $q9=1;
    } 
    else if($q6==1 && $q7 ==1 && $q8==1 && $q9==1){
        $("#10").removeClass('hide');
        $('#10').show();
        $q10=1;
    } 
})

    function delete_row(e_id,b_id){
      var e_id1 = '#'.concat(e_id);
      
     document.getElementById(b_id).value="";
       
        
       $(e_id1).addClass('hide');
       $(e_id1).hide();
       switch(e_id){
        case '6' : $q6=0;break;
        case '7' : $q7=0;break;
        case '8' : $q8=0;break;
        case '9' : $q9=0;break;
        case '10' : $q10=0;break;
       }
    }


</script>
</script>
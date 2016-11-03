<div class="row">
 <section class='col-sm-12 '>
   
  <div class="col-sm-1 pull-right" style="margin-top:5px;margin-right:5px">
      <a id='add' class="btn btn-info " ><i class="fa fa-plus"> Add more</i></a>
  </div>
</section>
</div> 
<br>

<div class="row">
                    <?php echo form_open(base_url() . 'index.php?admin/score_percentage/create/' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                      
                       <?php $i=0; foreach ($score_percentages as $p_row): 
                       $i++;?>
                      
                        <div class="padded ">
                        <div class="form-group row " id='<?php echo 'a'.$i;?>'>
                            <div class="form-group col-sm-5">
                                <label class="col-sm-6 control-label">Name :</label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $p_row['name'];?>" id='<?php echo $p_row['name'];?>'class="form-control" name="<?php echo $p_row['name'];?>" data-validate="required" data-message-required="<?php echo 'Required';?>"/>
                                </div>
                            </div>
                          <div class="form-group col-sm-6">
                                <label class="col-sm-6 control-label">Score percentage:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="<?php echo $p_row['percentage'];?>" max='100' data-validate="required" data-message-required="<?php echo 'Required ';?>" name="<?php echo $p_row['name'].'_percentage';?>" id='<?php echo $p_row['name'].'_percentage';?>' data-start-view="2">
                                </div>
                            </div>

                           <div class="col-sm-1" style="margin-top:5px;">
                                                 <a  class="btn btn-info " onclick="delete_row('<?php echo 'a'.$i;?>','<?php echo $p_row['name'];?>','<?php echo $p_row['name'].'_percentage';?>');" ><i class=" entypo-cancel"></i></a>
                                 </div>
                        </div>
                        </div>
                        
                    <?php endforeach;?>
                    <?php for ($i=6; $i <=10 ; $i++) :?>
                            <section class='row  hide <?php echo "q".$i;?>' id='<?php echo $i;?>'>
                              <div class="form-group col-sm-5">
                                <label class="control-label col-sm-6">Name </label>
                                <section class='col-sm-6'>
                                    <input type="text" class="form-control" name='name[]' id="<?php echo 't'.$i;?>" data-validate="required" data-message-required="<?php echo 'Required';?>">
                                </section>
                                </div>
                                <div class="form-group col-sm-6">
                                <label class="control-label col-sm-6">Score percentage</label>
                                <section class='col-sm-6'>
                                    <input type="text" class="form-control" name='percentage[]' id="<?php echo 'ts'.$i;?>" data-validate="required" data-message-required="<?php echo 'Required';?>">
                                </section>
                                </div>
                                <div class="col-sm-1" style="margin-top:5px;">
                                                 <a  class="btn btn-info " onclick="delete_row('<?php echo $i;?>','<?php echo 't'.$i;?>','<?php echo 'ts'.$i;?>');" ><i class=" entypo-cancel"></i></a>
                                 </div>
                            </section>
                           
                            <?php endfor;?>

                        <div class="form-group">
                              <div class="col-sm-offset-5 col-sm-1">
                                  <button type="submit" class="btn btn-info">Save</button>
                              </div>
                               <div class="col-sm-2" >
                  <a href="<?php echo base_url(); ?>index.php?admin/score_percentage" class="btn btn-info " >Back</a>
        
    </div>
                           </div>
                    </form>                
                </div>      
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

    function delete_row(e_id,b_id,s_id){
      var e_id1 = '#'.concat(e_id);
      
     document.getElementById(b_id).value="";
     document.getElementById(s_id).value="";  
      var a =document.getElementById(b_id).value;
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
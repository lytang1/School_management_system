<?php 
$edit_data		=	$this->db->get_where('invoice' , array('invoice_id' => $param2) )->result_array();
$services       =   $this->db->get('service')->result_array();
$service_list = $this->db->get_where('service_list_to_pay',array('id_invoice'=>$param2))->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo ' Add service';?>
            	</div>
            </div>
			<div class="panel-body">
              <?php echo form_open(base_url() . 'index.php?admin/paymentservice/create/'.$row['invoice_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

				<table class="table" width=100%>
                    <tr>
                        <th></th>
                        <th><?php echo 'Service name';?></th>
                        <th>Quantity</th>
                        <th><?php echo 'Cost ';?></th>
                    
                        <th><?php echo 'Free ';?></th>
                        <th><?php echo 'Discount ';?></th>
                        
                    </tr>
                                  <?php foreach ($services as $row1): ?>
                                   <?php $check='false';$is_free=0; $quantity=''; $free_quantity='';?>
                        <tr>
                        <?php  foreach ($service_list as $list){if($list['service']==$row1['name']){ $check='true'; $discount=$list['discount']; $is_free = $list['is_free'];}}?>
                            <td> <input type='checkbox' name='service[]' value="<?php echo $row1['service_id'];?>" 
                            <?php  if($check=='true'){echo 'checked';}?>
                            ></td>
                            <td><?php echo $row1['name'];?></td>
                             <td><?php  
                          if($row1['has_quantity']==1) :$quantity = sizeof($this->db->get_where('service_list_to_pay',array('service'=>$row1['name'],'id_invoice'=>$param2))->result_array());?>
                          <input type="number" class="quantity-input" maxlength="2" max="99" id="<?php echo 'quantity'.$row1['service_id'];?>" value='<?php echo $quantity;?>' name="<?php echo 'quantity'.$row1['service_id'];?>" oninput="change_type('<?php echo 'free'.$row1['service_id'];?>','<?php echo 'quantity'.$row1['service_id'];?>','<?php echo $row1['service_id'];?>')"
                          >
                        <?php endif;?>
                          </td>
                            <td><?php echo $row1['cost'].'$';?></td>
                          <?php $free_quantity = sizeof($this->db->get_where('service_list_to_pay',array('service'=>$row1['name'],'id_invoice'=>$param2,'is_free'=>'1'))->result_array());?>
                            <td><input class="<?php if($row1['has_quantity']==1) echo 'quantity-input';?>" 
                            type="<?php if($row1['has_quantity']==0)echo 'checkbox'; elseif($row1['has_quantity']==1) echo 'number';?>" <?php if($is_free==1){echo 'checked';}?> class="radio" name="<?php echo 'free'.$row1['service_id'];?>" id="<?php echo 'free'.$row1['service_id'];?>" value="<?php if($row1['has_quantity']==0) echo $row1['service_id']; else echo $free_quantity;?>"></td>
                            <td><select name="<?php echo $row1['service_id'];?>" data-validate="required" data-message-required="<?php echo 'Required ';?>" class="form-control" id="discount_value" 
                                    onchange="return get_class_sections(this.value)">
 <!--TO DO GET THE DISCOUNT IN ADMIN CATCH BY USING THE NAME OF SERVICE-->                             
                              
                              <option <?php if($discount==0){echo 'selected';}?> value="0"> 0%</option>
                              <option <?php if($discount==5){echo 'selected';}?> value="5"> 5%</option>
                              <option <?php if($discount==10){echo 'selected';}?> value="10"> 10%</option>      
                              <option <?php if($discount==15){echo 'selected';}?> value="15"> 15%</option>
                              <option <?php if($discount==20){echo 'selected';}?> value="20"> 20%</option>
                              <option <?php if($discount==25){echo 'selected';}?> value="25"> 25%</option>
                              <option <?php if($discount==30){echo 'selected';}?>value="30"> 30%</option>
                              <option <?php if($discount==35){echo 'selected';}?> value="35"> 35%</option>
                              <option <?php if($discount==40){echo 'selected';}?> value="40"> 40%</option>
                              <option <?php if($discount==45){echo 'selected';}?> value="45"> 45%</option>
                              <option <?php if($discount==50){echo 'selected';}?> value="50"> 50%</option>      
                                
                          </select></td>
                         
                        </tr>                     
                    <?php endforeach;?>
                    
                </table>
            		<div class="form-group">
						<div class="col-sm-offset-5 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo 'Add';?></button>
						</div>
					</div>
        		</form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>
<script>
  function change_type(id,qid,vid){
    $id = '#'.concat(id);
    $qid= '#'.concat(qid);
   $va = $($qid).val();
   $length = $va/10;
   if($length <1){$length =1;}
   else if($length>=1){$length=2;}
    $($id).attr('type','number');
    $($id).attr('max',$va);
    $($id).attr('maxlength',$length);
    $($id).addClass('quantity-input');
    $($id).val(null);
    if(!$va){
       $($id).attr('type','checkbox');
       $($id).val(vid);
       $($id).removeClass('quantity-input');
    }
  }
</script>

<br />
<div class="row">
	<div class="col-md-12">
    	<div class="row">
            <!-- CALENDAR-->
           <!--  <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-md-4" style="cursor:pointer"  onclick = "window.open('<?php echo base_url(); ?>index.php?admin/alert_dashboard/need_paid');" style="color:white">
            
                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-credit-card"></i></div>
                  
                    
                    <div class="num" 
                            data-postfix="" data-duration="1500" data-delay="0">
                            
                            <?php if($student_need_paid[0]=='') echo "0";?>
                            <?php if($student_need_paid[0] !='')echo sizeof($student_need_paid);?>
                      
                    </div>
                     <h3><?php if(sizeof($student_need_paid)>1)echo 'Students';else echo ' Student'; ?></h3>
                   <p>Need to pay invoice</p>
                   </div>
       
                   </div>
                   
             <div class="col-md-4" style="cursor:pointer" onclick = "window.open('<?php echo base_url(); ?>index.php?admin/alert_dashboard/renew_invoice');" style="color:white">
            
                <div class="tile-stats tile-green">
                   
                    <div class="icon"><i class="entypo-credit-card"></i></div>
       
                   <div class="num" 
                            data-postfix="" data-duration="1500" data-delay="0">
                                
                                  <?php if($student_renew_invoice[0]=='') echo "0";?>
                                     <?php if($student_renew_invoice[0] !='') echo sizeof($student_renew_invoice);?>
                        
                    </div>
                     <h3><?php if(sizeof($student_renew_invoice)>1)echo 'Students';else echo ' Student'; ?></h3>
                   <p>Need to re-new invoice</p>
                   
                </div>   
               
            </div>
               

                <div class="col-md-4" style="cursor:pointer"  onclick = "window.open('<?php echo base_url(); ?>index.php?admin/alert_dashboard/borrow');" style="color:white">
               
                <div class="tile-stats tile-aqua">
                    <div class="icon"><i class="fa fa-group"></i></div>
                   
                    <div class="num" data-start="0" data-end="" 
                            data-postfix="" data-duration="1500" data-delay="0">
                            <?php if($borrow_ids[0] =='') echo "0";?>
                            <?php if($borrow_ids[0] !='') echo sizeof($borrow_ids);?>
                                
                            </div>
                         <h3><?php if(sizeof($borrow_ids)>1)echo 'Students';else echo ' Student'; ?></h3>
                        <p> Need to return book</p>
                </div>
                
                </div>

                <div class="col-md-4" style="cursor:pointer" onclick = "window.open('<?php echo base_url(); ?>index.php?admin/alert_dashboard/renew_con');" style="color:white">
                   <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-vcard"></i></div>
                    
                   <!-- <p>Employee name</p> -->
                    <div class="num" data-start="0" data-end="" 
                            data-postfix="" data-duration="1500" data-delay="0">
                           

                            <?php if($employee_ids[0] =='') echo "0";?>
                            <?php if($employee_ids[0] !='') {echo sizeof($employee_ids);}?>
                            

                            </div>
                    <h3><?php if(sizeof($employee_ids)>1)echo 'Employees';else echo ' Employee'; ?> </h3>
                    <p>Need to re-new contract</p>
                </div>
             
               </div>
        
               <div class="col-md-4" style="cursor:pointer" onclick = "window.open('<?php echo base_url(); ?>index.php?admin/alert_dashboard/renew_work_verification');" style="color:white">
                   <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-vcard"></i></div>
                    
                   <!-- <p>Employee name</p> -->
                    <div class="num" data-start="0" data-end="" 
                            data-postfix="" data-duration="1500" data-delay="0">
                           

                            <?php if($wv_expired[0] =='') echo "0";?>
                            <?php if($wv_expired[0] !='') {echo sizeof($wv_expired);}?>
                            

                            </div>
                    <h3><?php if(sizeof($wv_expired)>1)echo 'Employees';else echo ' Employee'; ?> </h3>
                    <p>Need to update visa or work verification document</p>
                </div>
             
               </div>
	
	
            
                <div class="col-md-4">
                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('student');?>" 
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>
                    
                    <h3>Students</h3>
                   <p>Total students</p>
                </div>
               </div>

      </div>
    </div>         
            
    	
    
	
</div>



    <script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});
  </script>

  

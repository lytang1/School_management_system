<?php  
foreach ($books as $book):

?>

<div class="container">
                	
                        <div class="padded">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Title :</label>
                                
                                <label class="col-sm-5 control-label"><?php echo $book['name'];?></label>
                                
                            </div>

                            <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >Author name:</lable>
                            	
                            	<lable class="col-sm-3 control-label"><?php echo $book['author'];?></lable>
                           	    
                           	    <lable class="col-sm-2 control-label" >ISBN #:</lable>
                            	
                            		<label class="col-sm-3 control-label"><?php echo $book['isbn'];?></label>
                           	    
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >2nd Author name:</lable>
                            	
                            		<label class="col-sm-3 control-label"><?php echo $book['author2'];?></label>
                           	    
                           	    <lable class="col-sm-2 control-label" >Edition:</lable>
                            
                            	<label class="col-sm-3 control-label"><?php echo $book['edition'];?></label>
                           	    
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >3nd Author name:</lable>
                            	
                            		<label class="col-sm-3 control-label"><?php echo $book['author3'];?></label>
                           	    
                                <lable class="col-sm-2 control-label" ># of copies:</lable>
                            	  
                                <label class="col-sm-3 control-label"><?php echo $book['quantity'];?></label>
                           	    
                           	 </div>

                           	 

                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Description </label>
                                
                                    <textarea type="text" readonly="readonly" class="form-control"  name="description"  rows=4><?php echo $book['description'];?></textarea>
                                </div>
                            

                 
                        
                        
                    </div>
                        
                    <a   href="<?php echo base_url();?>index.php?admin/add_book/" ><img align=right src="<?php echo base_url();?>assets\images\back.jpg" height=30px;></a>         
                </div>  
  <?php endforeach;?>              
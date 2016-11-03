<?php  
foreach ($book_info as $book):

?>

<div class="container">
                	<?php echo form_open(base_url() . 'index.php?admin/edit_book/do_update/'.$book['book_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Title :</label>
                                <div class="col-sm-5">
                                    <input type="text" value="<?php echo $book['name'];?>" class="form-control" name="title" data-validate="required" data-message-required="<?php echo 'Value required';?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >Author name:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['author'];?>" class="form-control" name="author_name" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	    <lable class="col-sm-2 control-label" >ISBN #:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['isbn'];?>" class="form-control" name="isbn" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >2nd Author name:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['author2'];?>" class="form-control" name="author_name2" >
                           	    </div>
                           	    <lable class="col-sm-2 control-label" >Edition:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['edition'];?>" class="form-control" name="edition" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 <div class="form-group row">
                            	<lable class="col-sm-3 control-label" >3nd Author name:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['author3'];?>" class="form-control" name="author_name3" >
                           	    </div>
                           	    <lable class="col-sm-2 control-label" ># of copies:</lable>
                            	<div class="col-sm-3 ">
                            		<input type="text" value="<?php echo $book['quantity'];?>" class="form-control" name="copies" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                           	    </div>
                           	 </div>

                           	 

                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Description :</label>
                                <div class="col-sm-5">
                                    <textarea type="text" value="<?php echo $book['description'];?>" class="form-control"  name="description"  rows=4><?php echo $book['description'];?></textarea>
                                </div>
                            </div>

                 
                        
                        <div class="form-group">
                              <div class="col-sm-offset-5 col-sm-5">
                                  <button type="submit" class="btn btn-info" style="padding-left:30px;padding-right:30px"> Edit</button>
                                  
                             </div>
							     </div>
                    </div>
                    </form>      
                    <a   href="<?php echo base_url();?>index.php?admin/add_book/" ><img align=right src="<?php echo base_url();?>assets\images\back.jpg" height=30px;></a>         
                </div>  
  <?php endforeach;?>              
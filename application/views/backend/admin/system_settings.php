<hr />

    <div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/system_settings/do_update' , 
      array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
        <div class="col-md-6">
            
            <div class="panel panel-primary" >
            
                <div class="panel-heading">
                    <div class="panel-title">
                        System settings
                    </div>
                </div>
                
                <div class="panel-body">
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">System name </label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="system_name" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">System title</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="system_title" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_title'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Address</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="address" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'address'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Phone </label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="phone" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Paypal email</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="paypal_email" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'paypal_email'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Currency </label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="currency" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'currency'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">System email</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="system_email" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_email'))->row()->description;?>">
                      </div>
                  </div>
                    
                    <div class="form-group">
                      <label  class="col-sm-3 control-label">Borrow book default period</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="borrow_book_period" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'borrow_book_period'))->row()->description;?>">
                      </div>
                  </div>


                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Language</label>
                      <div class="col-sm-9">
                          <select name="language" class="form-control">
                                <?php
									$fields = $this->db->list_fields('language');
									foreach ($fields as $field)
									{
										if ($field == 'phrase_id' || $field == 'phrase')continue;
										
										$current_default_language	=	$this->db->get_where('settings' , array('type'=>'language'))->row()->description;
										?>
                                		<option value="<?php echo $field;?>"
                                        	<?php if ($current_default_language == $field)echo 'selected';?>> <?php echo $field;?> </option>
                                        <?php
									}
									?>
                           </select>
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Text align</label>
                      <div class="col-sm-9">
                          <select name="text_align" class="form-control">
                          	  <?php $text_align	=	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;?>
                              <option value="left-to-right" <?php if ($text_align == 'left-to-right')echo 'selected';?>> left-to-right</option>
                              <option value="right-to-left" <?php if ($text_align == 'right-to-left')echo 'selected';?>> right-to-left</option>
                          </select>
                      </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                  </div>
                    
                </div>
            
            </div>
        
        </div>
    <?php echo form_close();?>

      <?php 
        $skin = $this->db->get_where('settings' , array(
          'type' => 'skin_colour'
        ))->row()->description;
      ?>
    
        <div class="col-md-6">
            
            

            <?php echo form_open(base_url() . 'index.php?admin/system_settings/upload_logo' , array(
            'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>

              <div class="panel panel-primary" >
              
                  <div class="panel-heading">
                      <div class="panel-title">
                         Upload logo
                      </div>
                  </div>
                  
                  <div class="panel-body">
                      
                    
                      <div class="form-group">
                          <label for="field-1" class="col-sm-3 control-label">Photo</label>
                          
                          <div class="col-sm-9">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                      <img src="<?php echo base_url();?>uploads/logo.png" alt="...">
                                  </div>
                                  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                  <div>
                                      <span class="btn btn-white btn-file">
                                          <span class="fileinput-new">Select image</span>
                                          <span class="fileinput-exists">Change</span>
                                          <input type="file" name="userfile" accept="image/*">
                                      </span>
                                      <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                    
                    
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                          <button type="submit" class="btn btn-info">Upload</button>
                      </div>
                    </div>
                      
                  </div>
              
              </div>

            <?php echo form_close();?>
            
        
        </div>

    </div>

<script type="text/javascript">
    $(".gallery-env").on('click', 'a', function () {
        skin = this.id;
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/system_settings/change_skin/'+ skin,
            success: window.location = '<?php echo base_url();?>index.php?admin/system_settings/'
        });
});
</script>
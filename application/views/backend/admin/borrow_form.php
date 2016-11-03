<style>
.button {
   border-top: 1px solid #96d1f8;
   background: #65a9d7;
   background: -webkit-gradient(linear, left top, left bottom, from(#48a3e0), to(#65a9d7));
   background: -webkit-linear-gradient(top, #48a3e0, #65a9d7);
   background: -moz-linear-gradient(top, #48a3e0, #65a9d7);
   background: -ms-linear-gradient(top, #48a3e0, #65a9d7);
   background: -o-linear-gradient(top, #48a3e0, #65a9d7);
   padding: 4px 8px;
   -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 13px;
   font-family: Georgia, Serif;
   text-decoration: none;
   vertical-align: middle;

   }
.button:hover {
   border-top-color: #1486d1;
   background: #1486d1;
   color: #f7f7f7;
   }
.button:active {
   border-top-color: #469ed9;
   background: #469ed9;
   }
</style>
<div class="row">
    <div class="col-md-12">
    
        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li >
                <a href="<?php echo base_url(); ?>index.php?admin/borrow_book/"><i class="entypo-menu"></i> 
                    Book list
                        </a></li>
            <li class="active">
                <a href="" ><i class="entypo-plus-circled"></i>
                    Borrow book
                        </a></li>
        </ul>
 
            <!----CREATION FORM STARTS---->
            <div class="tab-content box"  style="padding: 5px">
                <div class="box-content">
       <input type="hidden" value="<?php echo $day;?>" id="day">
        <?php echo form_open(base_url() . 'index.php?admin/borrow_book/create/', array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Student :</label>
                    <div class="col-sm-3">
                        <input list='studentlist' name="student_id" id="student" class="form-control" data-validate="required" data-message-required="<?php echo 'Value required';?>">
                        <datalist id="studentlist">
                                            <?php 
                                            $students = $this->db->get('student')->result_array();
                                            foreach($students as $row):
                                            ?>
                                                <option value="<?php echo $row['name'].' #'.$row['student_id_code'];?>">
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                                </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title : </label>
                    <div class="col-sm-3" >
                       <input list='booklist' id="book_id"  name="book_id" class="form-control"  data-validate="required" data-message-required="<?php echo 'Value required';?>" >
                       <datalist id="booklist">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                                        

                                      
                    </div>

                         <label class="col-sm-2 control-label">Borrow period:</label>
                    <div class="col-sm-2">
                        <input type="text"  class="form-control "  name="return_date" value="<?php echo $day;?>">
                    </div>
                    <div class="col-sm-1" style="margin-top:5px;">
                        <a id='add' class="button " ><i class="fa fa-plus"></i></a>
                    </div>
                    </div>
                   
                    
                </div>
               <!--  <div class="form-group">
                   
                </div> -->
                <div class="form-group hide" id="book2">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title : </label>
                    <div class="col-sm-3" >
                    <input list='booklist2' id="book_id2" style="border-color:#ebebeb" name="book_id2" class="form-control"  >
                       <datalist id="booklist2">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                       
                    </div>

                         <label class="col-sm-2 control-label">Borrow period :</label>
                    <div class="col-sm-2">
                        <input type="text" id="date_id2" class="form-control" name="return_date2" value="" >
                    </div>
                    <div class="col-sm-1" style="margin-top:5px;">
                        <a  class="button " onclick="delete_row('book2','book_id2','date_id2');" ><i class="fa fa-minus"></i></a>
                    </div>
                    </div>
                   
                    
                </div>


               <div class="form-group hide" id="book3">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title : </label>
                    <div class="col-sm-3" >
                       <input list='booklist3' id="book_id3" style="border-color:#ebebeb" name="book_id3" class="form-control"   >
                       <datalist id="booklist3">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Borrow period :</label>
                    <div class="col-sm-2">
                        <input type="text" id="date_id3" class="form-control "  name="return_date3" value="" >
                    </div>
                    <div class="col-sm-1" style="margin-top:5px;">
                         <a  class="button " onclick="delete_row('book3','book_id3','date_id3');" ><i class="fa fa-minus"></i></a>
                    </div>
                    </div>
                   
                    
                </div>
                <div class="form-group hide" id="book4">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title : </label>
                    <div class="col-sm-3" >
                        <input list='booklist4' id="book_id4" style="border-color:#ebebeb" name="book_id4" class="form-control"  >
                       <datalist id="booklist4">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                   
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Borrow period :</label>
                    <div class="col-sm-2">
                        <input type="text" id="date_id4" class="form-control "  name="return_date4" value="" >
                    </div>
                    <div class="col-sm-1" style="margin-top:5px;">
                         <a  class="button " onclick="delete_row('book4','book_id4','date_id4');" ><i class="fa fa-minus"></i></a>
                    </div>
                    </div>
                   

                    
                </div>
                 <div class="form-group hide" id="book5">
                    <div class="row">
                    <label class="col-sm-2 control-label">Book title : </label>
                    <div class="col-sm-3" >
                        <input list='booklist5' id="book_id5" style="border-color:#ebebeb" name="book_id5" class="form-control"   >
                       <datalist id="booklist5">
                                        
                                            <?php 
                                            $this->db->select('*');
                                            $this->db->from('book');
                                            $this->db->where('quantity >',0);
                                            $books = $this->db->get()->result_array();
                                            foreach($books as $row):
                                            ?>
                                                <option value="<?php echo $row['name'];?> _by <?php echo $row['author'];?>" data-value="<?php echo $row['book_id'];?>" > 
                                                   <!--  class <?php echo $this->crud_model->get_class_name($row['class_id']);?> - -->
                                                  </option>  
                                                    
                                               
                                            <?php
                                            endforeach;
                                            ?>
                                        </datalist>
                    </div>

                         <label class="col-sm-2 control-label">Borrow period:</label>
                    <div class="col-sm-2">
                        <input type="text" id="date_id5" class="form-control "  name="return_date5" value="" >
                    </div>
                    <div class="col-sm-1" style="margin-top:5px;">
                         <a  class="button " onclick="delete_row('book5','book_id5','date_id5');" ><i class="fa fa-minus"></i></a>
                    </div>
                    </div>
               </div>
                    <br>
                <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-5">
                      <button type="submit" class="btn btn-info">Confirm borrow</button>
                  </div>
                </div>
        </form>
         
    </div>               
            </div>
            <!----CREATION FORM ENDS-->
        </div>
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript">
 
    $(document).ready(function($)
    { $book2 = 0;
    $book3 = 0;
    $book4 = 0;
    $book5 = 0;
    $day = $('#day').val();
   
      var aavailableTags = $('#booklist').find('option').map(function () {
            return this.value;
        }).get();
       
        $('#book_id').autocomplete({ source: aavailableTags });

       var availableTags = $('#studentlist').find('option').map(function () {
            return this.value;
        }).get();
        $('#student').autocomplete({ source: availableTags });

       
 var nativedatalist = !!('list' in document.createElement('input')) && 
            !!(document.createElement('datalist') && window.HTMLDataListElement);

        if (!nativedatalist) {
            $('input[list]').each(function () {
                var availableTags = $('#' + $(this).attr("list")).find('option').map(function () {
                    return this.value;
                }).get();
                $(this).autocomplete({ source: availableTags });
            });
        }




        var datatable = $("#table_export").dataTable();
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        
    });


$('#add').click(function(){
   

    if($book2 ==0){
    $("#book2").removeClass('hide');
    $('#book2').show();
    $('#date_id2').val($day);
    $book2 =1;
}

    else if($book2==1 && $book3==0){
        $("#book3").removeClass('hide');
    $('#book3').show();
    $('#date_id3').val($day);
        $book3=1;
    }
    else if($book2==1 && $book3==1 && $book4==0){
         $("#book4").removeClass('hide');
         $('#book4').show();
         $('#date_id4').val($day);
            $book4=1;
    }
    else if($book2==1 && $book3 ==1 && $book4==1){
        $("#book5").removeClass('hide');
        $('#book5').show();
        $('#date_id5').val($day);
        $book5=1;
    } 
})

    function delete_row(e_id,b_id,d_id){
       $e_id = '#'.concat(e_id);
     
      var book = document.getElementById(b_id);
      var date = document.getElementById(d_id);
       book.value='';
       date.value='';
        
       $($e_id).addClass('hide');
       $($e_id).hide();
       switch(e_id){
        case 'book2' : $book2=0;break;
        case 'book3' : $book3=0;break;
        case 'book4' : $book4=0;break;
        case 'book5' : $book5=0;break;
       }
    }


</script>
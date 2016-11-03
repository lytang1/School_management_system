<div class='contrent'>
<?php foreach ($books as $book) {
	$student_id = $book['student_id'];break;
}
?>
	 <?php echo form_open(base_url() . 'index.php?admin/return_book/create/'.$student_id, array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
	 <table class="table table-bordered datatable" style="text-align:center !important">
	 	<tr>
	 		<th><center>Student</center></th>
	 		<th><center>Book title</center></th>
	 		<th><center>Borrow date</center></th>
	 		<th><center>Due date</center></th>
	 		<th><center>Return</center></th>
	 	</tr>
	 	<?php foreach ($books as $row):?>
	 	<tr>
	 		<td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?></td>
	 		<td><?php echo $this->db->get_where('book',array('book_id'=>$row['book_id']))->row()->name;?></td>
	 		<td><?php echo date('Y-m-d',$row['borrow_date']);?></td>
	 		<td><?php echo date('Y-m-d',$row['return_date']);?></td>
	 		<td><input type="checkbox" name='return_id[]' value="<?php echo $row['book_id'];?>" class="form-group"></td>
	 	</tr>
	 <?php endforeach;?>
	 </table>
	 	 <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-5">
                      <button type="submit" class="btn btn-info">Confirm </button>
                  </div>
                </div>
	  </form>
	  <br><br><br><br><br>
	    <a   href="<?php echo base_url();?>index.php?admin/borrow_book/" ><img align=right src="<?php echo base_url();?>assets\images\back.jpg" height=30px; style="padding-right:30px"></a>         
</div>
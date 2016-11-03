<div class="row	">

<center>
    <a onClick="PrintElem('#print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print 
        <i class="entypo-print"></i>
    </a>
</center>
<?php echo form_open(base_url() . 'index.php?admin/view_weekly/search/'.$student_id, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
 	<section >
 			<label class="control-label col-sm-1" style="text-align:right">From </label>
 			<section class='col-sm-2'>
 				<input type="text" style="border-color:#ebebeb" data-date-format="yyyy/mm/dd" class="form-control datepicker" value="<?php echo $from_date;?>" name="from_date"  data-start-view="2">
 			</section>
 			<label class="control-label col-sm-1 " style="text-align:right">To </label>
 			<section class='col-sm-2 '>
 				<input type="text" style="border-color:#ebebeb" data-date-format="yyyy/mm/dd" class="form-control datepicker" value="<?php echo $to_date;?>" name="to_date"  data-start-view="2">
 			</section>
 	</section>
 	<input type="hidden" value="<?php echo $class_name;?>" name='cname'>
 	<section>
 		<button type="submit" class="btn btn-info ">Search</button>
 	</section>
 </form>   
    <br><br>
	<div id="print">
<table>
	<tr>
			<td>Name :</td><td><h4><b><?php echo $student_name;?></b></h4></td>
	</tr>
	<tr>
			<td>Class :</td><td><h4 title="<?php echo $grade_name.', '.$language.', '.$study_time;?>"><?php echo $class_name ;?></h4></td>
	</tr>
</table>

	<table class="table datatable table-bordered"  style="text-align:center">
		<thead>
		<tr >
			<th ><div><center>Date</center></div></th>
			<th ><div><center>Day of week</center></div></th>
			<th ><div><center>Present</center></div></th>
			<th ><div><center>Absent</center></div></th>
			<th ><div><center>Comment</center></div></th>
		</tr>
	
		</thead>
		<tbody>
		<?php foreach ($attendances as $row) :?>
			
		<tr>
			<td><?php echo $row['date'];?></td>
			<td><?php echo date('D',strtotime($row['date']));?></td>
			<td>
			<?php $att=0;$p=0;$m =0;
			$at_time=$this->db->get_where('attendance_time',array('attendance_time_id'=>$row['attendance_time_id']))->result_array();
			 foreach ($at_time as $row1) {
			 	
			 
			 if($study_time=='Full time'){$max = 6; $m= $max;$att = 
			 	$row1['first_session']+$row1['second_session']+$row1['third_session']+$row1['forth_session']+$row1['fifth_session']+$row1['sixth_session'];}
			elseif($study_time=='Part time afternoon'){ $max = 3;$m=$max; $att = $row1['forth_session']+$row1['fifth_session']+$row1['sixth_session'];}
			elseif($study_time=='Part time morning'){ $max = 3;$m=$max; $att = $row1['first_session']+$row1['second_session']+$row1['third_session'];}
			if($att>$max){$m=$max*2;}
			$p= $m - $att; 
			}?> 
			<?php echo $p;?>
			</td>
			<td><?php echo $att;?></td>
			<td><?php if(($max==3 && $att<=3 &&$att>0)||($max==6 && $att<=6 &&$att>0)){echo "Absence without permission";} elseif(($max==3 && $att<=6 &&$att>0)||($max==6 && $att<=12 &&$att>0))echo "Absence with permission";?></td>
			
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>

	<h5>Presence and absence note by hour</h5>
	<h5> Maximum hours of <?php echo $study_time;?> is <?php echo $max;?> hours	</h5>
	</div>
</div>
<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('<body><br><br><br><br><br><br><br>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>

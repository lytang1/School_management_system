<!--DISPLAY EMPLOYEE PERFORMANCE AND NOTE THE GRADE OF EMPLOYEE PERFORMANCE-->

<div class="row	">

<center>
    <a onClick="PrintElem('#print')" class="btn btn-default btn-icon icon-left hidden-print pull-right action-button">
        Print 
        <i class="entypo-print"></i>
    </a>
</center>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_form/" >Manage form
</a>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_question_list/" >Manage question
</a>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_note/">Note employee performance
</a> 
    <br><br>
	<div id="print">


	<table class="table datatable table-bordered"  style="text-align:center">
		<thead>
		<tr >
			<td rowspan="2"><div><center>Employee id</center></div></td>
			<td rowspan="2"><div><center>Name</center></div></td>

			<th colspan="12"><div><center>Month</center></div></th>
			<!-- <th ><div><center>Absent</center></div></th>
			<th ><div><center>Comment</center></div></th> -->
		</tr>
	
		</thead>
		<tbody>
		
		
		<tr>
			
		<td></td>
		<td></td>
			<?php for ($i=0; $i < 12; $i++):?>
			<td>
			 	
			 <?php $year = date('Y',now()); $m=8+$i; if($m>12){
			 	$m = $i+8-12;
			 } $d = $year.'-'.$m.'-'.'01'; echo date('M',strtotime($d));?>
		
			</td>
		<?php endfor;?>
			
			
			
		</tr>
		
			<?php $r=-1; $is_exist=0; foreach ($employees as $row):$is_exist=0; ?>
		 <tr href="<?php echo base_url();?>index.php?admin/employee_performance_detail/<?php echo $row['employee_id_code'];?>">
			<td style="cursor: pointer;"><?php echo $row['employee_id_code'];?></td>
			<td style="cursor: pointer;"><?php echo $row['name'].' '.$row['family_name'];?></td>
			<?php $length = sizeof($performances);
			
			for($i=0;$i<$length;$i++){
				if($performances[$i]['employee_id']==$row['employee_id_code'])
				:?>
			<?php $is_exist=1; for ($j=0; $j < 12; $j++):?>
				<td style="cursor: pointer;"><?php echo $marks[$i][$j];?></td>
			<?php endfor;?>
			<?php break; endif; ?>
			<?php } ?>

			<?php if($is_exist==0):?>
				<?php  for ($j=0; $j < 12; $j++):?>
				<td style="cursor: pointer;"> </td>
			<?php endfor;?>
		<?php endif;?>
		</tr>
		<?php endforeach;?>
		</tbody>
	</table>

	
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


    $(document).ready(function(){
    $('table tr').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});


</script>

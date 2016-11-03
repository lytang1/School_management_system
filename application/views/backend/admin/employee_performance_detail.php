<!--DISPLAY EMPLOYEE PERFORMANCE AND NOTE THE GRADE OF EMPLOYEE PERFORMANCE-->

<div class="row	">

<center>
    <a onClick="PrintElem('#print')" class="btn btn-default btn-icon icon-left hidden-print pull-right action-button">
        Print 
        <i class="entypo-print"></i>
    </a>
</center>
<!-- <a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_form/" >Manage form
</a>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_question_list/" >Manage question
</a>
<a class="btn btn-default pull-right action-button" href="<?php echo base_url();?>index.php?admin/e_performance_note/">Note employee performance
</a>  -->
    <br><br>
	<div id="print">

<h4>Employee <?php echo $employee_name;?></h4>

	<table class="table datatable table-bordered"  style="text-align:center">
		<thead>
		<tr >
			<th ><div><center>Date</center></div></th>
			<th><div><center>Form title</center></div></th>
			<th ><div><center>Question</center></div></th>

			<th colspan="12"><div><center>Grade</center></div></th>
			<!-- <th ><div><center>Absent</center></div></th>
			<th ><div><center>Comment</center></div></th> -->
		</tr>
	
		</thead>
		<tbody>
		
		
	 
		
			<?php  foreach ($performances as $row): ?>
		<tr>
			<td><?php echo $row['date'];?></td>
			<td><?php echo $row['form_title'];?></td>
			<td><?php echo $row['question'];?></td>
			<td><?php  if($row['answer_point']<=10 && $row['answer_point']>=8.1){
                $grade ='A';
               }elseif($row['answer_point']<=8 && $row['answer_point']>=6.1)
               {
                $grade = 'B';
               }elseif($row['answer_point']<=6 && $row['answer_point']>=4.1)
               {
                $grade = 'C';
               }elseif($row['answer_point'] <=4 && $row['answer_point']>=2.1)
               {
                $grade = 'D';
               }elseif($row['answer_point']>=2 && $row['answer_point'] >0)
               {
                $grade = 'E';
               }
			echo $grade;?></td>
		</tr>
		<?php endforeach;?>

		<?php if(!$performances):?>
			<td colspan="4">No data</td>
		<?php endif;?>
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

</script>

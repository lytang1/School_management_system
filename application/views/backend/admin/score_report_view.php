<style >
	.attendance-select{
		 background:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='50px' height='50px'><polyline points='46.139,15.518 25.166,36.49 4.193,15.519'/></svg>");
  background-color:#F0F0F1;
  background-repeat:no-repeat;
  background-position: right 4px top 10px;
  background-size: 8px 8px;
  color:black !important;

padding-top:4px;
padding-bottom: 4px;
 
  font-family:arial,tahoma;
  font-size:12px;
  color:#fff;
  text-align:center;
  text-shadow:0 -1px 0 rgba(0, 0, 0, 0.25);

  -webkit-appearance: none;
  border:0;
  outline:0;
 

	}
	.note-attendance{
		padding-left:30px;
	}
</style>
			<br>
			
			<center>
    <a onClick="PrintElem('#print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print 
        <i class="entypo-print"></i>
    </a>
</center>

			
			<section id='print'>
			<h4 title="<?php echo $grade_name, $language, $study_time ;?>">Class : <?php echo $class_name;?></h4>
			<h4><?php echo $period_name;?></h4>
		<table class="table table-bordered"  style="text-align:center" id='both'>
			<tr>
				<th></th>
				
				<th colspan="<?php echo sizeof($subject_ids);?>"><center>Subjects</center></th>
				<th></th>
			</tr>
			<tr>
				<td><center>Student name</center></td>
				<?php foreach ($subject_ids as $row_subject):?>
					<td><?php echo $row_subject['name'];?></td>
				<?php endforeach;?>
				<td>Average score</td>
			</tr>
		
			<?php $c=0; foreach ($students as $row):$total=0;?>
				
			<tr >
				<td ><?php echo ucfirst($row['name']);?> </td>
				
				<?php 
					
					for ($j=0;$j<sizeof($subject_ids);$j++):
			$sub_score = $this->db->get_where('score',array('period_id'=>$period_id,'subject_id'=>$subject_ids[$j]['subject_id'],'student_id'=>$row['student_id']))->row()->score_obtain;
				$total = $total + $sub_score;?>

				<td ><?php echo $sub_score;?>
				</td>
			<?php endfor;?>
				<td><?php $avg = $total/sizeof($subject_ids); echo $avg; ?></td>
			</tr>
		<?php endforeach;?>
		</table>

		
		
		
		</section>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js"></script>
		<script>
		  
			 jQuery(document).ready(function($)
		    {
	

		    	// $('select').change(function(){
		    	// 	var selected_value = $('select').val();
		    	// 	if(selected_value == '1')
		    	// 	{
		    	// 		$('select').css("background-color", "#cc2424");
		    	// 	}
		    	// 	if(selected_value == '2')
		    	// 	{
		    	// 		$('select').css("background-color", "#ffb400");
		    	// 	}
		    	// });
		    	
			  
			});
		</script>
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
        mywindow.document.write('</head><body><br><br><br><br><br><br><br>');
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
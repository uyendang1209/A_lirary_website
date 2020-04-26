<?php 
require_once("includes/config.php");
// code user email availablity
if(!empty($_POST["studentid"])) {
    $studentid= $_POST["studentid"];
    if (0) {
		echo "error : You did not enter a valid sid.";
    }
    else{
	$sql ="SELECT StudentId FROM tblstudents WHERE StudentId=:studentid";
$query= $dbh -> prepare($sql);
$query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> studentid already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> studentid available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}
?>
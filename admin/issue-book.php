<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['issue']))
{
$studentid=strtoupper($_POST['studentid']);
$bookid=$_POST['bookid'];
$sql="INSERT INTO  tblissuedbookdetails(StudentID,BookId) VALUES(:studentid,:bookid)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Book issued successfully";
header('location:manage-issued-books.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:manage-issued-books.php');
}

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Issue a new Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/rolldate.min.js"></script>
    <!-- <script src="assets/js/moment.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
    <!-- BOOTSTRAP SCRIPTS  -->
    <!-- <script src="assets/js/bootstrap.js"></script> -->
      <!-- CUSTOM SCRIPTS  -->
    <!-- <script src="assets/js/custom.js"></script> -->
<script>
// function for get student name
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <!-- <div class="content-wra -->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issue a New Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
Issue a New Book
</div>
<div class="panel-body">
<form role="form" method="post" onSubmit="valid()">

<div class="form-group">
<label>Student id<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off"  required />
</div>

<div class="form-group">
<span id="get_student_name" style="font-size:16px;"></span> 
</div>





<div class="form-group">
<label>ISBN Number of book<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()" autocomplete="off"  required="required" />
</div>

 <div class="form-group">
  <span id="get_book_name" style="font-size:16px;"></span>
 </div>

 <div class="form-group">
<label>Issue date</label>
<input class="form-control" type="text" value="<?php $t=time(); echo htmlentities(date("Y-m-d h:m:s",$t));?>"  required="required" readonly/>
</div>
<script>
function valid(){
  var expdate = Date.parse($('#expdate').val());
  var cur_date = Math.round(new Date().getTime());
  console.log(expdate)
  if (expdate < cur_date){
    console.log("test")
    $('#submit').prop('disabled',true);
    $("@expdate-status").html("exp date must greater than start date");
  } else {
    $('#submit').prop('disabled',false);
    $("@expdate-status").html("");
  }
}
$('#expdate').change(valid);
</script>
 <div class="form-group">
<label>Expired date<span style="color:red;">*</span></label>
<input readonly type="text" id="expdate" class="form-control" placeholder="YYYY-MM-DD hh:mm:ss" required="required" onchange ="valid()">
<span id="expdate-status" style="font-size:12px;"></span>
</div>
<script>
new Rolldate({
    el: '#expdate',
    format: 'YYYY-MM-DD hh:mm:ss',
    beginYear: 2020,
    endYear: 2100,
    lang: { 
      title: 'Select A Date', 
      cancel: 'Cancel', 
      confirm: 'Confirm', 
      year: '', 
      month: '', 
      day: '', 
      hour: '', 
      min: '', 
      sec: '' 
    }
})
</script>

 <button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <!-- <script src="assets/js/custom.js"></script> -->

</body>
</html>
<?php } ?>
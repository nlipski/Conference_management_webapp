<?php include 'confdb.php'; ?>

<!DOCTYPE HTML>
<html>
<head>
    <title>PHP Application</title>
</head>
<body>

<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 href=""  class="w3-wide"><b>Conference Management Application</b></h3>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="/index.php" class="w3-bar-item w3-button w3-light-grey">Home</a>
    <a href="/committee.php" class="w3-bar-item w3-button">Committee</a>
    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
      Jobs <i class="fa fa-caret-down"></i>
    </a>
	
    <div id="demoAcc1" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="/jobs.php" class="w3-bar-item w3-button">All Jobs</a>
      <a href="jobsbycompany.php" class="w3-bar-item w3-button">By Company</a>
    </div>
	<a onclick="myAccFunc2()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
      Attendees <i class="fa fa-caret-down"></i>
    </a>
	<div id="demoAcc2" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="attendeesbyclass.php" class="w3-bar-item w3-button">By Class</a>
      <a href="attendeesbycompany.php" class="w3-bar-item w3-button">By Company</a>
    </div>
	
    <a href="schedule.php" class="w3-bar-item w3-button">Schedule</a>
    <a href="hotel.php" class="w3-bar-item w3-button">Hotel Assignment</a>
    <a href="sponsors.php" class="w3-bar-item w3-button">Sponsors</a>
	<a onclick="myAccFunc3()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
      Edit <i class="fa fa-caret-down"></i>
    </a>
	<div id="demoAcc3" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="addattendee.php" class="w3-bar-item w3-button">Add</a>
	  <a href="#" class="w3-bar-item w3-button">Update</a>
      <a href="#" class="w3-bar-item w3-button">Remove</a>
    </div>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>


  <header class="w3-container w3-xlarge">
    <p class="w3-left"></p>
    <p class="w3-right">
    </p>
  </header>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:290px">
  <div class="w3-display-container w3-container" style="padding:10px" >
	<h1> Add attendee</h1>

	
	
  </div>
  <div  class="w3-container" style="padding:20px;background-color: #f2f2f2;" >
		<h3>Add a new attendee: </h3>
		<form class="w3-form" method="post">
			First name: <input class="w3-input" type="text" name="fName"><br>
			Last name: <input class="w3-input" type="text" name="lName"><br>
			Street: <input class="w3-input" type="text" name="street"><br>
			City: <input class="w3-input" type="text" name="city"><br>
			Province: <input class="w3-input" type="text" name="province"><br>
			Email: <input class="w3-input" type="text" name="email"><br>
			Attendee type:
			<select class="w3-select w3-border" name="formTier">
				
				<option value="">Select a type of attendee</option>
				<option value="Student">Student</option>
				<option value="Professional">Professional</option>
				<option value="Sponsor">Gold</option>
			</select>
			<input class="w3-button" type="submit" style="margin-top:10px">
		</form>
	</div>
	<?php
		if(isset($_POST['fName']) and isset($_POST['lName']) and isset($_POST['formTier'])) {
			
			
			$sth = $dbh->prepare("select * from attendee");
			$sth->execute();
			
			$num = $sth->rowCount() + 1;
			
				  
			$sql = $dbh->prepare("INSERT INTO attendee
					VALUES ($num,'".$_POST['fName']."', '".$_POST['lName']."', '".$_POST['street']."', '".$_POST['city']."', '".$_POST['province']."','".$_POST['email']."','".$_POST['formTier']."')");
    
			$sql->execute();
			
			if ($_POST['formTier'] == "Student"){
				$query1 = $dbh->prepare("CREATE VIEW temphousing as SELECT COUNT(student.aID) as numOccupied, student.roomNumber from student group by (student.roomNumber);");
				$query1->execute();
				$query2 = $dbh->prepare("CREATE VIEW accom as SELECT * from room NATURAL JOIN (temphousing) where room.roomNumber = temphousing.roomNumber;");
				$query2->execute();
				$query3 = $dbh->prepare("SELECT roomNumber, MAX(accom.numBeds *2 - accom.numOccupied) FROM accom where accom.numBeds *2 > accom.numOccupied;");
				$query3->execute();
				$roomNum = ($query3->fetch())['roomNumber'];
				$sql_student = $dbh->prepare("INSERT INTO student values($num, $roomNum)");
				$sql_student->execute();
				$query4 = $dbh->prepare("DROP VIEW temphousing;");
				$query4->execute();
				$query5 = $dbh->prepare("DROP view accom;");
				$query5->execute();
				echo "<h1> Student added to room $roomNum </h1>";
			}
			echo "<h1> Attendee added </h1>";
			
		}
	?>
</div>



<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc1");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
function myAccFunc2() {
  var x = document.getElementById("demoAcc2");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
function myAccFunc3() {
  var x = document.getElementById("demoAcc3");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
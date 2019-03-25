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
	  <a href="editsession.php" class="w3-bar-item w3-button">Update</a>
      <a href="removecompany.php" class="w3-bar-item w3-button">Remove</a>
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
  <div class="w3-display-container w3-container">
    <div class="w3-display-topleft" style="padding:44px 68px">
	
   </div>
	
	<h1>Attendees by company</h1>

	<form class="w3-form" method="post">
	<?php
		$sth = $dbh->prepare('select distinct companyName from company');
		$sth->execute();
		echo "<select class=\"w3-select w3-border\" name=\"formCom\">";
		echo "<option value=\"\">Select a company...</option>";
		while ($row = $sth->fetch()) {
			echo "<option value=\"$row[companyName]\">$row[companyName]</option>";
		}
		echo "</select>";
		
	?>
	<input class="w3-button "type="submit" name="Submit" value="Choose">
	</form>
	<?php
		if(isset($_POST['formCom']) ) {
			
			$userInput = $_POST['formCom'];
			echo "<h3>List of attendees from ".$userInput." :</h3>";
			$sth = $dbh->prepare("select * from attendee where aID in (select aID from sponsor where companyName= \"$userInput\")");
			$sth->execute();
			$sth2 = $dbh->prepare("select * from company where companyName= \"$userInput\"");
			$sth2->execute();
			$row2 = $sth2->fetch();
			echo "<table class=\"w3-table\">";
			echo "<tr>";
			echo "<td><b> First Name</b></td>";
			echo "<td><b> Last Name</b></td>";
			echo "<td><b> Sponsorship Tier</b></td>";
			echo "</tr>";
			while ($row = $sth->fetch()) {
                   echo "<tr>";
                   echo "<td>".$row[fName]."</td>";
                   echo "<td>".$row[lName]."</td>";
				   echo "<td>".$row2[sponsorship_tier]."</td>";
                   echo "</tr>";
               }
			echo "</table>";
		}
	?>
</div>
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
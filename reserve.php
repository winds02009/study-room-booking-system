<?php
	//Student Name: WONG Tsz Fung
	//Student No: 23043094S
	//Class: SEHS4517 IA
	session_start();
	$msg = isset($_SESSION["msg"]) ? $_SESSION["msg"] : "";
	$fName = isset($_SESSION["fName"]) ? $_SESSION["fName"] : "";
	$StudentID = isset($_SESSION["SID"]) ? $_SESSION["SID"] : "";
	$Email = isset($_SESSION["Email"]) ? $_SESSION["Email"] : "";
	$Campus = isset($_SESSION["campus"]) ? $_SESSION["campus"] : "";
	$Date = isset($_SESSION["date"]) ? $_SESSION["date"] : "";
	$Timeslot = isset($_SESSION["Timeslot"]) ? $_SESSION["Timeslot"] : "";
	
	$nameError = isset($_SESSION["fName"])  ? $_SESSION["fName"]  : "";
	$sidError = isset($_SESSION["SID"])  ? $_SESSION["SID"]  : "";
	$camError = isset($_SESSION["campus"]) ? $_SESSION["campus"] : "";
	$dateError = isset($_SESSION["date"]) ? $_SESSION["date"] : "";
	$emailError = isset($_SESSION["Email"]) ? $_SESSION["Email"] : "";
	

?>

<html lang="en">
	<head>
		<title>Study Room Booking System</title>
		<style> 
			td {border: 1px solid black;}
		</style>
	</head>
	<body>
		<h1 align="center">Study Room Booking System</h1>
		<h3 align="center">Welcome 
			<?php
				if (isset($_COOKIE['fName'])) {
					echo "back! " . ucwords(strtolower(trim($_COOKIE['fName'])));
				}
				else {
					echo "!";
				}
			?>	
		</h3>
		<p><?=$msg?></p>
		<table align="center">
			<form method="post" action="validateform.php">
				<tr>
					<td>
						<label for="fName">Name:
						<input id="fName" type="text" name="fName" value="<?=$fName?>" placeholder="Full Name"/><?$nameError;?>
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td>	
						<label for="SID">Student ID: </label>
						<input id="SID" type="text" name="SID" value="<?=$StudentID?>" placeholder="12345678S" /></label><?$sidError;?> 
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="Email">Email:</label>
						<input id="Email" type="Email" name="Email" value="<?=$Email?>" placeholder="123@domain" required/ >
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						Location:<?$campError;?><br/><br/>
						<input type="radio" name="campus" value="HHB" id="HHB" <?php if ($Campus != "WK") echo "checked"; ?>>
						<label for="HHB">Hung Hom Bay</label>
						<br/>
						<input type="radio" name="campus" value="WK" id="WK" <?php if ($Campus == "WK") echo "checked"; ?>>
						<label for="WK">West Kowloon</label>
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="date">Date:</label><span style="color:#ff0000";>* <?$dateError;?> </span>
						<input id="date" type="date" name="date" value="<?=$Date?>" required>
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td>										
						<label for="Timeslot">Choose the time:</label>
						<select name="Timeslot" id="Timeslot">
							<option value="1" <?php if ($Timeslot == "1") echo "selected"; ?>>09:00 – 12:00</option>
							<option value="2" <?php if ($Timeslot == "2") echo "selected"; ?>>12:00 – 15:00</option>
							<option value="3" <?php if ($Timeslot == "3") echo "selected"; ?>>15:00 – 18:00</option>
							<option value="4" <?php if ($Timeslot == "4") echo "selected"; ?>>18:00 – 21:00</option>
						</select>
						<br/><br/>
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="reset" id="reset" value="Reset"/>
						<input type="submit" id="btn-submit" value="Reserve Now"/>
					</td>
				</tr>
			</form>
		</table>
	</body>
</html>
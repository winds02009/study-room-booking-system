<?php

//Student Name: WONG Tsz Fung
//Student No: 23043094S
//Class:SEHS4517IA


session_start();
session_unset();

include_once 'db.php';

setcookie("fName", $_POST['fName'], time() + 60); 
setcookie("SID", $_POST['SID'], time() + 60); 
setcookie("Email", $_POST['Email'], time() + 60);
setcookie("campus", $_POST['campus'], time() + 60); 
setcookie("date", $_POST['date'], time() + 60); 
setcookie("Timeslot", $_POST['Timeslot'], time() + 60);

function validDate($str) {
    list($year, $month, $day) = explode('-', trim($str));
    return checkdate($month, $day, $year) && (trim($str) > date("Y-m-d"));
}

function checkDuplicateData($Timeslot, $Date, $Campus, $connection) {
    $query = "SELECT * FROM booking WHERE slot = ? AND date = ? AND campus = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iss", $Timeslot, $Date, $Campus);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $_POST['fName'];
    $StudentID = $_POST['SID'];
    $Email = $_POST['Email'];
    $Campus = $_POST['campus'];
    $Date = $_POST['date'];
    $Timeslot = $_POST['Timeslot'];
    
    if (!preg_match('/^\d{8}[A-Z]$/i', $StudentID)) {
        $message = "Error! Invalid Student ID format.";
        $message .= " You will be redirected in 5 seconds.";
        header("Refresh: 5; URL='reserve.php'");
    } else {
        if (validDate($Date) && trim($fName) != "" ) {
            $fName  = ucwords(strtolower(trim($fName)));
            
            $TimeslotName = getTimeslotName($Timeslot); // Function to get Timeslot name

            if (checkDuplicateData($Timeslot, $Date, $Campus, $connection)) {
                $message = "Sorry, all time slots for " . $Campus . " on " . $Date . " have been fully booked.";
                $message .= " You will be redirected in 5 seconds.";
                header("Refresh: 5; URL='reserve.php'");
            } else {
                $message = "Success! Your reservation has been confirmed.";
                $message .= " Here are your details:<br>";
                $message .= "Name: " . $fName . "<br>";
                $message .= "Student ID: " . $StudentID . "<br>";
                $message .= "E-mail: " . $Email . "<br>";
                $message .= "Date: " . $Date . "<br>";
                $message .= "Campus: " . $Campus . "<br>";
                $message .= "Timeslot: " . $TimeslotName . "<br>";

                setcookie("fName", $fName, time() + 60, "/");
                session_destroy();

                // Establish database connection
                $pdo = new PDO("mysql:host=localhost; dbname=SEHS45171A","root","");
                // Prepare and execute SQL query
                $sql = $pdo->prepare("INSERT INTO booking (fname, sid, email, campus, date, slot) VALUES (:fname, :sid, :email, :campus, :date, :slot)");
                $sql->bindParam(':fname', $fName);
                $sql->bindParam(':sid', $StudentID);
                $sql->bindParam(':email', $Email);
                $sql->bindParam(':campus', $Campus);
                $sql->bindParam(':date', $Date);
                $sql->bindParam(':slot', $Timeslot);
                $sql->execute();
            }
        } else {
            
           
            
            if (trim($fName) == "") {
                $_SESSION['nameError'] = "Please enter your name";
            }
            
            if (empty($Campus)) {
                $_SESSION['campusError'] = "Please select a location";
            }
            
            if (!validDate($Date)) {
                $_SESSION['dateError'] = "Please enter a valid date";
            }
                       
            if (empty($StudentID)) {
                $_SESSION['SIDError'] = "Please enter a valid student ID";
            }
                
			// Handle validation errors
			$_SESSION['fName'] = $fName;
            $_SESSION['SID'] = $StudentID;
            $_SESSION['Email'] = $Email;
            $_SESSION['campus'] = $Campus;
            $_SESSION['date'] = $Date;
            $_SESSION['Timeslot'] = $Timeslot;	
				
            header("Location: reserve.php");
			
			
        }
    }
}

function getTimeslotName($slot) {
    switch ($slot) {
        case 1:
            return "09:00 - 12:00";
        case 2:
            return "12:00 - 15:00";
        case 3:
            return "15:00 - 18:00";
        case 4:
            return "18:00 - 21:00";
        default:
            return "Unknown";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Confirmation</title>
</head>
<body>
<?php
if (isset($message)) {
    echo $message;
}
?>
</body>
</html>

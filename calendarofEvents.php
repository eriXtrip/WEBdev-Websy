<?php
session_start();
    // Check if the user is logged in, if not redirect to login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("location: login.php");
        exit;
    }

    // Process logout
    if (isset($_GET['logout'])) {
        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page after logout
        header("location: login.php");
        exit;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="css/calendarofEvents.css" rel="stylesheet">
    <title>iEMS</title>
</head>

<body>
    <div class="mainboard">
        <div class="top">
            <img src="assets/Male User.png" id="user">
            <img src="assets/rectangle with bell.png" id="notif">
        </div>
        <div class = "container">
            
          <div class="coEvents">
            <h1>CALENDAR OF EVENTS</h1>
            <p>S.Y 2024 - 2025</p>
          </div>
          <div class="monthbackbutton">
            <a href=""><img src="assets/Back.png"></a>
            <p>MAY</p> 
            <a href=""><img src="assets/Backback.png"></a>
          </div>

          <div class="events">
            <div class="dayevent">
                <div class="divider"><h2>01</h2></div>
                <div class="divider"><img src="assets/eventpic1.png"></div>
                <div class="divider"><h3>LABOR DAY</h3></div>
                <div class="divider"><p>A Tribute for the Hardworking Heart of the Philippines</p></div>
            </div>
            <div class="dayevent">
                <div class="divider"><h2>02 - 15</h2></div>
                <div class="divider"><img src="assets/eventpic2.png"></div>
                <div class="divider"><h3>SPG/SSG ELECTIONS</h3></div>
                <div class="divider"><p>Supreme Pupil Government and Supreme Student Government Election Period </p></div>
            </div>
            <div class="dayevent">
                <div class="divider"><h2>01</h2></div>
                <div class="divider"><img src="assets/eventpic3.png"></div>
                <div class="divider"><h3>EARLY REGISTRATION</h3></div>
                <div class="divider"><p> Early Enrollment Opens for the Next Academic Term</p></div>
            </div>
          </div>
        </div>
    </div>
    <div class="sideboard">
            <div class="box2">
                <img src="assets/Logo.png" alt="logo" id="logoHeader">
                <div class="schoolname">
                    <h5><span style="color: #FCA304;">IBALON</span></h5>
                    <h5><span style="color: #039B11;">CENTRAL</span></h5>
                    <h5><span style="color: #5582BF;">SCHOOL</span></h5>
                </div>
            </div>
            <p style="margin-left: 10px;">Main Menu</p>
            <div class="menu">
                <button class="option" onclick="location.href='adminoverview.php'" style="cursor: pointer;">
                    <img src="assets/Overview.png"  class="option-logo">
                    <a href="adminoverview.php">Overview</a>
                </button>
                <button class="option" onclick="location.href='classSchedule.php'" style="cursor: pointer;">
                    <img src="assets/Tear-Off Calendar.png"  class="option-logo" >
                    <a href="classSchedule.php">Class Schedule</a>
                </button>
                <button class="option" onclick="location.href='studentsData.php'" style="cursor: pointer;">
                    <img src="assets/Data Provider.png"  class="option-logo">
                    <a href="studentsData.php">Students Data</a>
                </button>
                <button class="option active" onclick="location.href='calendarofEvents.php'" style="cursor: pointer;">
                    <img src="assets/Timetable.png"  class="option-logo">
                    <a href="calendarofEvents.php">School Calendar</a>
                </button>
                
            </div>
            <div class="logoutline">
            <p>_____________________________</p>
            <button class="logout" id="logoutButton">
                <a href="?logout=1">Log Out</a>
            </button>
            </div>
            <div class="needhelp">
                <h1>Need Help?</h1>
                <div class="contact">
                    <div>
                        <p style="text-align: left;">You can reach us at (052) 821-7921, 820-5959, 820-5003, or by visiting our official <a href="fbaccount">Facebook</a> page.</p>
                    </div>
                    <div>
                        <img src="assets/image 6.png" alt="manquest" id="needhelpman">
                    </div>
                </div>
            </div>
        </div>
    
    <script>
        document.getElementById("logoutButton").addEventListener("click", function() {
            window.location.href = "?logout=1";
        });
    </script>
    
</html>
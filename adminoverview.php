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

    try {
        require_once "dbh.inc.php";
        $query = "SELECT COUNT(*)
          FROM STUDENT
          WHERE Gender = :GenderSearch;";

        $stmt = $pdo->prepare($query);
        $genderSearch = 'M'; // Male
        $stmt->bindParam(":GenderSearch", $genderSearch);
        $stmt->execute();
                
        $Male = $stmt->fetchColumn();

        $query = "SELECT COUNT(*)
                FROM STUDENT
                WHERE Gender = :GenderSearch;";

        $stmt = $pdo->prepare($query);
        $genderSearch = 'F'; // Female
        $stmt->bindParam(":GenderSearch", $genderSearch);
        $stmt->execute();
                
        $Female = $stmt->fetchColumn();

        // Retrieve total number of students
        $query = "SELECT COUNT(*) FROM STUDENT";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $totalStudents = $stmt->fetchColumn();

        // Retrieve counts for each grade level
        $grades = array();
        for ($i = 1; $i <= 6; $i++) {
            $query = "SELECT COUNT(*) FROM STUDENT WHERE Grade_level = :grade";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":grade", $i);
            $stmt->execute();
            $grades[$i] = $stmt->fetchColumn();
        }
            
    } catch (PDOException $e) {
        // Log the error and display a user-friendly message
        error_log("Query failed: " . $e->getMessage());
        die("Something went wrong. Please try again later.");
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
    <link href="css/adminoverview.css" rel="stylesheet">
    <title>iEMS</title>
</head>

<body>
    <div class="mainboard">
        <div class="top">
            <img src="assets/Male User.png" id="user">
            <img src="assets/rectangle with bell.png" id="notif">
        </div>
        <div class="welcome">
            <div class="message">
                <h1>Hello, </h1>
                <p>We're thrilled to have you here! Dive into the heart of your operations, where every click shapes the course of your platform. Together, we'll uphold the standards of excellence and ensure smooth operations for all users. </p>
            </div> 
            <div class="kidspic">
                <img src="assets/girl and boy sitting on floor and watching tablet.png" id="kids">
            </div>
        </div>
        <div class="summary">
            <div class="rightsum">
                <div class="gender">
                    <div class="male">
                        <div class="logo">
                            <img src="assets/Boy.png" id="malelogo">
                        </div>
                        <div class="stat">
                            <p>TOTAL</p>
                            <p>Male Students</p>
                            <p style="color: black; font-size: 300%; font-weight: 800; margin-top:10%"><?php echo $Male?></p>
                        </div>
                    </div>
                    <div class="female">
                        <div class="logo">
                            <img src="assets/Girl.png" id="femalelogo">
                        </div>
                        <div class="stat">
                            <p>TOTAL</p>
                            <p>Female Students</p>
                            <p style="color: black; font-size: 300%; font-weight: 800; margin-top:7%"><?php echo $Female?></p>
                        </div>
                    </div>
                </div>
                <div class="announcement">  
                    <div class="afeed">
                        <h3>ANNOUNCEMENT FEED</h3>
                    </div>
                    <div class="actualfeed">
                        <div class="feed" id="announcementFeed">
                            <!-- Announcements are added using js -->
                            <div class="announceblock">Jan 27 - Feb 23</div>
                            <div class="announceblock">July 29, 2024</div>
                        </div>
                        <div class="footfeed" id="announcementdesc">
                            <div class="description">
                                <h3>Early Registration</h3>
                                <p>The Early Registration of incoming Kindergarten,<br> Grades 1, 7 and 11 for School Year 2024-2025 <br> shall start on January 27 to February 23, 2024.</p>
                            </div>
                            <div class="description">
                                <h3>First Day of Class</h3>
                                <p>The Department of Education (DepEd) has <br> formally announced the opening of School Year <br> 2024-2025 for basic education on July 29, 2024. <br>DepEd Order No. 003 series of 2024 on Feb.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="piechart">
                <div class="numstud">
                    <h3>NUMBER OF STUDENTS PER GRADE</h3>
                    <canvas id="gradePieChart" class="javaPI"></canvas>
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
                <button class="option active" onclick="location.href='adminoverview.php'" style="cursor: pointer;">
                    <img src="assets/Overview.png"  class="option-logo">
                    <a href="adminoverview.php">Overview</a>
                </button>
                <button class="option" onclick="location.href='classSchedule.php'" style="cursor: pointer;">
                    <img src="assets/Tear-Off Calendar.png"  class="option-logo">
                    <a href="classSchedule.php">Class Schedule</a>
                </button>
                <button class="option" onclick="location.href='studentsData.php'" style="cursor: pointer;">
                    <img src="assets/Data Provider.png"  class="option-logo">
                    <a href="studentsData.php">Students Data</a>
                </button>
                <button class="option" onclick="location.href='calendarofEvents.php'" style="cursor: pointer;">
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
        
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('gradePieChart').getContext('2d');
                var gradePieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
                        datasets: [{
                            label: 'Number of Students',
                            data: <?php echo json_encode(array_values($grades)); ?>,
                            backgroundColor: [
                                'rgba(202, 73, 140, 1)',
                                'rgba(162, 83, 155, 1)',
                                'rgba(185, 119, 172, 1)',
                                'rgba(207, 155, 189, 1)',
                                'rgba(230, 191, 206, 1)',
                                'rgba(253, 227, 223, 1)'
                            ],
                            borderColor: [
                                'rgba(202, 73, 140, 1)',
                                'rgba(162, 83, 155, 1)',
                                'rgba(185, 119, 172, 1)',
                                'rgba(207, 155, 189, 1)',
                                'rgba(230, 191, 206, 1)',
                                'rgba(253, 227, 223, 1)'
                            ],
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

                document.getElementById("logoutButton").addEventListener("click", function() {
                    window.location.href = "?logout=1";
                });
            </script>
    
</html>
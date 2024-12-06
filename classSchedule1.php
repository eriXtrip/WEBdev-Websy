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
    $query = "SELECT *
              FROM SECTION;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $SectionResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
  } catch (PDOException $e) {
      // Log the error and display a user-friendly message
      error_log("Query failed: " . $e->getMessage());
      die("Something went wrong. Please try again later.");
  }

  // Check if sectionSelect is set in the POST data
    if (isset($_GET['sectionName'])) {
        try {
            require_once "dbh.inc.php";

            // Retrieve selected section from GET data
            $selectedSection = $_GET['sectionName'];

            // Use selected section in SQL query
            $query = "SELECT 
                section_schedule.*, 
                subject_schedule.*, 
                TEACHER.TH_Prefix, 
                TEACHER.TH_First_Name, 
                TEACHER.TH_Middle_Name, 
                TEACHER.TH_Last_Name, 
                TEACHER.TH_Suffix
            FROM 
                section_schedule
            LEFT OUTER JOIN 
                subject_schedule ON section_schedule.Sched_ID = subject_schedule.Section_Sched
            LEFT OUTER JOIN 
                TEACHER ON subject_schedule.Teacher_ID = TEACHER.Teacher_ID
            WHERE 
                Section_Name = :selectedSection
                AND daySCHED = 'M';";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':selectedSection', $selectedSection);
            $stmt->execute();

            $schedM = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        try{

            require_once "dbh.inc.php";

            $query = "SELECT 
            section_schedule.*, 
            subject_schedule.*, 
            TEACHER.TH_Prefix, 
            TEACHER.TH_First_Name, 
            TEACHER.TH_Middle_Name, 
            TEACHER.TH_Last_Name, 
            TEACHER.TH_Suffix
            FROM 
                section_schedule
            LEFT OUTER JOIN 
                subject_schedule ON section_schedule.Sched_ID = subject_schedule.Section_Sched
            LEFT OUTER JOIN 
                TEACHER ON subject_schedule.Teacher_ID = TEACHER.Teacher_ID
            WHERE 
                Section_Name = :selectedSection
                AND daySCHED = 'T';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(':selectedSection', $selectedSection);

            $stmt->execute();

            $schedT = $stmt->fetchAll(PDO::FETCH_ASSOC);


        }catch (PDOException $e){
            die("Query failed: " . $e->getMessage());
        }

        try{

            require_once "dbh.inc.php";

            $query = "SELECT 
            section_schedule.*, 
            subject_schedule.*, 
            TEACHER.TH_Prefix, 
            TEACHER.TH_First_Name, 
            TEACHER.TH_Middle_Name, 
            TEACHER.TH_Last_Name, 
            TEACHER.TH_Suffix
            FROM 
                section_schedule
            LEFT OUTER JOIN 
                subject_schedule ON section_schedule.Sched_ID = subject_schedule.Section_Sched
            LEFT OUTER JOIN 
                TEACHER ON subject_schedule.Teacher_ID = TEACHER.Teacher_ID
            WHERE 
                Section_Name = :selectedSection
                AND daySCHED = 'W';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(':selectedSection', $selectedSection);

            $stmt->execute();

            $schedW = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $e){
            die("Query failed: " . $e->getMessage());
        }

        try{

            require_once "dbh.inc.php";

            $query = "SELECT 
            section_schedule.*, 
            subject_schedule.*, 
            TEACHER.TH_Prefix, 
            TEACHER.TH_First_Name, 
            TEACHER.TH_Middle_Name, 
            TEACHER.TH_Last_Name, 
            TEACHER.TH_Suffix
            FROM 
                section_schedule
            LEFT OUTER JOIN 
                subject_schedule ON section_schedule.Sched_ID = subject_schedule.Section_Sched
            LEFT OUTER JOIN 
                TEACHER ON subject_schedule.Teacher_ID = TEACHER.Teacher_ID
            WHERE 
                Section_Name = :selectedSection
                AND daySCHED = 'TH';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(':selectedSection', $selectedSection);

            $stmt->execute();

            $schedTH = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $e){
            die("Query failed: " . $e->getMessage());
        }

        try{

            require_once "dbh.inc.php";

            $query = "SELECT 
            section_schedule.*, 
            subject_schedule.*, 
            TEACHER.TH_Prefix, 
            TEACHER.TH_First_Name, 
            TEACHER.TH_Middle_Name, 
            TEACHER.TH_Last_Name, 
            TEACHER.TH_Suffix
            FROM 
                section_schedule
            LEFT OUTER JOIN 
                subject_schedule ON section_schedule.Sched_ID = subject_schedule.Section_Sched
            LEFT OUTER JOIN 
                TEACHER ON subject_schedule.Teacher_ID = TEACHER.Teacher_ID
            WHERE 
                Section_Name = :selectedSection
                AND daySCHED = 'F';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(':selectedSection', $selectedSection);

            $stmt->execute();

            $schedF = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $e){
            die("Query failed: " . $e->getMessage());
        }

    
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
    <link href="css/classSchedule.css" rel="stylesheet">
    <title>iEMS</title>

    
</head>
    <body>
        <div class="mainboard">
            <class="top">
                <img src="assets/Male User.png" id="user">
                <img src="assets/rectangle with bell.png" id="notif">
            
                <div class="container">
                    <div class="container1">
                        <div class="SelectorBox">
                        <div>
                            <h2>Filter Search</h2>
                        </div>
                        <div class="optBox"> 
                            <div class="optBox1">
                            <p>Grade:</p>
                            <p>Section:</p>
                            </div>
                            <div class="optBox2">
                            <div>
                                <select class="classSelect" id="classSelect">
                                    <option value="">Grade</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                            <div>

                                <form action="classSchedule.php" method="get">
                                    <select class="sectionName" id="sectionName" name="sectionName">
                                        <option value="">Section</option>
                                    </select>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                <div>
              </div>

                    <table class="schedule-table">
                    <thead>
                        <tr>
                        <th>TIME</th>
                        <th>MONDAY</th>
                        <th>TUESDAY</th>
                        <th>WEDNESDAY</th>
                        <th>THURSDAY</th>
                        <th>FRIDAY</th>
                        </tr>
                    </thead>
                <?php if (isset($_GET['sectionName'])) { ?>
                    <tbody>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[0]['Time_IN']) ." - ". htmlspecialchars($schedM[0]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[0]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[0]['TH_First_Name']) ." ". htmlspecialchars($schedM[0]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[0]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[0]['TH_First_Name']) ." ". htmlspecialchars($schedT[0]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[0]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[0]['TH_First_Name']) ." ". htmlspecialchars($schedW[0]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[0]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[0]['TH_First_Name']) ." ". htmlspecialchars($schedTH[0]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[0]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[0]['TH_First_Name']) ." ". htmlspecialchars($schedF[0]['TH_Last_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[1]['Time_IN']) ." - ". htmlspecialchars($schedM[1]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[1]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[1]['TH_First_Name']) ." ". htmlspecialchars($schedM[1]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[1]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[1]['TH_First_Name']) ." ". htmlspecialchars($schedT[1]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[1]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[1]['TH_First_Name']) ." ". htmlspecialchars($schedW[1]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[1]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[1]['TH_First_Name']) ." ". htmlspecialchars($schedTH[1]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[1]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[1]['TH_First_Name']) ." ". htmlspecialchars($schedF[1]['TH_Last_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[2]['Time_IN']) ." - ". htmlspecialchars($schedM[2]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[2]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[2]['TH_First_Name']) ." ". htmlspecialchars($schedM[2]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[2]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[2]['TH_First_Name']) ." ". htmlspecialchars($schedT[2]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[2]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[2]['TH_First_Name']) ." ". htmlspecialchars($schedW[2]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[2]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[2]['TH_First_Name']) ." ". htmlspecialchars($schedTH[2]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[2]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[2]['TH_First_Name']) ." ". htmlspecialchars($schedF[2]['TH_Last_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[3]['Time_IN']) ." - ". htmlspecialchars($schedM[3]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[3]['Subject_Name']); ?></span></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[3]['Subject_Name']); ?></span></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[3]['Subject_Name']); ?></span></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[3]['Subject_Name']); ?></span></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[3]['Subject_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[4]['Time_IN']) ." - ". htmlspecialchars($schedM[4]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[4]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[4]['TH_First_Name']) ." ". htmlspecialchars($schedM[4]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[4]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[4]['TH_First_Name']) ." ". htmlspecialchars($schedT[4]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[4]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[4]['TH_First_Name']) ." ". htmlspecialchars($schedW[4]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[4]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[4]['TH_First_Name']) ." ". htmlspecialchars($schedTH[4]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[4]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[4]['TH_First_Name']) ." ". htmlspecialchars($schedF[4]['TH_Last_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[5]['Time_IN']) ." - ". htmlspecialchars($schedM[5]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[5]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[5]['TH_First_Name']) ." ". htmlspecialchars($schedM[5]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[5]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[5]['TH_First_Name']) ." ". htmlspecialchars($schedT[5]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[5]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[5]['TH_First_Name']) ." ". htmlspecialchars($schedW[5]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[5]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[5]['TH_First_Name']) ." ". htmlspecialchars($schedTH[5]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[5]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[5]['TH_First_Name']) ." ". htmlspecialchars($schedF[5]['TH_Last_Name']); ?></span></td>
                        </tr>
                        <tr>                
                        <td><span id="time_1"><?php echo htmlspecialchars($schedM[6]['Time_IN']) ." - ". htmlspecialchars($schedM[6]['Time_OUT']); ?></span></td>
                            <td><span id="subject_1" style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[6]['Subject_Name']); ?></span><br><span id="teacher_1"></span><?php echo htmlspecialchars($schedM[6]['TH_First_Name']) ." ". htmlspecialchars($schedM[6]['TH_Last_Name']); ?></td>
                            <td><span id="subject_2" style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[6]['Subject_Name']); ?></span><br> <span id="teacher_2"></span><?php echo htmlspecialchars($schedT[6]['TH_First_Name']) ." ". htmlspecialchars($schedT[6]['TH_Last_Name']); ?></td>
                            <td><span id="subject_3" style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[6]['Subject_Name']); ?></span><br> <span id="teacher_3"></span><?php echo htmlspecialchars($schedW[6]['TH_First_Name']) ." ". htmlspecialchars($schedW[6]['TH_Last_Name']); ?></td>
                            <td><span id="subject_4" style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[6]['Subject_Name']); ?></span><br> <span id="teacher_4"></span><?php echo htmlspecialchars($schedTH[6]['TH_First_Name']) ." ". htmlspecialchars($schedTH[6]['TH_Last_Name']); ?></td>
                            <td><span id="subject_5" style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[6]['Subject_Name']); ?></span><br> <span id="teacher_5"><?php echo htmlspecialchars($schedF[6]['TH_First_Name']) ." ". htmlspecialchars($schedF[6]['TH_Last_Name']); ?></span></td>
                        </tr>
                    </tbody>
                <?php }?>
                    </table>
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
                <button class="option">
                    <img src="assets/Overview.png"  class="option-logo">
                    <a href="adminoverview.php">Overview</a>
                </button>
                <button class="option active">
                    <img src="assets/Tear-Off Calendar.png"  class="option-logo">
                    <a href="classSchedule.php">Class Schedule</a>
                </button>
                <button class="option">
                    <img src="assets/Data Provider.png"  class="option-logo">
                    <a href="studentsData.php">Students Data</a>
                </button>
                <button class="option">
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

            document.getElementById("classSelect").addEventListener("change", function() {
                var grade = this.value;
                var sections = <?php echo json_encode($SectionResults); ?>;
                var sectionDropdown = document.getElementById("sectionName");
                
                // Clear existing options
                sectionDropdown.innerHTML = '<option value="">Section</option>';
                
                // Populate sections based on selected grade
                sections.forEach(function(section) {
                    if (section.Grade_Level == grade) {
                        var option = document.createElement("option");
                        option.value = section.Section_Name;
                        option.text = section.Section_Name;
                        sectionDropdown.appendChild(option);
                    }
                });
            });

            document.getElementById("sectionName").addEventListener("change", function() {
                // Submit the form when section selection changes
                this.closest('form').submit();
            });
        </script>
    </body>
</html>
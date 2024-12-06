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

            $sched = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
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
    <link href="css/studentsDataStyle.css" rel="stylesheet">
    <title>iEMS</title>
</head>

<body>
    <div class="mainboard">
        <div class="top">
            <img src="assets/Male User.png" id="user">
            <img src="assets/rectangle with bell.png" id="notif">
        </div>
        <div class = "container">
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
            </div>
            <div>
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
                <?php
                if (isset($_GET['sectionName'])){
                  for($j = 0; $j < sizeof($sched); $j++) { ?>

                    <?php
                        $time_in = $sched[$j]['Time_IN'];
                        $parts_in = explode(':', $time_in);
                        $time_in = $parts_in[0] . ':' . $parts_in[1];
                        
                        $time_out = $sched[$j]['Time_OUT'];
                        $parts_out = explode(':', $time_out);
                        $time_out = $parts_out[0] . ':' . $parts_out[1];
                        
                        // Determine if time_in is AM or PM
                            $hour_in = (int)$parts_in[0];
                            $minute_in = (int)$parts_in[1];
                            if (($hour_in >= 6 && $hour_in < 12) || ($hour_in == 12 && $minute_in == 0)) {
                                $time_in .= " AM";
                            } else {
                                if ($hour_in >= 12 && $hour_in < 18) {
                                    if ($hour_in > 12) {
                                        $hour_in -= 12;
                                    }
                                    $time_in = sprintf('%02d:%02d PM', $hour_in, $minute_in);
                                } else {
                                    $time_in .= " PM";
                                }
                            }

                            // Determine if time_out is AM or PM
                            $hour_out = (int)$parts_out[0];
                            $minute_out = (int)$parts_out[1];
                            if (($hour_out >= 6 && $hour_out < 12) || ($hour_out == 12 && $minute_out == 0)) {
                                $time_out .= " AM";
                            } else {
                                if ($hour_out >= 12 && $hour_out < 18) {
                                    if ($hour_out > 12) {
                                        $hour_out -= 12;
                                    }
                                    $time_out = sprintf('%02d:%02d PM', $hour_out, $minute_out);
                                } else {
                                    $time_out .= " PM";
                                }
                            } 
                    ?>
                    
                    <tr> 
                        <?php if($sched[$j]['Subject_Name'] == 'BREAK'){ ?> 
                            <td style="width: 20%;"><span id="time_1"><?php echo $time_in ." - ". $time_out; ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span></td>
                        <?php } else {?>
                            <td><span id="time_1"><?php echo $time_in ." - ". $time_out; ?></span></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span><br> <span id="teacher" style="font-weight: none;"></span><?php echo htmlspecialchars($sched[$j]['TH_First_Name']) ." ". htmlspecialchars($sched[$j]['TH_Last_Name']); ?></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span><br> <span id="teacher"></span><?php echo htmlspecialchars($sched[$j]['TH_First_Name']) ." ". htmlspecialchars($sched[$j]['TH_Last_Name']); ?></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span><br> <span id="teacher"></span><?php echo htmlspecialchars($sched[$j]['TH_First_Name']) ." ". htmlspecialchars($sched[$j]['TH_Last_Name']); ?></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span><br> <span id="teacher"></span><?php echo htmlspecialchars($sched[$j]['TH_First_Name']) ." ". htmlspecialchars($sched[$j]['TH_Last_Name']); ?></td>
                            <td><span id="subject" style="font-weight: 1000;"><?php echo htmlspecialchars($sched[$j]['Subject_Name']); ?></span><br> <span id="teacher"><?php echo htmlspecialchars($sched[$j]['TH_First_Name']) ." ". htmlspecialchars($sched[$j]['TH_Last_Name']); ?></span></td>
                        <?php }?>
                        
                    </tr>
                <?php }
                } ?>
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
                <button class="option" onclick="location.href='adminoverview.php'" style="cursor: pointer;">
                    <img src="assets/Overview.png"  class="option-logo" >
                    <a href="adminoverview.php">Overview</a>
                </button>
                <button class="option active" onclick="location.href='classSchedule.php'" style="cursor: pointer;">
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
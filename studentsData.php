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

    if (isset($_GET['sectionName'])) {

      try {
        require_once "dbh.inc.php";

        // Retrieve selected section from GET data
        $selectedSection = $_GET['sectionName'];

        $query = "SELECT *
        FROM STUDENT
        INNER JOIN ENROLL ON ENROLL.LRN = STUDENT.LRN
        WHERE ENROLL.section_name = :Section;";
    
        $stmt = $pdo->prepare($query);
        $stmt -> bindParam(":Section", $selectedSection);
        $stmt->execute();
        
        $FilStuInf = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            
      } catch (PDOException $e) {
          // Log the error and display a user-friendly message
          error_log("Query failed: " . $e->getMessage());
          die("Something went wrong. Please try again later.");
      }
    }


    // Check if the request method is GET and if 'status' and 'lrn' are set
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['status']) && isset($_GET['lrn'])) {
      // Both 'status' and 'lrn' are set
      $status = $_GET['status'];
      $lrn = $_GET['lrn'];

      try {
          require_once "dbh.inc.php";

          $query = "UPDATE STUDENT
                      SET ST_Status = :status
                      WHERE LRN = :lrn";

          $stmt = $pdo->prepare($query);
          $stmt->bindParam(":status", $status);
          $stmt->bindParam(":lrn", $lrn);
          $stmt->execute();

          // Retrieve selected section from GET data
          $selectedSection = $_GET['sectionName'];

          $query = "SELECT *
          FROM STUDENT
          INNER JOIN ENROLL ON ENROLL.LRN = STUDENT.LRN
          WHERE ENROLL.section_name = :Section;";
      
          $stmt = $pdo->prepare($query);
          $stmt -> bindParam(":Section", $selectedSection);
          $stmt->execute();
          $FilStuInf = $stmt->fetchAll(PDO::FETCH_ASSOC);

      } catch (PDOException $e) {
          // Log the error and display a user-friendly message
          error_log("Query failed: " . $e->getMessage());
          die("Something went wrong. Please try again later.");
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

                          <form action="studentsData.php" method="get">
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
                    <th>LRN</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birth Day</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <?php
                if (isset($_GET['sectionName'])){
                  for($j = 0; $j < sizeof($FilStuInf); $j++) { ?>
                    <tr>
                        <td><span id="lrn_<?php echo $j + 1; ?>"><?php echo htmlspecialchars($FilStuInf[$j]['LRN']); ?></span></td>
                        <td><span id="fname_<?php echo $j + 1; ?>">
                        <?php 
                        if(empty($FilStuInf[$j]['ST_Middle_Name']) && empty($FilStuInf[$j]['ST_Suffix'])){
                          echo htmlspecialchars($FilStuInf[$j]['ST_First_Name'] . " " . $FilStuInf[$j]['ST_Last_Name']);
                        }else if(!empty($FilStuInf[$j]['ST_Middle_Name']) && empty($FilStuInf[$j]['ST_Suffix'])){
                          echo htmlspecialchars($FilStuInf[$j]['ST_First_Name'] . " " . $FilStuInf[$j]['ST_Middle_Name'][0] . ". " . $FilStuInf[$j]['ST_Last_Name']);
                        }else if(empty($FilStuInf[$j]['ST_Middle_Name']) && !empty($FilStuInf[$j]['ST_Suffix'])){
                          echo htmlspecialchars($FilStuInf[$j]['ST_First_Name'] . " " . $FilStuInf[$j]['ST_Last_Name'] . " " . $FilStuInf[$j]['ST_Suffix']);
                        }else{
                          echo htmlspecialchars($FilStuInf[$j]['ST_First_Name'] . " " . $FilStuInf[$j]['ST_Middle_Name'][0] . ". " . $FilStuInf[$j]['ST_Last_Name'] . " " . $FilStuInf[$j]['ST_Suffix']);
                        }
                        ?></span></td>
                        <td><span id="lrn_<?php echo $j + 1; ?>"><?php echo ($FilStuInf[$j]['Gender'] == 'M') ? 'Male' : 'Female'; ?></span></td>
                        <td><span id="fname_<?php echo $j + 1; ?>"><?php echo htmlspecialchars($FilStuInf[$j]['Birth_Month'] . " / " . $FilStuInf[$j]['Birth_Day'] . " / " . $FilStuInf[$j]['Birth_Year']);?></span></td>
                        <td>
                            <select class="statusSelect" data-lrn="<?php echo htmlspecialchars($FilStuInf[$j]['LRN']); ?>" onchange="changeBorderColor(this)" value="<?php echo $FilStuInf[$j]['ST_Status']; ?>">
                                <option value="Pending" <?php if($FilStuInf[$j]['ST_Status'] == 'Pending') echo 'selected'; ?> style="color: #000000;">Pending</option>
                                <option value="Enrolled" <?php if($FilStuInf[$j]['ST_Status'] == 'Enrolled') echo 'selected'; ?> style="color: #000000;">Enrolled</option>
                                <option value="Drop" <?php if($FilStuInf[$j]['ST_Status'] == 'Drop') echo 'selected'; ?> style="color: #000000;">Dropped</option>
                            </select>
                        </td>
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
                    <img src="assets/Overview.png"  class="option-logo">
                    <a href="adminoverview.php">Overview</a>
                </button>
                <button class="option" onclick="location.href='classSchedule.php'" style="cursor: pointer;">
                    <img src="assets/Tear-Off Calendar.png"  class="option-logo">
                    <a href="classSchedule.php">Class Schedule</a>
                </button>
                <button class="option active" onclick="location.href='studentsData.php'" style="cursor: pointer;">
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

       // Function to set initial border color and text color based on the current value
      function setInitialColors() {
          var selects = document.getElementsByClassName("statusSelect");

          for (var i = 0; i < selects.length; i++) {
              var selectedValue = selects[i].value;
              var borderColor;
              var textColor;

              switch(selectedValue) {
                  case "Pending":
                      borderColor = "orange";
                      textColor = "orange";
                      break;
                  case "Enrolled":
                      borderColor = "green";
                      textColor = "green";
                      break;
                  case "Drop":
                      borderColor = "red";
                      textColor = "red";
                      break;
              }

              selects[i].style.borderColor = borderColor;
              selects[i].style.color = textColor;
          }
      }

      // Function to update border color and text color when a new option is selected
      function changeBorderColor(select) {
          var status = select.value;
          var lrn = select.dataset.lrn;
          console.log("LRN:", lrn);
          console.log("Status:", status);
          var borderColor;
          var textColor;

          switch(status) {
              case "Pending":
                  borderColor = "orange";
                  textColor = "orange";
                  break;
              case "Enrolled":
                  borderColor = "green";
                  textColor = "green";
                  break;
              case "Drop":
                  borderColor = "red";
                  textColor = "red";
                  break;
          }

          console.log("Border Color:", borderColor); // Log the border color value
          console.log("Text Color:", textColor); // Log the text color value

          select.style.borderColor = borderColor;
          select.style.color = textColor;

          // Send the selected status and LRN to PHP using a query string in the URL
          var url = 'studentsData.php?status=' + encodeURIComponent(status) + '&lrn=' + encodeURIComponent(lrn) + '&sectionName=' + encodeURIComponent('<?php echo isset($FilStuInf[0]['Section_Name']) ? $FilStuInf[0]['Section_Name'] : ""; ?>');
          window.location.href = url;
      
      }

      
      // Attach event listeners to update colors when an option is selected
      var selects = document.getElementsByClassName("statusSelect");
      for (var i = 0; i < selects.length; i++) {
          selects[i].addEventListener("change", changeBorderColor);
      }
      
      // Set initial colors when the DOM content is loaded
      window.addEventListener("DOMContentLoaded", setInitialColors);

    </script>
  </body>
</html>
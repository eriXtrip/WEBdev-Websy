<?php
    session_start();

    if (isset($_SESSION['Results'])) {
        $Results = $_SESSION['Results'];
        
        try{
            require_once "dbh.inc.php";
                
                if(!empty($Results[0]['LRN'])){
                    
                    $query = "SELECT *
                            FROM STUDENT
                            WHERE LRN = :LRN;";

                    $stmt = $pdo->prepare($query);

                    // Bind parameter
                    $stmt->bindParam(":LRN", $Results[0]['LRN']);

                    $stmt->execute();

                }else{

                    $query = "SELECT *
                            FROM STUDENT
                            WHERE Grade_level = :Grade_level AND ST_First_Name = :ST_First_Name AND ST_Last_Name = :ST_Last_Name AND Birth_Day = :Birth_Day AND Birth_Month = :Birth_Month AND Birth_Year = :Birth_Year;";

                    $stmt = $pdo->prepare($query);

                    // Bind parameter
                    $stmt->bindParam(":Grade_level", $Results[0]['Grade_level']);
                    $stmt->bindParam(":ST_First_Name", $Results[0]['ST_First_Name']);
                    $stmt->bindParam(":ST_Last_Name", $Results[0]['ST_Last_Name']);
                    $stmt->bindParam(":Birth_Day", $Results[0]['Birth_Day']);
                    $stmt->bindParam(":Birth_Month", $Results[0]['Birth_Month']);
                    $stmt->bindParam(":Birth_Year", $Results[0]['Birth_Year']);

                    $stmt->execute();
                }

                $Results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $_SESSION['Results'] = $Results;

        }catch (PDOException $e) {
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
    <link href="css/etsResultEnrolledStyle.css" rel="stylesheet">
    <title>iEMS</title>
</head>
<body>
    <header>
        <div class="box1">
            <div class="box2">
                <img src="assets/Logo.png" alt="logo" id="logoHeader">
                <div class="schoolname">
                    <h5><span style="color: #FCA304;">IBALON</span></h5>
                    <h5><span style="color: #039B11;">CENTRAL</span></h5>
                    <h5><span style="color: #5582BF;">SCHOOL</span></h5>
                </div>
            </div>
            <div class="box3">
                <h2 id="EMS">EMS Portal</h2>
            </div>    
        </div>
    </header>
    <section>
        <div class="content">
            <div class="steps-box">
                <div class="steps">
                    <img src = "assets/Check Mark.png" alt = "Check Mark" class = "imgs">
                    <p>STEP 1</p>
                    <b>Application</b>
                </div>
                <div class="steps">
                    <img src = "assets/Green Line.png" alt = "Green Line" class = "line">
                    <br><br><br><br>
                </div>
                <div class="steps">
                    <img src = "assets/Check Mark.png" alt = "Check Mark" class = "imgs">
                    <p>STEP 2</p>
                    <b>On Queue</b>
                </div>
                <div class="steps">
                    <img src = "assets/Green Line.png" alt = "Green Line" class = "line">
                    <br><br><br><br>
                </div>
                <div class="steps">
                    <img src = "assets/Check Mark.png" alt = "Blue Mark" class = "imgs">
                    <p>STEP 3</p>
                    <b>For Approval</b>
                </div>
                <div class="steps">
                    <img src = "assets/Green Line.png" alt = "Blue Line" class = "line">
                    <br><br><br><br>
                </div>  
                <div class="steps">
                    <img src = "assets/Check Mark.png" alt = "Blue Mark" class = "imgs">
                    <p>STEP 4</p>
                    <b>Enrolled</b>
                </div>
            </div>
        </div>
        <div class="content-2">
            <div class = "enrolled-box">
                <div class = "back-button"> 
                    <div class = "images">
                    <a href = "enrollmentTracker.php"><img src = "assets/backWithBilog.png" alt = "back" id="backButton"></a>
                    <img src ="assets/Graduation Cap.png" alt = "you are enrolled" id="gradcap">
                    </div>
                </div>
                <h3>You are Officially Enrolled!</h3>
                <p>We are thrilled to have you here! Looking forward to the exciting journey ahead.</p>
                <button id="buttonCOR" onclick="redirectToCOR()"><b>View Schedule</b></button>
            </div>
        </div>
    </section>
    <footer>
        <div class="FooterBox" style="margin-left: 3%;">
            <span style="font-weight: 500;"><p>197 Magallanes St, Legazpi Port District, Legazpi City, Albay</p></span>
            <span style="font-weight: 300;"><p>Copyright 2024. Ibalon Central School. All Rights Reserved.</p></span>
        </div>
        <div class="FooterBox" style="margin-left: 10%;">
            <span style="font-weight: 500;"><p>Contact Us</p></span>
            <span style="font-weight: 300;"><p>(052) 821-7921; 820-5959; 820-5003</p></span>
        </div>
        <div class="FooterBox" style="margin-left: 10%;">
            <div class="boxFoot">
                <div>
                    <span style="font-weight: 500;"><p>Follow our Social Media Accounts</p></span>
                </div>
                <div class="socmed">
                    <img src="assets/Facebook.png" alt="Facebook">
                    <img src="assets/Twitter.png" alt="Twitter">
                    <img src="assets/Gmail.png" alt="Gmail">
                </div>
            </div>
        </div>
    </footer>
        <script>
            function redirectToCOR() {
                // Check if $Results is not empty
                if (<?php echo !empty($Results) ? 'true' : 'false'; ?>) {
                    // Redirect to COR.php
                    window.location.href = 'COR.php';
                }
            }
        </script>
</body>
</html>
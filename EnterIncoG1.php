<?php

session_start();

$NAME1ST_error = 'First Name'; // Default placeholder text
$NAMEMid_error = 'Middle Name'; // Default placeholder text
$NAMElast_error = 'Last Name'; // Default placeholder text
$Res = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["find-IncG1"])) {
    // Check if the form is submitted and the submit button is clicked
    
    // Retrieve form data
    $Search1Stname = $_POST["Firstname"];
    $SearchMiddname = $_POST["Middlename"];
    $SearchLastname = $_POST["Lastname"];
    $SearchSuffix = $_POST["Suffix"];

    if(!empty($Search1Stname)){
        $Search1Stname = $Search1Stname . '%';
    }
    if(!empty($SearchMiddname)){
        $SearchMiddname = $SearchMiddname . '%';
    }
    if(!empty($SearchLastname)){
        $SearchLastname = $SearchLastname . '%';
    }
    if(!empty($SearchSuffix)){
        $SearchSuffix = $SearchSuffix . '%';
    }

    try {
        require_once "dbh.inc.php";        

        if(empty($SearchSuffix) && empty($SearchMiddname)){
            $query = "SELECT *
                  FROM INCOMING_GRADE_1
                  WHERE IN_First_Name LIKE :Search1Stname AND IN_Last_Name LIKE :SearchLastname;";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":Search1Stname", $Search1Stname);
            $stmt->bindParam(":SearchLastname", $SearchLastname);
            $stmt->execute();
            
        }else if(!empty($SearchMiddname) && empty($SearchSuffix)){

            try {
                $query = "SELECT *
                          FROM INCOMING_GRADE_1
                          WHERE IN_First_Name LIKE :Search1Stname AND IN_Middle_Name LIKE :SearchMiddname AND IN_Last_Name LIKE :SearchLastname;";
            
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":Search1Stname", $Search1Stname);
                $stmt->bindParam(":SearchMiddname", $SearchMiddname);
                $stmt->bindParam(":SearchLastname", $SearchLastname);
            
                // Execute the query
                $stmt->execute();
            
                // Use the results as needed
            
            } catch (PDOException $e) {
                // Handle any exceptions (errors) that occur during the execution of the query
                echo "Error executing SQL query: " . $e->getMessage();
            }
            
            
        }else if(!empty($SearchSuffix) && empty($SearchMiddname)){
            $query = "SELECT *
                  FROM INCOMING_GRADE_1
                  WHERE IN_First_Name LIKE :Search1Stname AND IN_Last_Name LIKE :SearchLastname AND IN_Suffix LIKE :SearchSuffix;";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":Search1Stname", $Search1Stname);
            $stmt->bindParam(":SearchLastname", $SearchLastname);
            $stmt->bindParam(":SearchSuffix", $SearchSuffix);
            $stmt->execute();

        }else {
            $query = "SELECT *
                  FROM INCOMING_GRADE_1
                  WHERE IN_First_Name LIKE :Search1Stname AND IN_Middle_Name LIKE :SearchMiddname AND IN_Last_Name LIKE :SearchLastname;";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":Search1Stname", $Search1Stname);
            $stmt->bindParam(":SearchMiddname", $SearchMiddname);
            $stmt->bindParam(":SearchLastname", $SearchLastname);
            $stmt->execute();
            
        }
        
        $Results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ////var_dump($Results);

        if (!empty($Results)) {

            $_SESSION['Results'] = $Results;

            
                   
            if ($Results[0]['ENROLLMENT_STATUS'] == 4 && $Results[0]['Cert_of_Compl'] == 1 && $Results[0]['Birth_Cert'] == 1) {
                //last step on tracker
                header("Location: etsResultEnrolled.php");
                exit();

            } else if ($Results[0]['ENROLLMENT_STATUS'] == 2) {
                //3 step
                ////var_dump($Results);
                header("Location: etsResultOnQ - IncG1 step3.php");
                exit();
                
            } else if ($Results[0]['ENROLLMENT_STATUS'] == 2) {
                //2 step
                ////var_dump($Results);
                header("Location: etsResultOnQ - IncG1.php");
                exit();
            } 

            foreach ($Results as $Result) {
                echo "Welcome " . htmlspecialchars($Result['ST_First_Name']) . " " . htmlspecialchars($Result['IN_Last_Name']);
            }
        } else {
            $Res = "No records found.";
        }

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
    <link href="css/EnterIncoG1.css" rel="stylesheet">
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
            <div class="container">
                <div class="boxes">
                    <h2>IBALON CENTRAL SCHOOL - EMS</h2>
                </div>
                <div class="boxes">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="find-IncG1" id ="find-IncG1">

                    <?php

                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["find-IncG1"])) {
                            $NAME1ST = $_POST["Firstname"];
                            $SearchMiddname = $_POST["Middlename"];
                            $SearchLastname = $_POST["Lastname"];

                            if (!ctype_alpha($NAME1ST)) {
                                $NAME1ST_error = 'Only Text is Allowed';
                            }  
                            if (!ctype_alpha($SearchMiddname)) {
                                $NAMEMid_error = 'Only Text is Allowed';
                            } if (!ctype_alpha($SearchLastname)) {
                                $NAMElast_error = 'Only Text is Allowed';
                            } 
                        }
                        ?>
                        
                        <input type="text" id="FirstName" name="Firstname" placeholder="<?php echo htmlspecialchars($NAME1ST_error); ?>" required>
                    
                        <input type="text" id="MiddleName" name="Middlename" placeholder="<?php echo htmlspecialchars($NAMEMid_error); ?>">
                    
                        <input type="text" id="LastName" name="Lastname" placeholder="<?php echo htmlspecialchars($NAMElast_error); ?>" required>
                    
                        <input type="text" id="Suffix" name="Suffix" placeholder="Suffix (Leave blank if none)">

                            <p><?php echo htmlspecialchars($Res); ?></p>
                
                        <div class="boxes">
                            <div class="ButtonSub">
                                <a href="enrollmentTracker.php">
                                    <div class="submit_box">
                                        <p>Back</p>
                                    </div>
                                </a>
                                    <input type="submit" name="find-IncG1" value="Submit" class="submitButton">
                            </div>
                        </div>
                    </form>
                </div>
                
                
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
</body>

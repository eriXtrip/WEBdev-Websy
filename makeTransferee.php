<?php 

session_start();

$NAME1ST_error = 'First Name'; // Default placeholder text
$NAMEMid_error = 'Middle Name'; // Default placeholder text
$NAMElast_error = 'Last Name'; // Default placeholder text
$Suffix_error = 'Suffix (Leave blank if none)';

$Gender_error = 'Gender';
$BRGY_error = 'Brgy No.';
$BRGYNAME_error = 'Barangay';
$Zip_error = 'Zip Code';
$City_error = 'City';

$PRNAME1ST_error = 'First Name'; // Default placeholder text
$PRNAMEMid_error = 'Middle Name'; // Default placeholder text
$PRNAMElast_error = 'Last Name'; // Default placeholder text
$PRSuffix_error = 'Suffix (Leave blank if none)';

$LRN_error = 'Learner Reference Number';
$ContNo_error = 'Contact No.';
$GradeLv_error = 'Grade Level';
$Res = '';



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["makeTransferee"])) {
    // Check if the form is submitted and the submit button is clicked
    
    // Retrieve form data
    $LRN = $_POST["LRN"];
    $NAME1ST = $_POST["Firstname"];
    $NAMEMid = $_POST["Middlename"];
    $NAMElast = $_POST["Lastname"];
    $Suffix = $_POST["Suffix"];

    $date_of_birth = $_POST["date_of_birth"];
    $Gender = $_POST["Gender"];
    $GradeLv = $_POST["GradeLv"];

    $BRGY = $_POST["BRGY"];
    $BRGYNAME = $_POST["BRGYNAME"];
    $ZIPCODE = $_POST["ZipCode"];
    $City = $_POST["City"];

    $ContNo = $_POST["ContNo"];
    $PRNAME1ST = $_POST["PRFirstname"];
    $PRNAMEMid = $_POST["PRMiddlename"];
    $PRNAMElast = $_POST["PRLastname"];
    $PRSuffix = $_POST["PRSuffix"];

    // //var_dump($date_of_birth);

    // Split the date string into an array using "-" as the delimiter
    $date_components = explode("-", $date_of_birth);

    // Define month names array
    $monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']; 

    // Extract day, month, and year components
    $birth_year = $date_components[0];
    $birth_month = $monthNames[(int)$date_components[1] - 1];
    $birth_day = $date_components[2];

    try {
        require_once "dbh.inc.php";

        $query = "SELECT LRN FROM TRANSFEREE
        UNION
        SELECT LRN FROM STUDENT;";

         // Execute the query
        $stmt = $pdo->query($query);
        
        // Fetch all rows
        $LRNresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ////var_dump($LRNresults);

        // Check if the submitted LRN exists in the results
        $inValidEnrty = false;

        $ValidStudentInf = TRUE;
        
        $ValidParentInf = TRUE;

        foreach ($LRNresults as $row) {
            if ($row['LRN'] == $LRN) {
                $LRN_error = "LRN already exists.";
                $inValidEnrty = TRUE;
                $ValidStudentInf = FALSE;
                break; // Exit the loop since we found a match
            }
        }

        if(strlen($LRN) != 12){
            $LRN_error = "Must be 12 Digit.";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$NAME1ST)){
            $NAME1ST_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$NAMEMid) && !empty($NAMEMid)){
            $NAMEMid_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$NAMElast)){
            $NAMElast_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$Suffix) && !empty($Suffix)){
            $Suffix_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if ($Gender != 'Male' && $Gender != 'M' && $Gender != 'MALE' && $Gender != 'Female' && $Gender != 'FEMALE' && $Gender != 'F' && !preg_match("/^[a-zA-Z ]+$/", $Gender)) {
            $Gender_error = "Invalid Entry";
            $inValidEnrty = true;
            $ValidStudentInf = false;
        }
        if($GradeLv < 1 && $GradeLv > 6){
            $GradeLv_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$BRGYNAME) && !empty($BRGYNAME)){
            $BRGYNAME_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
            } 
        if($BRGY < 0 || $BRGY > 70){
            $BRGY_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$City) && !empty($City)){
            $City_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if($ZIPCODE != 4500){
            $Zip_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidStudentInf = FALSE;
        }
        if(strlen($ContNo) != 10){
            $ContNo_error = "Must be 10 Digit.";
            $ValidParentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$PRNAME1ST)){
            $PRNAME1ST_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidParentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$PRNAMEMid) && !empty($PRNAMEMid)){
            $PRNAMEMid_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidParentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$PRNAMElast)){
            $PRNAMElast_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidParentInf = FALSE;
        }
        if(!preg_match("/^[a-zA-Z ]+$/",$PRSuffix) && !empty($PRSuffix)){
            $PRSuffix_error = "Invalid Entry";
            $inValidEnrty = TRUE;
            $ValidParentInf = FALSE;
        }

        $query = "SELECT * FROM PARENT;";

         // Execute the query
        $stmt = $pdo->query($query);
        
        // Fetch all rows
        $Parentresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ////var_dump($Parentresults);
        
        foreach ($Parentresults as $row) {
            if ($row['PR_Contact_Number'] == $ContNo) {
                $ContNo_error = "Contact No. already exist";
                $ValidParentInf = FALSE;

                // //var_dump($Parentresults);
                
                if(empty($PRSuffix) && empty($PRNAMEMid)){

                    if($row['TR_First_Name'] == $PRNAME1ST && $row['TR_Last_Name'] == $PRNAMElast && $row['PR_Contact_Number'] == $ContNo){
                        $ValidParentInf = FALSE;
                        break; // Exit the loop since we found a match
                    }
        
                }else if(!empty($PRSuffix) && empty($PRNAMEMid)){
    
                    if($row['TR_First_Name'] == $PRNAME1ST && $row['TR_Last_Name'] == $PRNAMElast && $row['PR_Contact_Number'] == $ContNo && $row['TR_Suffix'] == $PRSuffix){
                        $ValidParentInf = FALSE;
                        break; // Exit the loop since we found a match
                    }
                
                }else if(!empty($PRNAMEMid) && empty($PRSuffix)){
    
                    if($row['TR_First_Name'] == $PRNAME1ST && $row['TR_Last_Name'] == $PRNAMElast && $row['PR_Contact_Number'] == $ContNo && $row['TR_Middle_Name'] == $PRNAMEMid){
                        $ValidParentInf = FALSE;
                        break; // Exit the loop since we found a match
                    }
    
                }else {
    
                    if($row['TR_First_Name'] == $PRNAME1ST && $row['TR_Last_Name'] == $PRNAMElast && $row['PR_Contact_Number'] == $ContNo && $row['TR_Middle_Name'] == $PRNAMEMid && $row['TR_Suffix'] == $PRSuffix){
                        $ValidParentInf = FALSE;
                        break; // Exit the loop since we found a match
                    }
                }

                break; // Exit the loop since we found a match
            }
        }

        //var_dump($ValidParentInf);
        //var_dump($ValidStudentInf);

        if($ValidStudentInf == TRUE){

            try {   
                    if (!empty($PRNAME1ST)) {
                        $PRNAME1ST = ucfirst($PRNAME1ST);
                    }
                    
                    if (!empty($PRNAMEMid)) {
                        $PRNAMEMid = ucfirst($PRNAMEMid);
                    }
                    
                    if (!empty($PRNAMElast)) {
                        $PRNAMElast = ucfirst($PRNAMElast);
                    }
                    
                    if (!empty($PRSuffix)) {
                        $PRSuffix = ucfirst($PRSuffix);
                    }
                

                    if($ValidParentInf == TRUE){
                        // INSERT INTO PARENT
                        $queryParent = "INSERT INTO PARENT (PR_Contact_Number, PR_First_Name, PR_Middle_Name, PR_Last_Name, PR_Suffix)
                        VALUES (?, ?, ?, ?, ?)";
    
                        $stmtParent = $pdo->prepare($queryParent);
                        
                        if (empty($PRSuffix) && empty($PRNAMEMid)) {
                            $stmtParent->execute([$ContNo, $PRNAME1ST, NULL, $PRNAMElast, NULL]);
                        } else if (!empty($PRSuffix) && empty($PRNAMEMid)) {
                            $stmtParent->execute([$ContNo, $PRNAME1ST, NULL, $PRNAMElast, $PRSuffix]);
                        } else if (empty($PRSuffix) && !empty($PRNAMEMid)) {
                            $stmtParent->execute([$ContNo, $PRNAME1ST, $PRNAMEMid, $PRNAMElast, NULL]);
                        } else {
                            $stmtParent->execute([$ContNo, $PRNAME1ST, $PRNAMEMid, $PRNAMElast, $PRSuffix]);
                        }
                    }

                    if($Gender == 'MALE' || $Gender == 'Male'){
                        $Gender = 'M';
                    }
                    if($Gender == 'FEMALE' || $Gender == 'Female'){
                        $Gender = 'F';
                    }

                    if (!empty($NAME1ST)) {
                        $NAME1ST = ucfirst($NAME1ST);
                    }
                    
                    if (!empty($NAMEMid)) {
                        $NAMEMid = ucfirst($NAMEMid);
                    }
                    
                    if (!empty($NAMElast)) {
                        $NAMElast = ucfirst($NAMElast);
                    }
                    
                    if (!empty($Suffix)) {
                        $Suffix = ucfirst($Suffix);
                    }
                    
                
            
                // INSERT INTO TRANSFEREE
                $queryTransfer = "INSERT INTO TRANSFEREE (LRN, Grade_level, TR_First_Name, TR_Middle_Name, TR_Last_Name, TR_Suffix, Gender, Birth_Day, Birth_Month, Birth_Year, BRGY_NUM, PR_Contact_Number)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmtTransfer = $pdo->prepare($queryTransfer);
                
                if (empty($Suffix) && empty($NAMEMid)) {
                    $stmtTransfer->execute([$LRN, $GradeLv, $NAME1ST, NULL, $NAMElast, NULL, $Gender, $birth_day, $birth_month, $birth_year, $BRGY, $ContNo]);
                } else if (!empty($Suffix) && empty($NAMEMid)) {
                    $stmtTransfer->execute([$LRN, $GradeLv, $NAME1ST, NULL, $NAMElast, $Suffix, $Gender, $birth_day, $birth_month, $birth_year, $BRGY, $ContNo]);
                } else if (empty($Suffix) && !empty($NAMEMid)) {
                    $stmtTransfer->execute([$LRN, $GradeLv, $NAME1ST, $NAMEMid, $NAMElast, NULL, $Gender, $birth_day, $birth_month, $birth_year, $BRGY, $ContNo]);
                } else {
                    $stmtTransfer->execute([$LRN, $GradeLv, $NAME1ST, $NAMEMid, $NAMElast, $Suffix, $Gender, $birth_day, $birth_month, $birth_year, $BRGY, $ContNo]);
                }
            
                // SELECT FROM TRANSFEREE
                $querySelect = "SELECT *
                            FROM TRANSFEREE
                            WHERE LRN = :LRN";
            
                $stmtSelect = $pdo->prepare($querySelect);
                $stmtSelect->bindParam(":LRN", $LRN);
                $stmtSelect->execute();
            
                $Transfereeresults = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
                
                //var_dump($Transfereeresults); // Debugging: Check the results of the SELECT query
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            

            // //var_dump($Transfereeresults);

            $_SESSION['Results'] = $Transfereeresults;

            if (!empty($Transfereeresults)) {
                //var_dump($Transfereeresults);
                header("Location: etsResultOnQ.php");
                exit();
            } 
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
    <link href="css/regStudent.css" rel="stylesheet">
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

    <?php  
        ?>
        <div class="content">
            <div class="container">
                <div class="box">
                    <h2>IBALON CENTRAL SCHOOL - EMS</h2>
                </div>
                <div class="boxes">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class ="makeTransferee" id ="makeTransferee">

                    <div class="left-label">
                        <label>Student Information: </label>
                    </div>

                            <input type="number" id="LRN" min="1" maxlength="12" class="LRN" name="LRN" placeholder="<?php echo htmlspecialchars($LRN_error); ?>" required>

                            <div class="part">
                                <input type="text" id="FirstName" class="Firstname" name="Firstname" placeholder="<?php echo htmlspecialchars($NAME1ST_error); ?>" required>

                                <input type="text" id="MiddleName" class="Middlename" name="Middlename" placeholder="<?php echo htmlspecialchars($NAMEMid_error); ?>">
                            
                                <input type="text" id="LastName" class="Lastname" name="Lastname" placeholder="<?php echo htmlspecialchars($NAMElast_error); ?>" required>

                                <input type="text" id="Suffix" class="Suffix" name="Suffix" placeholder="<?php echo htmlspecialchars($Suffix_error); ?>">
                            </div>
                        
                            <div class="GB">
                                <label>Grade Level: </label>
                                <label>Gender: </label>    
                                <label class="bday">Birth Day: </label>

                                <input type="number" id="GradeLv" class="GradeLv" name="GradeLv" placeholder="<?php echo htmlspecialchars($GradeLv_error); ?>" required>

                                <input type="text" id="Gender" class="Gender" name="Gender" placeholder="<?php echo htmlspecialchars($Gender_error); ?>" required>

                                <input type="date" id="date_of_birth" class="date_of_birth" name="date_of_birth" required>
                            </div>

                            <div class="left-label">
                                <label>Current Address: </label>
                            </div>

                            <div class="part">
                                <input type="number" id="BRGY" class="BRGY" name="BRGY" placeholder="<?php echo htmlspecialchars($BRGY_error); ?>" required>

                                <input type="text" id="BRGYNAME" class="BRGYNAME" name="BRGYNAME" placeholder="<?php echo htmlspecialchars($BRGYNAME_error); ?>">
                            
                                <input type="number" id="ZipCode" class="ZipCode" name="ZipCode" placeholder="<?php echo htmlspecialchars($Zip_error); ?>" required>

                                <input type="text" id="City" class="City" name="City" placeholder="<?php echo htmlspecialchars($City_error); ?>">
                            </div>

                            <div class="left-label">
                                <label>Parents Information: </label>
                            </div>

                            <input type="number" id="ContNo" min="1" maxlength="11" class="ContNo" name="ContNo" placeholder="<?php echo htmlspecialchars($ContNo_error); ?>" required>

                            <div class="part">
                                <input type="text" id="PRFirstName" class="PRFirstname" name="PRFirstname" placeholder="<?php echo htmlspecialchars($PRNAME1ST_error); ?>" required>

                                <input type="text" id="PRMiddleName" class="PRMiddlename" name="PRMiddlename" placeholder="<?php echo htmlspecialchars($PRNAMEMid_error); ?>">
                            
                                <input type="text" id="PRLastName" class="PRLastname" name="PRLastname" placeholder="<?php echo htmlspecialchars($NAMElast_error); ?>" required>

                                <input type="text" id="PRSuffix" class="PRSuffix" name="PRSuffix" placeholder=" <?php echo htmlspecialchars($PRSuffix_error); ?>">
                            </div>
                        <div class="boxes2">
                            <div class="ButtonSub">
                                <a href="index.php">
                                    <div class="submit_box">
                                        <p>Back</p>
                                    </div>
                                </a>
                                <input type="submit" name="makeTransferee" value="Submit" class="submit_box1">
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

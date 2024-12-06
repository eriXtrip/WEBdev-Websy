<?php

session_start();

    if (isset($_POST["find-LRN"])) {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $LRNsearch = $_POST["lrn"];

            try {
                require_once "dbh.inc.php";
                $query = "SELECT *
                          FROM transferee
                          WHERE LRN = :LRNsearch;";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":LRNsearch", $LRNsearch);
                $stmt->execute();
                
                $Results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if(!empty($Results)){

                    $_SESSION['Results'] = $Results;

                    // //var_dump($Results);
                   
                    if ($Results[0]['ENROLLMENT_STATUS'] == 4 && $Results[0]['Cert_of_G_Moral'] == 1 && $Results[0]['Rec_Letter'] == 1 && $Results[0]['Cert_of_Trans'] == 1 && $Results[0]['Birth_Cert'] == 1 && $Results[0]['FORM137'] == 1 && $Results[0]['FORM138'] == 1) {
                        //last step on tracker
                        header("Location: etsResultEnrolled.php");
                        exit();
                       
                    } else if ($Results[0]['ENROLLMENT_STATUS'] == 3) {
                        //3 step
                        //var_dump($Results);
                        header("Location: etsResultPending.php");
                        exit();
                        
                    } else if ($Results[0]['ENROLLMENT_STATUS'] == 2) {
                        //2 step
                        //var_dump($Results);
                        header("Location: etsResultOnQ.php");
                        exit();
                    }                 
                    
                    foreach ($Results as $Result) {
                        echo "Welcome " . htmlspecialchars($Result['TR_First_Name']) . " " . htmlspecialchars($Result['TR_Last_Name']);
                    }
                } 
                    
            } catch (PDOException $e) {
                // Log the error and display a user-friendly message
                error_log("Query failed: " . $e->getMessage());
                die("Something went wrong. Please try again later.");
            }
        } else {
            exit(); // Stop script execution
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
    <link href="css/enterlrn.css" rel="stylesheet">
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
            <h1>ENROLLMENT TRACKING SYSTEM</h1>
            
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="find-LRN" class="container">
                    <div class="BackBox">
                        <a href="enrollmentTracker.php">
                            <div class="backButton">
                                <img src="assets/Back.png" alt="back">
                                <div style="margin-left: 10%;">
                                    <p>Back</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="BackBox">
                        <div class="LRNBox">
                            <div id="Label">
                                <h4>Enter Learner Reference Number (LRN)</h4>
                            </div>
                            <?php
                                $LRN = '';
                                $LRN_error = 'Ex. 9024903294302'; // Default placeholder text
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["find-LRN"])) {
                                    $lrn = $_POST["lrn"];
                                    if (!ctype_digit($lrn)) {
                                        $LRN_error = 'Number only';
                                    }else if(empty($Results)){
                                        $LRN_error = 'LRN not found';
                                    }else {
                                        $LRN = $lrn;
                                    }

                                    
                                }
                            ?>
                            <input type="text" id="LRNsearch" name="lrn" placeholder="<?php echo htmlspecialchars($LRN_error); ?>" class="InputLRN" required value="<?php echo htmlspecialchars($LRN); ?>">
                        </div>
                    </div>
                    <div class="BackBox1">
                        <h4><input type="submit" name="find-LRN" value="Submit" class="submitButton"></h4>
                    </div>

                    <div class="boxes">
                        <a href="method2TransfereeTrack.php"><span style="font-size: 12px; color: #5582BF;"><p>Forgot your LRN? Try Another Method.</p></span></a>
                    </div>

                </form>
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

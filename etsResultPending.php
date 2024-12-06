<?php
    session_start();

    if (isset($_SESSION['Results'])) {
        $Results = $_SESSION['Results'];
        //var_dump($Results);
        
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
    <link href="css/etsResultOnQStyle.css" rel="stylesheet">
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
                    <img src = "assets/Blue Mark.png" alt = "Blue Mark" class = "imgs">
                    <p>STEP 4</p>
                    <b>Enrolled</b>
                </div>
            </div>
        </div>
        <div class="content-2">
            <div class = "requirement-box">
                <div class = "top-section">
                    <a class = "back-button" href="index.php"> 
                        <img src = "assets/backWithBilog.png" alt = "back" id="backButton">
                    </a>
                    <div class="checkingRequirementText">
                        Checking Requirements
                    </div>
                    <div class = "legends">
                        <div class = "completed">
                            <img src = "assets/greenBox.png" alt = "completed" class = "boxes">
                            - Completed
                        </div>
                        <div class = "notCompleted">
                            <img src = "assets/redBox.png" alt = "not completed" class = "boxes">
                            - Not Completed
                        </div>
                    </div>
                </div>
                <div class ="bottom-section">
                    <div class = "requirements1" style="background: #FFC7C7;">
                        <img src = "assets/form137.png" alt = "Form 137" class = "reqImages">
                            <h3>Form 137</h3>
                            <p>Your previous school will send this to us.</p>
                    </div>
                    <div class = "requirements2" style="background: #FFC7C7;">
                        <img src = "assets/birthCertificate.png" alt = "Birth Certificate" class = "reqImages">
                            <h3 class="specialText">Birth Certificate</h3>
                            <p>This can be acquired on your nearest PSA Office or Municipal Bulding</p>
                    </div>
                    <div class = "requirements3" style="background: #FFC7C7;">
                        <img src = "assets/form138.png" alt = "Form 138" class = "reqImages">
                            <h3>Form 138</h3>
                            <p>Your previous school will send this to us.</p>
                    </div>
                    <div class = "requirements4" style="background: #FFC7C7;">
                        <img src = "assets/goodMoral.png" alt = "Good Moral" class = "reqImages">
                            <h3>Good Moral</h3>
                            <p>You can get this on your current school Guidance Counselor.</p>
                    </div>
                    <div class = "requirements5" style="background: #FFC7C7;">
                        <img src = "assets/clearance.png" alt = "Clearance" class = "reqImages">
                            <h5>Recommendation Letter</h5>
                            <p>You can get this on your current school Office.</p>
                    </div>
                    <div class = "requirements6" style="background: #FFC7C7;">
                        <img src = "assets/goodMoral.png" alt = "2 by 2 ID Pictures" class = "reqImages">
                            <h3 class = "specialText">Certificate Of Transfer</h3>
                            <p>You can get this on your current school Office.<br><br><br></p>
                    </div>
                </div>
                <div class="bottom-text">Your enrollment is in process; we'll keep you informed once it's finalized.</div>
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
    <script>
        
        var Results = <?php echo json_encode($Results); ?>;

        if (Results[0]['FORM137'] == 1) {
            var requirements1 = document.querySelector('.requirements1');
            if (requirements1) {
                requirements1.style.backgroundColor = '#D0F5D6';
            }
        }
        if (Results[0]['FORM138'] == 1) {
            var requirements3 = document.querySelector('.requirements3');
            if (requirements3) {
                requirements3.style.backgroundColor = '#D0F5D6';
            }
        }
        if (Results[0]['Birth_Cert'] == 1) {
            var requirements2 = document.querySelector('.requirements2');
            if (requirements2) {
                requirements2.style.backgroundColor = '#D0F5D6';
            }
        }
        if (Results[0]['Cert_of_G_Moral'] == 1) {
            var requirements4 = document.querySelector('.requirements4');
            if (requirements4) {
                requirements4.style.backgroundColor = '#D0F5D6';
            }
        }
        if (Results[0]['Rec_Letter'] == 1) {
            var requirements5 = document.querySelector('.requirements5');
            if (requirements5) {
                requirements5.style.backgroundColor = '#D0F5D6';
            }
        }
        if (Results[0]['Cert_of_Trans'] == 1) {
            var requirements6 = document.querySelector('.requirements6');
            if (requirements6) {
                requirements6.style.backgroundColor = '#D0F5D6';
            }
        }
    </script>
</html>
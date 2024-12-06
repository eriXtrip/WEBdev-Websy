<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="css/etsSyle.css" rel="stylesheet">
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
            <div class="centered-text">
                <h1 class="ETS">ENROLLMENT TRACKING SYSTEM</h1>
            </div>
            <div class="BackBox">
                <a href="index.php">
                    <div class="backButton">
                        <img src="assets/Back.png" alt="back">
                        <div style="margin-left: 10%;">
                            <p>Back</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="enrollment-tracking-system">
                <a class="option" href="EnterLRNRegST.php">
                    <div class = imgs><img src="assets/Student Male.png" alt="Regular"></div>
                    <div class="option-text">For Regular Students</div>
                    <div><button class="select-button">Select</button></div>
                </a>
                <a class="option" href="EnterIncoG1.php">
                    <div class = imgs><img src="assets/Students.png" alt="Upcoming Grade 1"></div>
                    <div class="option-text">For Incoming Grade 1 Students</div>
                    <div><button class="select-button">Select</button></div>
                </a>
                <a class="option" href="TranfStuEnterLRN.php">
                    <div class = imgs><img src="assets/School Backpack.png" alt="Transferee"></div>
                    <div class="option-text">For Transferees</div>
                    <div><button class="select-button">Select</button></div>
                </a>
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
</html>
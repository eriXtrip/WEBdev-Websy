<?php
session_start();

    if (isset($_POST["find-admin"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $SearchAdmin = $_POST["Username"];
            $AdminPWord = $_POST["Password"];

            try {
                require_once "dbh.inc.php";
                $query = "SELECT *
                          FROM ADMIN
                          WHERE Username = :SearchAdmin;";

                $stmt = $pdo->prepare($query);

                // Bind parameter
                $stmt->bindParam(":SearchAdmin", $SearchAdmin);

                $stmt->execute();

                // Check if username exists
                if ($stmt->rowCount() > 0) {
                    // Username exists, fetch the result
                    $Results = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Check if the password matches
                    if (password_verify($AdminPWord, $Results['Password'])) {

                        // Set session variables
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $SearchAdmin;

                        // Redirect to admin overview page
                        header("Location: adminoverview.php");
                        exit();

                    } else {
                        // Password is incorrect
                        $passwordError =  "Incorrect password!";
                    }
                } else {
                    // Username does not exist
                    $usernameError = "Username not found!";
                }

            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
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
    <link href="css/loginstyle.css" rel="stylesheet">
    <title>iEMS</title>
</head>
<body>
    <header>
        <div id="LogoBox1">  
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
        </div>
    </header>

    <section>
        <div class="OptionBox">

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

            <div class="logo2">
                    <img src="assets/logov2.png" alt="logo2">
            </div>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="find-admin" class="inputBox">
                <label>Username</label>
                <input type="text" id="Username" name="Username" class="Username" placeholder="<?php echo isset($usernameError) ? htmlspecialchars($usernameError) : ''; ?>">

                <label>Password</label>
                <input type="password" id="Password" name="Password" class="Password" placeholder="<?php echo isset($passwordError) ? htmlspecialchars($passwordError) : ''; ?>">
            
                <div class="checkBox">
                    <div class="boxInt1">
                        <input type="checkbox">
                        <p>Remember me for 7 days</p>
                    </div>
                    <div class="boxInt2">
                        <p>Forgot Password</p>
                    </div>
                </div>
                
                <div class="submit">
                    <input type="submit" name="find-admin" value="Sign In" class="submit">
                </div>
            </form>
        </div>
    </section>
</body>
</html>
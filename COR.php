<?php
    session_start();

    $LRN = '';
    $NAME = '';
    $GENDER = '';
    $SECTION = '';
    $GradeLevel = '';
    $TEACHERNAME = '';

    $schedM = '';
    $schedT = '';
    $schedW = '';
    $schedTH = '';
    $schedF = '';

    if (isset($_SESSION['Results'])) {
        $Results = $_SESSION['Results'];

        $LRN = $Results[0]['LRN'];

        

        if(empty($Results[0]['ST_Middle_Name']) && empty($Results[0]['ST_Suffix'])){
            $NAME = $Results[0]['ST_First_Name'] ." ". $Results[0]['ST_Last_Name'] ;

        }else if(!empty($Results[0]['ST_Middle_Name']) && empty($Results[0]['ST_Suffix'])){
            $NAME = $Results[0]['ST_First_Name'] ." ". $Results[0]['ST_Middle_Name'][0] .". ". $Results[0]['ST_Last_Name'] ;

        }else if(empty($Results[0]['ST_Middle_Name']) && !empty($Results[0]['ST_Suffix'])){
            $NAME = $Results[0]['ST_First_Name'] ." ". $Results[0]['ST_Last_Name'] ." ". $Results[0]['ST_Suffix'];
        }else{
            $NAME = $Results[0]['ST_First_Name'] ." ". $Results[0]['ST_Middle_Name'][0] .". ". $Results[0]['ST_Last_Name'] ." ". $Results[0]['ST_Suffix'];
        }

        if($Results[0]['Gender'] == 'M'){
            $GENDER = 'Male';
        }else{
            $GENDER = 'Female';
        }

       $GradeLevel = $Results[0]["Grade_level"];


        try{
            require_once "dbh.inc.php";

            $query = "SELECT *
                    FROM ENROLL
                    WHERE LRN = :LRN;";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":LRN", $Results[0]['LRN']);

            $stmt->execute();

            $Enroll = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $SECTION = $Enroll[0]['Section_Name'];

        }catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        try{
            require_once "dbh.inc.php";

            $query = "SELECT *
                    FROM ENROLL
                    NATURAL JOIN SECTION
                    NATURAL JOIN TEACHER
                    WHERE LRN = :LRN;";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":LRN", $Results[0]['LRN']);

            $stmt->execute();

            $Teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(empty($Teacher[0]['TH_Prefix']) && empty($Teacher[0]['TH_Middle_Name']) && empty($Teacher[0]['TH_Suffix'])){
                $TEACHERNAME = $Results[0]['ST_First_Name'] ." ". $Results[0]['ST_Last_Name'] ;
    
            }else if(!empty($Teacher[0]['TH_Prefix']) && empty($Teacher[0]['TH_Middle_Name']) && empty($Teacher[0]['TH_Suffix'])){
                $TEACHERNAME = $Teacher[0]['TH_Prefix'] ." ". $Teacher[0]['TH_First_Name'] ." ". $Teacher[0]['TH_Middle_Name'][0] .". ". $Teacher[0]['TH_Last_Name'] ;
    
            }else if(!empty($Teacher[0]['TH_Middle_Name']) && empty($Teacher[0]['TH_Suffix'])){
                $TEACHERNAME = $Teacher[0]['TH_Prefix'] ." ". $Teacher[0]['TH_First_Name'] ." ". $Teacher[0]['TH_Middle_Name'][0] .". ". $Teacher[0]['TH_Last_Name'] ;
    
            }else if(empty($Teacher[0]['TH_Middle_Name']) && !empty($Teacher[0]['TH_Suffix'])){
                $TEACHERNAME = $Teacher[0]['TH_Prefix'] ." ". $Teacher[0]['TH_First_Name'] ." ". $Results[0]['TH_Last_Name'] ." ". $Teacher[0]['TH_Suffix'];
            }else{
                $TEACHERNAME = $Teacher[0]['TH_Prefix'] ." ". $Teacher[0]['TH_First_Name'] ." ". $Teacher[0]['TH_Middle_Name'][0] .". ". $Teacher[0]['TH_Last_Name'] ." ". $Results[0]['TH_Suffix'];
            }

        }catch (PDOException $e) {
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
                Section_Name = :Grade
                AND daySCHED = 'M';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":Grade", $Enroll[0]['Section_Name']);

            $stmt->execute();

            $schedM = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
                Section_Name = :Grade
                AND daySCHED = 'T';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":Grade", $Enroll[0]['Section_Name']);

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
                Section_Name = :Grade
                AND daySCHED = 'W';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":Grade", $Enroll[0]['Section_Name']);

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
                Section_Name = :Grade
                AND daySCHED = 'TH';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":Grade", $Enroll[0]['Section_Name']);

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
                Section_Name = :Grade
                AND daySCHED = 'F';";

            $stmt = $pdo->prepare($query);

            // Bind parameter
            $stmt->bindParam(":Grade", $Enroll[0]['Section_Name']);

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
    <link href="css/CORstyle.css" rel="stylesheet">
    <title>iEMS</title>
</head>
<body>
    <section>
        <div class="content">
            <div class="contentBox1">
                <div class="box1">
                    <img src="assets/logov2.png" alt="logo" id="logoHeader">
                    <div class="schoolname">
                        <h5><span style="color: #FCA304;">IBALON</span></h5>
                        <h5><span style="color: #039B11;">CENTRAL</span></h5>
                        <h5><span style="color: #5582BF;">SCHOOL</span></h5>
                    </div>
                </div>  
                
                <div class="box2">
                    <div class="label1">
                        <p>LRN: </p>
                        <p>Name: </p>
                        <p>Gender: </p>
                    </div>
                    <div class="label2">
                        <p id="LRN"><?php echo htmlspecialchars($LRN); ?></p>
                        <p id="FullName"><?php echo htmlspecialchars($NAME); ?></p>
                        <p id="GENDER"><?php echo htmlspecialchars($GENDER); ?></p>
                    </div>
                </div>
                <div class="box3">
                    <div class="label1">
                        <p>School Year: </p>
                        <p>Grade & Section: </p>
                        <p>Class Adviser: </p>
                    </div>
                    <div class="label3">
                        <p id="SYear">2023 - 2024 </p>
                        <p id="GradeSection"><?php echo "Grade " . htmlspecialchars($GradeLevel) . " " . htmlspecialchars($SECTION); ?></p>
                        <p id="ClassAdviser"><?php echo htmlspecialchars($TEACHERNAME); ?></p>
                    </div>
                </div>

            </div>

            <div class="contentBox2">
                <div class="backButton">
                    <a href="enrollmentTracker.php">
                        <img src="assets/Back.png" alt="back">
                        <div style="margin-left: 10%;">
                            <p>Back</p>
                        </div>
                    </a>    
                </div>
            </div>


            <div class="contentBox3">
                <div class="SchedHead">
                    <div class="SchedHeadLabel">
                        <div id="labelBox1">
                            <p>TIME SCHEDULE</p>
                        </div>
                        <div id="labelBox1">
                            <p>MONDAY</p>
                        </div>
                        <div id="labelBox1">
                            <p>TUESDAY</p>
                        </div>
                        <div id="labelBox1">
                            <p>WEDNESDAY</p>
                        </div>
                        <div id="labelBox1">
                            <p>THURSDAY</p>
                        </div>
                        <div id="labelBox1">
                            <p>FRIDAY</p>
                        </div>
                    </div>
                </div>
                <div class="rowsContent1">
                    <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[0]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[0]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p> 
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[0]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[0]['TH_First_Name']) ." ". htmlspecialchars($schedM[0]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[0]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[0]['TH_First_Name']) ." ". htmlspecialchars($schedT[0]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[0]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[0]['TH_First_Name']) ." ". htmlspecialchars($schedW[0]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[0]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[0]['TH_First_Name']) ." ". htmlspecialchars($schedTH[0]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[0]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[0]['TH_First_Name']) ." ". htmlspecialchars($schedF[0]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
                </div>
                <div class="rowsContent2">
                <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[1]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[1]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                        <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[1]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[1]['TH_First_Name']) ." ". htmlspecialchars($schedM[1]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[1]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[1]['TH_First_Name']) ." ". htmlspecialchars($schedT[1]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[1]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[1]['TH_First_Name']) ." ". htmlspecialchars($schedW[1]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[1]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[1]['TH_First_Name']) ." ". htmlspecialchars($schedTH[1]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                        <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[1]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[1]['TH_First_Name']) ." ". htmlspecialchars($schedF[1]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
                </div>
                <div class="rowsContent1">
                    <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[2]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[2]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[2]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[2]['TH_First_Name']) ." ". htmlspecialchars($schedM[2]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[2]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[2]['TH_First_Name']) ." ". htmlspecialchars($schedT[2]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[2]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[2]['TH_First_Name']) ." ". htmlspecialchars($schedW[2]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[2]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[2]['TH_First_Name']) ." ". htmlspecialchars($schedTH[2]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[2]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[2]['TH_First_Name']) ." ". htmlspecialchars($schedF[2]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
                </div>
                <div class="rowsContent2">
                    <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[3]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[3]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[3]['Subject_Name']); ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[3]['Subject_Name']); ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[3]['Subject_Name']); ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[3]['Subject_Name']); ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[3]['Subject_Name']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="rowsContent1">
                    <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[4]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[4]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[4]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[4]['TH_First_Name']) ." ". htmlspecialchars($schedM[4]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[4]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[4]['TH_First_Name']) ." ". htmlspecialchars($schedT[4]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[4]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[4]['TH_First_Name']) ." ". htmlspecialchars($schedW[4]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                        <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[4]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[4]['TH_First_Name']) ." ". htmlspecialchars($schedTH[4]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[4]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[4]['TH_First_Name']) ." ". htmlspecialchars($schedF[4]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
                </div>
                <div class="rowsContent2">
                <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[5]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[5]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[5]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[5]['TH_First_Name']) ." ". htmlspecialchars($schedM[5]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[5]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[5]['TH_First_Name']) ." ". htmlspecialchars($schedT[5]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[5]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[5]['TH_First_Name']) ." ". htmlspecialchars($schedW[5]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[5]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[5]['TH_First_Name']) ." ". htmlspecialchars($schedTH[5]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[5]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[5]['TH_First_Name']) ." ". htmlspecialchars($schedF[5]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
                </div>
                <div class="rowsContent1">
                    <div class="rowLabel">   
                        <div id="labelBox">
                            <p><?php
                            
                            $time_in = $schedM[6]['Time_IN'];
                            $parts_in = explode(':', $time_in);
                            $time_in = $parts_in[0] . ':' . $parts_in[1];
                            
                            $time_out = $schedM[6]['Time_OUT'];
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
                            
                            echo $time_in ." - ". $time_out; ?></p>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedM[6]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedM[6]['TH_First_Name']) ." ". htmlspecialchars($schedM[6]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedT[6]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedT[6]['TH_First_Name']) ." ". htmlspecialchars($schedT[6]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                        <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedW[6]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedW[6]['TH_First_Name']) ." ". htmlspecialchars($schedW[6]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedTH[6]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedTH[6]['TH_First_Name']) ." ". htmlspecialchars($schedTH[6]['TH_Last_Name']); ?></P>
                        </div>
                        <div id="labelBox">
                            <p style="font-weight: 1000;"><?php echo htmlspecialchars($schedF[6]['Subject_Name']); ?></p>
                            <P><?php echo htmlspecialchars($schedF[6]['TH_First_Name']) ." ". htmlspecialchars($schedF[6]['TH_Last_Name']); ?></P>
                        </div>
                    </div>
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

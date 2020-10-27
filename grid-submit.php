<?php
    # when submit or skip button clicked on grid screen, update database with grid variables
    session_start();
    # database credentials
    $db_server = $_SESSION['db_server'];
    $db_username = $_SESSION['db_username'];
    $db_password = $_SESSION['db_password'];
    $db_database = $_SESSION['db_database'];
    # database variables
    $ratings_table = $_SESSION['ratings_table'];
    $lab_id_column = $_SESSION['lab_id_column'];
    $crn_column = $_SESSION['crn_column'];
    $student_id_column = $_SESSION['student_id_column'];
    $lab_question_column = $_SESSION['lab_question_column'];
    $difficulty_column = $_SESSION['difficulty_column'];
    $interest_column = $_SESSION['interest_column'];
    # connect to database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # read posted values and session variables
        $grid_x_value = $_POST['x_value'];
        $grid_y_value = $_POST['y_value'];
        $current_question = $_SESSION['current_question'];
        $student_id = $_SESSION['student_id'];
        $lab_id = $_SESSION['lab_id'];
        $crn = $_SESSION['crn'];
        # update record with values from grid
        $update = "UPDATE $ratings_table SET $difficulty_column='$grid_x_value', $interest_column='$grid_y_value' WHERE $lab_id_column='$lab_id' AND $crn_column='$crn' AND $student_id_column='$student_id' AND $lab_question_column='$current_question'";
        echo $update;
        if($conn->query($update) === TRUE){
            $conn->close();
            # if rating successful, go to next question
            header("Location: grid.php");
            exit;
        }else{
            $conn->close();
            header("Location: error.html");
            exit;
        }
    }
?>
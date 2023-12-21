<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'db.php';

$response = array();

$maxStudents = 36;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $projectTitle = mysqli_real_escape_string($conn, $_POST['projectTitle']); 
    $timeSlot = mysqli_real_escape_string($conn, $_POST['timeSlot']);

    // Check if the student is already registered
    $check_query = "SELECT * FROM students WHERE studentid = '$studentid'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $response['success'] = false;
        $response['message'] = "You are already registered. Do you want to change your registration?";
    } else {
        // Check if the maximum number of students is reached
        $count_query = "SELECT COUNT(*) as total_students FROM students";
        $count_result = $conn->query($count_query);
        $total_students = $count_result->fetch_assoc()['total_students'];

        if ($total_students >= $maxStudents) {
            $response['success'] = false;
            $response['message'] = "Registration failed. Maximum number of students reached ({$maxStudents}).";
        } else {
            // Insert the student data into the database
            $insert_query = "INSERT INTO students (firstname, lastname, studentid, email, phone, projectTitle, timeSlot) VALUES ('$firstname', '$lastname', '$studentid', '$email', '$phone', '$projectTitle', '$timeSlot')";

            if ($conn->query($insert_query) === TRUE) {
                // Update available seats in the time_slots table
                $update_query = "UPDATE time_slots SET available_seats = available_seats - 1 WHERE timeSlot_id = '$timeSlot'";
                $conn->query($update_query);

                $response['success'] = true;
                $response['message'] = "Registration successful!";
                
                // Redirect to registered_students.html
                header("Location:https://php-app-mu.vercel.app/registered_students.html");
                exit();
            } else {
                $response['success'] = false;
                $response['message'] = "Error: " . $conn->error;
            }
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
?>

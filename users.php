<?php
require_once('connection.php');

if (isset($_POST['userForm'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $birthday = $_POST['date'];
    $isAdmin = $_POST['isAdmin'];
    $success = "";
    // Check if the email already exists, but only if the user ID is not provided
    if (!isset($_POST['userId'])) {
        $sql_check = "SELECT COUNT(*) as count FROM users WHERE Email='$email'";
        $result_check = $conn->query($sql_check);
        $count = $result_check->fetch_assoc()['count'];
        if ($count > 0) {
            echo json_encode(array('error' => 'This email already exists'));
            return;
        }
    }
    // Update User
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        // Update an existing user
        $sql = "UPDATE users SET name='$name', email='$email', password='$password', country='$country', gender='$gender', phone='$phone', birthday='$birthday', isAdmin='$isAdmin' WHERE user_id=$userId";
        $success = "User Updated Successfully!";
    } else {
        // Add a new user
        $sql = "INSERT INTO users (name, email, password, country, gender, phone, birthday, isAdmin) VALUES ('$name', '$email', '$password', '$country', '$gender', '$phone', '$birthday', '$isAdmin')";
        $success = "User Inserted Successfully!";
    }
    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => $success));
    }
} else if(isset($_GET['users'])){
    try{
        // Fetch the data from the database
        $sql = "SELECT * FROM users WHERE isAdmin = 'false'";
        $result = $conn->query($sql);

        // Convert the data to JSON format
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);

    }
    catch (Exception $e){
        echo "[]";
    }
} else if(isset($_GET['adminUsers'])){
    try{
        // Fetch the data from the database
        $sql = "SELECT * FROM users WHERE isAdmin = 'true'";
        $result = $conn->query($sql);

        // Convert the data to JSON format
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);

    }
    catch (Exception $e){
        echo "[]";
    }
}
else if(isset($_GET['user'])){
    try{
        $u = $_GET['user'];
        // Fetch the data from the database
        $sql = "SELECT * FROM users WHERE user_id = ".$u;
        $result = $conn->query($sql);

        // Convert the data to JSON format
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);

    }
    catch (Exception $e){
        echo "[]";
    }
} else if (isset($_GET['deleteuser'])) {
    $user_id = $_GET['deleteuser'];

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE user_id = $user_id";

    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => 'User deleted successfully!'));
    }
} else if (isset($_POST['profileForm'])) {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $birthday = $_POST['date'];
    $success = "";
    // Delete the user from the database
    $sql = "UPDATE users SET name='$name', email='$email', country='$country', gender='$gender', phone='$phone', birthday='$birthday' WHERE user_id=$userId";

    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => 'User Updated Successfully!'));
    }
} else if(isset($_POST['updatePassword'])){
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    $sql = "UPDATE users SET password='$password' WHERE user_id=$userId";
    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => 'Password Updated Successfully!'));
    }
}

$conn->close();
?>

<?php
require_once('connection.php');

if(isset($_POST['commentForm'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $body = $_POST['body'];
    $post_id = $_POST['postId'];

    $sql = "INSERT INTO comments (name, email, body, post_id) VALUES ('$name', '$email', '$body', '$post_id')";
    
    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => 'Comment added successfully!'));
    }
}else if(isset($_GET['comments'])){
    try{
        // Fetch the data from the database
        $sql = "SELECT * FROM comments";
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
} else if(isset($_GET['comment'])){
    try{
        $u = $_GET['comment'];
        // Fetch the data from the database
        $sql = "SELECT * FROM comments WHERE comment_id = ".$u;
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
?>
<?php
require_once('connection.php');

if (isset($_POST['postForm'])) {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category = $_POST['category'];
    $createdAt = $_POST['date'];
    $success = "";

    if(isset($_POST['postId'])){
        $postId = $_POST['postId'];
        $sql = "UPDATE posts SET author='$author', title='$title', body='$body', category='$category', createdAt='$createdAt' WHERE post_id=$postId";
        $success = "Post Updated Successfully!";
    } else {
        $sql = "INSERT INTO posts (author, title, body, category, createdAt) VALUES ('$author','$title', '$body', '$category', '$createdAt')";
        $success = "Post Inserted Successfully!";
    }
    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => $success));
    }
} else if(isset($_GET['posts'])){
    try{
        // Fetch the data from the database
        $sql = "SELECT * FROM posts";
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
} else if(isset($_GET['post'])){
    try{
        $u = $_GET['post'];
        // Fetch the data from the database
        $sql = "SELECT * FROM posts WHERE post_id = ".$u;
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
} else if (isset($_GET['deletepost'])){
    $post_id = $_GET['deletepost'];
    $sql = "DELETE FROM posts WHERE post_id = $post_id";

    if ($conn->query($sql) === FALSE) {
        echo json_encode(array('error' => $conn->error));
    } else {
        echo json_encode(array('success' => 'Post deleted successfully!'));
    }
}

$conn->close();
?>
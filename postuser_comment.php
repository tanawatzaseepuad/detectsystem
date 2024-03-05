<?php
include_once 'Comment.php';

$com = new Comment();

if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $status = $_POST['status'];
    $camera = $_POST['camera'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    
    if (empty($name) || empty($comment) || empty($status)){
        echo "<script>alert('Field must not be empty');</script>";
        echo "<script>window.location.href = 'comment_user.php?msg=';</script>";
    } else {
        $com->setData($name, $comment, $status, $camera, $date, $type);
        if ($com->create()) {
            echo "<script>alert('Sent successfully');</script>";
            echo "<script>window.location.href = 'comment_user.php?msg=';</script>";
        }
    }
}
?>
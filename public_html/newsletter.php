<?php
//require_once 'content/incl/init.php';

if (!empty($_POST['email'])) {
    $Newsletter = new Newsletter();
    $Newsletter->email = ($_POST["email"]);
    $Newsletter->name = ($_POST["name"]);
    $id = $Newsletter->signNewsletter(email , name);
    header("Location: index.php?success");
} else {
    header("Location: index.php");
}

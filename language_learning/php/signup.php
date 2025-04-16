<?php

// ⚠️ create a alert box to write account created successfully

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if ($password !== $cpassword) {
        echo "Passwords do not match.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, mobile, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $mobile, $hashed_password);

    if ($stmt->execute()) {
        // echo "Signup successful. <a href='../html/login.html'>Login here</a>";
        echo "Account created Successfully !";
        header("Location: ../html/login.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

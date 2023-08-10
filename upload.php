<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Database connection
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Upload image
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        die("Only JPEG and PNG files are allowed");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Prepare and execute the database insertion
        $stmt = $conn->prepare("INSERT INTO uploads (email, image_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $targetFile);
        
        if ($stmt->execute()) {
            echo "File uploaded and data stored successfully.";
        } else {
            echo "Error storing data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
}
?>

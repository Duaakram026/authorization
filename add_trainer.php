<?php
header('Content-Type: application/json');

// Database credentials
$host = 'localhost';
$db   = 'trainers';
$user = 'root'; // change if needed
$pass = '';     // change if needed

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

// Escape and prepare data
$full_name = $conn->real_escape_string($data['fullName']);
$about_you = $conn->real_escape_string($data['aboutYou']);
$photo = $conn->real_escape_string($data['photo']);
$typed_certs = $conn->real_escape_string(json_encode($data['typedCerts']));
$pdfs = $conn->real_escape_string(json_encode($data['pdfs']));

// Insert query
$sql = "INSERT INTO trainer (full_name, about_you, photo, typed_certs, pdfs)
        VALUES ('$full_name', '$about_you', '$photo', '$typed_certs', '$pdfs')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>

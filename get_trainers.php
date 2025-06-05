<?php
header('Content-Type: application/json');

// DB credentials
$host = 'localhost';
$db   = 'trainers';
$user = 'root'; // change if needed
$pass = '';     // change if needed

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Fetch all trainers
$sql = "SELECT * FROM trainer ORDER BY id DESC";
$result = $conn->query($sql);

$trainers = [];

while ($row = $result->fetch_assoc()) {
    $trainers[] = [
        'fullName' => $row['full_name'],
        'aboutYou' => $row['about_you'],
        'photo' => $row['photo'],
        'typedCerts' => json_decode($row['typed_certs']),
        'pdfs' => json_decode($row['pdfs'])
    ];
}

echo json_encode(['success' => true, 'trainers' => $trainers]);

$conn->close();
?>

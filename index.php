<?php

// Allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database configuration
include('config.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Retrieve attendance for a specific employee
    $employeeId = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;

    if ($employeeId !== null) {
        $result = $conn->query("SELECT * FROM attendance WHERE employee_id = $employeeId");
        $attendanceData = [];

        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }

        echo json_encode($attendanceData);
    } else {
        echo json_encode(["error" => "Missing 'employee_id' parameter"]);
    }
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(["error" => "Method not allowed"]);
}

$conn->close();

?>

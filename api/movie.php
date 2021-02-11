<?php

require_once './classes/Movie.php';
require_once './classes/Database.php';

header("Content-Type: application/json; charset=UTF-8");

if (!$_SERVER['REQUEST_METHOD'] === 'GET' || !$_SERVER['REQUEST_METHOD'] === 'POST') {
    http_response_code(405);
    echo json_encode(array(
        "status" => 405,
        "message" => "You cannot " . $_SERVER['REQUEST_METHOD'] . " this endpoint."
    ));
    exit();
}

$database = new Database();
$db = $database->getConnection();
    
$movie = new Movie($db);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $response = $movie->getAllMovies();  
    http_response_code($response["status"]);
    echo json_encode($response);
} 

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->title) && isset($data->director) && isset($data->release_date) && isset($data->genre) && isset($data->poster)) {
    
        $movie->title = $data->title;
        $movie->director = $data->director;
        $movie->release_date = $data->release_date;
        $movie->genre = $data->genre;
        $movie->poster = $data->poster;

        $response = $movie->createMovie();
    
    } else {
        $response = array("status" => 401, "message" => "Malformed request.");
    }

    http_response_code($response["status"]);
    echo json_encode($response);
}

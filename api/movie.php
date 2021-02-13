<?php

require_once './classes/Movie.php';
require_once './classes/Database.php';

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $database = new Database();
        $db = $database->getConnection();

        $movie = new Movie($db);

        if ($_GET['id']) {
            $movie->id = (int) $_GET['id'];
            $response = $movie->getMovie();
        } else {
            $response = $movie->getAllMovies();
        }
        http_response_code($response["status"]);
        echo json_encode($response);
        
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $data = $data->data;

        if (isset($data->title) && isset($data->director) && isset($data->release_date) && isset($data->genre) && isset($data->poster)) {
            $database = new Database();
            $db = $database->getConnection();

            $movie = new Movie($db);

            $movie->title = $data->title;
            $movie->director = $data->director;
            $movie->release_date = $data->release_date;
            $movie->genre = $data->genre;
            $movie->poster = $data->poster;

            $response = $movie->createMovie();
        } else {
            $response = array("status" => 400, "message" => "Malformed request.");
        }

        http_response_code($response["status"]);
        echo json_encode($response);

        break;
    default:
        http_response_code(405);
        echo json_encode(array(
            "status" => 405,
            "message" => "You cannot " . $_SERVER['REQUEST_METHOD'] . " this endpoint."
        ));
        break;
}

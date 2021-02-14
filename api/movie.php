<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
header('Access-Control-Max-Age: 86400');

require_once './classes/Movie.php';
require_once './classes/Database.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        header("HTTP/1.1 200 OK");
        break;
    case 'GET':
        $database = new Database();
        $db = $database->getConnection();

        $movie = new Movie($db);

        if (isset($_GET['id'])) {
            $movie->id = (int) $_GET['id'];
            $response = $movie->getMovie();
        } else {
            $response = $movie->getAllMovies();
        }
        http_response_code($response["status"]);
        echo json_encode($response);
        
        break;
    case 'POST':
        $request = json_decode(file_get_contents("php://input"));

        if (isset($request->data->title) && isset($request->data->director) && isset($request->data->release_date) && isset($request->data->genre) && isset($request->data->poster)) {
            $database = new Database();
            $db = $database->getConnection();

            $movie = new Movie($db);

            $movie->title = $request->data->title;
            $movie->director = $request->data->director;
            $movie->release_date = $request->data->release_date;
            $movie->genre = $request->data->genre;
            $movie->poster = $request->data->poster;

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

<?php

class Movie
{
    // Connection
    private $conn;

    // Columns
    public $id;
    public $title;
    public $director;
    public $release_date;
    public $genre;
    public $poster;

    // Database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllMovies()
    {
        try {
            $sqlQuery = "SELECT `id`, `title`, `director`, `release_date`, `genre`, `poster` 
                        FROM `Movie`";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data["data"] = $result == false ? array() : $result;
            $data["status"] = 200;
            
            return $data;
        } catch (Exception $e) {
            return array("status" => 500, "message" => "Something went wrong.");
        }
    }

    public function getMovie()
    {
        try {
            $sqlQuery = "SELECT `id`, `title`, `director`, `release_date`, `genre`, `poster` 
                    FROM `Movie`
                    WHERE `id` = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data["data"] = $result == false ? array() : $result;
            $data["status"] = 200;

            return $data;
        } catch (Exception $e) {
            return array("status" => 500, "message" => "Something went wrong.". $e);
        }
    }


    public function createMovie()
    {
        try {
            $sqlQuery = "INSERT INTO `Movie`
                        SET `title` = :title, 
                            `director` = :director,
                            `release_date` = :release_date,
                            `genre` = :genre,
                            `poster` = :poster";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":director", $this->director);
            $stmt->bindParam(":release_date", $this->release_date);
            $stmt->bindParam(":genre", $this->genre);
            $stmt->bindParam(":poster", $this->poster);

            if ($stmt->execute()) {
                return array("status" => 201, "message" => "Successfully added movie.");
            }
            
            return array("status" => 500, "message" => "Something went wrong");
        } catch (Exception $e) {
            return array("status" => 500, "message" => "Something went wrong");
        }
    }
}

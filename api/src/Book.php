<?php
require_once "Connection.php";

class Book
{
    private $id;
    private $author;
    private $title;
    private $description;

    public function __construct()
    {
        $this->id = -1;
        $this->author = "";
        $this->title = "";
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    static public function allBooks(mysqli $connection)
    {
        $query = "SELECT * FROM `book`";
        $ret = [];
        $result = $connection->query($query);
        if ($result == true) {
            foreach ($result as $row) {
                $loadedBook = new Book();
                $loadedBook->id = $row['id'];
                $loadedBook->author = $row['author'];
                $loadedBook->title = $row['title'];
                $loadedBook->description = $row['description'];

                $ret[] = $loadedBook;
            }
        }
        return $ret;
    }

    static public function load1Book(mysqli $connection, $id)
    {
        $query = "SELECT * FROM `book` WHERE id = '" . $id . "'";
        $result = $connection->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedBook = new Book();
            $loadedBook->id = $row['id'];
            $loadedBook->author = $row['author'];
            $loadedBook->title = $row['title'];
            $loadedBook->description = $row['description'];
            return $loadedBook;
        } else {
            return NULL;
        }
    }

    static public function create(mysqli $connection, $title, $author, $description)
    {
        $query = "INSERT INTO `book` (title, author, description) VALUES ('".$title."','".$author."','".$description."')";
        $result = $connection->query($query);
        if ($result == true) {
            $id = $connection->lastInsertId();
            return Book::load1Book($connection, $id);
        } else {
            return NULL;
        }
    }

    static public function update($connection, $id, $title, $author)
    {
        $sql = "UPDATE books
                SET title = :title, author = :author
                WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author", $author);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    static public function deleteFromDB($connection, $id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
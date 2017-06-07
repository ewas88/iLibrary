<?php
require_once "Connection.php";
class Book
{
    private $id;
    private $author;
    private $title;
    public function __construct()
    {
        $this->id = -1;
        $this->author = "";
        $this->title = "";
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
    static public function loadAllFromDB(mysqli $connection){
        $sql = "SELECT * FROM `books`";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        if ($stmt->num_rows === 0 ) {
            return [];
        } else {
            $books = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $book = new Book();
                $book->setId($row['id']);
                $book->setTitle(($row['title']));
                $book->setAuthor($row['author']);
                $books[] = $book;
            }
            return $books;
        }
    }
    static public function loadFromDB($connection, $id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() == 0 ) {
            return null;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $book = new Book();
                $book->setId($row['id']);
                $book->setTitle(($row['title']));
                $book->setAuthor($row['author']);
            }
            return $book;
        }
    }
    static public function create($connection, $title, $author)
    {
        $sql = "INSERT INTO books (title, author) VALUES (:title, :author)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author", $author);
        $stmt->execute();
        $id = $connection->lastInsertId();
        return Book::loadFromDB($connection, $id);
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
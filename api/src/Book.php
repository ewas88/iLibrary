<?php
require "Connection.php";

class Book
{
    private $id;
    private $title;
    private $author;
    private $description;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->id = -1;
        $this->title = "";
        $this->author = "";
        $this->description = "";
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    private function loadFromDB($conn, $id)
    {

    }

    static public function loadAll($conn)
    {
        $query = "SELECT * FROM `book`";
        $ret = [];
        $result = $conn->query($query);
        if ($result == true) {
            foreach ($result as $row) {
                $loadedBook = new Book();
                $loadedBook->id = $row['id'];
                $loadedBook->title = $row['title'];
                $loadedBook->author = $row['author'];
                $loadedBook->description = $row['description'];
                $ret[] = $loadedBook;
            }
        }
        return $ret;
    }

    private function create($conn, $title, $author)
    {

    }

    private function update($conn, $title, $author)
    {

    }

    private function deleteFromDB($conn)
    {

    }


}
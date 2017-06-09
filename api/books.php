<?php
require_once "src/Book.php";
header('Content-type: application/json');
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if ($_SERVER['REQUEST_METHOD'] == "GET" && !isset($_GET['id'])) {
        $booksArray = Book::allBooks($connection);
        $books = [];
        foreach ($booksArray as $book) {
            $books[] = ["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor(),
            ];
        }
        $convertBook = json_encode($books);
        echo $convertBook;

    } elseif ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {

        $book = Book::load1Book($connection, $_GET['id']);
        $convertBook = json_encode(["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor(),
            "description" => $book->getDescription()]);
        echo $convertBook;

    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['title']) && isset($_POST['author'])
        && isset($_POST['description'])
    ) {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $book = Book::newBook($connection, $title, $author, $description);
        $convertBook = json_encode(["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor(),
            "description" => $book->getDescription()]);
        echo $convertBook;

    } elseif ($_SERVER['REQUEST_METHOD'] == "PUT" && isset($_GET['id']) && isset($_GET['title']) && isset($_GET['author'])
        && isset($_GET['description'])
    ) {
        $id = $_GET['id'];
        $title = $_GET['title'];
        $author = $_GET['author'];
        $description = $_GET['description'];
        Book::modifyBook($connection, $id, $title, $author, $description);

    } elseif ($_SERVER['REQUEST_METHOD'] == "DELETE" && isset($_GET['id'])) {

        $id = $_GET['id'];
        Book::deleteBook($connection, $id);
    }
}
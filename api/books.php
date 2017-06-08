<?php
require_once "src/Book.php";
header('Content-type: application/json');
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER['REQUEST_METHOD'] == "GET" && !isset($_GET['id'])) {
        $booksArray = Book::allBooks($connection);
        $books = [];
        foreach ($booksArray as $book) {
            $books[] = ["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor()];
        }
        $booksInJSON = json_encode($books);
        echo $booksInJSON;
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
        $book = Book::load1Book($connection, $_GET['id']);
        $bookInJSON = json_encode(["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor(),
            "description" => $book->getDescription()]);
        echo $bookInJSON;
    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['title']) && isset($_POST['author'])
        && isset($_POST['description'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $book = Book::create($connection, $title, $author, $description);
        $bookInJSON = json_encode(["id" => $book->getId(), "title" => $book->getTitle(), "author" => $book->getAuthor(),
            "description" => $book->getDescription()]);
        echo $bookInJSON;
    } elseif ($_SERVER['REQUEST_METHOD'] == "PUT" && isset($_GET['id']) && isset($_GET['title']) && isset($_GET['author'])) {
        $id = $_GET['id'];
        $title = $_GET['title'];
        $author = $_GET['author'];
        if (Book::update($connection, $id, $title, $author)) {
            $resultInJSON = json_encode(['message' => "pomyślnie zmodyfikowałeś książkę", 'id' => $id]);
            echo $resultInJSON;
        } else {
            $resultInJSON = json_encode(['message' => "nie udało się zmodyfikować książki", 'id' => $id]);
            echo $resultInJSON;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == "DELETE" && isset($_GET['id'])) {
        $id = $_GET['id'];
        if (Book::deleteFromDB($connection, $id)) {
            $resultInJSON = json_encode(['message' => "pomyślnie usunąłeś książkę", 'id' => $id]);
            echo $resultInJSON;
        } else {
            $resultInJSON = json_encode(['message' => "nie udało się usunąć książki", 'id' => $id]);
            echo $resultInJSON;
        };
    }
}
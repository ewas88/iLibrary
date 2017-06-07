$(function() {

    $("#addBtn").on("click", function (event) {
        addNewBook();
    });

    $("#showBtn").on("click", function (event) {
        showAllBooks();
    });

    function addNewBook () {
        var newTitle = $("#newTitle").val();
        var newAuthor = $("#newAuthor").val();
        var settings = {
            "url": "api/books.php",
            "method": "POST",
            "data": {
                "author": newAuthor,
                "title": newTitle
            }
        }
        $.ajax(settings).done(function (response) {
            var textOfMessage = "Utworzyłeś nową książkę (id: " + response.id + ")";
            var message = $(".message");
            message.text(textOfMessage);
        });
    }

    function modifyBook (bookId) {
        var changedTitle = $("#changedTitle").val();
        var changedAuthor = $("#changedAuthor").val();
        var settings = {
            "url": "api/books.php?id=" + bookId + "&title=" + changedTitle + "&author=" + changedAuthor,
            "method": "PUT"
        }
        $.ajax(settings).done(function (response) {
            var textOfMessage = "Zmodyfikowałeś pomyślnie książkę (id: " + response.id + ")";
            var message = $(".message");
            message.text(textOfMessage);
        });
    }

    function getBook(bookId, authorLine)
    {
        var settings = {
            "url": "api/books.php?id=" + bookId,
            "method": "GET"
        };
        $.ajax(settings).done(function (response) {
            authorLine.text(response.author);
        });
    }

    function deleteBook(bookId) {
        var settings = {
            "url": "api/books.php?id=" + bookId,
            "method": "DELETE"
        };
        $.ajax(settings).done(function (response) {
            var textOfMessage = "Pomyślnie usunąłeś książkę (id: " + response.id + ")";
            var message = $(".message");
            message.text(textOfMessage);
        });
    }

    function showAllBooks() {
        var settings = {
            "url": "api/books.php",
            "method": "GET"
        };
        $.ajax(settings).done(function (response) {
            var allBooks = $(".allBooks");
            if (allBooks.attr("hidden") == "hidden") {
                // odkrywamy div z książkami
                allBooks.removeAttr("hidden");
                response.forEach(function (book) {
                    var bookId = book.id;
                    var bookTitle = book.title;
                    // dodajemy tytuł, pustego autora, przyciski
                    var titleLine = "<div class='title' data-id='" + bookId + "'>" + bookTitle + "</div>";
                    var authorLine = "<div class='author' data-id='" + bookId + "'></div>";
                    var showAuthorButton = "<button class='showAuthorBtn' data-id='" + bookId + "'>autor</button>";
                    var modifyButton = "<button class='modifyBtn' data-id='" + bookId + "'>zmień</button>";
                    var deleteButton = "<button class='deleteBtn' data-id='" + bookId + "'>usuń</button>";
                    var newline = titleLine + authorLine + showAuthorButton + modifyButton + deleteButton;
                    allBooks.append(newline);
                    // eventy na poszczególnych elementach
                    $(".showAuthorBtn").on("click", function(event) {
                        event.stopImmediatePropagation();
                        var bookId = $(this).data("id");
                        var authorLine = $(this).prev();
                        getBook(bookId, authorLine);
                    });
                    $(".deleteBtn").on("click", function (event) {
                        event.stopImmediatePropagation();
                        var bookId = $(this).data("id");
                        deleteBook(bookId);
                    });
                    $(".modifyBtn").on("click", function (event) {
                        event.stopImmediatePropagation();
                        var bookId = $(this).data("id");
                        $(".modify").show();
                        $("#modifyBtn2").on("click", function (event) {
                            modifyBook(bookId);
                        });
                    });
                });
            } else {
                $(".title").remove();
                $(".author").remove();
                $(".showAuthorBtn").remove();
                $(".modifyBtn").remove();
                $(".deleteBtn").remove();
                allBooks.attr("hidden", "hidden");
            }
        });
    }
});
$(function () {

    showAllBooks();
    function showAllBooks() {
        $.ajax({
            "url": "api/books.php",
            "method": "GET"
        }).done(function (response) {
            var allBooks = $(".allBooks");
            response.forEach(function (book) {
                var bookId = book.id;
                var bookTitle = book.title;
                var titleLine = "<div style='font-size: 30px' class='title' data-id='" + bookId + "'>" + bookTitle + "</div>";
                var authorLine = "<div style='font-style: oblique' class='author' data-id='" + bookId + "'></div>";
                var descriptionLine = "<div class='description' data-id='" + bookId + "'></div>";
                var modifyButton = "<button class='modifyBtn' data-id='" + bookId + "'>modify</button>";
                var deleteButton = "<button class='deleteBtn' data-id='" + bookId + "'>delete</button>";
                var line = titleLine + authorLine + descriptionLine + modifyButton + deleteButton;
                allBooks.append(line);

                $(".title").on("click", function () {
                    var bookId = $(this).data("id");
                    var authorLine = $(this).next();
                    var descriptionLine = $(this).next().next();
                    $.ajax({
                        "url": "api/books.php?id=" + bookId,
                        "method": "GET"
                    }).done(function (response) {
                        authorLine.text(response.author);
                        descriptionLine.text(response.description)
                    });
                });

                $(".deleteBtn").on("click", function () {
                    var bookId = $(this).data("id");
                    $.ajax({
                        "url": "api/books.php?id=" + bookId,
                        "method": "DELETE"
                    }).done(function () {
                        console.log("Book deleted");
                    });
                });

                $(".modifyBtn").on("click", function () {
                    var bookId = $(this).data("id");
                    $(".modify").show();
                    $("#modifyButton").on("click", function (event) {
                        var changedTitle = $("#changedTitle").val();
                        var changedAuthor = $("#changedAuthor").val();
                        var changedDesc = $("#changedDesc").val();
                        $.ajax({
                            "url": "api/books.php?id=" + bookId + "&title=" + changedTitle + "&author=" + changedAuthor
                            + "&description=" + changedDesc,
                            "method": "PUT"
                        }).done(function () {
                            console.log("Book modified");
                        });
                    });
                });
            });
        });
    }

    $("#addBtn").on("click", function (event) {
        var newTitle = $("#newTitle").val();
        var newAuthor = $("#newAuthor").val();
        var newDesc = $("#newDesc").val();
        $.ajax({
            "url": "api/books.php",
            "method": "POST",
            "data": {
                "author": newAuthor,
                "title": newTitle,
                "description": newDesc
            }
        }).done(function () {
            console.log("Book created");
        });
    });
});
<?php

$wsdl = "http://localhost:53218/Service.svc?wsdl";

try {
    $client = new SoapClient($wsdl);

    if (isset($_POST['delete'])) {
        $bookId = (int)$_POST['book_id'];
        $client->DeleteBook(['id' => $bookId]);
        echo "<p class='alert alert-success'>Libro eliminado exitosamente.</p>";
    }

    $books = $client->GetAllBooks();

} catch (SoapFault $e) {
    echo "<p class='alert alert-danger'>Error: {$e->getMessage()}</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">CRUD Libros</h1>


        <a href="add_edit_book.php" class="btn btn-success mb-4">Nuevo Libro</a>


        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($books->GetAllBooksResult->Book)) {
                    $bookList = $books->GetAllBooksResult->Book;

                    if (is_array($bookList)) {
                        foreach ($bookList as $book) {
                            echo "<tr>";
                            //echo "<td>{$book->Id}</td>";
                            echo "<td>{$book->Title}</td>";
                            echo "<td>{$book->Author}</td>";
                            echo "<td>\${$book->Price}</td>";
                            echo "<td>
                                    <a href='add_edit_book.php?id={$book->Id}' class='btn btn-warning'>Editar</a>
                                    <form method='post' style='display:inline;' onsubmit='return confirm(\"¿Seguro que deseas eliminar este libro?\");'>
                                        <input type='hidden' name='book_id' value='{$book->Id}' />
                                        <button type='submit' class='btn btn-danger' name='delete'>Eliminar</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        //echo "<td>{$bookList->Id}</td>";
                        echo "<td>{$bookList->Title}</td>";
                        echo "<td>{$bookList->Author}</td>";
                        echo "<td>\${$bookList->Price}</td>";
                        echo "<td>
                                <a href='add_edit_book.php?id={$bookList->Id}' class='btn btn-warning'>Editar</a>
                                <form method='post' style='display:inline;' onsubmit='return confirm(\"¿Seguro que deseas eliminar este libro?\");'>
                                    <input type='hidden' name='book_id' value='{$bookList->Id}' />
                                    <button type='submit' class='btn btn-danger' name='delete'>Eliminar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay libros disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

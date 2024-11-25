<?php

$wsdl = "http://localhost:53218/Service.svc?wsdl"; 

try {
    $client = new SoapClient($wsdl);

    // Si estamos editando un libro
    if (isset($_GET['id'])) {
        $bookId = (int)$_GET['id'];
        $book = $client->GetBook(['id' => $bookId])->GetBookResult;
    }

    // Agregar o actualizar libro
    if (isset($_POST['submit'])) {
        $newBook = [
            'Title' => $_POST['title'],
            'Author' => $_POST['author'],
            'Price' => (float)$_POST['price']
        ];

        if (isset($book)) {
            // Actualizar libro
            $newBook['Id'] = $bookId;
            $client->UpdateBook(['book' => $newBook]);
            echo "<p class='alert alert-success'>Libro actualizado exitosamente.</p>";
        } else {
            // Agregar libro
            $client->AddBook(['book' => $newBook]);
            echo "<p class='alert alert-success'>Libro agregado exitosamente.</p>";
        }
    }
} catch (SoapFault $e) {
    echo "<p class='alert alert-danger'>Error: {$e->getMessage()}</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($book) ? 'Editar' : 'Agregar'; ?> Libro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo isset($book) ? 'Editar' : 'Nuevo'; ?> Libro</h1>

        <form method="post">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo isset($book) ? $book->Title : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Autor:</label>
                <input type="text" class="form-control" name="author" id="author" value="<?php echo isset($book) ? $book->Author : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo isset($book) ? $book->Price : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit"><?php echo isset($book) ? 'Actualizar' : 'Agregar'; ?> Libro</button><br><br>
            
        </form>
        <button type="button" class="btn btn-dark" onclick="window.location.href='index.php'">Regresar</button>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

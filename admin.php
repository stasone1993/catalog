<?php
include_once './config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin ALL ITEMS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="jumbotron text-center">
            <h1>ADMIN PAGE</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Добавить товар</h2>
                    <form action="proccess.php" method="POST">
                        <div class="form-group">
                            <label for="name">Название:</label>
                            <input type="text" class="form-control" id="name" placeholder="Введите незвание товара">
                        </div>
                        <div class="form-group">
                            <label for="price">Цена:</label>
                            <input type="text" class="form-control" id="price" placeholder="Введите цену">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание:</label>
                            <textarea class="form-control" id="description" placeholder="Введите описание"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">Фото товара:</label>
                            <input type="file" class="form-control" id="img">
                        </div>
                        <button type="submit" class="btn btn-default">Добавить</button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h2>Все товары</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Фото</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$mysqli->connect_errno) {
                                $query = "SELECT * FROM shops ORDER BY id DESC";
                                if ($result = $mysqli->query($query)) {
                                    while ($row = $result->fetch_assoc()):
                                        ?> <tr>
                                            <td><?= $row[name] ?></td>
                                            <td><?= $row[price] ?> €</td>
                                            <td><img src="<?= $row[img] ?>" class="image_item" alt="<?= $row[name] ?>"/></td>
                                        </tr>
                                        <?php
                                    endwhile;
                                }
                            }
                            ?>


                        </tbody>
                    </table>

                </div>


            </div>
        </div>

    </body>
</html>


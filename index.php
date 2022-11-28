<?php
include "Database.php";
$db = new Database;
$errors = [];

$cates = $db->getAll('category');
$prods = $db->getAll('product');

$id = isset($_POST['id']) ? $_POST['id'] : 0; 
if ($id) {
  $db->deleteParent('category', 'product', 'category_id', $id);
  header('location: index.php');
}

if (isset($_POST['name'])) {
  if (empty($_POST['name'])) {
    $errors['name_required'] = "Name must be provided";
  }

  if (!$errors) {
    $query = $db->create('category', $_POST);
    if (!$query) {
      $errors['invalid_query'] = " Invalid query, please check your query statement";
    } else {
      header("location: index.php");
    }
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>Titleee</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <div class="container-fluid p-5">
    <div class="row">
      <div class="col-lg-4">
        <p class="text-center text-success">Form Add</p>
        <form action="" method="POST">

          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="1">Show</option>
              <option value="1">Hide</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-block">Submit</button>
          </div>
        </form>
      </div>

      <div class="col-lg-8">
        <p class="text-center text-success">Show Data</p>
        <table class="table table-bordered table-striped">
          <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          <?php foreach ($cates as $key => $value) { ?>
            <tr>
              <td><?= $key ?></td>
              <td><?= $value->id ?></td>
              <td><?= $value->name ?></td>
              <td><?= $value->status ?></td>
              <td>
                <form action="" method="POST">
                  <input type="hidden" name="id" value="<?= $value->id ?>">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure ?')">&times;</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>

  <div class="container p-5">
    <div class="row">
      <?php foreach ($prods as $key => $value) { ?>
        <div class="col-lg-4">
          <div class="card border-success">
            <img class="card-img-top" src="uploads/<?= $value->image?>" alt="">
            <div class="card-body">
              <h4 class="card-title"><?= $value->name?></h4>
              <p class="card-text"><?= $value->price?></p>
              <a href="cart-process.php?id=<?= $value->id?>" class="btn btn-outline-success">Add to Cart &plus;</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
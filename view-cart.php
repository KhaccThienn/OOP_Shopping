<?php
session_start();
include 'Cart.php';
$cart = new Cart;

?>
<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Title Page</title>

  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="text-center">Giỏ hàng</h1>

  <div class="container py-5">
    <div class="row">
      <div class="col-md-8">
        <H4>GIỎ HÀNG CỦA QUÝ KHÁCH</H4>
        <table class="table ">
          <thead class="thead-inverse">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart->items as $item) :

            ?>
              <tr>
                <td>
                  <img src="uploads/<?= $item['image']; ?>" alt="" style="width:60px">
                </td>
                <td><?= $item['name']; ?></td>
                <td><?= number_format($item['price'], 2, '.', ','); ?> đ</td>
                <td>
                  <form action="cart-process.php" method="get">
                    <input type="hidden" name="id" class="form-control" value="<?= $item['id']; ?>">
                    <input type="hidden" name="action" class="form-control" value="update">
                    <input type="number" name="quantity" class="form-control" value="<?= $item['quantity']; ?>" style="width:80px; text-align:center">
                    <button>Cập nhật</button>
                  </form>

                </td>
                <td><?= number_format($item['price'] * $item['quantity'], 2, '.', ','); ?> đ</td>
                <td>
                  <a onclick="return confirm('Chắc không?')" href="cart-process.php?id=<?= $item['id']; ?>&action=delete" class="btn btn-sm btn-danger">&times;</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <h4>CART TOTAL</h4>
        <table class="table">
          <tbody>
            <tr>
              <td>Subtotal</td>
              <td class="text-right"><?= "$".number_format($cart->totalPrice, 2, '.', ','); ?></td>
            </tr>
            <tr>
              <td>Total</td>
              <td class="text-right">
                <?= "$".number_format($cart->getTotalPrice(), 2, '.', ',');?>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="clear text-center">
          <a href="index.php" class="btn btn-primary">Tiếp tục mua hàng</a>
          <a href="cart-process.php?action=clear" class="btn btn-danger" onclick="return confirm('Chắc không?')">Xóa hết</a>
          <a href="" class="btn btn-success">Đặt hàng</a>
        </div>

      </div>
    </div>


  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
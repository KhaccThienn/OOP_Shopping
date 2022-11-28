<?php
class Cart
{
  public $items = []; // lưu các sản phẩm trong giỏ hàng
  public $totalPrice; // lưu tổng tiền
  public $totalQuantity; // lưu tổng số lượng

  public function __construct()
  {
    $this->items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $this->totalPrice = $this->getTotalPrice();
    $this->totalQuantity = $this->getTotalQuantity();
  }

  public function add($pro, $quantity = 1)
  {

    if (isset($this->items[$pro['id']])) {
      $this->items[$pro['id']]['quantity'] += $quantity;
    } else {

      $cart_item = [
        'id' => $pro['id'],
        'name' => $pro['name'],
        'image' => $pro['image'],
        'price' => $this->setPrice($pro['price'], $pro['sale']),
        'quantity' => $quantity
      ];

      $this->items[$pro['id']] = $cart_item;
    }

    $_SESSION['cart'] = $this->items;
  }

  public function update($id, $quantity = 1)
  {
    if (isset($this->items[$id])) {
      $_SESSION['cart'][$id]['quantity'] = $quantity;
    }
  }

  public function remove($id)
  {
    if (isset($this->items[$id])) {
      unset($_SESSION['cart'][$id]);
    }
  }

  public function clear()
  {
    $_SESSION['cart'] = null;
  }

  //..... các phương thức bổ trợ khác nếu cần

  public function getTotalQuantity()
  {
    $total = 0;

    foreach ($this->items as $item) {
      $total += $item['quantity'];
    }

    return $total;
  }

  public function getTotalPrice()
  {
    $total = 0;

    foreach ($this->items as $item) {
      $total += $item['quantity'] * $item['price'];
    }

    return $total;
  }

  public function setPrice($price, $sale)
  {
    $newPrice = $price;
    if ($sale > 0) {
      $newPrice = round($price - ($price * $sale / 100), 2);
    }

    return $newPrice;
  }
}

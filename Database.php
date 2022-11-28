<?php
class Database
{
  private $hostname = "localhost";
  private $username = "root";
  private $password = "";
  private $db_name = "shopping";
  private $connect;

  public function __construct()
  {
    $this->connect = new mysqli($this->hostname, $this->username, $this->password, $this->db_name);
  }

  public function connectToDB()
  {
    return $this->connect;
  }

  public function getAll($table)
  {
    $result = [];

    $sql = "SELECT * FROM $table";

    $query = $this->connect->query($sql);

    if ($query->num_rows > 0) {
      while ($row = $query->fetch_object()) {
        $result[] = $row;
      }
    } else {
      return $result;
    }

    return $result;
  }

  public function getById($table, $id)
  {
    $sql = "SELECT * FROM $table WHERE id = $id";

    $query = $this->connect->query($sql);
    return $query->fetch_object();
  }

  public function create($table, $data)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
    $fields = '';
    $values = '';
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        $fields .= $key . ',';
        $values .= "'" . $value . "',";
      }

      $fields = trim($fields, ',');
      $values = trim($values, ',');

      $sql = "INSERT INTO $table($fields) VALUES ($values)";

      $query = $this -> connect -> query($sql);

      return $query;
    }
  }

  public function update($table, $data, $id)
  {
    $sql = "UPDATE $table SET ";
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        $sql .= " $key = '$value', ";
      }
      $sql = rtrim($sql, ', ') . " WHERE id = $id";
      return $this->connect->query($sql);
    }
    return false;
  }

  public function deleteByID($table, $id)
  {
    $sql = "DELETE FROM $table WHERE id = $id";
    $query = $this -> connect -> query($sql);
    return $query;
  }

  public function deleteParent($tbl_Parent, $tbl_child, $fk_key, $id)
  {
    $sql = "DELETE FROM $tbl_child WHERE $fk_key = $id";
    $query = $this -> connect -> query($sql);

    if ($query) {
      $sql2 = "DELETE FROM $tbl_Parent WHERE id = $id";
      $result = $this -> connect ->query($sql2);
      return $result;
    }

    return false;
  }
}

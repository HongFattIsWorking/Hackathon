<?php
/**
 * contains properties and methods for "category" database queries.
 */

class Customer
{
    //db conn and table
    private $conn;
    private  $table_name  = "customer";
    //object properties
    public $cus_name;
    public $cus_email;
    public $cus_pw;
    public $roles;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //used by select drop-down list
    public function readAll(){

        $query = 'SELECT * FROM ' . $this->table_name ;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

    }

    //used by select drop-down list
    public function read(){

        $query =  'SELECT * FROM ' . $this->table_name ;

        $stmt=$this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function search($keywords){

    // select all query
    $query = 'SELECT * FROM  '.  $this->table_name . ' WHERE cus_name LIKE ?';

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
  $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
    // bind

    $stmt->bindParam(1, $keywords);

    // execute query
    $stmt->execute();

    return $stmt;
  }
  public function create(){

      //query insert
      $query = "INSERT INTO ". $this->table_name ." SET cus_name=:cus_name, cus_email=:cus_email, cus_pw=:cus_pw, roles=:roles";

      //Prepare
      $stmt = $this->conn->prepare($query);

      //sanitize
      $this->name=htmlspecialchars(strip_tags($this->cus_name));
      $this->price=htmlspecialchars(strip_tags($this->cus_email));
      $this->description=htmlspecialchars(strip_tags($this->cus_pw));
      $this->category_id=htmlspecialchars(strip_tags($this->roles));


      //Bind values
      $stmt->bindParam(":cus_name", $this->cus_name);
      $stmt->bindParam(":cus_email", $this->cus_email);
      $stmt->bindParam(":cus_pw", $this->cus_pw);
      $stmt->bindParam(":roles", $this->roles);
      //execute
      if($stmt->execute()){
          return true;
      }
      return false;
  }
  // delete the product
function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE customer_id  = ?";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->customer_id));

    // bind id of record to delete
    $stmt->bindParam(1, $this->id);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}
// update the product
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                cus_name = :cus_name,
                cus_email = :cus_email,
                cus_pw = :cus_pw,
                roles = :roles
            WHERE
                customer_id = :customer_id";
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->cus_name=htmlspecialchars(strip_tags($this->cus_name));
    $this->cus_email=htmlspecialchars(strip_tags($this->cus_email));
    $this->cus_pw=htmlspecialchars(strip_tags($this->cus_pw));
    $this->roles=htmlspecialchars(strip_tags($this->roles));

    $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));

    // bind new values
    $stmt->bindParam(':cus_name', $this->cus_name);
    $stmt->bindParam(':cus_email', $this->cus_email);
    $stmt->bindParam(':cus_pw', $this->cus_pw);
    $stmt->bindParam(':roles', $this->roles);
    $stmt->bindParam(':customer_id', $this->customer_id);

    // execute the query

    if($stmt->execute()){
        return true;

    }
    print_r($this->conn->errorInfo());
    return false;
}
}

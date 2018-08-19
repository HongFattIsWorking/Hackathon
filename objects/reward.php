<?php
class reward
{

    //Db connection and table
    private $conn;
    private $table_name = 'reward';

    //Object properties
    public $reawrdID;
    public $cus_ID;
    public $point;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create()
    {

        //query insert
        $query = " INSERT INTO ". $this->table_name ." SET cus_ID=:cus_ID,point=:point";

        //Prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->cus_ID=htmlspecialchars(strip_tags($this->cus_ID));
        $this->point=htmlspecialchars(strip_tags($this->point));

        //bind new values
        $stmt->bindParam(':cus_ID', $this->cus_ID);
        $stmt->bindParam(':point', $this->point);

        //execute
        if($stmt->execute()){
            return true;
        }
        return false;
    }


    //Read product
    public function read(){

        $query =  'SELECT * FROM ' . $this->table_name ;

        $stmt=$this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //update product
    function update(){

        //update query
        $query = "UPDATE
                    " . $this->table_name. "
                    SET
                       point=:point
                    WHERE
                      cus_ID=:cus_ID";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->point=htmlspecialchars(strip_tags($this->point));
        $this->cus_ID=htmlspecialchars(strip_tags($this->cus_ID));

        //bind new values
        $stmt->bindParam(':point', $this->point);
        $stmt->bindParam(':cus_ID', $this->cus_ID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete product
    function delete(){

        //delete query
        $query = " DELETE FROM " . $this->table_name . " WHERE cus_ID = ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->cus_ID=htmlspecialchars(strip_tags($this->cus_ID));

        //bind id
        $stmt->bindParam(1, $this->cus_ID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function search($keywords){

    // select all query
    $query = 'SELECT * FROM  '.  $this->table_name . ' WHERE cus_ID LIKE ?';

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


}

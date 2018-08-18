<?php
class DonationType
{

    //Db connection and table
    private $conn;
    private $table_name = 'donationtype';

    //Object properties
    public $donationTypeID;
    public $catergory;
    public $name;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create()
    {

        //query insert
        $query = " INSERT INTO ". $this->table_name ." SET catergory=:catergory,name=:name";

        //Prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->catergory=htmlspecialchars(strip_tags($this->catergory));
        $this->name=htmlspecialchars(strip_tags($this->name));

        //bind new values
        $stmt->bindParam(':catergory', $this->catergory);
        $stmt->bindParam(':name', $this->name);

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
                       catergory=:catergory,name=:name
                    WHERE
                      donationTypeID=:donationTypeID";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->catergory=htmlspecialchars(strip_tags($this->catergory));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->donationTypeID=htmlspecialchars(strip_tags($this->donationTypeID));

        //bind new values
        $stmt->bindParam(':catergory', $this->catergory);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':donationTypeID',$this->donationTypeID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete product
    function delete(){

        //delete query
        $query = " DELETE FROM " . $this->table_name . " WHERE donationTypeID = ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id=htmlspecialchars(strip_tags($this->donationTypeID));

        //bind id
        $stmt->bindParam(1, $this->donationTypeID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function search($keywords){

    // select all query
    $query = 'SELECT * FROM  '.  $this->table_name . ' WHERE donationTypeID LIKE ?';

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

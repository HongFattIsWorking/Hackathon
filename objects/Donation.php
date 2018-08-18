<?php
class Donation
{

    //Db connection and table
    private $conn;
    private $table_name = 'donation';

    //Object properties
    public $donationID;
    public $from_cusID;
    public $To_cusID;
    public $location;
    public $status;
    public $type_id;
    public $amount;
    public $timestamp;
    public $image;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create()
    {

        //query insert
        $query = " INSERT INTO ". $this->table_name ." SET from_cusID=:from_cusID,
        To_cusID=:To_cusID,
         location=:location,
         status=:status,
          type_id=:type_id,
          amount=:amount,
          image=:image";

        //Prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->from_cusID=htmlspecialchars(strip_tags($this->from_cusID));
        $this->To_cusID=htmlspecialchars(strip_tags($this->To_cusID));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->type_id=htmlspecialchars(strip_tags($this->type_id));
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->image=htmlspecialchars(strip_tags($this->image));


        //bind new values
        $stmt->bindParam(':from_cusID', $this->from_cusID);
        $stmt->bindParam(':To_cusID', $this->To_cusID);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':image', $this->image);


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
                        from_cusID=:from_cusID,
                        To_cusID=:To_cusID,
                        location=:location,
                        status=:status,
                        type_id=:type_id,
                        amount=:amount,
                        image=:image

                    WHERE
                        donationID=:donationID";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->from_cusID=htmlspecialchars(strip_tags($this->from_cusID));
        $this->To_cusID=htmlspecialchars(strip_tags($this->To_cusID));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->type_id=htmlspecialchars(strip_tags($this->type_id));
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->donationID=htmlspecialchars(strip_tags($this->donationID));

        //bind new values
        $stmt->bindParam(':from_cusID', $this->from_cusID);
        $stmt->bindParam(':To_cusID', $this->To_cusID);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':donationID', $this->donationID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete product
    function delete(){

        //delete query
        $query = " DELETE FROM " . $this->table_name . " WHERE donationID = ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id=htmlspecialchars(strip_tags($this->donationID));

        //bind id
        $stmt->bindParam(1, $this->donationID);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function search($keywords){

    // select all query
    $query = 'SELECT * FROM  '.  $this->table_name . ' WHERE from_cusID LIKE ?';

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

  //[CURRENTLY NOT IN USED]
    //read products with pagination
    public function readPaging($from_record_num, $records_per_page){

        //select
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                  FROM " . $this->table_name . " p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  ORDER BY p.created DESC
                  LIMIT ?, ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //bind
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        //return values from db
        return $stmt;
    }
}

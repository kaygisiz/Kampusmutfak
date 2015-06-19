<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false)  {
    // die ("Direct access not premitted");
    header("HTTP/1.1 404 File Not Found", 404);
    exit;
}

class dbHelper { 
	const DB_SERVER = "localhost";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB = "webprogramlamadb";

    /*const DB_SERVER = "localhost";
    const DB_USER = "kaygisiz_caner";
    const DB_PASSWORD = "12345?";
    const DB = "kaygisiz_kampusmutfak";*/
		
	public $db = NULL;

	public function __construct() {
        try {
    	    $this->dbConnect();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
  	}

	public function __destruct(){ 
		$this->dbDisConnect();
	}

	public function dbConnect(){
		$this->db = new PDO('mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB, self::DB_USER, self::DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		if($this->db) {
			$this->db->exec("SET CHARACTER SET utf8");
            return true;
		} else {
            return false;
        }
	} 	
		
	private function dbDisConnect(){
		$this->db = null;
        // echo "<br> disconnected";
    }

	/* public function getResult($sql) { // old...
		$sth = $this->db->prepare($sql);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$sth->execute();
		$retRows = $sth->fetchAll();  
		$sth->closeCursor(); 
		return $retRows; 		
	} */

    public function query($sql, $bindings=array(), $return_resultset=false) {
        $statement = $this->db->prepare($sql);

        foreach ($bindings as $binding => $value) {
            if (is_array($value)) {
                $first = reset($value);
                $last = end($value);
                // Cast the bindings when something to cast to was sent in.
                $statement->bindParam($binding, $first, $last);
            } else {
                $statement->bindValue($binding, $value);
            }
        }

        $statement->execute();

        if ($return_resultset) {
            return $statement; // Returns a foreachable resultset
        } else {
            // Otherwise returns all the data an associative array.
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function exec($sql, $bindings=array()) {
        $statement = $this->db->prepare($sql);

        foreach ($bindings as $binding => $value) {
            if (is_array($value)) {
                $first = reset($value);
                $last = end($value);
                // Cast the bindings when something to cast to was sent in.
                $statement->bindParam($binding, $first, $last);
            } else {
                $statement->bindValue($binding, $value);
            }
        }

        $statement->execute();
        return $statement->rowCount();
    }

    public function begin() {
        $this->db->beginTransaction();
    }


    public function commit() {
        $this->db->commit();
    }

    public function rollback() {
        $this->db->rollBack();
    }
}

?>
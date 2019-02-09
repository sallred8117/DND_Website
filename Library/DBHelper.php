<?php
//NOTE:
/*
- BEFORE EXECUTING QUERIES OR CALL SPs, MUST EITHER:
    + Use prepare statement
    + OR Sanitize input using mysqli_real_escape_string
- BIND PARAMETER: Types: s = string, i = integer, d = double,  b = blob
*/
//PLEASE USE THIS TEMPLATE TO COMMENT ON FUNCTIONS
/**********************************************
Function:
Description:
Parameter(s):
Return value(s):
 ***********************************************/
class DBHelper
{
    //Members
    static protected $ini_dir = "dnd_website_config\\dnd_website.ini";
    protected $host;
    protected $user;
    protected $pwd;
    protected $maindb;
    protected $conn;

    //Getter and setters
    function __construct()
    {
        $root = substr(getcwd(), 0, strpos(getcwd(), "htdocs\\")); //point to xampp// directory
        $config = parse_ini_file($root . DBHelper::$ini_dir);
        $this->host = $config['servername'];
        $this->user = $config['username'];
        $this->pwd = $config['password'];
        $this->maindb = $config['dbname'];

        /*if not currently connected, attempt to connect to DB*/
        if ($this->getConn() == null)
            $this->DB_CONNECT(null);
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**********************************************
     * Function: DB_CONNECT
     * Description: Connect to XAMPP db. localhost/phpadmin All functions connect to db using this.
     * Parameter(s):
     * $db (string) - name of database to be connected to
     * Return value(s):
     * $conn (object) - return connection object if success
     * - return -1 if failed
     ***********************************************/
    function DB_CONNECT($db)
    {
        if ($db == "" || $db == null) //empty parameter = default = bandocatdb
            $db = "equipment";
        /* assign conn as a PHP Data Object, concat the host, user and pwd */
        $this->conn = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $db, $this->getUser(), $this->getPwd());
        return 0;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    //Constructor

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
    //IMPORTANT: Default Host, username, password can be changed here!

    /**
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    function DB_CLOSE()
    {
        $this->setConn(null);
    }

    public function getMysqliConnection()
    {
        return $db = new mysqli($this->host, $this->user, $this->pwd, $this->maindb);
    }

    public function getMysqliConnectionServer()
    {
        return $db = new mysqli($this->host, $this->user, $this->pwd);
    }

    /**********************************************
     * Function: SWITCH_DB
     * Description:This function switches the current connection to the database specified in the parameter
     * Parameter(s):
     *$collection (string) - db parameter name (such as bluchermaps, greenmaps)
     * Return value(s): true if success, false if error occurs
     ***********************************************/
    public function SWITCH_DB($database)
    {
        $this->maindb = $database;
        mysqli_select_db($this->getMysqliConnection(), $database);
    }

    /**********************************************
     * Function: SP_GET_COLLECTION_CONFIG (SP_GET_COLLECTION_DATA)
     * Description: Pulls the data associated with the collection name passed in.
     * Parameter(s):
     * $iName (in string) - input DB Name
     * Return value(s):
     * $result (assoc array) - return above values in an assoc array
     ***********************************************/
    function SP_GET_COLLECTION_CONFIG($iName)
    {   //USE is sql for changing to the database supplied after the concat.
        $this->getConn()->exec('USE ' . $this->maindb);
        /* PREPARE STATEMENT */
        //CALL is sql for telling the db to execute the function following call.
        //The ? in the functions parameter list is a variable that we bind a few lines down
        $call = $this->getConn()->prepare("CALL SP_GET_COLLECTION_CONFIG(?,@oDisplayName,@oDbName,@oStorageDir,@oPublicDir,@oThumbnailDir,@oTemplateID,@oGeorecDir,@oCollectionID)");
        //ERROR HANDLING
        if (!$call)
            trigger_error("SQL failed: " . $this->getConn()->errorCode() . " - " . $this->conn->errorInfo()[0]);
        //Bind the database name ($iName) into the prepared call statement from above.
        $call->bindParam(1, $iName, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        /* EXECUTE STATEMENT */
        $call->execute();
        /* RETURN RESULT */
        //returned after successful call statement. Need to tell the db what data we want selected.
        $select = $this->getConn()->query('SELECT @oDisplayName AS DisplayName,@oDbName AS DbName,@oStorageDir AS StorageDir,@oPublicDir AS PublicDir,@oThumbnailDir AS ThumbnailDir,@oTemplateID as TemplateID,@oGeorecDir as GeoRecDir,@oCollectionID as CollectionID');
        //Database now has the appropriate data selected. We now need to ask the DB to fetch the values for us
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $result["Name"] = htmlspecialchars($iName);
        return $result;
    }

    function GET_ALL_TABLES($database)
    {
        // Change to the correct DB first
        $this->SWITCH_DB($database);
        $conn = $this->getMysqliConnection();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SHOW TABLES";

        $listdbtables = array_column(mysqli_fetch_all($conn->query('SHOW TABLES')),0);

        $conn->close();
        return $listdbtables;
    }

    function SELECT_ALL($table)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM $table";

        $result = $conn->query($sql) or trigger_error(mysqli_error($conn) . " " . $sql);

        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }
	function SELECT_ONE_ITEM_FROM_TABLE($table)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM $table ORDER BY RAND() LIMIT 1";
        $result = $conn->query($sql);
		
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }
	function SELECT_CR_0to4_MagicItems($table,$limit = null)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
		if($limit = null)
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' ORDER BY RAND()";
		}
		else
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' ORDER BY RAND() LIMIT " . $limit;
		}
        
        $result = $conn->query($sql);
		
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }
	function SELECT_CR_5to10_MagicItems($table,$limit = null)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
		if($limit = null)
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare' ORDER BY RAND()";
		}
		else
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare'  ORDER BY RAND() LIMIT " . $limit;
		}
        
        $result = $conn->query($sql);
		
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }
	function SELECT_CR_11to17_MagicItems($table,$limit = null)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
		if($limit = null)
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare' OR Rarity = 'Very Rare' ORDER BY RAND()";
		}
		else
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare' OR Rarity = 'Very Rare'  ORDER BY RAND() LIMIT " . $limit;
		}
        
        $result = $conn->query($sql);
		
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }
	function SELECT_CR_17plus_MagicItems($table,$limit = null)
    {
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
		if($limit = null)
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare' OR Rarity = 'Very Rare' OR Rarity = 'Legendary' ORDER BY RAND()";
		}
		else
		{
			$sql = "SELECT * FROM `magic_items` WHERE Rarity = 'Uncommon' OR Rarity = 'Common' OR Rarity = 'Rare' OR Rarity = 'Very Rare' OR Rarity = 'Legendary' ORDER BY RAND() LIMIT " . $limit;
		}
        
        $result = $conn->query($sql);
		
        if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();
        return $data;
    }

    function GET_ALL_DATABASES()
    {
        //SELECT * FROM sys.databases
        $conn = $this->getMysqliConnectionServer();
        $data = array();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $listdbtables = array_column(mysqli_fetch_all($conn->query('SHOW DATABASES')),0);

        $conn->close();
        return $listdbtables;
    }

    function SELECT_RANDOM_CONTAINER($option = null)
    {
        $this->SWITCH_DB("containers");
        $conn = $this->getMysqliConnection();
        $data = array();

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }


            $sql = "SELECT Prefix,(SELECT object FROM type ORDER BY RAND() LIMIT 1) AS Container, Description FROM container_descriptions ORDER BY RAND() LIMIT 1;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                // output data of each row, there is only one though
                while($row = $result->fetch_assoc())
                {
                    array_push($data, $row);
                }
            }
            $conn->close();
            return $data;







    }
    function UPDATE_TABLE($database, $table, $data)
    {
        // Switch DB just to make sure its connected to the right one
        $this->SWITCH_DB($database);

        // Then get the connection
        $conn = $this->getMysqliConnection();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $initialKey = key($data);
        $where = "$initialKey = $data[$initialKey]";
        $query = "";
        $size = count($data);
        $counter = 0;

        foreach($data as $key => $value)
        {
            // Ignore keys that are table and database name
            if($key == "table" || $key == "database")
            {
                continue;
            }
            // Checking to see if its the end. If it is, we don't need a comma
            if($counter == $size - 3)
            {
                // attunement, id
                if(is_numeric($value))
                {
                    $query .= "$key = $value";
                }

                else
                {
                    $query .= "$key = '$value'";
                }
            }

            else
            {
                if(is_numeric($value))
                {
                    $query .= "$key = $value, ";
                }

                else
                {
                    $query .= "$key = '$value', ";
                }
            }
            $counter++;
        }

        $sql = "UPDATE $table SET $query WHERE $where";

        $result = $conn->query($sql);

        if ($result === TRUE) {
            echo "<script>alert('Update successful!')</script>";
        } else {
            echo '<script>alert("Error updating record: ' . $conn->error . '");</script>';
        }

        /*if ($result->num_rows > 0)
        {
            // output data of each row, there is only one though
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }
        $conn->close();*/
        return $data;
    }
}
<?php 

    namespace becwork\utils;

    class MysqlUtils {

        // mysql connect
        public function mysqlConnect($mysqlDbName) {
            
            global $configOBJ;

            // connect to database
            try {
                $connection = mysqli_connect($configOBJ->config["ip"], $configOBJ->config["username"], $configOBJ->config["password"], $mysqlDbName);
            
            } catch(Exception $e) { 
                
                // print error
                if ($configOBJ->config["dev_mode"] == false) {
                    if ($e->getMessage() == "Connection refused") {
                        die(include_once($_SERVER['DOCUMENT_ROOT']."/../site/errors/Maintenance.php"));
                    } else {
                        die(include_once($_SERVER['DOCUMENT_ROOT']."/../site/errors/UnknownError.php"));
                    }
                }

            }

            // set mysql utf/8 charset
            mysqli_set_charset($connection, $configOBJ->config["encoding"]);

            return $connection;
        }


        /*
          * The database insert sql query function (Use basedb name from config.php)
          * Usage like insertQuery("INSERT INTO `users`(`firstName`, `secondName`, `password`) VALUES ('$firstName', '$secondName', '$password')"))
          * Input sql command like string
          * Returned true or false if insers, array if select, etc
        */
        public function insertQuery($query) {

            global $configOBJ;

            $useInsertQuery = mysqli_query($this->mysqlConnect($configOBJ->config["basedb"]), $query);
            if (!$useInsertQuery) {
                http_response_code(503);
                die('The service is currently unavailable due to the inability to send requests');
            }
        }


        /*
          * The mysql get version function
          * Usage like $ver = getMySQLVersion();
          * Returned mysql version in system
        */
        public function getMySQLVersion() {
            $output = shell_exec('mysql -V');
            preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
            return $version[0];
        }


        /*
         * The mysql log function (Muste instaled logs table form sql)
         * Input log name and value
       */
        public function logToMysql($name, $value) {
            $name = $this->escapeString($name, true, true);;
            $value = $this->escapeString($value, true, true);
            $date = date('d.m.Y H:i:s');
            $remote_addr = $_SERVER['REMOTE_ADDR'];
            $this->insertQuery("INSERT INTO `logs`(`name`, `value`, `date`, `remote_addr`) VALUES ('$name', '$value', '$date', '$remote_addr')");
        }


        /*
         * The escape string function
         * Usage standard like $str = escapeString("string")
         * Usage protected html tasg like $str = escapeString("string", true)
         * Usage protected html special chars like $str = escapeString("string", false, true)
         * Usage complete protect string like $str = escapeString("string", true, true)
         * Returned escaped string
       */
        public function escapeString($string, $stripTags = false, $specialChasr = false) {

            global $configOBJ;

            $out = mysqli_real_escape_string($this->mysqlConnect($configOBJ->config["basedb"]), $string);
            if ($stripTags) {
                $out = strip_tags($out);
            }
            if ($specialChasr) {
                $out = htmlspecialchars($out, ENT_QUOTES);
            }
            return $out;
        }


        /*
          * The set mysql charset to basedb from config
          * Usage like setCharset("utf8")
          * Input charset type
        */
        public function setCharset($charset) {

            global $configOBJ;

            mysqli_set_charset($this->mysqlConnect($configOBJ->config["basedb"]), $charset);
        }


        /*
          * The read specific value from mysql base db by query
          * Usage like $vaue = readFromMysql("SELECT name FROM users WHERE username = 'lukas'", "name");
          * Input query select string and select value
          * Return value type string or number
        */
        public function readFromMysql($query, $specifis) {

            global $configOBJ;
            
            $sql=mysqli_fetch_assoc(mysqli_query($this->mysqlConnect($configOBJ->config["basedb"]), $query));
            return $sql[$specifis];
        }


        /*
          * Check if mysql is offline
          * Usage like: $status = isOffline();
          * Return: true or false
        */
        public function isOffline() {
            
            global $configOBJ;

            if($this->mysqlConnect($configOBJ->config["basedb"])->connect_error) {
                return true;
            } else {
                return false;
            }
        }
    }
?>

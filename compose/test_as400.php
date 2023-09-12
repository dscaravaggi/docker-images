<?php

function myCustomErrorHandler(int $errNo, string $errMsg, string $file, int $line) {
	echo "Wow my custom error handler got #[$errNo] occurred in [$file] at line [$line]: [$errMsg]";
}

set_error_handler('myCustomErrorHandler');

try {
	
   $var1 = 'a';
   $var1 .= 'b';
  $conn = new PDO("odbc:DRIVER={IBM i Access ODBC Driver 64-bit};SYSTEM=192.168.0.254;DATABASE=STORETZD;UID=store;PWD=tosano");
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT FIXD,CACE FROM STORETZD.ARTPES0F LIMIT 5";
  foreach ($conn->query($sql) as $row) {
    print json_encode($row);
  } 
/*} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();*/
} catch(Throwable $e) {
	echo $e->getMessage()."\nat line ".$e->getLine()."\nin file ".$e->getFile();
}
?> 
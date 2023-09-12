<?php

function myCustomErrorHandler(int $errNo, string $errMsg, string $file, int $line) {
	echo "Wow my custom error handler got #[$errNo] occurred in [$file] at line [$line]: [$errMsg]";
}

set_error_handler('myCustomErrorHandler');

try {
	
   $var1 = 'a';
   $var1 .= 'b';
  $conn = new PDO("odbc:Driver={SQL Anywhere 17};Host=192.168.3.258:5500;uid=SQL;pwd=***;Integrated=NO");
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT ABILITAZIONI.CODICE, ABILITAZIONI.DESCRIZIONE, ABILITAZIONI.CODMPV, ABILITAZIONI.STATO, ABILITAZIONI.last_mod FROM DBA.ABILITAZIONI ABILITAZIONI";
  foreach ($conn->query($sql) as $row) {
    print json_encode($row);
  } 
/*} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();*/
} catch(Throwable $e) {
	echo $e->getMessage()."\nat line ".$e->getLine()."\nin file ".$e->getFile();
}
?> 
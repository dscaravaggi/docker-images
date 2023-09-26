<?php
/* FreeTDS ODBC Connection for OLD SQLServer version */ 
/* use correct address and password */

function myCustomErrorHandler(int $errNo, string $errMsg, string $file, int $line) {
	echo "Wow my custom error handler got #[$errNo] occurred in [$file] at line [$line]: [$errMsg]";
}

set_error_handler('myCustomErrorHandler');

try {
	
   $var1 = 'a';
   $var1 .= 'b';
  //$conn = new PDO("odbc:DRIVER={FreeTDS};Server=192.168.0.289;Database=Anagrafica;Port=1433;UID=***;PWD=*****;tds version=7.4");
  $conn = new PDO("odbc:DSN=SQLSRV76;UID=****;PWD=****");

  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "select top(10) * from Anagrafica_Articoli ";
  foreach ($conn->query($sql) as $row) {
    print json_encode($row);
  } 
/*} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();*/
} catch(Throwable $e) {
	echo $e->getMessage()."\nat line ".$e->getLine()."\nin file ".$e->getFile();
}

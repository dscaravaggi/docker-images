<?php

/*
 oci_connect(
    string $username,
    string $password,
    ?string $connection_string = null,
    string $encoding = "",
    int $session_mode = OCI_DEFAULT
): resource|false
*/
// Connects to the XE service (i.e. database) on the "localhost" machine
$conn = oci_connect('riordino', '******', '192.168.0.258/ora18c');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'select E_DATA, E_ORA, E_PROCEDURA from PROD_JSON.sy_err_log where rownum <= 10');
oci_execute($stid);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print json_encode($row);
}

?>

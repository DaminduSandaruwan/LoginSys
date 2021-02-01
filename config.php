<?php

    define('DBSERVER','localhost');
    define('DBUSERNAME','root');
    define('DBPASSWORD','');
    define('DBNAME','hostelmgt');

    $db = mysqli_connect(DBSERVER,DBUSERNAME,DBPASSWORD,DBNAME);

    if($db == false){
        die("Error: Connection Error " . mysqli_connect_error());
    }

?>
<?php

// $host = "localhost";
// $user = "root";
// $pass = "";
// $dbname = "crud";
// $port = 3306;

//Conexao com a porta
$conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);
$conn2 = mysqli_connect($host, $user, $pass, $dbname);
// $conn = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

//Conexao sem a porta
// $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);


<?php
/* 
 * Conexão com o banco
 *
 */

//$link = mysql_connect('localhost', 'root', 'root');
////$link = mysql_connect('localhost', 'livros', 'livros');
//if (!$link)
//{
//    die('Não foi possível conectar: ' . mysql_error());
//}
//
// $db_selected = mysql_select_db('scrum', $link);
//if (!$db_selected)
// {
//	die ('banco não conectado : ' . mysql_error()); 
// }

$servername = "localhost";
$user = "root";
$pass = "root";
$dbname = "scrum";

// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = mysqli_connect($servername, $user, $pass, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


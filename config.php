<?php
/* 
 * Conexão com o banco
 *
 */

$link = mysql_connect('localhost', 'root', 'root');
//$link = mysql_connect('localhost', 'livros', 'livros');
if (!$link)
{
    die('Não foi possível conectar: ' . mysql_error());
}

 $db_selected = mysql_select_db('scrum', $link);
if (!$db_selected)
 {
	die ('banco não conectado : ' . mysql_error()); 
 }

 
 
$conn = new mysqli('localhost','root','root','scrum');
if ($conn->connect_error)die ($conn->connect_error);
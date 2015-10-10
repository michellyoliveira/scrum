<?php

$conn = new mysqli('localhost','root','root','scrum');
if ($conn->connect_error)die ($conn->connect_error);

//$query = 'SELECT * FROM usuario';
$query = "SELECT u.*, ps.id_papel FROM usuario AS u "
        . "JOIN papel_sistema AS ps ON u.id_usuario = ps.id_usuario "
        . "WHERE u.username LIKE 'admin'";
$result = $conn->query($query);

//if(!$result->num_rows)

$rows = $result->num_rows;
//$result->data_seek($j);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo 'username: '.$row['username'];
echo 'id_papel: '.$row['id_papel'];


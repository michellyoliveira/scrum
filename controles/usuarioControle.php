<?php

function listaUserSelect($name, $idForm, $idPapel) {
    include "controles/config.php";
    $query = "SELECT u.username, u.id_usuario FROM usuario AS u "
            . "LEFT JOIN papel_sistema AS ps ON u.id_usuario = ps.id_usuario "
            . "WHERE ps.id_papel = '$idPapel' "; 
    $result = mysqli_query($conn,$query);
        $linha = mysqli_num_rows($result);
        if ($linha > 0) {
            echo '<select name="'.$name.'" form="'.$idForm.'"  multiple="multiple">';
            //echo ' <option value="Selecione">Selecione</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo ' <option value="'.$row['id_usuario']. '">'. $row['username'].'</option>';
            }
            echo '</select><br />';    
        } else {
            echo "nenhum usuario cadastrado";
        }
    }
    
    function listaAutorizado($idPapel) {
    include "controles/config.php";
    $query = "SELECT u.username, u.id_usuario FROM usuario AS u "
            . "LEFT JOIN papel_sistema AS ps ON u.id_usuario = ps.id_usuario "
            . "WHERE ps.id_papel = '$idPapel' "; 
    $result = mysqli_query($conn,$query);
        $linha = mysqli_num_rows($result);
        if ($linha > 0) {
//            echo '<select name="'.$name.'" form="'.$idForm.'"  multiple="multiple">';
//            echo ' <option value="Selecione">Selecione</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $idUsuario[] = $row['id_usuario'];
                echo "<br>".$row['username'];
//                echo ' <option value="'.$row['id_usuario']. '">'. $row['username'].'</option>';
            }
//            echo '</select><br />';    
        } else {
            echo "nenhum usuario cadastrado";
        }
}
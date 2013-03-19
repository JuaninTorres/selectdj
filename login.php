<?php
session_start();


// solo operará si es que
if(isset($_POST))
{
    require_once('class/connectPDO.php');
    $connection = new connectPDO;

    $sql = 'SELECT * FROM cpj_users WHERE user_name = ? AND user_pass = ?';
    $params = array($_POST['login_user'],md5($_POST['login_pass']));

    // parche para desarrollo
    $sql = 'SELECT * FROM cpj_users limit 1';
    $params = array();


    $data = $connection->getrow($sql,$params);
    if($data===PDOWARNING)
    {
        $resultado = array(
            'errores' => 1,
            'msg' => 'El usuario o la contraseña son incorrectas'
            );
    }
    else
    {
        $resultado = array(
            'errores' => 0,
            'msg' => 'Logueo exitoso',
            );
        $_SESSION['auth'] = $data;
    }
    echo json_encode($resultado);
}
?>
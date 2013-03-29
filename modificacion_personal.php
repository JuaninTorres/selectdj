<?php
session_start();
if(isset($_SESSION['auth']['id_user']))
{
    $codeInput      = 'onclick="editInputCRC(this)" onblur="editInputCRCOff(this)"';
    $codeSelect     = 'onclick="editInputCRC(this)" onchange="editInputCRCOff(this);editInputCRC(this);"';
    $codeInputCheck = 'class="radio" onclick="guardando(this.value,this.id,this.checked)"';
    $codeInputRadio = 'onclick="guardando(this.value,this.name)" ';

    $id = $_SESSION['auth']['id_user'];

    require_once('class/connectPDO.php');
    $connection = new connectPDO;

    $sql = 'SELECT * FROM cpj_users WHERE id_user = ?';
    $params = array($id);

    try
    {
        $data = $connection->getrow($sql,$params);
        if($data===PDOERROR)
        {
            throw new Exception('Error ejecutando la consulta', 1);
        }
        if($data===PDOWARNING)
        {
            throw new Exception('No existe el usuario', 1);
        }

        // Comenzamos a dibujar
        $html = "
        <table id='modificion_usuario' class='ui-widget'>
        <tbody class='ui-widget-content'>
            <tr>
                <th class='ui-widget-header'>Usuario</th>
                <td><input type='text' value='{$data['user_name']}' readonly='readonly' disabled='disabled' /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Nickname</th>
                <td><input type='text' id='upWnick_nameW{$id}' value='{$data['nick_name']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Nombres</th>
                <td><input type='text' id='upWfirst_nameW{$id}' value='{$data['first_name']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Apellidos</th>
                <td><input type='text' id='upWlast_nameW{$id}' value='{$data['last_name']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>email</th>
                <td><input type='text' id='upWemailW{$id}' value='{$data['email']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Programación</th>
                <td><input type='text' id='upWprogramasW{$id}' value='{$data['programas']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Horarios</th>
                <td><input type='text' id='upWhorariosW{$id}' value='{$data['horarios']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Residencia</th>
                <td><input type='text' id='upWresidenciaW{$id}' value='{$data['residencia']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Facebook</th>
                <td><input type='text' id='upWurl_facebookW{$id}' value='{$data['url_facebook']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Twitter</th>
                <td><input type='text' id='upWurl_twitterW{$id}' value='{$data['url_twitter']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Google+</th>
                <td><input type='text' id='upWurl_googleplusW{$id}' value='{$data['url_googleplus']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>YouTube</th>
                <td><input type='text' id='upWurl_youtubeW{$id}' value='{$data['url_youtube']}' {$codeInput} /></td>
            </tr>
            <tr>
                <th class='ui-widget-header'>Hobbies</th>
                <td><textarea id='upWhobbiesW{$id}' {$codeInput} >{$data['hobbies']}</textarea></td>
            </tr>
        </tbody>
        </table>
        ";
    }
    catch(Exception $e)
    {
        $html = $e->getMessage();
    }
    echo json_encode(
        array(
            'contenido'=>$html,
        )
    );
}
?>
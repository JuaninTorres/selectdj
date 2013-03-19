<?php
session_start();
if(isset($_SESSION['auth']))
{
    require_once('funciones_comunes.php');

    // Lo que primero haré es dejar la instruccion para armar los tabs
    $jsCall[] = "$('#tabs').tabs()";
    $jsCall[] = "$('#div_btn_logout').show()";


    $titulos[] = 'Dj Locuteando';
    //si existe el id_online quiere decir que tiene viva la sesion para transmitir
    if(isset($_SESSION['auth']['id_online']))
    {
        $locutor = getLocutorOnline();
        $contenidos[]=$locutor['contenido'];
        $jsCall[]=$locutor['jscall'];
    }
    else
    {
        $idBtn = 'btn_comenzar_transmitir';
        $contenidos[] = "<fieldset class='ui-widget ui-widget-content'>
        <legend class='ui-widget-header ui-corner-all'>¿".ucfirst($_SESSION['auth']['first_name'])." ".ucfirst($_SESSION['auth']['last_name']).", Vas a transmitir en este momento?</legend>
        <button id='{$idBtn}'>Comenzar a transmitir</button>
        </fieldset>";
        $jsCall[]="$('#{$idBtn}').button({icons: { primary: \"ui-icon-check\"}}
            ).click(function(){
                var comenzarLocutor = \$.get('locutor_online.php',function(data){
                    \$('#tabs-1').html(data.contenido);
                    eval(data.jscall);
                },'json');
        })";
    }



    // Ahora vemos si es administrador, si es asi... le damos las opciones
    $titulos[] = 'Administracion de usuarios';
    $contenidos[] = "<fieldset class='ui-widget ui-widget-content'>
        <legend class='ui-widget-header ui-corner-all'>Usuario del sistema</legend>
        <div id='listado_usuarios'></div>
        </fieldset>";
    $jsCall[]="\$.get('listado_usuarios.php',function(data){
                \$('#listado_usuarios').html(data.contenido);
                eval(data.jscall);
            },'json');
    ";


    // Procesamos los contenidos
    // titulos
    $html = "<div id='tabs'><ul>";
    foreach ($titulos as $index => $titulo)
    {
        $html .= "<li><a href='#tabs-".($index+1)."'>".$titulo."</a></li>";
    }
    $html .= "</ul>";

    //Contenidos de los tabs
    foreach ($contenidos as $index => $contenido)
    {
        $html .= "<div id='tabs-".($index+1)."'>".$contenido."</div>";
    }
    $html .= "</div>";
    echo json_encode(array(
        'contenido'=>$html,
        'jscall'=>implode(';', $jsCall),
        'user'=>$_SESSION['auth'],
        'session'=>array('session_id' => session_id())
        ));

}
?>
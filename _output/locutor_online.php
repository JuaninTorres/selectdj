<link href='http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<style>

#locutor_nombre
{
    font-size: 1em;
}

#locutor_online
{
    color: white;
    font-family: Open Sans;
    font-size: 16px;
}
#locutor_online article
{
    background: white;
    border-radius: 1em;
    padding: 0.5em;
}
#locutor_online .foto_locutor, #locutor_online .locu
{
    display: inline-block;
    vertical-align: top;
    margin: 0;
    padding: 0;
}

#locutor_online .foto_locutor img
{
    margin: 0;
    max-width: 100%;
    max-height: 100%;
}
#locutor_online .locu
{
    text-align: left;
}
#locutor_online .locu p
{
    color: #333333;
    margin: -0.3em 0 0 2em;
}
#locutor_online .locu label
{
    color: #0080FF;
    font-family: Open Sans Condensed;
    font-weight: bold;
    /*text-shadow: 0.1em 0.1em 0.2em rgba(0,0,0,0.7);*/
}

#locutor_online .logos_sociales
{
    display: inline-block;
    margin-top: 1em;
}

#locutor_online .logos_sociales a {
    display: inline-block;
}

#locutor_online p.nickname
{
    color: #666666;
    font-size: 2em;
    font-weight: bold;
    margin: 0.5em 0;
    text-shadow: 0.1em 0.1em 0.3em rgba(0,0,0,0.2);
}
#locutor_online #locutor_nombre
{
    text-transform: capitalize;
}


</style>
<?php

require_once('../class/connectPDO.php');
$connection = new connectPDO;

$data = $connection->getrow('SELECT cpj_online.id_online, NOW() BETWEEN tiempo_desde AND tiempo_hasta as vigente,cpj_users.*
FROM cpj_online,cpj_users
WHERE cpj_users.id_user = cpj_online.id_user AND id_online = (SELECT MAX(id_online) FROM cpj_online)');

$autoLocutor = ($data===PDOWARNING || $data['vigente']=='0')?true:false;
if($autoLocutor)
{

?>
<section id='locutor_online'>
    <article>
        <div class="foto_locutor">
            <img src="/selectdj/_images/classic_mic.jpg">
        </div>
        <div class="locu">
            <div class="locutor">
                <p>Locutor@:<br><strong> Locutor automático</strong></p>
            </div>
        </div>
    </article>
</section>

<?php

}
else
{

$facebook = ($data['url_facebook']=='')?'':"<a href='{$data['url_facebook']}' target='_blank'><img src='/selectdj/_images/facebook.png'></a>";
$twitter = ($data['url_twitter']=='')?'':"<a href='{$data['url_twitter']}' target='_blank'><img src='/selectdj/_images/twitter.png'></a>";
$googleplus = ($data['url_googleplus']=='')?'':"<a href='{$data['url_googleplus']}' target='_blank'><img src='/selectdj/_images/google.png'></a>";
$youtube = ($data['url_youtube']=='')?'':"<a href='{$data['url_youtube']}' target='_blank'><img src='/selectdj/_images/youtube.png'></a>";


?>
<section id='locutor_online'>
    <?php echo "<!-- {$data['id_online']} - {$data['id_user']} -->"; ?>
    <article>
        <div id="header_locutor">
            <div class="foto_locutor">
                <img src="<?php echo $data['fotografia']; ?>">
            </div>
            <div class="logos_sociales">
                <?php
                echo "{$facebook}\n";
                echo "{$twitter}\n";
                echo "{$googleplus}\n";
                echo "{$youtube}\n";
                ?>
            </div>
        </div>
        <div class="locu">
            <!--
            <p class="nickname">
                <?php echo $data['nick_name']; ?>
            </p> -->
            <label for='locutor_nombre'>Nombre</label>
            <p id="locutor_nombre">
                <?php echo $data['first_name'].' '.$data['last_name']; ?>
            </p>
            <label for='locutor_programacion'>Programacion</label>
            <p id="locutor_programacion">
                <?php echo $data['programas']; ?>
            </p>

            <label for='locutor_lugar'>Vive en</label>
            <p id="locutor_lugar">
                <?php echo $data['residencia']; ?>
            </p>

            <label for='locutor_horario'>Horario</label>
            <p id="locutor_horario">
                <?php echo $data['horarios']; ?>
            </p>

        </div>
    </article>
</section>
<?php
}
?>
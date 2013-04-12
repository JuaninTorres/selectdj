<style>
</style>
<?php
require_once('../class/connectPDO.php');
$connection = new connectPDO;
$data = $connection->getrow('SELECT * FROM cpj_anuncios ORDER BY id_anuncio DESC LIMIT 1');
?>
    <div class="titulo1">
        <a href="<?php echo $data['url_link']; ?>" target="_blank" class="link"><?php echo $data['titulo']; ?></a>
    </div>
    <div id="espacio2">
        <a href="<?php echo $data['url_link']; ?>" target="_blank" ><img src="<?php echo $data['url_imagen']; ?>"></a>
    </div>
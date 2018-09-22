    
    
    <main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="izquierdo" style="width: 100%;">
                    <div class="ruta">
                        <a>Gestión > Resultados de búsqueda</a>
                    </div>
                    <div class="titulo1" style="padding-bottom: 15px;border-bottom: 1px solid #eaeaea;">
                    <?php
                    $palabra = $_GET['q'];
                    ?>
                        Resultados para "<?php echo $palabra; ?>"
                    </div>
                    <div class="texto1">
                            <?php
                            if ($faqs->exists(true)) {
                                foreach ($faqs as $F) {
                            ?>
                            <div style="width: 100%;float:left;">
                                    <div style="width: 100%;float:left;margin-bottom:8px;">
                                        <a href="faq.php?id=<?php echo $F->getId(); ?>" style="font-family: 'Roboto';
                                        font-size: 14px;
                                        font-weight: normal;
                                        font-style: normal;
                                        font-stretch: normal;
                                        text-decoration:none;
                                        line-height: normal;
                                        letter-spacing: normal;
                                        color: #094d7d;">
                                            <?php echo $F->getLocalQuestion(); ?>
                                        </a>
                                    </div>
                                    <div style="width: 100%;float:left;margin-bottom:8px;
                                    font-family: 'Roboto';
                                    font-size: 14px;
                                    font-weight: normal;
                                    font-style: normal;
                                    font-stretch: normal;
                                    line-height: 1.14;
                                    letter-spacing: normal;
                                    text-align: left;
                                    color: #b20053;">
                                    <?php $categoria = $F->getCategory();echo $categoria->getName(); ?>
                                    <?php 
                                    $producto = "";
                                    foreach ($F->getHelpTopics() as $T) {
                                        $producto = ' > ' . $T->topic->getFullName();
                                     } 
                                    ?>

                                    <?php echo $producto; ?>
                                    </div>
                                    <div style="width: 100%;float:left;
                                    margin-bottom:40px;font-family: 'Roboto';
                                    font-size: 14px;
                                    font-weight: normal;
                                    overflow: hidden;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    font-style: normal;
                                    font-stretch: normal;
                                    line-height: normal;
                                    letter-spacing: normal;
                                    text-align: left;
                                    color: #818181;">
                                        <?php
                                            $allowed_tags = array("html", "body", "b", "br", "em", "hr", "i", "li", "ol", "p", "s", "span", "table", "tr", "td", "u", "ul","div");
                                            $descripcion = $F->getLocalAnswer();
                                            foreach($allowed_tags as $tag ){
                                                $descripcion = strip_tags($descripcion, $tag);
                                            }
                                        ?>
                                        <?php echo substr($descripcion, 0, 200); ?>
                                    </div>
                            </div>
                            
                            <?php
                                }
                            }else{
                                ?>

                                <div style="width: 100%;float:left;">
                                    <div style="width: 100%;float:left;margin-bottom:8px;">
                                        <a style="font-family: 'Roboto';
                                        font-size: 14px;
                                        font-weight: normal;
                                        font-style: normal;
                                        font-stretch: normal;
                                        text-decoration:none;
                                        line-height: normal;
                                        letter-spacing: normal;
                                        color: #094d7d;">
                                            No hay resultados de búsqueda para <?php echo $palabra; ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="publicidad-2">
            <div class="margen">
                <div class="texto">
                    <span>¿Tiene más preguntas?</span>
                    <div class="boton">
                        <a href="http://testa.digital/demostracion" class="boton-texto">Enviar una solicitud</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script>
$( document ).ready(function() {
    $('#in-buscador').val('<?php echo $palabra; ?>');
});
</script>
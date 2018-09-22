<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>

<main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="izquierdo">

                    <div class="ruta">
                        <?php 
                        $producto = "";
                        foreach ($faq->getHelpTopics() as $T) {
                            $producto = $T->topic->getFullName();
                         } 
                         ?>
                        <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a>
                         > <a><?php echo $producto; ?></a>
                    </div>
                    <div class="titulo1">
                        <?php echo $faq->getLocalQuestion() ?>
                    </div>
                    <div class="texto1">
                        <?php echo $faq->getLocalAnswerWithImages(); ?>
                    </div>
                </div>
                <div class="derecho">
                
                    <div class="titulo3">
                            
                    </div>
                    <!--
                    <div class="enlaces">
                        <?php if ($faq->getHelpTopics()->count()) { ?>
                        <ul>
                        <?php foreach ($faq->getHelpTopics() as $T) { ?>
                            <li><?php echo $T->topic->getFullName(); ?></li>
                        <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                    -->
                    <div class="contenedor">
                        <div class="titulo4">
                        Sumá Soluciones
                        </div>
                        <img src="/assets/img/group-12.svg" alt="">
                        <div class="titulo5">
                                Lo ayudamos siempre.
                        </div>
                        <div class="texto6">
                            <p>
                                    Si estás interesado en un soporte o desarrollo personalizado nosotros contamos con los servicios para vos.
                            </p>
                        </div>
                        <div class="boton">
                            <a href="http://testa.digital/servicios">
                                    Ver servicios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="publicidad-2">
            <div class="margen">
                <div class="texto">
                    <span>¿Tiene más preguntas?</span>
                    <div class="boton">
                        <a href="/open.php" class="boton-texto">Enviar una solicitud</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

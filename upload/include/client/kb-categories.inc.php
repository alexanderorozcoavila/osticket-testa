<main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="izquierdo" style="width: 100%;">
                    <div class="ruta">
                        <a>Gestión > Resultados de busqueda</a>
                    </div>
                    <div class="titulo1" style="padding-bottom: 15px;border-bottom: 1px solid #eaeaea;">
                    <?php
                    $palabra = $_GET['q'];
                    ?>
                        Resultados para "<?php echo $palabra; ?>"
                    </div>
                    <div class="texto1">
                            <?php
                            $categories = Category::objects()
                            ->exclude(Q::any(array(
                                'ispublic'=>Category::VISIBILITY_PRIVATE,
                                'faqs__ispublished'=>FAQ::VISIBILITY_PRIVATE,
                            )))
                            ->annotate(array('faq_count'=>SqlAggregate::COUNT('faqs')))
                            ->filter(array('faq_count__gt'=>0));

                            if ($categories->exists(true)) {
                                foreach ($C->faqs
                    ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                    ->limit(5) as $F) { 
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
                                            <?php echo $F->getLocalQuestion() ?: $F->getQuestion(); ?>
                                        </a>
                                    </div>
                            </div>
                            
                            <?php
                                }
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
                        <a href="" class="boton-texto">Enviar una solicitud</a>
                    </div>
                </div>
            </div>
        </div>
    </main>



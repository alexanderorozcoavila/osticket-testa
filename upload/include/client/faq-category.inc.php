<?php
if(!defined('OSTCLIENTINC') || !$category || !$category->isPublic()) die('Access Denied');
?>


<main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="izquierdo" style="width: 100%;">
                    <div class="ruta">
                        <a>Testa Gestión > Resultados de busqueda</a>
                    </div>
                    <div class="titulo1" style="padding-bottom: 15px;border-bottom: 1px solid #eaeaea;">
                    
                        <?php echo $category->getLocalName() ?>
                    </div>
                    <div class="texto1">
                            <?php
                            $faqs = FAQ::objects()
                            ->filter(array('category'=>$category))
                            ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                            ->annotate(array('has_attachments' => SqlAggregate::COUNT(SqlCase::N()
                                ->when(array('attachments__inline'=>0), 1)
                                ->otherwise(null)
                            )))
                            ->order_by('-ispublished', 'question');

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
                                            <?php echo Format::htmlchars($F->question); ?>
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


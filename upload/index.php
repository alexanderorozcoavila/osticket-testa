<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.testa.inc.php');
?>

<?php $topics = Topic::objects()->order_by('sort','ASC'); ?>
<?php //$topics = Topic::objects(); ?>
<?php $T = $topics; ?>
<main>

        <div class="bases-conocimiento">
            <div class="margen">
                <div class="sub-titulo">
                    <h2>BASE DE CONOCIMIENTO</h2>
                </div>
                <?php foreach ($T as $C) { ?>
                <div class="base-lits">
                        <div class="base-list-cabecera">
                            <span class="primerpaso"><?php echo $C->getName(); ?></span>
                            <img class="arrow-drop-down" src="/assets/img/arrow-drop-down-copy-2.svg" alt="">
                        </div>
                        <div class="base-lits-contenido">
                            <ul>
                                    <?php 
                                    $faqs = FAQ::allPublic()
                                    ->annotate(array(
                                        'attachment_count'=>SqlAggregate::COUNT('attachments'),
                                        'topic_count'=>SqlAggregate::COUNT('topics')
                                    ))
                                    ->order_by('question');
                                    $faqs->filter(array('topics__topic_id'=>$C->getId()));
                                    if ($faqs->exists(true)) {
                                        foreach ($faqs as $F) {
                                            echo sprintf(
                                                '<li><a href="/kb/faq.php?id=%d" class="previewfaq">%s</a></li>',
                                                $F->getId(), $F->getLocalQuestion(), $F->getVisibilityDescription());
                                        }
                                    }
                                    ?>

                            </ul>
                        </div>
                </div>

                <?php
                }
                ?>
            </div>
        </div>


        <div class="publicidad">
            <div class="titulo">
                <span>La información no duerme</span>
            </div>
            <div class="sub-titulo">
                <span>Ofrecemos soporte a nuestros clientes las 24 horas los 7 días de la semana.</span>
            </div>
            <div class="boton">
                <a href="" class="boton-texto" id="btn-publicidad">Pruebe nuestros productos</a>
            </div>
        </div>
    </main>
<?php require(CLIENTINC_DIR.'footer.testa.inc.php'); ?>

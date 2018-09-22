<?php
if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

$info=($_POST && $errors)?Format::htmlchars($_POST):array();

$dept = $ticket->getDept();

if ($ticket->isClosed() && !$ticket->isReopenable())
    $warn = sprintf(__('%s is marked as closed and cannot be reopened.'), __('This ticket'));

//Making sure we don't leak out internal dept names
if(!$dept || !$dept->isPublic())
    $dept = $cfg->getDefaultDept();
?>


<main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="cabecera-verticket">
                    <div class="ruta">
                        <a href="/tickets.php">Soporte > Mis solicitudes </a>
                    </div>
                    <div class="titulo1-1">
                        <?php echo $ticket->getSubject() ?>
                    </div>
                </div>
                <div class="cuerpo-verticket">
                    <div class="izquierdo">
                        <div class="texto1">
                        <?php
                            $ticket->getThread()->render(array('M', 'R'), array(
                                        'mode' => Thread::MODE_CLIENT,
                                        'html-id' => 'ticketThread')
                                    );
                        ?>
                        <?php if (!$ticket->isClosed() || $ticket->isReopenable()) { ?>
                            <div class="thread-entry">
                                <div class="cabecera">
                                <table>
                                    <tr>
                                    <td rowspan="2" width="40px">
                                        <img src="/assets/img/ic-account-circle-copy.svg">
                                    </td>
                                    <td class="username">
                                    <form id="reply" action="tickets.php?id=<?php echo $ticket->getId();
                                        ?>#reply" name="reply" method="post" enctype="multipart/form-data">
                                            <?php csrf_token(); ?>
                                            
                                            <input type="hidden" name="id" value="<?php echo $ticket->getId(); ?>">
                                            <input type="hidden" name="a" value="reply">
                                            
                                                <input type="text" name="message" id="message" placeholder="Agregar a la conversación" />
                                            
                                    </form>
                                    </td>
                                    <td width="10px"></td>
                                    </tr>

                                </table>
                                </div>  
                        </div>
                            <?php
                            } ?>
                        </div>

                    </div>
                    <div class="derecho">
                        <div class="contenedor">
                            <div class="linea">
                                <div class="etiqueta">
                                    Solicitante
                                </div>
                                <div class="valor">
                                <?php echo mb_convert_case(Format::htmlchars($ticket->getName()), MB_CASE_TITLE); ?>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                Creación
                                </div>
                                <div class="valor">
                                <?php echo Format::datetime($ticket->getCreateDate()); ?>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                Última actividad
                                </div>
                                <div class="valor">
                                    <?php $ticket2=Ticket::lookup($ticket->getId()); ?>
                                    <?php echo Format::datetime($ticket2->getLastMsgDate()); ?>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                ID
                                </div>
                                <div class="valor">
                                <?php echo $ticket->getNumber(); ?>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                Grupo
                                </div>
                                <div class="valor">
                                    <?php echo Format::htmlchars($dept instanceof Dept ? $dept->getName() : ''); ?>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                Estado
                                </div>
                                <div class="valor">
                                <?php 
                                
                                $status = ($S = $ticket->getStatus()) ? $S->getLocalName() : ''; 
                                switch ($status) {
                                    case "Abierto":
                                        $statusw = "open";
                                        break;
                                    case "Resuelto":
                                        $statusw = "resolved";
                                        break;
                                    case "Closed":
                                        $statusw = "closed";
                                        break;
                                    case "En espera":
                                        $statusw = "wait";
                                        break;
                                }
                                ?>
                                    <button class="<?php echo $statusw; ?>"><?php echo $status; ?></button>
                                </div>
                            </div>
                            <div class="linea">
                                <div class="etiqueta">
                                    Impacto en el negocio
                                </div>
                                <div class="valor">
                                <?php echo $ticket->getPriority(); ?>
                                </div>
                            </div>
                            <div class="linea"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>






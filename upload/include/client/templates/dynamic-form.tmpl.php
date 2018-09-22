<?php
    global $thisclient;
    $i = 2;
    $o = 0;
    foreach ($form->getFields() as $field) { ?>
        <?php 
            if($o == 0){
                ?>
                    <div class="linea-new">
                <?php
                $o = $o +1;
            }else{
                $o = $o +1;
            }
        ?>
            <div class="campo-formulario-new-ticket campo<?php echo $i = $i + 1; ?>">
                <label for="<?php echo $field->getFormName(); ?>">
                    <?php $name = Format::htmlchars($field->getLocal('label')); ?>
                    <?php if($name == "archivo"){ ?>
                    
                    <?php }else{ ?>
                        <?php echo $name = Format::htmlchars($field->getLocal('label')); ?>
                    <?php } ?>

                    <?php if($name == "Impacto en el negocio"){ ?>
                        <img src="/assets/img/ic-help.svg" class="tooltip" title="<p class='texto-p'><b>Crítico:</b> no se puede comunicar con sus clientes. <b>Importante:</b> una función <br>importante de su servicio a dejado de funcionar. <b>Moderado:</b> hay una <br>función que no está funcionando y está causando retrasos. <b>Limitado:</b> tiene <br>una pregunta sobre cómo hacer algo.</p>">
                    <?php } ?>

                    <?php if($name == "Link de su sistema"){ ?>
                        <img src="/assets/img/ic-help.svg" class="tooltip" title="<p class='texto-p'>El subdominio de su cuenta de Sumá Digital se encuentra en el URL que utiliza<br> para acceder a su cuenta <b>p.ej:nombredecompañia.Suma.Digital</b></p>">
                    <?php } ?>

                    <?php if($name == "Descripción"){ ?>
                        <img src="/assets/img/ic-help.svg" class="tooltip" title="<p class='texto-p'>Intente ser lo más especifico que pueda. Si se trata de problemas con los <br>poductos, incluya todos los detalles adicionales que crea pertinentes, tales <br>como los pasos que ya ha realizado para resolver el problema y varios <br>ejemplos de tickets.</p>">
                    <?php } ?>
                    

                </label>


                    <?php if($name == "Descripción"){ ?>
                        <textarea name="<?php echo $field->getFormName(); ?>" id="_<?php echo $field->getFormName(); ?>">
                        </textarea>
                    <?php }else{
                          if($name == "archivo"){
                    ?>
                            <label for="boton-archivo" class="label-adjunto">
                                <img src="/assets/img/ic-attach-file.svg">
                                Adjuntar archivos
                            </label>
                            <input type="file" style="display:none;" multiple="multiple" name="<?php echo $field->getFormName(); ?>" id="boton-archivo" accept="">
                    <?php
                          }else{
                                $field->render(array('client'=>true));
                          }                        
                    } ?>
            </div>
        <?php

            if( $o == 2){
                ?>
                    </div>
                <?php
                $o = 0;
            }
    }
?>

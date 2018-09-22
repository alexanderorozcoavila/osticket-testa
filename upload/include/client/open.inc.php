<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;

$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = '1';
    else
        $info['topicId'] = '1';
}

$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F;
    }
}

if(isset($_SESSION['mensaje']) and !empty($_SESSION['mensaje'])){
?>
<div class="mensaje-exito">
    <span>
        <?php echo $_SESSION['mensaje']; ?>
    </span>
    <label id="x-close-mensaje" for="">X</label>
</div>
<?php

    unset($_SESSION['mensaje']);
    session_write_close();
    session_regenerate_id();
}
?>
<main>
        <div class="bases-conocimiento">
            <div class="margen">
                <div class="cabecera-verticket">
                    <div class="titulo1">
                    Enviar una solicitud
                    </div>
                </div>
                <div class="cuerpo-verticket">
                    <form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">
                    <?php csrf_token(); ?>
                    <input type="hidden" name="a" value="open">
                        <div class="linea-new">
                            <div class="campo-formulario-new-ticket campo1">
                                <label><?php echo __('Categoria'); ?></label>
                                
                                <label for="ch-buscador" class="la-buscador">
                                    <ul class="listado-solicitudes">
                                        <li>
                                        <input type="checkbox" name="" id="ch-buscador">
                                        <input type="hidden" id="categoryId" name="categoryId">
                                        <span id="sp-buscador">
                                                <img id="sp-buscador-img" class="sp-buscador-img" src=""><span class="sp-buscador-prin" id="sp-buscador-span"></span>
                                        </span> 
                                        <img class="arrow-drop-down" id="flecha-buscador-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="" style="float: right;
    margin-top: 16px;
    margin-right: 10px;">
                                        <ul class="submenu-buscador">
                                        <?php $cats = Category::getFeatured();?>
                                        <?php $cats->all(); ?>
                                            <?php foreach ($cats as $topic){ ?>
                                            <li>
                                                <span id="sp-buscador" class="buscador-elmento">
                                                    <img src="/assets/img/<?php echo $topic->name; ?>.svg"><span id="<?php echo $topic->getId(); ?>"><?php echo $topic->name; ?></span>
                                                </span>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        </li>
                                    </ul>
                                </label>
                            </div>

                            <div class="campo-formulario-new-ticket campo2">
                                <label>¿En que le podemos ayudar?</label>
                                <select id="topicId" name="topicId">
                                    <option value="" selected="selected"></option>
                                    <?php
                                        if($topics=Topic::getPublicHelpTopics()) {
                                            foreach($topics as $id =>$name) {
                                                echo sprintf('<option value="%d" %s>%s</option>',
                                                        $id, ($info['topicId']==$id)?'':'', $name);
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>     
                            <?php foreach ($forms as $form) {
                                include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
                            } ?>
                        
                    <div class="linea-new" style="text-align: center;margin-top: 40px;margin-bottom: 0px;">
                            <!-- 6LeAmmUUAAAAACE2GNDHoyZdsfc1hMg01h8MT7QC -->
                            <!-- 6LfDgjMUAAAAANLH7JZzrOvxW5taOy7nunVKt0Tg -->
                        <div class="g-recaptcha" data-sitekey="6LeAmmUUAAAAACE2GNDHoyZdsfc1hMg01h8MT7QC" data-callback="recaptchaCallback"></div>
                    </div>
                    <div class="linea-new" style="text-align: center;margin-top: 0px;">
                            <button type="submit" id="button-formulario-ticket" >Enviar</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</main>
<script>
$(".buscador-elmento").click(function(){
    var button=$(this);
    var texto = $(this).find('span');
    console.log('============================================');
    console.log(texto[0].id);
    console.log('============================================');

    $('#categoryId').val(texto[0].id);

});


$()

$('#boton-archivo').change(function(){
    $('.label-adjunto').text('');
    var texto = $('#boton-archivo').val();
    // console.log(texto);
    var fin = texto.length;
    var ini = fin - 30;
    var res = texto.substring(ini,fin);
    $( ".label-adjunto" ).append('<img src="/assets/img/ic-attach-file.svg"> '+res);
    
});
</script>
<script>
        $(document).ready(function() {
            $('.menu-superior > a').css('color','#29aae2');
            $('.tooltip').tooltipster({
                theme: 'tooltipster-shadow',
                maxWidth: '400px',
                contentAsHTML:true,
                // functionPosition: function(instance, helper, position){
                    
                //     position.coord.left += 200;
                //     return position;
                // }
            });
        });
        
        $('#x-close-mensaje').click(function() {
            $('.mensaje-exito').css('display','none');
        });

        function recaptchaCallback() {
            $('#button-formulario-ticket').removeAttr('disabled');
        }

        // var isCaptchaValidated = false;
        // var response = grecaptcha.getResponse();
        // if(response.length == 0) {
        //     isCaptchaValidated = false;
        //     toast('Please verify that you are a Human.');
        // } else {
        //     isCaptchaValidated = true;
        // }


        // if (isCaptchaValidated ) {
        //     //you can now submit your form
        // }
    </script>

<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" />
    <title>Soporte</title>
    <link rel="stylesheet" href="/assets/css/estilo.css">
    <link rel="stylesheet" href="/assets/fontello/css/fontello.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link rel="stylesheet" type="text/css" href="/assets/tooltipster/dist/css/tooltipster.bundle.min.css" />

    <script type="text/javascript" src="/assets/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" />


</head>
<body>
<header>
        <div class="header-preguntas header-preguntas2">
            <div class="cabecera cabecera2">
                <div class="menu-izquierdo-movil" style="display:none;">
                    <span class="icon-menu" style="font-size: 22px;"></span>
                </div>
                <div class="logo">
                    <a href="/"><img src="/assets/img/page-1.svg" alt="" class="logo"></a>
                </div>
                <?php
                if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                && !$thisclient->isGuest()) {
                    ?>
                    <div class="menu-superior-movil" style="display:none;">
                        <label for="ch-micuenta" class="la-micuenta">
                            <ul>
                                <li>
                                    <input type="checkbox" name="" id="ch-micuenta">
                                    <a class="login">
                                    <img src="/assets/img/ic-account-circle.svg" style="float: left;margin-top: -5px;">
                                    <img class="menu-list-formating" src="/assets/img/menu-list-formating.svg">
                                    </a>
                                    <img class="arrow-drop-down" id="flecha-menu-usuario-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="">
                                    <ul class="submenu-micuenta">
                                        <li><span><a href="/open.php">Enviar una solicitud</a></span></li>
                                        <li><span><a href="<?php echo ROOT_PATH; ?>tickets.php">Mis solicitudes</a></span></li>
                                        <li><span><a href="<?php echo $signout_url; ?>">Cerrar sesión</a></span></li>
                                        
                                    </ul>
                                    
                                </li>
                            </ul>   
                        </label>
                    </div>

                    <div class="menu-superior">
                        <a href="/open.php">Enviar una solicitud</a>
                        <label for="ch-micuenta2" class="la-micuenta">
                            <ul>
                                <li>
                                    <input type="checkbox" name="" id="ch-micuenta2">
                                    <img src="/assets/img/ic-account-circle.svg">
                                    <a class="login">
                                    <?php
                                        echo Format::htmlchars($thisclient->getName())
                                    ?>
                                    </a>
                                    <img class="arrow-drop-down icono-flecha-menu" id="flecha-menu-usuario-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="">
                                    <ul class="submenu-micuenta">
                                        
                                        <li><span><a href="<?php echo ROOT_PATH; ?>tickets.php">Mis solicitudes</a></span></li>
                                        <li><span><a href="<?php echo $signout_url; ?>">Cerrar sesión</a></span></li>
                                        
                                    </ul>
                                    
                                </li>
                            </ul>   
                        </label>
                    </div>
                    <?php
                        }else{
                    ?>
            
                    <div class="menu-superior-movil" style="display:none;">
                        <label for="ch-micuenta" class="la-micuenta">
                            <ul>
                                <li>
                                    <input type="checkbox" name="" id="ch-micuenta">
                                    <a class="login">
                                    <img class="menu-list-formating" src="/assets/img/menu-list-formating.svg">
                                    </a>
                                    <img class="arrow-drop-down" id="flecha-menu-usuario-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="">
                                    <ul class="submenu-micuenta">
                                        <li><span><a href="/open.php">Enviar una solicitud</a></span></li>
                                        <li><span><a href="<?php echo $signin_url; ?>">Iniciar sesión</a></span></li>
                                        
                                    </ul>
                                    
                                </li>
                            </ul>   
                        </label>
                    </div>
                    <div class="menu-superior">
                        <a href="/open.php">Enviar una solicitud</a>
                        <a href="<?php echo $signin_url; ?>" style="margin-left:16px;">Iniciar sesión</a>
                    </div>
                    <?php
                        }
                    ?>
            </div>
        </div>
    </header>
    
    
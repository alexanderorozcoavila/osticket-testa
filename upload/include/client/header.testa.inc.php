
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
    <title>Soporte</title>
    <link rel="stylesheet" href="/assets/css/estilo.css">
    <link rel="stylesheet" href="/assets/fontello/css/fontello.css">
    <link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="cabecera">
            <div class="menu-izquierdo-movil" style="display:none;">
                <span class="icon-menu" style="font-size: 22px;"></span>
            </div>
            <div class="logo">
                <img src="/assets/img/page-1.svg" alt="" class="logo">
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
                                    <img src="/assets/img/ic-account-circle.svg">
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
                                        <span id="login-name-span">
                                            <?php
                                                echo Format::htmlchars($thisclient->getName())
                                            ?>
                                        </span>
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
                        <a href="/open.php" >Enviar una solicitud</a>
                        <a href="<?php echo $signin_url; ?>" style="margin-left:16px;">Iniciar sesión</a>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="titulo">
            <h1><p>Estamos acá para ayudarte</p></h1>
        </div>
        <div class="buscador">
            <form method="get" action="/kb/faq.php">
                <label for="ch-buscador" class="la-buscador">
                    <ul>
                        <li>
                        <input type="checkbox" name="" id="ch-buscador">
                        <span id="sp-buscador">
                                <img id="sp-buscador-img" class="sp-buscador-img" src="/assets/img/Gestión.svg"><span class="sp-buscador-prin" id="sp-buscador-span">Gestión</span>
                        </span> 
                        <img class="arrow-drop-down" id="flecha-buscador-cabecera" src="/assets/img/arrow-drop-down-copy-2.svg" alt="">
                        <ul class="submenu-buscador">
                        <?php $cats = Category::getFeatured();?>
                        <?php $cats->all(); ?>
                            <?php foreach ($cats as $topic){ ?>
                            <li>
                                <span id="sp-buscador" class="buscador-elmento">
                                    <img src="/assets/img/<?php echo $topic->name; ?>.svg"><span><?php echo $topic->name; ?></span>
                                </span>
                            </li>
                            <?php } ?>
                        </ul>
                        </li>
                    </ul>
                </label>
                <input type="hidden" name="a" value="search"/>
                <input type="text" name="q" id="in-buscador" placeholder="Buscar en el soporte">
                <button type="submit" class="search"><img class="search2" src="/assets/img/search.svg" alt=""></button>
            </form>
        </div>
    </header>
    
    
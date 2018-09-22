        
<footer>
        <div class="margen">
            <div class="column" id="footer-column-1">
                <h3>Nuestras soluciones</h3>
                <ul>
                    <li>Gestión</li>
                    <li>Terminal de venta</li>
                    <li>Ecommerce</li>
                    <li>Marketing</li>
                    <li>Ventas</li>
                    <li>Servicio al cliente</li>
                </ul>
            </div>
            <div class="column" id="footer-column-2">
                <h3>Nuestras soluciones</h3>
                <ul>
                    <li>Planes de servicio</li>
                    <li>Implementación de soluciones</li>
                    <li>Soporte de soluciones</li>
                    <li>Precios</li>
                    <li>Medios de pago</li>
                    <li>Especificaciones técnicas</li>
                </ul>
            </div>
            <div class="column" id="footer-column-3">
                <h3>Recursos</h3>
                <ul>
                    <li>Soporte de soluciones</li>
                    <li>Solicite una demostración</li>
                    <li>Base de conocimiento</li>
                    <li>Genere una consulta</li>
                    <li>Capacitación</li>
                    <li>Experiencias de nuestros clientes</li>
                </ul>
            </div>
            <div class="column" id="footer-column-4">
                <h3>Compañía</h3>
                <ul>
                    <li>Acerca de nosotros</li>
                    <li>Prensa</li>
                    <li>Contáctenos</li>
                    <li>Mapa del sitio</li>
                    <li>Aviso legal</li>
                </ul>
            </div>
            <div class="column" id="footer-column-5">
                
            </div>
            <div class="column" id="footer-column-6">
                <div class="redes-sociales">
                    <a href=""><img src="/assets/img/linkedin.svg" alt=""></a>
                    <a href=""><img src="/assets/img/facebook.svg" alt=""></a>
                    <a href=""><img src="/assets/img/google.svg" alt=""></a>
                    <ul>
                        <li id="footer-lista-1">Términos de uso</li>
                        <li id="footer-lista-2">Política de privacidad</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<script>
$(".base-lits").click(function(){
		
    var button=$(this);
    var contenido=$(this).find(".base-lits-contenido");
    var img=$(this).find(".arrow-drop-down");
    
    if (button.hasClass('base-lits-open')){
        button.removeClass("base-lits-open");
        contenido.removeClass("base-lits-contenido-open");
        img.attr('src','assets/img/arrow-drop-down-copy-2.svg');
    }else{
        button.addClass("base-lits-open");
        contenido.addClass("base-lits-contenido-open");
        img.attr('src','assets/img/arrow-drop-down-copy.svg');
    }
                             
 });

 $("#ch-buscador").change(function() {
    if(this.checked) {
        $('#flecha-buscador-cabecera').attr('src','assets/img/arrow-drop-down-copy.svg');
    }else{
        $('#flecha-buscador-cabecera').attr('src','assets/img/arrow-drop-down-copy-2.svg');
    }
});

$("#ch-micuenta").change(function() {
    if(this.checked) {
        $('#flecha-menu-usuario-cabecera').attr('src','assets/img/arrow-drop-down-copy.svg');
    }else{
        $('#flecha-menu-usuario-cabecera').attr('src','assets/img/arrow-drop-down-copy-2.svg');
    }
});

 $(".buscador-elmento").click(function(){
    var button=$(this);
    var texto = $(this).find('span');

    $('.sp-buscador-prin').text(texto[0].innerText);
    $('.sp-buscador-img').attr('src','/assets/img/'+ texto[0].innerText +'.svg');
    console.log(texto[0].innerText);
    });
</script>

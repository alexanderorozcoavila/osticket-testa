
    <footer style="background-color: #ffffff; height:151px;">
        <div class="margen margen-poslogin">
            <div class="margen-footer footer-poslogin">
                <span><b>Testa</b> Digital</span>
                <a href="">Política de privacidad</a>
                |
                <a href="">Términos y condiciones</a>
                |
                <a href="">Estado del sistema</a>
            </div>
            <div class="margen-footer footer-poslogin-2" style="display:none;">
                <span id="footer-span"><b>Testa</b> Lorem ipsum dolor sit amet, consectetuer</span>
                <a id="footer-politicas" href="">Política de privacidad</a>
                |
                <a id="footer-terminos" href="">Términos y condiciones</a>
                <a id="footer-estado" href="">Estado del sistema</a>
            </div>
        </div>
    </footer>
</body>
</html>

<script>
$("#ch-micuenta").change(function() {
    if(this.checked) {
        $('#flecha-menu-usuario-cabecera').attr('src','assets/img/arrow-drop-down-copy.svg');
    }else{
        $('#flecha-menu-usuario-cabecera').attr('src','assets/img/arrow-drop-down-copy-2.svg');
    }
});

$("#ch-buscador").change(function() {
    if(this.checked) {
        $('#flecha-buscador-cabecera').attr('src','assets/img/arrow-drop-down-copy.svg');
    }else{
        $('#flecha-buscador-cabecera').attr('src','assets/img/arrow-drop-down-copy-2.svg');
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
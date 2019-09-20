// para que funcione el input file de boostrap
$('.logoMarca-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).siblings('.logoMarca').addClass('selected').html(fileName);
});
// fin

// validaciones
    // enviarForm()
    // function enviarForm(){
        let form = document.querySelector('#formEditarPerfil');

        let aValidar = document.querySelectorAll('.validar');
        let paisInput = document.querySelector('#pais');

        form.addEventListener('submit', function(event){
            for (const campo in aValidar) {
                if (aValidar.hasOwnProperty(campo)) {
                    const element = aValidar[campo];
                    
                    if (element.value === '' || element.value === null) {
                        event.preventDefault();
                        element.classList.add('is-invalid')
                        return;
                    } else {
                        if (element.className.includes('is-invalid')) {
                            element.classList.remove('is-invalid')
                        }
                    }

                    if(paisInput.value !== 'Argentina'){
                        event.preventDefault();
                        paisInput.classList.add('is-invalid')
                        Swal.fire({
                            title: 'Gil',
                            type: 'warning'
                        })
                        return;
                    } else {
                        if (paisInput.className.includes('is-invalid')) {
                            paisInput.classList.remove('is-invalid')
                        }
                    }
                }
            }

            form.submit();
            
        });
    // }

// fin validaciones

// cambiar imagen logo preview
    function cambiarImagen(){
        let imagenLogo = document.querySelector('.imagenLogo');
        let logoMarcaInput = document.querySelector('.logoMarca-input');

        let fr = new FileReader();
        // when image is loaded, set the src of the image where you want to display it
        fr.onload = function(e) { 
            // imagenLogo.style.backgroundImage = 'url('+this.result+')';
            imagenLogo.src = this.result;
        };
        logoMarcaInput.addEventListener("change",function() {
            // fill fr with image data    
            fr.readAsDataURL(logoMarcaInput.files[0]);
        });
    }

    cambiarImagen()
// fin
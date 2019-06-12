// imagenShop para que funcione el input file
    $('.imagenShop-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.imagenShop').addClass('selected').html(fileName);
    });
    
    //imagenShop texto en el input
    var imagenShopLabel = document.querySelector('.imagenShop');
    var imagenShopInput = document.querySelector('.imagenShop-input');
    
    if (imagenShopInput) {
        imagenShopInput.addEventListener('change', function () {
            imagenShopLabel.innerText = 'Estas agregando ' + imagenShopInput.files.length + ' archivos';
        });
    }

// imagenDescripcion para que funcione el input file
    $('.imagenDetalle-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.imagenDetalle').addClass('selected').html(fileName);
    });
    
    //imagenDetalle texto en el input
    var imagenDetalleLabel = document.querySelector('.imagenDetalle');
    var imagenDetalleInput = document.querySelector('.imagenDetalle-input');
    
    if (imagenDetalleInput) {
        imagenDetalleInput.addEventListener('change', function () {
            imagenDetalleLabel.innerText = 'Estas agregando ' + imagenDetalleInput.files.length + ' archivos';
        });
    }

// imagenShop miniatura
            // var imagenShop = $(".imagenShop-input");
            // function readURL1(imagenShop) {
            //     if (imagenShop.files && imagenShop.files[0]) {
            //         var reader = new FileReader();
                
            //         reader.onload = function (e) {
            //             $('#imagenShop-preview').attr('src', e.target.result);
            //         }
    
            //         reader.readAsDataURL(imagenShop.files[0]);
            //     }
            // }
    
            // $(".imagenShop-input").change(function(){
            //     readURL1(this);
            // });
    
            // var cover = $(".cover-input");
            // function readURL2(cover) {
            //     if (cover.files && cover.files[0]) {
            //         var reader = new FileReader();
                    
            //         reader.onload = function (e) {
            //             $('#portada-preview').attr('src', e.target.result);
            //         }
            //         reader.readAsDataURL(cover.files[0]);
            //     }
            // }
    
            // $(".cover-input").change(function () {
            //     readURL2(this);
            // });
        // fin
        // console.log(document.forms["form"]["nombre"].value);
        
        // let campos = $("form :input")
    
        // campos.change(function() {
        //     console.log(campos.val());
            
        // });

// funcion para los talles y cantidad
    function agregarTalle(id) {
        let checkTalle = document.querySelector('.talleId' + id);
        let inputCantidadTalle = document.querySelector('[name^=cantidadId' + id);

        if (checkTalle.checked == true) {
            inputCantidadTalle.classList.remove('d-none');
            inputCantidadTalle.focus();
            inputCantidadTalle.addEventListener('focusout', function () {
                if (this.value == '') {
                    this.style.borderColor = "red";
                }else{
                    this.style.borderColor = "";
                }
            });
        } else {
            inputCantidadTalle.classList.add('d-none');
            inputCantidadTalle.value = '';
            inputCantidadTalle.style.borderColor = "";
        }

    }
// fin funcion

// funcionalidad al click del modificar stock
    if (document.querySelector('.modificarStock')) {
        let checkModStock = document.querySelector('.modificarStock');
        let tablaStock = document.querySelector('.tablaStock');

        checkModStock.addEventListener('click', function () {
            if (this.checked == true) {
                tablaStock.classList.remove('d-none');
            } else {
                tablaStock.classList.add('d-none');
                let checkTalle = document.querySelectorAll('[name^=talles');
                checkTalle.forEach(element => {
                    element.checked = false;
                    let inputCantidadTalle = document.querySelector('[name^=cantidadId' + element.id);
                    inputCantidadTalle.value = '';
                    inputCantidadTalle.classList.add('d-none');

                });

            }
        });
    }
// fin

// edit talles o cantidad ya marcados
    // let checkTalles = document.querySelectorAll('[name^=talles]');
    // let inputCantidadTalles = document.querySelectorAll('[name^=cantidadId]');
    
    // let talleCheckeado = [];

    // checkTalles.forEach(element => {
    //     if (element.checked == true) {
    //         talleCheckeado.push(element.classList.value);
    //     }
    // });

    // inputCantidadTalles.forEach(element => {
    //     //agarro el nombre de la 3er clase que es la que quiero hacer coincidir, ojo si agrego mas clases
    //     if (talleCheckeado.includes(element.classList[2])) {
    //         console.log(element);
    //         element.classList.remove('d-none');
    //     }
        
    // });
    

// fin

//validacion cantidad de determinado talle
    // let form = document.querySelector('.form');

    // form.addEventListener('submit', function enviarForm(event){
    //     event.preventDefault();
    //     let inputsCantidadTalle = document.querySelectorAll('[name^=cantidadId');
    //     inputsCantidadTalle.forEach(element => {
    //         if (!element.classList.contains('d-none') && element.value == '') {
    //             element.focus();
    //         }
    //     });
    // });

    function validateForm(){
        let inputsCantidadTalle = document.querySelectorAll('[name^=cantidadId');
        inputsCantidadTalle.forEach(element => {
            if (!element.classList.contains('d-none') && element.value == '') {
                element.focus();
                event.preventDefault();
            }
        });
    }
    
    
//fin validacion cantidad

document.addEventListener("DOMContentLoaded", function(event) { 
    // imagenShop para que funcione el input file
    $('.imagenShop-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.imagenShop').addClass('selected').html(fileName);
    });

    //imagenShop texto en el input
    var imagenShopLabel = document.querySelector('.imagenShop');
    var imagenShopInput = document.querySelector('.imagenShop-input');
    let imagenShopAgregadas = document.querySelectorAll('.imagenShopAgregadas')

    if (imagenShopInput) {
        imagenShopInput.addEventListener('change', function () {
            let imagenesShopAgregadas = document.querySelectorAll('.imagenesShopAgregadas')
            imagenShopLabel.innerText = 'Estas agregando ' + imagenShopInput.files.length + ' archivos';

            if (imagenesShopAgregadas) {
                imagenesShopAgregadas.forEach(element => {
                    console.log(element);
                    console.log(element.parentNode);
                    
                    element.parentNode.remove()
                    element.remove();
                });
            }

            cambiarImagen('imagenesShopAgregadasDiv', 'imagenShop-input', 'imagenesShopAgregadas', 'imagenShopAgregadas');
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
            let imagenesDetalleAgregadas = document.querySelectorAll('.imagenesDetalleAgregadas')
            imagenDetalleLabel.innerText = 'Estas agregando ' + imagenDetalleInput.files.length + ' archivos';

            if (imagenesDetalleAgregadas) {
                imagenesDetalleAgregadas.forEach(element => {
                    console.log(element);
                    console.log(element.parentNode);
                    
                    element.parentNode.remove()
                    element.remove();
                });
            }

            cambiarImagen('imagenesDetalleAgregadasDiv', 'imagenDetalle-input', 'imagenesDetalleAgregadas', 'imagenDetalleAgregadas')
        });
    }

    // funciones a ejecutarse cuando se cargue la pagina
    acortarDescripcion()
    // fin

});

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

// funcionalidad al click del modificar stock en el EDIT
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

// valido que se carguen 2 imagenes para el shop si o si
    // ya esta declarada en linea 8
    var imagenShopInput = document.querySelector('.imagenShop-input');
    var imagenDetalleInput = document.querySelector('.imagenDetalle-input');
    
    let imagenShopDiv = document.querySelector('.imagenShopDiv');
    if (imagenShopInput) {
        imagenShopInput.addEventListener('change', function () {
            if (imagenShopInput.files.length !== 2) {
                const alerta = document.createElement('span');
                imagenShopInput.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-imagenShopInput');
                alerta.classList.add('d-block');
                alerta.innerText = 'Tenes que agregar 2 imagenes para que se vean en el shop';
                imagenShopDiv.appendChild(alerta);
            }

            // if (imagenShopInput.files.length === 2 && $('[name^=alerta-imagenShopInput]')) {
            //     $('[name^=alerta-imagenShopInput]').remove();
            // }
        });
        imagenShopInput.addEventListener('click', function () {
            if ($('[name^=alerta-imagenShopInput]')) {
                $('[name^=alerta-imagenShopInput]').remove();
            }
        });
    }
// fin

// valido que se carguen hasta 5 imagenes para el detalle
    let imagenDetalleDiv = document.querySelector('.imagenDetalleDiv');
    // imagenDetalleInput ya esta delcarada en la linea 25
    if (imagenDetalleInput) {
        imagenDetalleInput.addEventListener('change', function () {
            if (imagenDetalleInput.files.length < 2) {
                const alerta = document.createElement('span');
                imagenDetalleInput.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-imagenDetalleInput');
                alerta.classList.add('d-block');
                alerta.innerText = 'Tenes que agregar al menos 2 imagenes para que se vean en el detalle del producto';
                imagenDetalleDiv.appendChild(alerta);
            }

            if (imagenDetalleInput.files.length > 5) {
                const alerta = document.createElement('span');
                imagenDetalleInput.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-imagenDetalleInput');
                alerta.classList.add('d-block');
                alerta.innerText = 'Podes agregar como máximo 5 imagenes para que se vean en el detalle del producto';
                imagenDetalleDiv.appendChild(alerta);
            }
        });
        imagenDetalleInput.addEventListener('click', function () {
            if ($('[name^=alerta-imagenDetalleInput]')) {
                $('[name^=alerta-imagenDetalleInput]').remove();
            }
        });
    }
//fin

function cambiarImagen(divImagen, input, imagenesXxxAgregadas, claseDivOculto){
    let img = document.querySelector('.'+divImagen);
    let divOculto = document.querySelector('.'+claseDivOculto)
    divOculto.setAttribute('class', claseDivOculto);
    let imgInput = document.querySelector('.'+input);
    
    let imagenes = []

    for (const imagen in imgInput.files) {
        if (imgInput.files.hasOwnProperty(imagen)) {
            const element = imgInput.files[imagen];
            imagenes.push(element)
        }
    }

    imagenes.forEach(element => {
        let fr = new FileReader();

        fr.onload = function(e) { 
            let imagenAgregada = document.createElement('DIV');
            imagenAgregada.setAttribute('class','d-inline-block col-sm-4 mt-4');
            let imagen = document.createElement('IMG');
            imagen.setAttribute('class','m-auto '+imagenesXxxAgregadas);
            imagen.style = 'display:block; width:200px;';
            imagen.src = this.result;
            imagenAgregada.append(imagen)
            img.append(imagenAgregada)
        };

        fr.readAsDataURL(element);
    });
}

function validateForm(){

    let titulo = document.querySelector('[name=titulo');
    // validacion para el titulo
        if (titulo.value === '') {
            event.preventDefault();
            const alerta = document.createElement('span');
            titulo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-titulo');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que agregar un título';
            titulo.parentNode.appendChild(alerta);
            corrijo(titulo, 'alerta-titulo');
        }
        
        if (titulo.value !== '' && titulo.value.length < 3) {
            event.preventDefault();
            const alerta = document.createElement('span');
            titulo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-titulo');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'El título debe tener como mínimo 3 letras';
            titulo.parentNode.appendChild(alerta);
            corrijo(titulo, 'alerta-titulo');
        } 
        
        if (titulo.value !== '' && titulo.value.length > 30) {
            event.preventDefault();
            const alerta = document.createElement('span');
            titulo.focus();
            alerta.classList.add('alert');
            alerta.setAttribute('name', 'alerta-titulo');
            alerta.classList.add('alert-danger');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'El título debe tener como máximo 30 letras';
            titulo.parentNode.appendChild(alerta);
            corrijo(titulo, 'alerta-titulo');
        }
    // fin validacion para el titulo

    let categoria_id = document.querySelector('[name=categoria_id]');
    // validacion categira
        if (categoria_id.value < 1) {
            event.preventDefault();
            const alerta = document.createElement('span');
            categoria_id.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-categoria_id');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que elegir una categoria';
            // categoria_id.parentNode.prepend(alerta);
            categoria_id.parentNode.appendChild(alerta);
            corrijo(categoria_id, 'alerta-categoria_id');
        }

        if (categoria_id.value > 15) {
            event.preventDefault();
            const alerta = document.createElement('span');
            categoria_id.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-categoria_id');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'No te hagas el piola salame';
            // categoria_id.parentNode.prepend(alerta);
            categoria_id.parentNode.appendChild(alerta);
        }
    // fin validacion categoria

    //checkbox con dos opciones ambas mismo name
    let nuevoSi = document.querySelector('#nuevoSi');
    let nuevoNo = document.querySelector('#nuevoNo');
    let esNuevo = document.querySelector('.esNuevo');
    // validacion producto nuevo
        if (nuevoSi.checked === false && nuevoNo.checked === false) {
            event.preventDefault();
            const alerta = document.createElement('span');
            nuevoNo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-esNuevo');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que marcar una casilla';
            esNuevo.appendChild(alerta);
            let checksNuevo = document.querySelectorAll('[name=nuevo]');
            corrijoCheckbox(checksNuevo, 'alerta-esNuevo');
        }

        if (nuevoSi.checked && nuevoNo.checked) {
            event.preventDefault();
            const alerta = document.createElement('span');
            nuevoNo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-esNuevo');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Solo podes seleccionar una opción';
            esNuevo.appendChild(alerta);
            let checksNuevo = document.querySelectorAll('[name=nuevo]');
            corrijoCheckbox(checksNuevo, 'alerta-esNuevo');
        }

        if ($('[name^=alerta-esNuevo]').length > 1) {
            for (let i = 0; i < ($('[name^=alerta-esNuevo]').length - 1); i++) {
                $('[name^=alerta-esNuevo]')[i].remove();
            }
        }
    // fin validacion producto nuevo
    
    //checkbox con dos opciones ambas mismo name
    let popularSi = document.querySelector('#popularSi');
    let popularNo = document.querySelector('#popularNo');
    let esPopular = document.querySelector('.esPopular');
    // validacion producto destacado
        if (popularSi.checked === false && popularNo.checked === false) {
            event.preventDefault();
            const alerta = document.createElement('span');
            popularNo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-esPopular');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que marcar una casilla';
            esPopular.appendChild(alerta);
            let checksPopu = document.querySelectorAll('[name=popular]');
            corrijoCheckbox(checksPopu, 'alerta-esPopular');
        }

        if (popularSi.checked && popularNo.checked) {
            event.preventDefault();
            const alerta = document.createElement('span');
            popularNo.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-esPopular');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Solo podes seleccionar una opción';
            esPopular.appendChild(alerta);
            let checksPopu = document.querySelectorAll('[name=popular]');
            corrijoCheckbox(checksPopu, 'alerta-esPopular');
        }

        if ($('[name^=alerta-esPopular]').length > 1) {
            for (let i = 0; i < ($('[name^=alerta-esPopular]').length - 1); i++) {
                $('[name^=alerta-esPopular]')[i].remove();
            }
        }
    // fin validacion producto destacado

    let categoriasSecundarias = document.querySelectorAll('[name^=categoriasSecundarias]');
    let catSecundarias = document.querySelector('.catSecundarias');
    // validacion categoria secundaria
        let iCatSec = 0;
        categoriasSecundarias.forEach(check => {
            if (check.checked) {
                iCatSec++;
            }
        });
        if (iCatSec === 0) {
            event.preventDefault();
            const alerta = document.createElement('span');
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-catSecundarias');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que elegir una categoria secundaria';
            // categoria_id.parentNode.prepend(alerta);
            catSecundarias.appendChild(alerta);
            corrijoCheckbox(categoriasSecundarias, 'alerta-catSecundarias');
        }

        if (iCatSec > 3) {
            event.preventDefault();
            const alerta = document.createElement('span');
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-catSecundarias');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Solo podes seleccionar hasta 3 categorias secundarias';
            // categoria_id.parentNode.prepend(alerta);
            catSecundarias.appendChild(alerta);
            corrijoCheckbox(categoriasSecundarias, 'alerta-catSecundarias');
        }

        if ($('[name^=alerta-catSecundarias]').length > 1) {
            for (let i = 0; i < ($('[name^=alerta-catSecundarias]').length - 1); i++) {
                $('[name^=alerta-catSecundarias]')[i].remove();
            }
        }
    // fin validacion categoria secundaria

    let imagenesShopAnteriores = document.querySelectorAll('.imagenesShopAnteriores')
    let imagenShop = document.querySelector('[name^=imagenShop]');
    // let imagenShopDiv = document.querySelector('.imagenShopDiv');
    // validacion imagenes shop
    if (!imagenesShopAnteriores) {
        if (imagenShop.files.length === 0) {
            event.preventDefault();
            const alerta = document.createElement('span');
            imagenShop.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.classList.add('alerta-imagenShop');
            alerta.classList.add('d-block');
            alerta.innerText = 'Las imagenes para el shop son obligatorias';
            imagenShopDiv.appendChild(alerta);
            imagenShop.addEventListener('click', function () {
                $('.alerta-imagenShop').remove();
            });
        }
    }
    // fin validacion imagenes shop

    let imagenesDetalleAnteriores = document.querySelectorAll('.imagenesDetalleAnteriores')
    let imagenDetalle = document.querySelector('[name^=imagenDetalle]');
    let imagenDetalleDiv = document.querySelector('.imagenDetalleDiv');
    // validacion imagenes detalle
        if (!imagenesDetalleAnteriores) {
            if (imagenDetalle.files.length === 0) {
                event.preventDefault();
                const alerta = document.createElement('span');
                imagenDetalle.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.classList.add('alerta-imagenDetalle');
                alerta.classList.add('d-block');
                alerta.innerText = 'Las imagenes para el detalle son obligatorias';
                imagenDetalleDiv.appendChild(alerta);
                imagenDetalle.addEventListener('click', function () {
                    $('.alerta-imagenDetalle').remove();
                });
            }
        }
    // fin validacion imagenes detalle

    let detalle = document.querySelector('[name=detalle');
    // validacion detalle
        if (detalle.value === '') {
            event.preventDefault();
            const alerta = document.createElement('span');
            detalle.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-detalle');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que agregar un detalle';
            detalle.parentNode.appendChild(alerta);
            corrijo(detalle, 'alerta-detalle');
        }
        
        if (detalle.value !== '' && detalle.value.length < 10) {
            event.preventDefault();
            const alerta = document.createElement('span');
            detalle.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-detalle');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'El detalle debe tener como mínimo 10 letras';
            detalle.parentNode.appendChild(alerta);
            corrijo(detalle, 'alerta-detalle');
        } 
        
        if (detalle.value !== '' && detalle.value.length > 60) {
            event.preventDefault();
            const alerta = document.createElement('span');
            detalle.focus();
            alerta.classList.add('alert');
            alerta.setAttribute('name', 'alerta-detalle');
            alerta.classList.add('alert-danger');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'El detalle debe tener como máximo 60 letras';
            detalle.parentNode.appendChild(alerta);
            corrijo(detalle, 'alerta-detalle');
        }
    // fin validacion detalle

    // validacion talles
        let inputsCantidadTalle = document.querySelectorAll('[name^=cantidadId');
        inputsCantidadTalle.forEach(element => {
            if (!element.classList.contains('d-none') && element.value == '') {
                element.focus();
                event.preventDefault();
            }
        });

        let talle = document.querySelectorAll('[name^=talle]');
        let talles = document.querySelector('.talles');
        let iTalle = 0; 
        talle.forEach(check => {
            if (check.checked) {
                iTalle++;
            }                
        });
        
        if (talles.classList[0] !== 'd-none' && talles.classList[4] !== 'd-none') {
            if (iTalle === 0) {
                event.preventDefault();
                const alerta = document.createElement('span');
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-talles');
                alerta.classList.add('d-block');
                alerta.classList.add('mt-2');
                alerta.innerText = 'Tenes que agregar al menos un talle';
                // categoria_id.parentNode.prepend(alerta);
                talles.appendChild(alerta);
                corrijoCheckbox(talle, 'alerta-talles');
            }

            if ($('[name^=alerta-talles]').length > 1) {
                for (let i = 0; i < ($('[name^=alerta-talles]').length - 1); i++) {
                    $('[name^=alerta-talles]')[i].remove();
                }
            }
        }
    // fin validacion talles

    let colores = document.querySelectorAll('[name^=colores');
    let colors = document.querySelector('.colors');
    // validacion colores
        let iColor = 0;
        
        colores.forEach(check => {
            
            if (check.checked) {
                iColor++;
            }
        });
        if (iColor === 0) {
            event.preventDefault();
            const alerta = document.createElement('span');
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-colors');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que selecionar al menos 1 color';
            // categoria_id.parentNode.prepend(alerta);
            colors.appendChild(alerta);
            corrijoCheckbox(colores, 'alerta-colors');
        }

        if (iColor > 4) {
            event.preventDefault();
            const alerta = document.createElement('span');
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-colors');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Solo podes seleccionar hasta 4 colores';
            // categoria_id.parentNode.prepend(alerta);
            colors.appendChild(alerta);
            corrijoCheckbox(colores, 'alerta-colors');
        }

        if ($('[name^=alerta-colors]').length > 1) {
            for (let i = 0; i < ($('[name^=alerta-colors]').length - 1); i++) {
                $('[name^=alerta-colors]')[i].remove();
            }
        }
    // fin validacion colores

    // let descripcion = document.querySelector('[name=descripcion]');
    // validacion descripcion
        // if (descripcion.value === '') {
        //     event.preventDefault();
        //     const alerta = document.createElement('span');
        //     descripcion.focus();
        //     alerta.classList.add('alert');
        //     alerta.classList.add('alert-danger');
        //     alerta.setAttribute('name', 'alerta-descripcion');
        //     alerta.classList.add('d-block');
        //     alerta.classList.add('mt-2');
        //     alerta.innerText = 'Tenes que agregar una descripción';
        //     descripcion.parentNode.appendChild(alerta);
        //     corrijo(descripcion, 'alerta-descripcion');
        // }
        
        // if (descripcion.value !== '' && descripcion.value.length < 20) {
        //     event.preventDefault();
        //     const alerta = document.createElement('span');
        //     descripcion.focus();
        //     alerta.classList.add('alert');
        //     alerta.classList.add('alert-danger');
        //     alerta.setAttribute('name', 'alerta-descripcion');
        //     alerta.classList.add('d-block');
        //     alerta.classList.add('mt-2');
        //     alerta.innerText = 'La descripción debe tener como mínimo 20 letras';
        //     descripcion.parentNode.appendChild(alerta);
        //     corrijo(descripcion, 'alerta-descripcion');
        // } 
    // fin validacion descripcion

    let precio = document.querySelector('[name=precio]');
    // validacion precio
        if (precio.value === '') {
            event.preventDefault();
            const alerta = document.createElement('span');
            precio.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-precio');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Tenes que agregar un precio';
            precio.parentNode.appendChild(alerta);
            corrijo(precio, 'alerta-precio');
        }
        
        if (precio.value > 10000) {
            event.preventDefault();
            const alerta = document.createElement('span');
            precio.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-precio');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'Es muuuuy caro';
            precio.parentNode.appendChild(alerta);
            corrijo(precio, 'alerta-precio');
        }

        if (precio.value < 0) {
            event.preventDefault();
            const alerta = document.createElement('span');
            precio.focus();
            alerta.classList.add('alert');
            alerta.classList.add('alert-danger');
            alerta.setAttribute('name', 'alerta-precio');
            alerta.classList.add('d-block');
            alerta.classList.add('mt-2');
            alerta.innerText = 'El precio no puede ser negativo';
            precio.parentNode.appendChild(alerta);
            corrijo(precio, 'alerta-precio');
        } 
    // fin validacion precio

    let descuento = document.querySelector('[name=descuento');
    // validacion descuento
        if (descuento.value) {
            if (descuento.value > 100) {
                event.preventDefault();
                const alerta = document.createElement('span');
                descuento.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-descuento');
                alerta.classList.add('d-block');
                alerta.classList.add('mt-2');
                alerta.innerText = 'El descuento no puede ser mayor al 100%';
                descuento.parentNode.appendChild(alerta);
                corrijo(descuento, 'alerta-descuento');
            }

            if (descuento.value < 0) {
                event.preventDefault();
                const alerta = document.createElement('span');
                descuento.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-descuento');
                alerta.classList.add('d-block');
                alerta.classList.add('mt-2');
                alerta.innerText = 'El porcentaje no puede ser negativo';
                descuento.parentNode.appendChild(alerta);
                corrijo(descuento, 'alerta-descuento');
            }
        }
    // fin validacion descuento


    function corrijoCheckbox(elemento, nombreSpan){
        elemento.forEach(check => {
            if (check.checked) {
                check.checked = false;
            }
            check.addEventListener('click', function () {
                // if (nombreSpan) {
                let alerta = $('[name^=' + nombreSpan + ']');
                alerta.remove();
                // }
            });
        });
    }

    function corrijo(elemento, nombreSpan) {
        elemento.addEventListener('focusin', function () {
            if (nombreSpan) {
                let alerta = $('[name^=' + nombreSpan + ']');
                alerta.remove();
            }
            elemento.value = '';
        });
    }


}

// -----------

function fetchDelete(deleteUrl){
    // var url = '/dashboard/personalizacion/'+userId+'/borrarCarPrincipal/'+catId;
    fetch(deleteUrl, {
        method: 'DELETE', // or 'PUT'
        headers:{
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).then(res => res.text())
      .catch(error => console.error('Error:', error))
      .then(response => {
            let mensaje = response.mensaje;
            // let mensaje = JSON.parse(response).mensaje;
        
            if (mensaje !== '') {
                Swal.fire(
                    'Eliminado!',
                    'El producto se eliminó correctamente.',
                    'success'
                );
            }
          
      });
}

function eliminarProducto(prodId){
    Swal.fire({
        title: 'Estas seguro que queres eliminar este producto?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminalo!'
      }).then((result) => {
        if (result.value) {
            fetchDelete(`/dashboard/productos/borrar/${prodId}`);
            // let productos = document.querySelectorAll('.producto')
            let productos = document.querySelectorAll('.tarjeta')
            // let contenedorDeProductos = document.querySelector('.contenedorDeProductos')
            let contenedorDeProductos = document.querySelector('.tarjetas')
            let productosNuevos = [];
            productos.forEach(element => {
                let idsProucto = element.id.split('prodId')[1]
                if (idsProucto != prodId) {
                    productosNuevos.push(element)
                }
                element.remove();
            });
            productosNuevos.forEach(element => {
                contenedorDeProductos.append(element);
            });
        }
      })
}

function acortarDescripcion(){
    let descripcion = document.querySelectorAll('.descripcionP');
    descripcion.forEach(element => {
        if (element.innerText.length > 50) {
            let prodDescripcion = element.innerText;
            let puntos = '...';
            prodDescripcion = prodDescripcion.slice(0, 50);
            prodDescripcion = prodDescripcion + puntos;
            element.innerText = prodDescripcion;
        }
    });
    
}
// ------------

// para editar

let formEdit = document.querySelector('#formEdit');

if (formEdit) {
    function cambiarImagenEdit(divImagen, input, imagenesXxxAnteriores){
        let img = document.querySelector('.'+divImagen);
        let imgInput = document.querySelector('.'+input);
        let imagenes = []
    
        for (const imagen in imgInput.files) {
            if (imgInput.files.hasOwnProperty(imagen)) {
                const element = imgInput.files[imagen];
                imagenes.push(element)
            }
        }
    
        imagenes.forEach(element => {
            let fr = new FileReader();
    
            fr.onload = function(e) { 
                let imagenAnterior = document.createElement('DIV');
                imagenAnterior.setAttribute('class','d-inline-block col-sm-4 mt-4');
                let imagen = document.createElement('IMG');
                imagen.setAttribute('class','m-auto '+imagenesXxxAnteriores);
                imagen.style = 'display:block; width:200px;';
                imagen.src = this.result;
                imagenAnterior.append(imagen)
                img.append(imagenAnterior)
            };
    
            fr.readAsDataURL(element);
        });
    }
    
    imagenShopInput.addEventListener('change', () => {
        let imagenesShopAnteriores = document.querySelectorAll('.imagenesShopAnteriores')
        Swal.fire({
            title: 'Estas seguro que queres cambiar las imagenes?',
            text: 'Todas las imagenes se REEMPLAZARAN por las seleccionadas',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cambialas!'
        }).then( (result) => {
            
            if (result.value) {
                imagenesShopAnteriores.forEach(element => {
                    element.parentNode.remove()
                    element.remove();
                });
                cambiarImagenEdit('imagenesShopAnterioresDiv', 'imagenShop-input', 'imagenesShopAnteriores');
            }
    
            if (result.dismiss) {
                console.log(imagenShopInput.files);
                imagenShopInput.value = '';
                console.log(imagenShopInput.files);
                let imagenShopLabel = document.querySelector('.imagenShop');
                imagenShopLabel.innerText = 'click para agregar'
                
                Swal.fire('No se cambio nada')
            }
        })
    });
    
    imagenDetalleInput.addEventListener('change', () => {
        let imagenesDetalleAnteriores = document.querySelectorAll('.imagenesDetalleAnteriores')
        Swal.fire({
            title: 'Estas seguro que queres cambiar las imagenes?',
            text: 'Todas las imagenes se REEMPLAZARAN por las seleccionadas',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cambialas!'
        }).then( (result) => {
            if (result.value) {
                imagenesDetalleAnteriores.forEach(element => {
                    console.log(element);
                    console.log(element.parentNode);
                    
                    element.parentNode.remove()
                    element.remove();
                });
                cambiarImagenEdit('imagenesDetalleAnterioresDiv', 'imagenDetalle-input', 'imagenesDetalleAnteriores');
            }
    
            if (result.dismiss) {
                imagenDetalleInput.value = '';
                let imagenDetalleLabel = document.querySelector('.imagenDetalle');
                imagenDetalleLabel.innerText = 'click para agregar'
                Swal.fire('No se cambio nada')
            }
        })
    });   
}
// fin editar
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

    // valido que se carguen 2 imagenes para el shop si o si
        // ya esta declarada en linea 8
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

            if (categoria_id.value > 12) {
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
        // fin validacion categoria secundaria

        let imagenesShopAnteriores = document.querySelectorAll('.imagenesShopAnteriores')
        let imagenShop = document.querySelector('[name^=imagenShop]');
        let imagenShopDiv = document.querySelector('.imagenShopDiv');
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
        // console.log(modificarStock);
            
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
            if (talles.classList[0] !== 'd-none') {
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
        // fin validacion colores

        let descripcion = document.querySelector('[name=descripcion]');
        // validacion descripcion
            if (descripcion.value === '') {
                event.preventDefault();
                const alerta = document.createElement('span');
                descripcion.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-descripcion');
                alerta.classList.add('d-block');
                alerta.classList.add('mt-2');
                alerta.innerText = 'Tenes que agregar una descripción';
                descripcion.parentNode.appendChild(alerta);
                corrijo(descripcion, 'alerta-descripcion');
            }
            
            if (descripcion.value !== '' && descripcion.value.length < 20) {
                event.preventDefault();
                const alerta = document.createElement('span');
                descripcion.focus();
                alerta.classList.add('alert');
                alerta.classList.add('alert-danger');
                alerta.setAttribute('name', 'alerta-descripcion');
                alerta.classList.add('d-block');
                alerta.classList.add('mt-2');
                alerta.innerText = 'La descripción debe tener como mínimo 20 letras';
                descripcion.parentNode.appendChild(alerta);
                corrijo(descripcion, 'alerta-descripcion');
            } 
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
            // if (descuento.value === '') {
            //     event.preventDefault();
            //     const alerta = document.createElement('span');
            //     descuento.focus();
            //     alerta.classList.add('alert');
            //     alerta.classList.add('alert-danger');
            //     alerta.setAttribute('name', 'alerta-descuento');
            //     alerta.classList.add('d-block');
            //     alerta.classList.add('mt-2');
            //     alerta.innerText = 'Tenes que agregar un descuento';
            //     descuento.parentNode.appendChild(alerta);
            //     corrijo(descuento, 'alerta-descuento');
            // }
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


    // campos a validar

    
//fin validacion cantidad

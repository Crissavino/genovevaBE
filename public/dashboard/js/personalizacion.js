// let categoriasPrincipales = $( "a[class^='quitarCategoriaPrincipal']" )

// console.log(categoriasPrincipales);
document.addEventListener("DOMContentLoaded", function(event) { 
    cambiarColor('checkColorLetra', 'colorLetra', false);

    cambiarColor('checkColorNew', 'colorNew');

    cambiarColor('checkColorDescuento', 'colorDescuento');

    cambiarImagen();
});

let that = this;

// function quitarCategoriaPrincipal(id){
//     let categoriaAborrar = document.querySelector('.quitarCategoriaPrincipal'+id);
//     let categoriaEliminada = document.querySelector('.catEliminadas');
//     let arrayIds = [categoriaEliminada.value];

//     if (arrayIds[0] === "") {
//         arrayIds[0] = id;
//         categoriaEliminada.value = arrayIds[0];
//     } else {
//         arrayIds.push(id);
//         categoriaEliminada.value = arrayIds;
//     }
//     categoriaAborrar.parentElement.innerHTML = " "
// }

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
            let mensaje = JSON.parse(response).mensaje;
        
            if (mensaje !== '') {
                Swal.fire(
                    'Eliminado!',
                    'La categoría se eliminó correctamente.',
                    'success'
                );
            }
          
      });
}

function quitarCategoriaPrincipal(userId, catId){


    Swal.fire({
        title: 'Estas seguro que queres eliminar esta categoria?',
        text: "Si eliminas esta categoria todos los productos asociados a la misma tambien seran eliminados!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminala!'
      }).then((result) => {
        if (result.value) {
            fetchDelete(`/dashboard/personalizacion/${userId}/borrarCatPrincipal/${catId}`);
            let categoriasPrincipales = document.querySelectorAll('.categoriaPrincipalLi')
            let categoriaPrincipalUl = document.querySelector('.categoriaPrincipalUl')
            let categoriasNuevas = [];
            categoriasPrincipales.forEach(element => {
                let idsCategoria = element.id.split('catPrinId')[1]
                if (idsCategoria != catId) {
                    categoriasNuevas.push(element)
                }
                element.remove();
            });
            categoriasNuevas.forEach(element => {
                categoriaPrincipalUl.append(element);
                
            });
        }
      })
}

function quitarCategoriaSecundaria(userId, catId){

    Swal.fire({
        title: 'Estas seguro que queres eliminar esta categoria?',
        // text: "Si eliminas esta categoria todos los productos asociados a la misma tambien seran eliminados!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminala!'
      }).then((result) => {
        if (result.value) {
            fetchDelete(`/dashboard/personalizacion/${userId}/borrarCatSecundaria/${catId}`);
            let categoriasPrincipales = document.querySelectorAll('.categoriaSecundariaLi')
            let categoriaSecundariaUl = document.querySelector('.categoriaSecundariaUl')
            let categoriasNuevas = [];
            categoriasPrincipales.forEach(element => {
                let idsCategoria = element.id.split('catSecId')[1]
                if (idsCategoria != catId) {
                    categoriasNuevas.push(element)
                }
                element.remove();
            });
            categoriasNuevas.forEach(element => {
                categoriaSecundariaUl.append(element);
            });
            
            
            
        }
      })

    // let categoriaAborrar = document.querySelector('.quitarCategoriaSecundaria'+id);
    // let categoriaEliminada = document.querySelector('.catSecEliminadas');
    // let arrayIds = [categoriaEliminada.value];

    // if (arrayIds[0] === "") {
    //     arrayIds[0] = id;
    //     categoriaEliminada.value = arrayIds[0];
    // } else {
    //     arrayIds.push(id);
    //     categoriaEliminada.value = arrayIds;
    // }
}

function cambiarImagen(){
    let imagenBanner = document.querySelector('.imagenBanner');
    let bannerMarcaInput = document.querySelector('.bannerMarca-input');

    let fr = new FileReader();
    // when image is loaded, set the src of the image where you want to display it
    fr.onload = function(e) { 
        imagenBanner.style.backgroundImage = 'url('+this.result+')';
    };
    bannerMarcaInput.addEventListener("change",function() {
        // fill fr with image data    
        fr.readAsDataURL(bannerMarcaInput.files[0]);
    });
}

function cambiarColor(claseCheckColor, claseElementoAcambiar, colorDeFondo = true){

    let claseCheck = document.querySelectorAll('.'+claseCheckColor);
    
    let claseElemento = document.querySelector('.'+claseElementoAcambiar);

    let colorDeFondoInicial = claseElemento.style.backgroundColor
    let colorDeLetraInicial = claseElemento.style.color

    claseCheck.forEach(inputCheck => {
        inputCheck.addEventListener('click', () => {
            if (inputCheck.checked) {
                if (colorDeFondo) {
                    claseElemento.setAttribute('style', 'background-color: '+inputCheck.id);
                } else {
                    claseElemento.setAttribute('style', 'color: '+inputCheck.id);
                }
                claseCheck.forEach(inputCheck2 => {
                    if (inputCheck2.id !== inputCheck.id) {
                        inputCheck2.checked = false;
                    }
                });
            } else {
                if (colorDeFondo) {
                    claseElemento.setAttribute('style', 'background-color: '+colorDeFondoInicial);
                } else {
                    claseElemento.setAttribute('style', 'color: '+colorDeLetraInicial);
                }
            }
        });
    });
}

    
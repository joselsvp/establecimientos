document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#dropzone')){
        Dropzone.autoDiscover = false;

        const dropzone = new Dropzone('div#dropzone', {
            url: '/images/store',
            dictDefaultMessage: 'Sube hasta 10 imágenes'
        })

    }
});

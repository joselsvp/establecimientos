document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#dropzone')){
        Dropzone.autoDiscover = false;

        const dropzone = new Dropzone('div#dropzone', {
            url: '/images/store',
            dictDefaultMessage: 'Sube hasta 10 imágenes',
            maxFiles: 10,
            required: true,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar imagen",
            acceptedFiles: '.png,.jpg,.gif,.bmp,.jpeg',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            success: function (file, response){
                console.log(response);
                file.serverName = response.file
            },
            sending: function (file, xhr, formData){
                formData.append('uuid', document.querySelector('#uuid').value);
                console.log('enviando');
            },
            removedfile: function (file, response){
                console.log(file);
                const params = {
                    image: file.serverName
                }

                axios.post('/images/destroy', params)
                    .then(response => {
                       console.log(response);
                       file.previewElement.parentNode.removeChild(file.previewElement);
                    });
            }
        })

    }
});

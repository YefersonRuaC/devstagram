import Dropzone  from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Arrastra aqui tu imagen',
    acceptedFiles: ".png, .jpg, jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()) {
            const imagenSubida = {}
            imagenSubida.size = 1234;
            imagenSubida.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call( this, imagenSubida );
            this.options.thumbnail.call( this, imagenSubida, `/uploads/${imagenSubida.name}` )

            imagenSubida.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

dropzone.on('success', function(file, response) {
    // console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = "";
});
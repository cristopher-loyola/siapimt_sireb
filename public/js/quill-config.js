// CONFIGURACION DEL EDITOR QUILL

document.addEventListener("DOMContentLoaded", function(){
    function insertarEstilosToast(){
        if(document.getElementById('quill-toast-styles')) return;
        const estilo = document.createElement('style');
        estilo.id = 'quill-toast-styles';
        estilo.textContent = `
            .quill-toast{
                position: fixed;
                left: 50%;
                right: auto;
                top: 16px;
                max-width: 620px;
                background: #ff311aff; 
                color: #fff;
                padding: 12px 16px;
                border-radius: 8px;
                box-shadow: 0 8px 20px rgba(0,0,0,.15);
                font-family: system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
                font-size: 14px;
                line-height: 1.4;
                white-space: pre-line; 
                z-index: 9999;
                opacity: 0;
                transform: translate(-50%, -8px);
                transition: opacity .2s ease, transform .2s ease;
            } .quill-toast.mostrar {
                opacity: 1;
                transform: translate(-50%, 0);
            } `;
        document.head.appendChild(estilo);
    }
    function mostrarToast(mensaje, duracion = 4000){
        insertarEstilosToast();
        const toast = document.createElement('div');
        toast.className = 'quill-toast';
        toast.textContent = mensaje;
        document.body.appendChild(toast);
        void toast.offsetHeight;
        toast.classList.add('mostrar');
        setTimeout(() => {
            toast.classList.remove('mostrar');
            setTimeout(() => toast.remove(), 250);
        }, duracion);
    }

    // PARA LOS TOAST
    function quitarDuplicados(lista){
        const vistos = {};
        const salida = [];
        for(let i=0; i<lista.length; i++){
            const item = lista[i];
            if(!vistos[item]){
                vistos[item] = true;
                salida.push(item);
            }
        }
        return salida;
    }

    function manejadorImagen() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        // SOLO PARA JPG Y PNG
        input.setAttribute('accept', 'image/jpeg,image/png');
        input.click();
        input.onchange = () => {
            const archivo = input.files[0];
            if (!archivo){
                return;
            }
            // 1MB
            const tamMax = 1 * 1024 * 1024; 
            const permitidos = ['image/jpeg', 'image/png'];
            if(!permitidos.includes(archivo.type)){
                mostrarToast('Nota: \n Solo se permiten imágenes JPG o PNG.');
                return;
            }
            if(archivo.size > tamMax){
                mostrarToast('Nota: \n La imagen no debe exceder 1 MB.');
                return;
            }
            const lector = new FileReader();
            lector.onload = (e) => {
                const rango = this.quill.getSelection();
                this.quill.insertEmbed(rango.index, 'image', e.target.result);
            };
            lector.readAsDataURL(archivo);
        };
    }

    // INICIALIZACIÓN DEL EDITOR QUILL, DONDE SE AGREGAN LOS ELEMENTOS 
    const editoresQuill = [];
    document.querySelectorAll('.editor-quill').forEach(function (contenedor){
        let nombreInput = contenedor.getAttribute('data-input') || 'justificacion';
        let inputOculto = document.querySelector('input[name="' + nombreInput + '"]') || document.querySelector('textarea[name="' + nombreInput + '"]');
        if (!inputOculto){
            return;
        }
        let valorOriginal = inputOculto.value.trim();
        // Verificar si está en modo solo lectura
        let esReadonly = contenedor.hasAttribute('data-readonly');
        
        let quill = new Quill(contenedor,{
            theme: 'snow',
            placeholder: contenedor.getAttribute('placeholder') || '',
            readOnly: esReadonly, // Activar modo solo lectura si es necesario
            modules: {
                toolbar: { // Mantener toolbar siempre para mismo tamaño
                    container: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'image'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        [{ align: [] }],
                        [{ script: 'sub' }, { script: 'super' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean'],
                    
                        
                    ],
                    handlers: {
                        image: manejadorImagen
                    }
                }
            }
        });
        
        // Si es readonly, deshabilitar toolbar después de crear Quill
        if (esReadonly) {
            let toolbar = contenedor.previousElementSibling;
            if (toolbar && toolbar.classList.contains('ql-toolbar')) {
                // Deshabilitar todos los botones del toolbar
                toolbar.style.pointerEvents = 'none';
                toolbar.style.opacity = '0.5';
                toolbar.style.cursor = 'not-allowed';
            }
        }
        editoresQuill.push({ quill, inputOculto });

        // TOOLTIPS PARA LOS BOOTONES DE LA BARRA DE HERRAMIENTAS
        document.querySelectorAll('.ql-toolbar button.ql-header').forEach(btn => btn.title = 'Tamaño de Fuente');
        document.querySelectorAll('.ql-toolbar button.ql-bold').forEach(btn => btn.title = 'Negrita');
        document.querySelectorAll('.ql-toolbar button.ql-italic').forEach(btn => btn.title = 'Cursiva');
        document.querySelectorAll('.ql-toolbar button.ql-underline').forEach(btn => btn.title = 'Subrayado');
        document.querySelectorAll('.ql-toolbar button.ql-link').forEach(btn => btn.title = 'Link');
        document.querySelectorAll('.ql-toolbar button.ql-image').forEach(btn => btn.title = 'Imágenes');
        document.querySelectorAll('.ql-toolbar button.ql-list').forEach(btn => btn.title = 'Enumeración');
        document.querySelectorAll('.ql-toolbar button.ql-list[value="bullet"]').forEach(btn => btn.title = 'Viñetas');
        document.querySelectorAll('.ql-toolbar button.ql-script[value="sub"]').forEach(btn => btn.title = 'Subíndice');
        document.querySelectorAll('.ql-toolbar button.ql-script[value="super"]').forEach(btn => btn.title = 'Superíndice');
        document.querySelectorAll('.ql-toolbar .ql-color').forEach(btn => btn.title = 'Color de Fuente');
        document.querySelectorAll('.ql-toolbar .ql-background').forEach(btn => btn.title = 'Resaltado');
        document.querySelectorAll('.ql-toolbar button.ql-clean').forEach(btn => btn.title = 'Limpiar Formato');
       
        contenedor.classList.add('borde-azul');
        let barra = contenedor.previousElementSibling;
        if(barra && barra.classList.contains('ql-toolbar')){
            barra.classList.add('borde-azul');
        }
        if(inputOculto.value){
            quill.clipboard.dangerouslyPasteHTML(inputOculto.value);
        }
        quill.on('text-change', function(){
            inputOculto.value = quill.root.innerHTML;
            let current = quill.root.innerHTML.trim();
            if(current !== valorOriginal){
                contenedor.classList.remove('borde-azul');
                contenedor.classList.add('borde-rojo');
                if(barra && barra.classList.contains('ql-toolbar')){
                    barra.classList.remove('borde-azul');
                    barra.classList.add('borde-rojo');
                }
            }else{
                contenedor.classList.remove('borde-rojo');
                contenedor.classList.add('borde-azul');
                if(barra && barra.classList.contains('ql-toolbar')){
                    barra.classList.remove('borde-rojo');
                    barra.classList.add('borde-azul');
                }
            }
        });
    });

    // PARA EL PROCESAMIENTO DE IMAGENES, ANTES DE QUE SE GUARDEN EN STORAGE
    async function procesarImagenesBase64(quill, inputOculto) {
        let imagenes = Array.from(quill.root.querySelectorAll('img'));
        let huboCambios = false;
        let errores = [];
        let inputIdProy = document.getElementById('idproy-quill');
        let idProyecto = '';
        if(inputIdProy){
            idProyecto = inputIdProy.value;
        }
        for(let img of imagenes){
            if(img.src && img.src.startsWith('data:image/')){
                let formData = new FormData();
                formData.append('image_base64', img.src);
                if (idProyecto) formData.append('idproy', idProyecto);
                const metaToken = document.querySelector('meta[name="csrf-token"]');
                const token = metaToken ? metaToken.getAttribute('content') : '';
                try {
                    let resp = await fetch('../quill/imagenesQuillBase64', {
                        method: 'POST',
                        body: formData,
                        headers: token ? { 'X-CSRF-TOKEN': token } : {}
                    });
                    if (!resp.ok) {
                        errores.push('No se pudo subir una imagen (estado ' + resp.status + ').');
                        // Elimina la imagen base64 para no guardar contenido inválido
                        img.remove();
                        huboCambios = true;
                        continue;
                    }
                    let datos = await resp.json();
                    if (datos.success && datos.url) {
                        img.setAttribute('src', datos.url);
                        huboCambios = true;
                    } else {
                        errores.push(datos.error || 'Imagen rechazada por el servidor.');
                        img.remove();
                        huboCambios = true;
                    }
                } catch (err) {
                    errores.push('Error de red subiendo una imagen.');
                    img.remove();
                    huboCambios = true;
                }
            }
        }
        if(huboCambios){
            quill.root.innerHTML = quill.root.innerHTML;
            inputOculto.value = quill.root.innerHTML;
        }
        return{ changed: huboCambios, errors: errores};
    }

    // SUBMIT Y BOTONES DE LAS CEJAS
    let formulariosProcesados = new Set();
    editoresQuill.forEach(({quill, inputOculto}) => {
        let form = inputOculto.closest('form');
    if(!form || formulariosProcesados.has(form)){
        return;
    }
        formulariosProcesados.add(form);

        form.addEventListener('submit', async function(e){
            if(form.dataset.processingQuill === '1'){
                return;
            }
            form.dataset.processingQuill = '1';
            e.preventDefault();
            let erroresGlobales = [];
            for(const{quill, inputOculto} of editoresQuill){
                const res = await procesarImagenesBase64(quill, inputOculto);
                if (res && res.errors && res.errors.length) erroresGlobales.push(...res.errors);
            }
            form.dataset.processingQuill = '';
            if (erroresGlobales.length) {
                const lista = quitarDuplicados(erroresGlobales);
                mostrarToast('Se bloquearon imágenes no válidas:\n- ' + lista.join('\n- '));
                return; // No envia hasta que el usuario corrija
            }
            form.submit();
        });

        form.querySelectorAll('button[name="oculto"]').forEach(function (btn){
            const manejador = async function (ev) {
                if (form.dataset.processingQuill === '1') return;
                form.dataset.processingQuill = '1';
                ev.preventDefault();
                let erroresGlobales = [];
                for (const { quill, inputOculto } of editoresQuill) {
                    const res = await procesarImagenesBase64(quill, inputOculto);
                    if (res && res.errors && res.errors.length) erroresGlobales.push(...res.errors);
                }
                form.dataset.processingQuill = '';
                if (erroresGlobales.length) {
                    const lista = quitarDuplicados(erroresGlobales);
                    mostrarToast('Se bloquearon imágenes no válidas:\n- ' + lista.join('\n- '));
                    return; 
                }
                // Crear input hidden temporal con el valor de la ceja
                let inputTemporal = document.createElement('input');
                inputTemporal.type = 'hidden';
                inputTemporal.name = btn.name;
                inputTemporal.value = btn.value;
                form.appendChild(inputTemporal);
                form.submit();
                setTimeout(() => {
                    form.removeChild(inputTemporal);
                }, 1000);
            };
            btn.addEventListener('click', manejador);
        });
    })
    
});
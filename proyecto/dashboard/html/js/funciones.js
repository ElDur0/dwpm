function seguridad(){
	const myHeaders = new Headers()
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: "",
        redirect: "follow"
    };
    fetch("http://localhost/dwpm/proyecto/dashboard/php/seguridad.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos     = JSON.parse(result)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
			localStorage.setItem('key', datos.data);
        }
    })
    .catch((error) => console.error(error));
}
seguridad();
async function obtenerPerfiles(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'getPerfiles',
            metodo: 'GET'
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/proyecto/dashboard/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
		//console.log(result)
        const datos     = JSON.parse(result)
        const respuesta = JSON.parse(datos.data)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            document.getElementById('cards').innerHTML = respuesta.card
            
        }
    })
    .catch((error) => console.error(error));
}

async function agregarPerfil(perfil){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'agregarPerfil',
            metodo: 'POST',
            datos: perfil
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/proyecto/dashboard/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
		console.log(result)
        const datos     = JSON.parse(result)
        const respuesta = JSON.parse(datos.data)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
           location.reload();
            
        }
    })
    .catch((error) => console.error(error));
}


obtenerPerfiles();



//eliminar un perfil
async function eliminarPerfil(id){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'eliminarPerfil',
            metodo: 'POST',
            query: id
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/proyecto/dashboard/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
		//console.log(result)
        const datos     = JSON.parse(result)
        //const respuesta = JSON.parse(datos.data)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            location.reload();
            
        }
    })
    .catch((error) => console.error(error));
}
document.getElementById('guardarPerfil').addEventListener('click', () => {
    const nombre = document.getElementById('nombrePerfil').value.trim();
    const puesto = document.getElementById('puesto').value.trim();
    const edad = document.getElementById('edad').value.trim();
    const educacion = document.getElementById('educacion').value.trim();
    const locacion = document.getElementById('locacion').value.trim();
    const biografia = document.getElementById('biografia').value.trim();
    const metas = document.getElementById('metas').value.trim();
    const motivaciones = document.getElementById('motivaciones').value.trim();
    const preocupaciones = document.getElementById('preocupaciones').value.trim();


    const perfil = { 
        nombre, 
        puesto, 
        edad, 
        educacion, 
        locacion, 
        biografia, 
        metas, 
        motivaciones, 
        preocupaciones 
    };

    agregarPerfil(perfil);
    // Cerrar el modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarPerfil'));
    modal.hide();

    // Limpiar formulario
    document.getElementById('formAgregarPerfil').reset();
});
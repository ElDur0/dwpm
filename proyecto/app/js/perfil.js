
function obtenerParametroPorNombre(nombre){
    const url = new URL(window.location.href);
    return url.searchParams.get(nombre);
}

async function buscarPerfil() {
    const query = obtenerParametroPorNombre('id');

    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'buscarPerfil',
            metodo: 'GET',
            query: query // El parámetro de búsqueda
        }),
        redirect: "follow"
    };

    await fetch("http://localhost/dwpm/proyecto/app/php/intermediario.php", requestOptions)
        .then((response) => response.text())
        .then((result) => {
            const datos     = JSON.parse(result);
            const cuerpo = JSON.parse(datos.data);
            if (datos.status != 200) {
                throw new Error('Error en la respuesta API');
            } else {
                document.getElementById('profile').innerHTML = cuerpo.contenido;
                console.log(cuerpo.contenido);
            }
        })
        .catch((error) => {
            console.error('Error al cargar el perfil:', error);
            // Mostrar un mensaje de error en caso de que no se carguen los datos
           
        });
}
buscarPerfil();
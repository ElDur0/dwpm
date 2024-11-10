/*async function insertarPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const raw = JSON.stringify({
        "nombre": "pelicula generica",
        "year": "2001",
        "portada": "pordatapelicual.jpg"
    });
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/examen3/loteria/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos = JSON.parse(result)
        console.log(datos)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            window.alert("datos Guardados de manera correcta");
        }
    })
    .catch((error) => console.error(error));
}*/
async function obtenerPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'getCartas',
            metodo: 'GET'
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/examen3/loteria/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos = JSON.parse(result);
        const contenido = JSON.parse(datos.data);
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            document.getElementById('cardsLoteria').innerHTML=contenido.tablero;
            //document.getElementById('tablaPeliculas').innerHTML=contenido.tabla;
           // let table = new DataTable('#myTable', {});
        }
    })
    .catch((error) => console.error(error));
}
obtenerPeliculas();
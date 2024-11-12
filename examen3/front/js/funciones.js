
async function dibujarTablero(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'tablero',
            metodo: 'GET',

        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/examen3/front/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos = JSON.parse(result);
        const contenido = JSON.parse(datos.data);
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            document.getElementById('cardsLoteria').innerHTML=contenido.tablero;
            
        }
    })
    .catch((error) => console.error(error));
}

async function cantar_loteria(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'cantarLoteria',
            metodo: 'GET',

        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/examen3/front/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos = JSON.parse(result);
        const contenido = JSON.parse(datos.data);
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            let cartas= contenido;
            document.getElementById('cardsLoteria').innerHTML='';
            let index=0;
            const mostrarCarta=()=>{
                if (index < cartas.length) {
                    // Mostrar la carta en el contenedor
                    const carta = cartas[index];
                    const cartaHTML = `<div class="grid-item"><img src="img/${carta[0]}"></div>`;
                    document.getElementById('cardsLoteria').innerHTML = cartaHTML;
                    index++;

                    // Llamar nuevamente a la función con un pequeño retraso (1 segundo, por ejemplo)
                    setTimeout(mostrarCarta, 5000);
                }
            };
            //iniciar la función para mostrar cartas
            mostrarCarta();
        }
    })
    .catch((error) => console.error(error));
}

dibujarTablero();
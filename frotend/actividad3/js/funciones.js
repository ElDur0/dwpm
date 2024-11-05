const form= document.querySelector('form')
document.getElementById("login").addEventListener('submit', async (event) =>{
    event.preventDefault();
    const formData =  new FormData(form)
    const myHeaders = new Headers()
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'login',
            metodo  : 'POST',
            usuario : formData.get('username'),
            clave:formData.get('password')
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/frotend/actividad3/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        console.log(result)
        const datos     = JSON.parse(result)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            alert("contraseña y usuario válido");
        }
    })
    .catch((error) => console.error(error));
})
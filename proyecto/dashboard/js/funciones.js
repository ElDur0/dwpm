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
            password: formData.get('password')
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/dwpm/proyecto/dashboard/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos     = JSON.parse(result)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            const respuesta     = JSON.parse(datos.data)
            if(respuesta.status)
                location.href="../html/home.html";
            else
                alert("Error de usuario o contraseña")
        }
    })
    .catch((error) => console.error(error));
})
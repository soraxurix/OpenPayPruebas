const inputNombre = document.getElementById("input-nombre");
const inputEmail = document.getElementById("input-email");
const buttonAgregarCliente = document.getElementById("button-agregar_cliente");

buttonAgregarCliente.addEventListener("click", async function (e) {
	const dataSend = {
		"name": inputNombre.value,
		"email": inputEmail.value
	}
	const res = await fetch("crear-cliente.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	console.log(data);
});
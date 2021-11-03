// Inicializamos variables
const buttonSeleccionarCliente = document.getElementById("button-agregarCliente");
const buttonClienteSeleccionado =document.getElementById("button-cliente-seleccionado");
const formularioTarjeta = document.getElementById("processCard");
const selectUsuario = document.getElementById("Usuario");
const tabla_clientes = document.getElementById("tabla_clientes");
var id_cliente ="";
var nombre_cliente ="";
var dataCliente;
const titulo_cliente = document.getElementById("cliente_titulo");

// Llenamos la variable dataCliente con la función para obtener la información
(async()=>{
	 dataCliente= await ObtenerInformacionCliente();
	await llenar_select(dataCliente);
})();

// Iniciamos valores de la tienda
OpenPay.setId('mwfanfxqufp7o9fvm3yk');
OpenPay.setApiKey('pk_739ea2a87279477eaecbfd3ab8638812');
OpenPay.setSandboxMode(true);
// Añadimos un id de sesión para el dispositovo (Se necesita para anexar una tarjeta el cliente)
var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");


// Evento para registrar la tarjeta con el formulario
document.getElementById("makeRequestCard").addEventListener("click", function (e) {
	OpenPay.token.extractFormAndCreate(
      formularioTarjeta,
      SuccessCallback,
      ErrorCallback);	
})
// Función en caso que se haga la opreación correctamente
function SuccessCallback(response) {
	var token_id = response.data.id;
    // alert('Operacion exitosa. El token es: '+ token_id);    
    agregarTarjetaCliente(deviceSessionId, token_id, id_cliente);
}
// Función en caso que haya un error
function ErrorCallback(response) {
	// alert('Fallo en la transacción');
	var desc = response.data.description != undefined ?
	response.data.description : response.message;
	alert("ERROR [" + response.status + "] " + desc);
}

// Agregar cliente a una tarjeta
async function agregarTarjetaCliente (diviceID , tokenID, clienteID) {
	const dataSend = {
		"device_session_id": diviceID,
		"token_id": tokenID,
		"id_cliente": clienteID
	}
	const res = await fetch("anexar-tarjeta.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	console.log(data);
}

selectUsuario.addEventListener("change", async function (e) {
	id_cliente = selectUsuario.value;
	// Mostramos la tabla
	tabla_clientes.classList.remove("d-none");
	llenar_tabla_clientes();
});

// función para mostrar la información del cliente en la tabla
function llenar_tabla_clientes (e) {
	const informacion_cliente = document.getElementById("informacion_cliente");
	var datos_a_enviar ="";
		
	for (var i = 0; i < dataCliente.length; i++) {
		if(dataCliente[i].id_cliente === selectUsuario.value){
			datos_a_enviar = '<td>'+dataCliente[i].id_cliente+'</th>';
			datos_a_enviar += '<td>'+dataCliente[i].nombre_cliente+'</th>';
			datos_a_enviar += '<td>'+dataCliente[i].email+'</th>';

			nombre_cliente = dataCliente[i].nombre_cliente;
			break;
		}
	}
	informacion_cliente.innerHTML = datos_a_enviar;
}

// Función para obtener la información de los clientes
async function ObtenerInformacionCliente (e) {
	const dataSend = {
		"tabla": "clientes"
	}
	const res = await fetch("consultas/consultar-tabla.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	return data;
}
// Función para llenar el select
async function llenar_select (data) {
	for (var i = 0; i < data.length; i++) {
		var opt = document.createElement('option');
		opt.innerHTML = data[i].nombre_cliente;
		opt.value = data[i].id_cliente;
		selectUsuario.appendChild(opt);	
	}
}
// Evento para abrir el modal
buttonSeleccionarCliente.addEventListener("click", async function (e) {
	$('#modalSeleccionarCliente').modal('show');
})

buttonClienteSeleccionado.addEventListener("click", async function (e) {
	$('#modalSeleccionarCliente').modal('hide');
	formularioTarjeta.classList.remove("d-none");

	titulo_cliente.innerHTML = "<strong>Cliente: </strong>"+nombre_cliente;
})
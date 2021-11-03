// Inicializamos variables
const buttonSeleccionarCliente = document.getElementById("button-agregarCliente");
const buttonClienteSeleccionado =document.getElementById("button-cliente-seleccionado");

const buttonSeleccionarPlan = document.getElementById("button-agregarPlan");
const buttonPlanSeleccionado =document.getElementById("button-plan-seleccionado");

const buttonSeleccionarTarjeta = document.getElementById("button-agregarTarjeta");
const buttonTarjetaSeleccionado =document.getElementById("button-tarjeta-seleccionado");

const buttonSuscribirCliente = document.getElementById("button-suscribirCliente");

var id_cliente ="";
var nombre_cliente ="";
var id_plan ="";
var nombre_plan ="";
var id_tarjeta ="";
var num_tarjeta ="";

var dataCliente;
var dataPlan;
var dataTarjeta;

var titulo_cliente = document.getElementById("cliente_titulo");
var titulo_plan = document.getElementById("plan_titulo");
var titulo_tarjeta = document.getElementById("tarjeta_titulo");

// Llenamos la variable dataCliente con la función para obtener la información
(async()=>{
	dataCliente= await ObtenerInformacionCliente("clientes");
	await llenar_select(dataCliente, "clientes", document.getElementById("select-cliente"));

	dataPlan= await ObtenerInformacionCliente("planes");
	await llenar_select(dataPlan, "planes", document.getElementById("select-plan"));
})();

// Función para obtener la información de los clientes
async function ObtenerInformacionCliente (tabla) {
	dataSend = {
		"tabla": tabla
	}
	if (tabla === "tarjetas") {
		dataSend = {
			"tabla": tabla,
			"id_cliente": id_cliente
		}
	}	
	const res = await fetch("consultas/consultar-tabla.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	return data;
}

// Funcion para llenar el select
function llenar_select (data, tabla, select) {
	for (var i = 0; i < data.length; i++) {
		if(tabla === "clientes"){
			var opt = document.createElement('option');
			opt.innerHTML = data[i].nombre_cliente;
			opt.value = data[i].id_cliente;
			select.appendChild(opt);	

		}else if (tabla === "planes") {
			var opt = document.createElement('option');
			opt.innerHTML = data[i].nombre_plan;
			opt.value = data[i].id_plan;
			select.appendChild(opt);

		}else if (tabla === "tarjetas") {
			var opt = document.createElement('option');
			opt.innerHTML = data[i].numero_tarjeta;
			opt.value = data[i].id_tarjeta;
			select.appendChild(opt);
		}
	}
}

// función para mostrar la información del cliente en la tabla
function llenar_tabla (informacion, data, select, tabla) {
	var datos_a_enviar ="";
	
	if(tabla === "clientes"){
		for (var i = 0; i < data.length; i++) {
			if(data[i].id_cliente === select.value){
				datos_a_enviar = '<td>'+data[i].id_cliente+'</th>';
				datos_a_enviar += '<td>'+data[i].nombre_cliente+'</th>';
				datos_a_enviar += '<td>'+data[i].email+'</th>';

				nombre_cliente = data[i].nombre_cliente;
				break;	
			} 			
		}
		
	}else if (tabla === "planes") {
		for (var i = 0; i < data.length; i++) {
			if(data[i].id_plan === select.value){
				datos_a_enviar = '<td>'+data[i].id_plan+'</th>';
				datos_a_enviar += '<td>'+data[i].nombre_plan+'</th>';
				datos_a_enviar += '<td>'+data[i].amount+'</th>';

				nombre_plan = data[i].nombre_plan;
				break;	
			} 			
		}
	}else if (tabla === "tarjetas") {
		for (var i = 0; i < data.length; i++) {
			if(data[i].id_tarjeta === select.value){
				datos_a_enviar = '<td>'+data[i].id_tarjeta+'</th>';
				datos_a_enviar += '<td>'+data[i].numero_tarjeta+'</th>';
				datos_a_enviar += '<td>'+data[i].nombre_propietario+'</th>';

				num_tarjeta = data[i].numero_tarjeta;
				break;	
			} 			
		}
	}
	informacion.innerHTML = datos_a_enviar;
}

document.getElementById("select-cliente").addEventListener("change", async function (e) {
	id_cliente = document.getElementById("select-cliente").value;
	// Mostramos la tabla
	document.getElementById("tabla-cliente").classList.remove("d-none");

	llenar_tabla(document.getElementById("informacion-cliente"), dataCliente, document.getElementById("select-cliente"), "clientes");
});

document.getElementById("select-plan").addEventListener("change", async function (e) {
	id_plan = document.getElementById("select-plan").value;
	// Mostramos la tabla
	document.getElementById("tabla-plan").classList.remove("d-none");

	llenar_tabla(document.getElementById("informacion-plan"), dataPlan, document.getElementById("select-plan"), "planes");
});

document.getElementById("select-tarjeta").addEventListener("change", async function (e) {
	id_tarjeta = document.getElementById("select-tarjeta").value;
	// Mostramos la tabla
	document.getElementById("tabla-tarjeta").classList.remove("d-none");
	
	llenar_tabla(document.getElementById("informacion-tarjeta"), dataTarjeta, document.getElementById("select-tarjeta"), "tarjetas");
});



// Evento para abrir el modal Cliente
buttonSeleccionarCliente.addEventListener("click", async function (e) {
	$('#modalSeleccionarCliente').modal('show');
});

buttonClienteSeleccionado.addEventListener("click", async function (e) {
	$('#modalSeleccionarCliente').modal('hide');

	dataTarjeta= await ObtenerInformacionCliente("tarjetas");
	await llenar_select(dataTarjeta, "tarjetas", document.getElementById("select-tarjeta"));
	
	titulo_cliente.innerHTML = "<strong>Cliente: </strong>"+nombre_cliente;
});

// Evento para abrir el modal Plan
buttonSeleccionarPlan.addEventListener("click", async function (e) {
	$('#modalSeleccionarPlan').modal('show');
});

buttonPlanSeleccionado.addEventListener("click", async function (e) {
	$('#modalSeleccionarPlan').modal('hide');

	titulo_plan.innerHTML = "<strong>Plan: </strong>"+nombre_plan;
});

// Evento para abrir el modal Tarjeta
buttonSeleccionarTarjeta.addEventListener("click", async function (e) {
	$('#modalSeleccionarTarjeta').modal('show');
});

buttonTarjetaSeleccionado.addEventListener("click", async function (e) {
	$('#modalSeleccionarTarjeta').modal('hide');

	titulo_tarjeta.innerHTML = "<strong>Tarjeta: </strong>"+num_tarjeta;
});


buttonSuscribirCliente.addEventListener("click", async function (e) {
	console.log("id cliente: "+ id_cliente);
	console.log("id tarjeta: "+ id_tarjeta);
	console.log("id plan: "+ id_plan);

	dataSend = {
		"plan_id": id_plan,
		"card_id": id_tarjeta,
		"cliente_id": id_cliente
	}
	const res = await fetch("suscribir-cliente.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	console.log(data);
});
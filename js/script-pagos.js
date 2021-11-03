// obtenerPago("afh0uw8ifly95uuqkyay");
// obtenerPago("as0x4vqhswuqm0ctpv5y");

procesoPagos();

obtenerTodosLosPagos();

async function procesoPagos (e) {
	var startTime = performance.now();
	dataSend = {
		"tabla": "clientes"
	}
	const res = await fetch("consultas/consultar-tabla.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const clientes = await res.json();
	

	var arr1;
	var arr2;

	var pagos;
	for (var i = 0; i < clientes.length; i++) {
		const pago = await obtenerPago(clientes[i].id_cliente);

		if (i===0) {
			arr1 = pago;
			// console.log(arr1);
		} else {
			arr2 = pago;
			arr1 = [...new Set([...arr1, ...arr2])];
		}
		/*if (pago.length != 0) {
			pagos = [...new Set([...pagos, ...pago])];
			console.log(union);
		}*/
	}
	
	console.log(arr1);

	var endTime = performance.now()
	console.log(`La función tardó ${endTime - startTime} milliseconds`);
}

async function obtenerPago (idCliente) {
	const dataSend = {
		"cliente_id": idCliente
	}
	const res = await fetch("obtener-pagos.php", {
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();
	// console.log();
	return data;
}

async function obtenerTodosLosPagos (e) {
	var startTime = performance.now();

	const res = await fetch("obtener-pagos-completos.php");
	const data = await res.json();
	console.log(data);

	var endTime = performance.now()
	console.log(`La función tardó ${endTime - startTime} milliseconds`);
}
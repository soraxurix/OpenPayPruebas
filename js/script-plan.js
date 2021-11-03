// Inicializamos variables
const buttonAgregarPlan = document.getElementById("button-agregar-pan");
const name = document.getElementById("input-nombre");
const amount = document.getElementById("input-precio");
const retry_times = document.getElementById("input-intentos");
const status_after_retry = document.getElementById("input-terminar");
const repeat_unit = document.getElementById("input-repeticion-unidad");
const repeat_every = document.getElementById("input-repeticion-cada");
const trial_days = document.getElementById("input-dias_pruebas");
const currency = document.getElementById("input-moneda");

buttonAgregarPlan.addEventListener("click", async function (e) {
	const dataSend = {
		"name": name.value,
		"amount": amount.value,
		"retry_times": retry_times.value,
		"status_after_retry": status_after_retry.value,
		"repeat_unit": repeat_unit.value,
		"repeat_every": repeat_every.value,
		"trial_days": trial_days.value,
		"currency": currency.value
	}
	const res = await fetch("crear-plan.php",{
		method: "POST",
		body: JSON.stringify(dataSend)
	});
	const data = await res.json();

	console.log(data);
});
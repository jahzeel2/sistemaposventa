console.log("Starting quotes")
import { searchProduct } from "../export_funcion/export_function_search_quotes.js";
import { SeachCustomer, searchCustomer, loadHtml } from "../export_funcion/export_function_customers.js";

//const btnAddCustomer = document.querySelectorAll(".btn-customer-add");

let showtablecustomers = document.querySelector("#show-customers");

const mysearchp = document.querySelector("#buscarQuoteProducto");
const ul_add_lip = document.querySelector("#autocomplequote");
const printTbody = document.querySelector("#tbodyProd");
const idlip = "prodquotep";
const myurlp ="/nombrearticuloquote";
/**************SEARCH PRODUCT**************/
const searchProductQuote = new searchProduct(myurlp,mysearchp,ul_add_lip,idlip,token,printTbody);
searchProductQuote.inputSearchProduct();
const id_ulp = "#autocomplequote";
searchProductQuote.InputKeydownEntradas(id_ulp);
/**************SEARCH CUSTOMERS**************/
const inputSearchCustomer = document.querySelector("#customers-searchs");
/*const searchcustomer = new SeachCustomer(inputSearchCustomer);
searchcustomer.InputSearchCustomer();*/
inputSearchCustomer.addEventListener("input", (e) =>{
	e.preventDefault();
    let minimo_letras = 0; // minimo letras visibles en el autocompletar
    let valor = inputSearchCustomer.value;
    let datos = new FormData();
    datos.append("valor", valor);
	console.log(valor);
	let myurlcustomer ="/findcustomer";
	searchCustomer(myurlcustomer,datos,token).then((resp) =>{
		console.log(resp);
		let tbody = loadHtml(resp,valor).then((html) => {
			console.log(tbody);
			showtablecustomers.innerHTML = "";
			showtablecustomers.innerHTML = String(html);
			const btnAdd = document.querySelectorAll(".btn-customer-add");
			btnAdd.forEach(btn => {
				btn.addEventListener("click", (e) => {
					let nombre = btn.getAttribute('name');
					let cadena = nombre.split('*-*');
					console.log(cadena);
					let id = btn.getAttribute('id');
					const nomCustomer = document.querySelector("#nomcliente").value = cadena[0];
					const idCustomer = document.querySelector("#clienteId");
					const emailCustomer = document.querySelector("#email").value = cadena[1];
					idCustomer.value = id;
					document.querySelector('.btn-close-customer').click();
				});
			});
		});
	})
});




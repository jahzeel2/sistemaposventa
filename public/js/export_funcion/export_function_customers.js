export class SeachCustomer{
	constructor(mycustomer){

		this.myurlcustomer ="/findcustomer";
		this.mycustomer = mycustomer;
		this.showtablecustomers = document.querySelector("#show-customers");
	}

	InputSearchCustomer(){
		this.mycustomer.addEventListener("input", (e) =>{
			e.preventDefault();
            		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            		let minimo_letras = 0; // minimo letras visibles en el autocompletar
            		let valor = this.mycustomer.value;
            		if (valor.length > minimo_letras) {
                		let datos = new FormData();
                		datos.append("valor", valor);
                		////console.log(valor);
                		fetch(this.myurlcustomer, {
                    		headers: {
                    		'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
                    		},
                    		method:'post',
                    		body:datos
                		})
                		.then(data => data.json())
                		.then(data => {
                    		console.log('Success:', data);
                    		this.ShowCustomer(data,valor);
                		})
                		.catch(function(error){
                    		console.error('Error:', error)
                		});
            		}else{
                		//this.ul_add_li.style.display = "none";
				this.showtablecustomers.innerHTML = "";
				console.log("error")
            		}
		});
	}

	ShowCustomer(data,valor){
		let customers = data.result;
		//let showtablecustomers = document.querySelector("#show-customers");
		this.showtablecustomers.innerHTML = "";
		for (const item of customers) {
					console.log(item);
            		this.showtablecustomers.innerHTML += `
                		<tr>
                    		<td class="text-center"><button name="${item.nombre}*-*${item.email}" id="${item.idcliente}" class="btn btn3 btn-sm btn-customer-add"><i class="fas fa-check-square"></i></button></td>
                    		<td><strong style="color:#16DF7E;font-size:17px;">${item.nombre.substr(0,valor.length)}</strong>${item.nombre.substr(valor.length)}</td>
                    		<td>${item.direccion}</td>
                    		<td>${item.email}</td>
                		</tr>
            
            		`;
			//console.log(item.nombre);
		}

		const btnAdd = document.querySelectorAll(".btn-customer-add");
		btnAdd.forEach(btn => {
			btn.addEventListener("click", (e) => {
				let nombre = btn.getAttribute('name');
				let cadena = nombre.split('*-*');
				console.log(cadena);
				let id = btn.getAttribute('id');
				
				const nomCustomer = document.querySelector("#nomcliente").value = cadena[0];
				const idCustomer = document.querySelector("#ventidcliente");
				idCustomer.value = id;
				const clasecustomer = idCustomer.getAttribute('class');
				//console.log(clasecustomer)
				if (clasecustomer == null) {
					idCustomer.classList.add(cadena[1]);
				}else{
					idCustomer.classList.remove(clasecustomer);
					idCustomer.classList.add(cadena[1]);
				}

				document.querySelector('.btn-close-customer').click();
			})
		});
	}


}

export const searchCustomer = async (url,form,token) => {
    try {
        let response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': token
        },
        method: 'POST',
        body: form
        });
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}

export const loadHtml = async (data,valor) => {
	let customers = data.result;
	let show = "";
	for (const item of customers) {
		console.log(item);
        show += `
            <tr>
                <td class="text-center"><button name="${item.nombre}*-*${item.email}" id="${item.idcliente}" class="btn btn3 btn-sm btn-customer-add"><i class="fas fa-check-square"></i></button></td>
                <td><strong style="color:#16DF7E;font-size:17px;">${item.nombre.substr(0,valor.length)}</strong>${item.nombre.substr(valor.length)}</td>
                <td>${item.direccion}</td>
                <td>${item.email}</td>
            </tr>
            
        `;
	}
	
	return show;
}

export const clickButton = async () => {//not function for the moment
	const btnAdd = document.querySelectorAll(".btn-customer-add");
	let cadena = "";
	btnAdd.forEach(btn => {
		btn.addEventListener("click", (e) => {
			let nombre = btn.getAttribute('name');
			cadena = nombre.split('*-*');
			//console.log(cadena);
			//let id = btn.getAttribute('id');
			return cadena;
		});
	});
	//console.log(cadena);
	//return cadena;
 };
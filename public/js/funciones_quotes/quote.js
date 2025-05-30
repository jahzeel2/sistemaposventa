let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
const totalQuote = document.querySelector("#total_quote");
const btnSaveQuotation = document.querySelector("#btn-save-quotation");
const formQuote = document.querySelector("#form-quote");
const printProdDetail = document.querySelector("#tbodyProd");
const contentPdf = document.querySelector("#content-pdf");
const cancelQuote = document.querySelector("#cancelQuote");

const fnInputEnter = (event,id) => {
    if (event.keyCode === 13) {
        console.log(event)
        console.log(event.target.value);
        console.log(id)
        const cantidadProd = document.querySelector(`#cantidad${id}`)
        console.log(cantidadProd)
        const precioProd = document.querySelector(`#precio${id}`)
        let formData = new FormData();
        formData.append("id",id );
        formData.append("cantidad", Number(cantidadProd.value) );
        formData.append("precio", Number(precioProd.value) );
        sendAction("/quote/updateProdTemp",formData,token).then(result => {
            console.log(result);
            let products = result.prod;
            showRowProd(products)
        });

    }
}

showRowProd = (products) => {
    let total = 0;
    printProdDetail.innerHTML = "";
    products.forEach((element, index) => {
        console.log(element);
        total = total + Number(element.total);
        printProdDetail.innerHTML += `
            <tr>
            <td>${index + 1}</td>
            <td>${element.nombre}</td>
            <td><input type="text" value="${element.cantidad}" id="cantidad${element.id}" onkeydown="fnInputEnter(event,${element.id},'cantidad');" class="input-table form-control form-control-sm" placeholder="0.00"></td>
            <td><input type="text" value="${element.precio}" id="precio${element.id}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
            <td><input type="text" value="${element.total}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
            <td class="text-center"><button type="button" onclick="downProd(${element.id});" class="btn btn-danger btn-sm delete_btn_prod_venta"><i class="fas fa-trash-alt"></i></button></td>
            </tr>
        `;
    });

    totalQuote.value = total;
}

downProd = (id) => {
    console.log(id);
    let formData = new FormData();
    formData.append("id",id);
    sendAction("/quote/downProdTemp",formData,token).then(result => {
        console.log(result);
        let products = result.prod;
        showRowProd(products)
    });
}

btnSaveQuotation.addEventListener("click", (e) => {
    e.preventDefault();
    let formData = new FormData(formQuote);
    formData.append("id","save");
    sendAction("/quote/store",formData,token).then(result => {
        console.log(result);
        //let products = result.prod;
        //showRowProd(products)
        if(result.status == 1){
            printProdDetail.innerHTML = "";
            contentPdf.innerHTML = "";
            contentPdf.innerHTML = `
                <a target="_blank" href="/quote/print/${result.cotizacionId}" type="button" class="btn btn6 btn-sm mr-3">
                <i class="fas fa-file-pdf mr-2"></i>
                Generar PDF
                </a>
            `;
            let myModal = new bootstrap.Modal(document.getElementById('quoteExitModal'));
            myModal.show();
            formQuote.reset();
            totalQuote.value = "";
        }
        if(result.status == 0){
            //alert(result.message);
            sweetError(result.message);
        }
    });
})

cancelQuote.addEventListener(("click"), (e) => {
    e.preventDefault();
    let formData = new FormData();
    formData.append("action","cancel");
    sendAction("/quote/cancel",formData,token).then(result => {
        console.log(result.status);
        if(result.status == 1 ){
            printProdDetail.innerHTML = "";
            formQuote.reset();
            totalQuote.value = "";
            sweetSuccess(result.message);
        }
    })
});

const sendAction = async (url,form,token) => {
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

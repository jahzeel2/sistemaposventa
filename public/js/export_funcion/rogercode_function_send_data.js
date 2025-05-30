
export const sendDataForm = async (url,form,token) => {
    try {
        const dataform = new FormData(form);
        let response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': token
        },
        method: 'POST',
        body: dataform
        });
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}

export const msgError = (msg) => {
    Swal.fire(
        'Error!',
        msg,
        'error'
    )
};

export const spinnerStart = (btn) => {
    btn.disabled = true;
    btn.innerHTML = "";
    btn.innerHTML += `
        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
        Consultando...
    `;
}

export const spinnerEnd = (btn) => {
    btn.disabled = false;
    btn.innerHTML = "";
    btn.innerHTML += `
        Consultar
    `;
}

export const getdata = async (ruta,id) => {
    try {
        let response = await fetch(ruta+id); 
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error)    
    }
}
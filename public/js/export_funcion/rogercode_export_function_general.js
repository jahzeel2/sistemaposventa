export class operations {
    updateData = async (url,form,token) => {
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


    msgError = (msg) => {
        Swal.fire(
            'Error!',
            msg,
            'error'
        )
    };

    msgSuccess = (msg) => {
        Swal.fire(
            'Exito!',
            msg,
            'success'
        )
    };


    spinnerStart = (btn,text) => {
        btn.disabled = true;
        btn.innerHTML = "";
        btn.innerHTML += `
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            ${text}
        `;
    }

    
    spinnerEnd = (btn,text) => {
        btn.disabled = false;
        btn.innerHTML = "";
        btn.innerHTML += `
            ${text}
        `;
    }

}


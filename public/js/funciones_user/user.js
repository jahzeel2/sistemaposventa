//console.log('y jajja');
class Users{
    constructor(url){
        this.url = url;
    }
}

class UsersFuncion extends Users{
    constructor(url,id){
        super(url);
        this.id =id;
      
    }

    deleteusers = () =>{
        //console.log(this.url);
        try {
            Swal.fire({
                title: 'Estas seguro de dar de baja el usuario?',
                text: "El usuario no podra ingresar al sistema!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.value) {
                    (async () => {
                        let response = await fetch(this.url+this.id);
                        let json = await response.json();
                        //console.log(json); 
                        switch (json.estado) {
                            case 1:
                                Swal.fire(
                                'Se dio de baja!',
                                json.mensaje,
                                'success'
                                )
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            break;
                            case 0:
                                Swal.fire(
                                'Error!',
                                json.mensaje,
                                'error'
                                )
                            break;
                            default:
                                break;
                        }

                    })();
                }

            });
        } catch (error) {
            
        }

    }

    changepassworduser = (formdata) =>{
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        fetch(this.url,{
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
            },
            method:"post",
            body:formdata
        })
        .then(data => data.json())
        .then(data=> {
            let divmessage = document.querySelector("#errorpass");
            let divclass = data.class_name;
            let messagee = data.mensaje;
            if (data.estado == 1) {
                document.querySelector("#password").value="";
                document.querySelector("#closechange").click();
                this.successmessage(messagee);
            }else if (data.estado == "errorvalidacion") {
                this.messagegeneral(divclass,messagee,divmessage);
                console.log(messagee);
            }          
            //console.log("success:", data);
        })
        .catch(error => console.error('Error:', error));

    }

    addnewuser = (formuser) =>{
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        fetch(this.url,{
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
            },
            method:"post",
            body:formuser
        })
        .then(data => data.json())
        .then(data=> {
            ////console.log("success:", data);
            const divmessage = document.querySelector("#erroruser");
            let divclass = data.class_name;
            let messagee = data.mensaje;
            if(data.estado == 1) {
               Swal.fire({
                    type: 'success',
                    title: "Exito",
                    text: messagee
                }).then(function(){
                    location.reload();
                })
            }else if (data.estado == "errorvalidacion") {
                this.messagegeneral(divclass,messagee,divmessage);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    messagegeneral(divclass,messagee,divmessage){
        //console.log(message+divclass);
        divmessage.innerHTML = "";
            messagee.forEach(element =>{
                divmessage.innerHTML += " <strong> <li>" + element+ "</li></strong>";
            })
        divmessage.style.background="#c82333";
        divmessage.style.color="#ffffff";
        setTimeout(function(){
            divmessage.innerHTML = "";
        },5000);
    }

    successmessage(messagee){
        Swal.fire(
        'Exito',
        messagee,
        'success'
        )
    }

    startLoadIcon(btnpassword){
        btnpassword.innerHTML = "";
        btnpassword.disabled = true;
        btnpassword.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos ...`;
    }

    endLoadIcon(btnpassword,message_end){
        btnpassword.disabled = false;
        btnpassword.innerHTML = message_end;
        
    }

}
/**FUNCTION THAT ALLOWS DELETE USER*/
const btndeleteuser = document.querySelectorAll(".btnuserdelete");
btndeleteuser.forEach(btn => {
    btn.addEventListener("click", (e) =>{
        e.preventDefault();
        const id = btn.getAttribute('name');
        const url = "/delete-users/"; 
        const deluser = new UsersFuncion(url,id);
        deluser.deleteusers();


    });
});
/**FUNCTION THAT SHOW THE MODAL CHANGE PASSWORD*/
var changepassword = (id,useremail) => {
    $("#newpassword").val("");
    $("#email_user_now").val(useremail);
    $("#id_user_now").val(id);
    $("#mostrarmodal").modal("show");
}

/**FUNCTION THAT ALLOWS TO CHANGE TE USER PASSWORD*/
const btnpassword = document.querySelector("#btnchangepassword");
btnpassword.addEventListener('click', (e) =>{
    e.preventDefault();
    try {
        const loading = new UsersFuncion();
        loading.startLoadIcon(btnpassword);
        setTimeout(() => {
            const formchangepass = document.querySelector("#change_password");
            const formdata = new FormData(formchangepass);
            
            const url = "/updatepasssword";
            const changepass = new UsersFuncion(url);
            changepass.changepassworduser(formdata);

            const endloading = new UsersFuncion();
            endloading.endLoadIcon(btnpassword,"Actualizar");
        }, 2000);
    } catch (error) {
        alert("error: "+ error);
    }
});

/**FUNCTION THAT SAVE THE USER*/
const adduser = document.querySelector("#adduser");
adduser.addEventListener("click", (e) =>{
    e.preventDefault();
    try {
        const newuser = document.querySelector("#addnewuser");
        const formuser = new FormData(newuser);
        
        const url = "/newuser";
        const userf = new UsersFuncion(url);
        userf.addnewuser(formuser);
    } catch (error) {
        alert("error: "+ error);
    }
})
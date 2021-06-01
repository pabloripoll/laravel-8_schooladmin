/*

*/

// SIGN IN AJAX
logout = () => {

    //sign_in_waiting_process();

    let data = Object.create(null)
    data.token		= csrf_token
    data.api		= routeLogout
    data.json = {
        user : user,
        password : password
    }
    jsonPost(data).then(json => {

        if (json.status == 'error') {
            
            signInStatus.innerHTML = json.message

        } else {

            signInStatus.classList.remove('text-danger')
            signInStatus.classList.add('text-success')
            signInStatus.innerHTML = json.message
            console.log(json)

        }
    }).catch( console.error() )
}


/* document.forms['logout-form'].addEventListener('submit', (e) => {
	e.preventDefault();
}) */
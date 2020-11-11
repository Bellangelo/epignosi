/**
 * Sends request to login user in.
 * 
 * @param {*} form 
 * @param {*} event 
 */
function login ( form, event ) {

    event.preventDefault();
    form.className = 'loading';
    formData = new FormData( form );
    api( 'login.php', formData )
        .then( res => {

            if ( res.type === 'success' ) {
                window.location = '/epignosi/portal.php';
            }
            else {
                alert(res.message);
            }

            form.className = '';

        });

}
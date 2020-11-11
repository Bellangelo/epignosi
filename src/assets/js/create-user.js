/**
 * Sends a request to create a user.
 * 
 * @param {*} form 
 * @param {*} event 
 */
function createUser ( form, event ) {

    event.preventDefault();
    form.className = 'loading';
    formData = new FormData( form );
    api( 'create-user.php', formData )
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
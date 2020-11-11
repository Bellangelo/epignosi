/**
 * Sends a request to edit a user.
 * 
 * @param {*} form 
 * @param {*} event 
 */
function editUser ( form, event ) {

    event.preventDefault();
    form.className = 'loading';
    formData = new FormData( form );
    api( 'edit-user.php', formData )
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
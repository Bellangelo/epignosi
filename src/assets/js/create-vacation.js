/**
 * Sends a request to create a user.
 * 
 * @param {*} form 
 * @param {*} event 
 */
function createVacation ( form, event ) {

    event.preventDefault();
    form.className = 'loading';
    formData = new FormData( form );
    api( 'create-vacation.php', formData )
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
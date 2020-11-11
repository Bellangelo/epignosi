var API_PATH = '/epignosi/actions/';
var GENERAL_ERROR = 'There was an error. Please try again.';

function api ( url, body ) {

    return new Promise( function ( resolve, reject ) {
        fetch ( API_PATH + url, {
            method: 'POST',
            body: body,
        })
        .then( res => res.json() )
        .then( res => {
            resolve( res );
        })
        .catch( () => {
            resolve({
                type: 'error',
                message: GENERAL_ERROR,
            });
        });
    });

}
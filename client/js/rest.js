/**
 * @brief REST API interface class.
 * 
 * Provides an interface to a REST API.
 */
class RestApi {
    /**
     * Construct from API URL.
     * 
     * @param {String} server_url URL of API
     */
    constructor(api_url){
        this._api_url = api_url;
    }

    /**
     * Get URL to access a certain resource from its URI.
     * 
     * @param {String} uri URI of resource
     */
    _url_from_uri(uri){
        return `${this._api_url}${uri}`;
    }

    /**
     * Get resource.
     * 
     * @param {String} uri URI
     */
    get(uri){
        return fetch(
            this._url_from_uri(uri),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
            }
        );
    }
    
    /**
     * Perform operation.
     * 
     * @param {String} uri URI
     * @param {Object} params Operation parameters
     */
    post(uri, params){
        return fetch(
            this._url_from_uri(uri),
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: params
            }
        );
    }
    
    /**
     * Create resource.
     * 
     * @param {String} uri URI
     * @param {Object} params New resource parameters
     */
    put(uri, params){
        let data;
        if(!(params instanceof File)){
            console.log("Sending JSON data");
            data = JSON.stringify(params);
        } else {
            console.log("Sending file");
            data = params;
        }
        return fetch(
            this._url_from_uri(uri),
            {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json'
                },
                body: data
            }
        );
    }
    
    /**
     * Delete resource.
     * 
     * @param {String} uri URI
     */
    delete(uri){
        return fetch(
            this._url_from_uri(uri),
            {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json'
                }
            }
        );
    }
};

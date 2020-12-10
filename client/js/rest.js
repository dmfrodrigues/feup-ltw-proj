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
        let url = this._url_from_uri(uri);
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.responseType = 'json';
            xhr.open('GET', url);
            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };
            
            xhr.send();
        });
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

    /*
    _makeRequest(method, url, data) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };
            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };
            
            xhr.send(data);
        });
    }
    */
    
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

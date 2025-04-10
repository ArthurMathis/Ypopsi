/**
 * @module Response
 * @description Response module
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
export default class Response {
    /**
     * @constructor
     * @description Default constructor class
     * @param {Integer} code The response's code
     * @param {String} message The response's message
     */
    constructor(code, message) {
        this._code = code;
        this._message = message;
    }

    /**
     * @function code
     * @description Gets the response's code.
     * @returns {number} The response's code.
     */
    get code() { return this._code; }
    /**
     * @function message
     * @description Gets the response's message.
     * @returns {string} The response's message.
     */
    get message() { return this._message; }
}

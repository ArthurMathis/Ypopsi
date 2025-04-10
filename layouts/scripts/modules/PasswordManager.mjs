import Response from './Response.mjs';
import InputPassword from './InputPassword.mjs';

/**
 * @module PasswordManager
 * @description PasswordManager module
 * @requires Response
 * @requires InputPassword
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
export default class PasswordManager {
    /**
     * @constructor
     * @description Default constructor class
     * @param {InputPassword} oldPassword The old password
     * @param {InputPassword} newPassword The new password
     * @param {InputPassword} confirmPassword The confirmation password
     */
    constructor(oldPassword, newPassword, confirmPassword) {
        this.oldPassword     = oldPassword;
        this.newPassword     = newPassword;
        this.confirmPassword = confirmPassword;

        this._STD_EXIT     = new Response(0, "");
        this._ERR_VLD_PSWD = new Response(1, "Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.");
        this._ERR_VLD_CONF = new Response(2, "Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.");
        this._ERR_DIF_PREC = new Response(3, "Le mot de passe doit être différent de l'ancien mot de passe.");
        this._ERR_DIF_NEW  = new Response(4, "Le mot de passe et la confirmation doivent être identiques.");
        this._ERR_EMP_PREC = new Response(5, "L'ancien mot de passe ne peut être vide.");
        this._ERR_EMP_PSWD = new Response(6, "Le nouveau mot de passe ne peut être vide.");
        this._ERR_EMP_NEW  = new Response(7, "La confirmation du mot de passe ne peut être vide.");
    }

    // * GET * //
    /**
     * @function STD_EXIT
     * @description Gets the standard exit response
     * @returns {Response} _STD_EXIT The standard exit response
     */
    get STD_EXIT() { return this._STD_EXIT; }
    /**
     * @function ERR_VLD_PSWD
     * @description Gets the invalid password response
     * @param {Response} _ERR_VLD_PSWD The invalid password response
     */
    get ERR_VLD_PSWD() { return this._ERR_VLD_PSWD; }
    /**
     * @function ERR_VLD_CONF
     * @description Gets the invalid confirmation response
     * @param {Response} _ERR_VLD_CONF The invalid confirmation response
     */
    get ERR_VLD_CONF() { return this._ERR_VLD_CONF; }
    /**
     * @function ERR_DIF_PREC
     * @description Gets the different previous password response
     * @param {Response} _ERR_DIF_PREC The different previous password response
     */
    get ERR_DIF_PREC() { return this._ERR_DIF_PREC; }
    /**
     * @function ERR_DIF_NEW
     * @description Gets the different new password response
     * @param {Response} _ERR_DIF_NEW The different new password response
     */
    get ERR_DIF_NEW() { return this._ERR_DIF_NEW; }
    /**
     * @function ERR_EMP_PREC
     * @description Gets the empty previous password response
     * @param {Response} _ERR_EMP_PREC The empty previous password response
     */
    get ERR_EMP_PREC() { return this._ERR_EMP_PREC; }
    /**
     * @function ERR_EMP_PSWD
     * @description Gets the empty new password response
     * @param {Response} _ERR_EMP_PSWD The empty new password response
     */
    get ERR_EMP_PSWD() { return this._ERR_EMP_PSWD; }
    /**
     * @function ERR_EMP_NEW
     * @description Gets the empty confirmation password response
     * @param {Response} _ERR_EMP_NEW The empty confirmation password response
     */
    get ERR_EMP_NEW() { return this._ERR_EMP_NEW; }

    // * TOOLS * //
    /**
     * @function isValidPassword
     * @description Function that checks if the password is valid
     * @param {string} str The password to check
     * @returns {boolean} True if the password is valid, false otherwise
     */
    isValidPassword(str) {
        return str.length >= 12 && /[a-z]/.test(str) && /[A-Z]/.test(str) && /\d/.test(str) && /[(){}[\]&#_@+!*?:;,.<>-]/.test(str);
    }

    /**
     * @function startListening
     * @description Function that starts listening to the form
     * @param {HTMLFormElement} form The HTML form
     * @return {void}
     */
    startListening(form) {
        this.oldPassword.htmlElement.addEventListener('input', (event) => {
            this.handleResponseForm(this.handleInputPrec(event.target));
        });

        this.newPassword.htmlElement.addEventListener('input', (event) => {
            this.handleResponseForm(this.handleInputPassword(event.target));
        });

        this.confirmPassword.htmlElement.addEventListener('input', (event) => {
            this.handleResponseForm(this.handleInputConfirmation(event.target));
        });

        form.addEventListener('submit', (event) => handlePasswordChange(event));
    }

    // * HANDLE * //
    /**
     * @function handleResponseForm
     * @description Function that handles the error form
     * @param {Response} response The response code
     * @returns {void}
     */
    handleResponseForm(response) {
        switch(response.code) {
            // success
            case this.STD_EXIT.code :
                this.oldPassword.htmlElement.setCustomValidity(this.STD_EXIT.message);
                this.newPassword.htmlElement.setCustomValidity(this.STD_EXIT.message);
                this.confirmPassword.htmlElement.setCustomValidity(this.STD_EXIT.message);
                this.oldPassword.htmlMessage.textContent = this.STD_EXIT.message;
                this.newPassword.htmlMessage.textContent = this.STD_EXIT.message;
                this.confirmPassword.htmlMessage.textContent = this.STD_EXIT.message;
                break;

            // invalid password
            case this.ERR_VLD_PSWD.code :
                this.newPassword.htmlElement.setCustomValidity(this.ERR_VLD_PSWD.message);
                this.newPassword.htmlMessage.textContent = this.ERR_VLD_PSWD.message;
                break;

            // invalid confirmation
            case this.ERR_VLD_CONF.code :
                this.confirmPassword.htmlElement.setCustomValidity(this.ERR_VLD_CONF.message);
                this.confirmPassword.htmlMessage.textContent = this.ERR_VLD_CONF.message;
                break;

            // same password
            case this.ERR_DIF_PREC.code:
                this.oldPassword.htmlElement.setCustomValidity(this.ERR_VLD_PSWD.message);
                this.newPassword.htmlElement.setCustomValidity(this.ERR_VLD_CONF.message);
                this.newPassword.htmlMessage.textContent = this.ERR_VLD_CONF.message;
                break;

            // different confirmation
            case this.ERR_DIF_NEW.code:
                this.newPassword.htmlElement.setCustomValidity(this.ERR_DIF_NEW.message);
                this.confirmPassword.htmlElement.setCustomValidity(this.ERR_DIF_NEW.message);
                this.confirmPassword.htmlMessage.textContent = this.ERR_DIF_NEW.message;
                break;

            // empty password
            case this.ERR_EMP_PREC.code:
                this.oldPassword.htmlElement.setCustomValidity(this.ERR_EMP_PREC.message);
                console.log(this.oldPassword);
                this.oldPassword.htmlMessage.textContent = this.ERR_EMP_PREC.message;
                break;

            // empty new password
            case this.ERR_EMP_PSWD.code:
                this.newPassword.htmlElement.setCustomValidity(this.ERR_EMP_PSWD.message);
                this.newPassword.htmlMessage.textContent = this.ERR_EMP_PSWD.message;
                break;

            // empty confirmation
            case this.ERR_EMP_NEW.code:
                this.confirmPassword.htmlElement.setCustomValidity(this.ERR_EMP_NEW.message);
                this.confirmPassword.htmlMessage.textContent = this.ERR_EMP_NEW.message;
                break;

            default:
                console.error("Unknown error code: " + response.code + " - " + response.message);
                break;
        }

        console.log("Response code: " + response.code + " - " + response.message);
    }

    /**
     * @function handleInputPrec
     * @description Function that handles the input of the password field
     * @param {HTMLInputElement} target The input element
     * @returns {int} The response code
     */
    handleInputPrec(target) {
        let response;
        switch(true) {
            case target.value.length === 0:
                response = this.ERR_EMP_PREC;
                break;

            default:
                response = this.STD_EXIT;
                break;
        }
        return response;
    }

    /**
     * @function handleInputPassword
     * @description Function that handles the input of the new password and confirmation fields
     * @param {HTMLInputElement} target The input element
     * @returns {int} The response code
     */
    handleInputPassword(target) {
        console.log("Nouvelle valeur : " + target.value);
        let response;
        switch(true) {
            case target.value.length === 0:
                response = this.ERR_EMP_PSWD;
                break;

            case !this.isValidPassword(target.value):
                response = this.ERR_VLD_PSWD;
                break;

            case target.value === password.value:
                response = this.ERR_DIF_PREC;
                break;

            case this.confirmPassword.htmlElement.value && target.value !== this.confirmPassword.htmlElement.value:
                response = this.ERR_DIF_NEW;
                break;

            default:
                response = this.STD_EXIT;
                break;
        }
        return response;
    }

    /**
     * @function handleInputConfirmation
     * @description Function that handles the input of the confirmation field
     * @param {HTMLInputElement} target The input element
     * @returns {int} The response code
     */
    handleInputConfirmation(target) {
        let response;
        switch(true) {
            case target.value.length === 0:
                response = this.ERR_EMP_NEW;
                break;

            case !this.isValidPassword(target.value):
                response = this.ERR_VLD_CONF;
                break;

            case target.value !== this.newPassword.htmlElement.value:
                response = this.ERR_DIF_NEW;
                break;

            default:
                response = this.STD_EXIT;
                break;
        }
        return response;
    }

    /**
     * @function handlePasswordChange
     * @description Function that analyses the request of password change
     * @param {SubmitEvent} event The event object
     * @returns {int} The response code
     */
    handlePasswordChange(event) {
        event.preventDefault();

        let index = 0;
        let response;
        const arr = [
            {
                input: this.oldPassword.htmlElement,
                method: handleInputPrec
            },
            {
                input: this.newPassword.htmlElement,
                method: handleInputPassword
            },
            {
                input: this.confirmPassword.htmlElement,
                method: handleInputConfirmation
            }
        ];

        do {
            response = arr[index].method(arr[index].input);
            this.handleResponseForm(response);
            index++;
        } while(index < arr.length && response.code === STD_EXIT.code);

        if(response.code === STD_EXIT.code) {
            event.submit();
        }
    }
}

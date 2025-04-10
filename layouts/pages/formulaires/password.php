<form 
    class="small-form"
    method="post" 
    action="<?= APP_PATH ?>/preferences/users/profile/password/update/<?= $user->getId() ?>"
>
    <h3>
        Modification de mot de passe
    </h3>

    <div class="input-container">
        <label for="password">
            Saisissez votre ancien mot de passe
        </label>

        <i class="error-message" id="password-message"></i>

        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Wu1ehTpcs+90"
        >
    </div>

    <section>
        <div class="input-container">
            <label for="new-password">
                Choissiez votre nouveau mot de passe
            </label>

            <i class="error-message" id="new-password-message"></i>

            <input 
                type="password" 
                id="new-password" 
                name="new-password" 
                placeholder="J@im3_l1_Guit@r3#!" 
            >
        </div>

        <div class="input-container">
            <label for="confirmation">
                Confirmez votre nouveau mot de passe
            </label>

            <i class="error-message" id="confirmation-message"></i>

            <input 
                type="password" 
                id="confirmation" 
                name="confirmation" 
                placeholder="J@im3_l1_Guit@r3#!" 
            >
        </div>
    </section>

    <div class="form-section">
        <button 
            class="action_button grey_color"
            type="button"
            onclick="window.history.back()"
        >
            <p>Annuler</p>

            <img
                src="<?= APP_PATH ?>\layouts\assets\img\arrow\left\black.svg"
                alt="Annuler"
            >
        </button>

        <button 
            class="action_button reverse_color"
            type="submit" 
            value="new_passwprd"
        >
            <p>Enregistrer</p>

            <img
                src="<?= APP_PATH ?>\layouts\assets\img\save\white.svg"
                alt="Enregistrer"
            >
        </button>
    </div>
</form>

<script>
    const STR_EXIT = {
        code: 0,
        msg: ""
    };
    const ERR_VLD_PSWD = {
        code: 1,
        msg: "Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial."
    };
    const ERR_VLD_CONF = {
        code: 2,
        msg: "Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial."
    };
    const ERR_DIF_PREC = {
        code: 3,
        msg: "Le mot de passe doit être différent de l'ancien mot de passe."
    };
    const ERR_DIF_NEW = {
        code: 4,
        msg: "Le mot de passe et la confirmation doivent être identiques."
    };
    const ERR_EMP_PREC = {
        code: 5,
        msg: "L'ancien mot de passe ne peut être vide."
    };
    const ERR_EMP_PSWD = {
        code: 6,
        msg: "Le nouveau mot de passe ne peut être vide."
    };
    const ERR_EMP_NEW = {
        code: 7,
        msg: "La confirmation du mot de passe ne peut être vide."
    };

    const password = document.getElementById("password");
    const passwordMessage = document.getElementById("password-message");
    const newPassword = document.getElementById("new-password");
    const confirmation = document.getElementById("confirmation");
    const newPasswordMessage = document.getElementById("new-password-message");
    const confirmationMessage = document.getElementById("confirmation-message");

    /**
     * @function handleResponseForm
     * @description Function that handles the error form
     * @param {struct} response The response code
     * @returns {void}
     */
    function handleResponseForm(response) {
        switch(response.code) {
            // success
            case STR_EXIT.code :
                password.setCustomValidity(STR_EXIT.msg);
                newPassword.setCustomValidity(STR_EXIT.msg);
                confirmation.setCustomValidity(STR_EXIT.msg);
                passwordMessage.textContent = STR_EXIT.msg;
                newPasswordMessage.textContent = STR_EXIT.msg;
                confirmationMessage.textContent = STR_EXIT.msg;
                break;

            // invalid password
            case ERR_VLD_PSWD.code :
                newPassword.setCustomValidity(ERR_VLD_PSWD.msg);
                newPasswordMessage.textContent = ERR_VLD_PSWD.msg;
                break;

            // invalid confirmation
            case ERR_VLD_CONF.code :
                confirmation.setCustomValidity(ERR_VLD_CONF.msg);
                confirmationMessage.textContent = ERR_VLD_CONF.msg;
                break;

            // same password
            case ERR_DIF_PREC.code:
                password.setCustomValidity(ERR_VLD_PSWD.msg);
                newPassword.setCustomValidity(ERR_VLD_CONF.msg);
                newPasswordMessage.textContent = ERR_VLD_CONF.msg;
                break;

            // different confirmation
            case ERR_DIF_NEW.code:
                newPassword.setCustomValidity(ERR_DIF_NEW.msg);
                confirmation.setCustomValidity(ERR_DIF_NEW.msg);
                confirmationMessage.textContent = ERR_DIF_NEW.msg;
                break;

            // empty password
            case ERR_EMP_PREC.code:
                password.setCustomValidity(ERR_EMP_PREC.msg);
                passwordMessage.textContent = ERR_EMP_PREC.msg;
                break;

            // empty new password
            case ERR_EMP_PSWD.code:
                newPassword.setCustomValidity(ERR_EMP_PSWD.msg);
                newPasswordMessage.textContent = ERR_EMP_PSWD.msg;
                break;

            // empty confirmation
            case ERR_EMP_NEW.code:
                confirmation.setCustomValidity(ERR_EMP_NEW.msg);
                confirmationMessage.textContent = ERR_EMP_NEW.msg;
                break;

            default:
                console.error("Unknown error code: " + response.code + " - " + response.msg);
                break;
        }

        console.log("Response code: " + response.code + " - " + response.msg);
    }

    /**
     * @function isValidPassword
     * @description Function that checks if the password is valid
     * @param {string} str The password to check
     * @returns {boolean} True if the password is valid, false otherwise
     */
    function isValidPassword(str) {
        return !(str.length < 12 || !/[a-z]/.test(str) || !/[A-Z]/.test(str) || !/\d/.test(str) || !/[@$!%*?&]/.test(str));
    }
    

    /**
     * @function handleInputPrec
     * @description Function that handles the input of the password field
     * @param {HTMLInputElement} target The input element
     * @returns {int} The response code
     */
    function handleInputPrec(target) {
        let response;
        switch(true) {
            case target.value.length === 0:
                response = ERR_EMP_PREC;
                break;

            default:
                response = STR_EXIT;
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
    function handleInputPassword(target) {
        let response;
        switch(true) {
            case target.value.length === 0:
                response = ERR_EMP_PSWD;
                break;

            case !isValidPassword(target.value):
                response = ERR_VLD_PSWD;
                break;

            case target.value === password.value:
                response = ERR_DIF_PREC;
                break;

            case target.value !== confirmation.value:
                response = ERR_DIF_NEW;
                break;

            default:
                response = STR_EXIT;
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
    function handleInputConfirmation(target) {
        let response;
        switch(true) {
            case target.value.length === 0:
                response = ERR_EMP_NEW;
                break;

            case !isValidPassword(target.value):
                response = ERR_VLD_CONF;
                break;

            case target.value !== newPassword.value:
                response = ERR_DIF_NEW;
                break;

            default:
                response = STR_EXIT;
                break;
        }
        return response;
    }

    /**
     * @function handlePasswordChange
     * @description Function that analyses the request of password change
     * @returns {int} The response code
     */
    function handlePasswordChange() {
        event.preventDefault();

        let index = 0;
        let response;
        const arr = [
            {
                input: password,
                method: handleInputPrec
            },
            {
                input: newPassword,
                method: handleInputPassword
            },
            {
                input: confirmation,
                method: handleInputPassword
            }
        ];

        do {
            response = arr[index].method(arr[index].input);
            handleResponseForm(response);
            index++;
        } while(index < arr.length && response.code === STR_EXIT.code);

        if(response.code === STR_EXIT.code) {
            event.target.submit();
        }
    }
    
    password.addEventListener('input', (event) => {
        handleResponseForm(handleInputPrec(event.target));
    });
    newPassword.addEventListener('input', (event) => {
        handleResponseForm(handleInputPassword(event.target));
    });
    confirmation.addEventListener('input', (event) => {
        handleResponseForm(handleInputConfirmation(event.target));
    });
    document.querySelector('form')
            .addEventListener('submit', (event) => handlePasswordChange(event));
</script>
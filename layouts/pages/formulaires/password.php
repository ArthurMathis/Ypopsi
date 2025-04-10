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

        <i 
            class="error-message" 
            id="password-message"
        ></i>

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

            <i 
                class="error-message" 
                id="new-password-message"
            ></i>

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

            <i 
                class="error-message" 
                id="confirmation-message"
            ></i>

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

<script type="module">
    import InputPassword from "<?= APP_PATH ?>\\layouts\\scripts\\modules\\InputPassword.mjs";
    import PasswordManager from "<?= APP_PATH ?>\\layouts\\scripts\\modules\\PasswordManager.mjs";
    
    new PasswordManager(
        new InputPassword(
            document.getElementById("password"),
            document.getElementById("password-message")
        ),new InputPassword(
            document.getElementById("new-password"),
            document.getElementById("new-password-message")
        ),new InputPassword(
            document.getElementById("confirmation"),
            document.getElementById("confirmation-message")
        )).startListening(document.querySelector('form'));
</script>
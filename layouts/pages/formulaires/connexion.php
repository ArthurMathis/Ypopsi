<section class='titled'>
    <div>
        <p>Bienvenue sur</p>
        <h1>Ypopsi</h1>
    </div>
    <button id="action-button">
        <p>Accéder</p>
        <img src="<?= APP_PATH ?>/layouts/assets/img/logo/blue/arrow.svg" alt="">
    </button>
</section>

<form 
    method="post" 
    action="<?= APP_PATH ?>/login/set"
>
    <h3>Connexion à l'application</h3>
    <section>
        <div class="input-container">
            <label>Indentifiant</label>
            <input 
                type="text" 
                id="identifiant" 
                name="identifiant" 
                placeholder="dupond.j"
                required
            >
        </div>
        <div class="input-container">
            <label>Mot de passe</label>
            <input 
            type="password" 
            id="motdepasse" 
            name="motdepasse" 
            placeholder="................"
            required
        >
        </div>
    </section>
    <div class="form-section">
        <button 
            type="submit" 
            value="login"
        >
            <p>Se connecter</p>
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/blue/arrow.svg" alt="">
        </button>
    </div>
</form>

<script>
    document.getElementById('action-button').addEventListener('click', function() {
        document.querySelector('section').classList.add('hided');
        
        setTimeout(function() {
            document.querySelector('form').classList.add('showed');
        }, 600);
    });
</script>
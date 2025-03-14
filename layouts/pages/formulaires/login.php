<section class='titled form-section'>
    <div>
        <p>Bienvenue sur</p>
        <h1>Ypopsi</h1>
    </div>

    <button 
        id="action-button"
        class="action_button reverse_color"
        type="submit" 
        value="login"
    >
        Accéder
    </button>
</section>

<form 
    method="post" 
    action="<?= APP_PATH ?>/login/set"
>
    <h3>Connexion à l'application</h3>
    <section>
        <div class="input-container">
            <label for="identifiant">
                Indentifiant *
            </label>

            <input 
                type="text" 
                id="identifiant" 
                name="identifiant" 
                placeholder="dupond.j"
                required
            >
        </div>
        
        <div class="input-container">
            <label for="motdepasse">
                Mot de passe *
            </label>

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
            class="action_button reverse_color"
            type="submit" 
            value="login"
        >
            Se connecter
        </button>
    </div>
</form>

<footer class="versionning">version <?= getenv('APP_VERSION'); ?></footer>

<script>
    document.getElementById('action-button').addEventListener('click', function() {
        document.querySelector('section').classList.add('hided');
        
        setTimeout(function() {
            document.querySelector('form').classList.add('showed');
        }, 600);
    });
</script>
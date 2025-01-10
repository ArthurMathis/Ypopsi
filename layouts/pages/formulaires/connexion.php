<section class='titled'>
    <div>
        <p>Bienvenue sur</p>
        <h1>Ypopsi</h1>
    </div>
    <button id="action-button">
        <p>Accéder</p>
        <img src="layouts/assets/img/logo/blue/arrow.svg" alt="">
    </button>
</section>
<form method="post" action="index.php?login=connexion">
    <h3>Connexion à l'application</h3>
    <section>
        <div class="input-container">
            <p>Indentifiant</p>
            <input type="text" id="identifiant" name="identifiant" placeholder="dupond.j">
        </div>
        <div class="input-container">
            <p>Mot de passe</p>
            <input type="password" id="motdepasse" name="motdepasse" placeholder="................">
        </div>
    </section>
    <div class="form-section">
        <button type="submit" value="new_user">
            <p>Se connecter</p>
            <img src="layouts/assets/img/logo/blue/arrow.svg" alt="">
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
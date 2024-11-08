<section class='titled'>
    <div>
        <p>Bienvenu sur</p>
        <h1>Ypopsi</h1>
    </div>
    <button id="action-button">
        <p>Accéder</p>
        <img src="layouts/assets/img/logo/arrow.svg" alt="">
    </button>
</section>
<form method="post" action="index.php?login=connexion">
    <h3>Connexion à l'application</h3>
    <section>
        <p>Saisissez vos informations de connexion</p>
        <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
        <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
    </section>
    <div class="form-section">
        <button type="submit" value="new_user">Se connecter</button>
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
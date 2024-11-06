<nav class="navbarre">
    <article>
        <img src="layouts/assets/img/main-logo.svg" alt="">
        <div>
            <p><?= $_SESSION['user_identifier']; ?></p>
            <p><?= $_SESSION['user_role']; ?></p>
        </div>
    </article>
    <section class="action-section">
        <a href="index.php" <?php if($currentPage == 'HOME') echo 'class="selected"' ?>>
            <img src="layouts/assets/img/logo/home.svg" alt="page d'accueil">
        </a>
        <a href="index.php?applications=home">
            <img src="layouts/assets/img/logo/applications.svg" alt="liste des candidatures">
        </a>
        <a href="#">
            <img src="layouts/assets/img/logo/needs.svg" alt="liste des besoins">
        </a>
        <a href="#">
            <img src="layouts/assets/img/logo/statistics.svg" alt="statistiques">
        </a>
    </section>
    <section>
        <a href="index.php?preferences=home">
            <img src="layouts/assets/img/logo/preferences.svg" alt="paramètres">
        </a>
        <a href="index.php?login=deconnexion">
            <img src="layouts/assets/img/logo/disconnect.svg" alt="déconnexion">
        </a>
    </section>
</nav>
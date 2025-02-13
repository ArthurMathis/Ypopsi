<nav class="navbarre <?php if($form) : ?>formbarre<?php endif ?>">
    <article>
        <?php if($form) : ?>
            <img src="<?= APP_PATH ?>/layouts/assets/img/white-logo.svg" alt="">
        <?php else : ?>
            <img src="<?= APP_PATH ?>/layouts/assets/img/main-logo.svg" alt="">
        <?php endif ?>
        <div>
            <p><?= $_SESSION['user']->getIdentifier(); ?></p>
            <p><?= $_SESSION['user_titled_role']; ?></p>
        </div>
    </article>
    <section class="action-section">
        <a href="<?= APP_PATH ?>" class="LignesHover <?php if($currentPage == HOME) echo 'selected'?>">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/home.svg" alt="page d'accueil">
        </a>
        <a href="<?= APP_PATH ?>/applications" class="LignesHover <?php if($currentPage == APPLICATIONS) echo 'selected'?>">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/applications.svg" alt="liste des candidatures">
        </a>
        <!--
        <a href="#" class="LignesHover <?php if($currentPage == NEEDS) echo 'selected'?>">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/needs.svg" alt="liste des besoins">
        </a>
        <a href="#" class="LignesHover <?php if($currentPage == STATS) echo 'selected'?>">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/statistics.svg" alt="statistiques">
        </a>
        -->
    </section>
    <section>
        <a href="<?= APP_PATH ?>/index.php?preferences=home" class="LignesHover <?php if($currentPage == PREFERENCES) echo 'selected'?>">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/preferences.svg" alt="paramètres">
        </a>
        <a href="<?= APP_PATH ?>/logout" class="LignesHover">
            <img src="<?= APP_PATH ?>/layouts/assets/img/logo/disconnect.svg" alt="déconnexion">
        </a>
    </section>
</nav>
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
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white-home.svg" alt="accueil">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/home.svg" alt="accueil">
            <?php endif ?>
        </a>
        <a href="<?= APP_PATH ?>/applications" class="LignesHover <?php if($currentPage == APPLICATIONS) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white-applications.svg" alt="candidatures">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/applications.svg" alt="candidatures">
            <?php endif ?>
        </a>
        <!--
        <a href="#" class="LignesHover <?php if($currentPage == NEEDS) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white-needs.svg" alt="besoins">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/needs.svg" alt="besoins">
            <?php endif ?>
        </a>
        <a href="#" class="LignesHover <?php if($currentPage == STATS) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white-statistics.svg" alt="statistiques">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/statistics.svg" alt="statistiques">
            <?php endif ?>
        </a>
        -->
    </section>
    <section>
        <a href="<?= APP_PATH ?>/index.php?preferences=home" class="LignesHover <?php if($currentPage == PREFERENCES) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white-preferences.svg" alt="paramètres">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/preferences.svg" alt="paramètres">
            <?php endif ?>
        </a>
        <a href="<?= APP_PATH ?>/logout" class="LignesHover">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/white/disconnect.svg" alt="déconnexion">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/logo/disconnect.svg" alt="déconnexion">
            <?php endif ?>
        </a>
    </section>
</nav>
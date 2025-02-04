<?php if($form) : ?>
    <nav class="navbarre formbarre">
        <article>
            <img src="layouts/assets/img/white-logo.svg" alt="">
            <div>
                <p><?= $_SESSION['user_identifier']; ?></p>
                <p><?= $_SESSION['user_titled_role']; ?></p>
            </div>
        </article>
        <section class="action-section">
            <a href="index.php" class="LignesHover <?php if($currentPage == HOME) echo 'selected'?>">
                <img src="layouts/assets/img/logo/white/home.svg" alt="page d'accueil">
            </a>
            <a href="index.php?applications=home" class="LignesHover <?php if($currentPage == APPLICATIONS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/white/applications.svg" alt="liste des candidatures">
            </a>
            <!--
            <a href="#" class="LignesHover <?php if($currentPage == NEEDS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/white/needs.svg" alt="liste des besoins">
            </a>
            <a href="#" class="LignesHover <?php if($currentPage == STATS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/white/statistics.svg" alt="statistiques">
            </a>
            -->
        </section>
        <section>
            <a href="index.php?preferences=home" class="LignesHover <?php if($currentPage == PREFERENCES) echo 'selected'?>">
                <img src="layouts/assets/img/logo/white/preferences.svg" alt="paramètres">
            </a>
            <a href="index.php?login=deconnexion" class="LignesHover">
                <img src="layouts/assets/img/logo/white/disconnect.svg" alt="déconnexion">
            </a>
        </section>
    </nav>
<?php else : ?>
    <nav class="navbarre">
        <article>
            <img src="layouts/assets/img/main-logo.svg" alt="">
            <div>
                <p><?= $_SESSION['user_identifier']; ?></p>
                <p><?= $_SESSION['user_titled_role']; ?></p>
            </div>
        </article>
        <section class="action-section">
            <a href="index.php" class="LignesHover <?php if($currentPage == HOME) echo 'selected'?>">
                <img src="layouts/assets/img/logo/home.svg" alt="page d'accueil">
            </a>
            <a href="index.php?applications=home" class="LignesHover <?php if($currentPage == APPLICATIONS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/applications.svg" alt="liste des candidatures">
            </a>
            <!--
            <a href="#" class="LignesHover <?php if($currentPage == NEEDS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/needs.svg" alt="liste des besoins">
            </a>
            <a href="#" class="LignesHover <?php if($currentPage == STATS) echo 'selected'?>">
                <img src="layouts/assets/img/logo/statistics.svg" alt="statistiques">
            </a>
            -->
        </section>
        <section>
            <a href="index.php?preferences=home" class="LignesHover <?php if($currentPage == PREFERENCES) echo 'selected'?>">
                <img src="layouts/assets/img/logo/preferences.svg" alt="paramètres">
            </a>
            <a href="<?= APP_PATH ?>/logout" class="LignesHover">
                <img src="layouts/assets/img/logo/disconnect.svg" alt="déconnexion">
            </a>
        </section>
    </nav>
<?php endif ?>
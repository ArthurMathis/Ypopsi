<nav class="navbarre <?php if($form) : ?>formbarre<?php endif ?>">
    <article>
        <?php if($form) : ?>
            <img 
                src="<?= APP_PATH ?>/layouts/assets/img/ypopsi/white.svg" 
                alt=""
            >
        <?php else : ?>
            <img    
                src="<?= APP_PATH ?>/layouts/assets/img/ypopsi.svg" 
                alt=""
            >
        <?php endif ?>
        <div>
            <p>
                <?= $_SESSION['user']->getIdentifier(); ?>
            </p>

            <p>
                <?= $_SESSION['user_titled_role']; ?>
            </p>
        </div>
    </article>

    <section class="action-section">
        <a 
            href="<?= APP_PATH ?>" 
            class="LignesHover 
            <?php if($currentPage == HOME): ?>
                selected
            <?php endif ?>"
        >
            <?php if($form) : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/home/white.svg"     
                    alt="accueil"
                >
            <?php else : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/home/black.svg" 
                    alt="accueil"
                >
            <?php endif ?>
        </a>

        <a 
            href="<?= APP_PATH ?>/applications" 
            class="LignesHover 
            <?php if($currentPage == APPLICATIONS): ?>
                selected
            <?php endif ?>"
        >
            <?php if($form) : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/applications/white.svg" 
                    alt="candidatures"
                >
            <?php else : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/applications/black.svg" 
                    alt="candidatures"
                >
            <?php endif ?>
        </a>
        <!--
        <a href="#" class="LignesHover <?php if($currentPage == NEEDS) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/needs/white.svg" alt="besoins">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/needs/black.svg" alt="besoins">
            <?php endif ?>
        </a>
        <a href="#" class="LignesHover <?php if($currentPage == STATS) echo 'selected'?>">
            <?php if($form) : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/statistics/white.svg" alt="statistiques">
            <?php else : ?>
                <img src="<?= APP_PATH ?>/layouts/assets/img/statistics/black.svg" alt="statistiques">
            <?php endif ?>
        </a>
        -->
    </section>
    <section>
        <a 
            href="<?= APP_PATH ?>/preferences" 
            class="LignesHover 
            <?php if($currentPage == PREFERENCES): ?>
                selected
            <?php endif ?>"
        >
            <?php if($form) : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/preferences/white.svg" 
                    alt="paramètres"
                >
            <?php else : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/preferences/black.svg" 
                    alt="paramètres"
                >
            <?php endif ?>
        </a>

        <a 
            href="<?= APP_PATH ?>/logout" 
            class="LignesHover"
        >
            <?php if($form) : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/disconnect/white.svg" 
                    alt="déconnexion"
                >
            <?php else : ?>
                <img 
                    src="<?= APP_PATH ?>/layouts/assets/img/disconnect/black.svg" 
                    alt="déconnexion"
                >
            <?php endif ?>
        </a>
    </section>
</nav>
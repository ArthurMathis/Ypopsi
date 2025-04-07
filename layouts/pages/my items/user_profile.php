<?php

use App\Core\Middleware\AuthMiddleware;
use App\Core\Moment;

?>

<div class="dashboard_bubble bold">
    <header>
        <h2>
            <?= $user->getCompleteName() ?>
        </h2>
        <p>
            <?= $role->getTitled() ?>
        </p>
    </header>

    <content>
        <article>
            <p>
                Email :
            </p>

            <p>
                <?= $user->getEmail() ?>
            </p>
        </article>

        <article>
            <p>
                Etablissement : 
            </p>

            <p>
                <?= $establishment->getTitled() ?>
            </p>
        </article>
        
        <article>
            <p>
                Inscription :
            </p>

            <p>
                <?= Moment::dayFromDate($user->getCreated()) ?> 
            </p>
        </article>
    </content>
</div>

<div class="number_bubble">
    <p>
        Connexions
    </p>

    <p class="number">
        <?= $nb_connexions ?>
    </p>
</div>

<div class="number_bubble">
    <p>
        Actions
    </p>

    <p class="number">
        <?= $nb_actions ?>
    </p>
</div>

<div class="dashboard_bubble">
    <h2>
        Connexions
    </h2>

    <content>
        <article>
            <p>
                Première connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($first_log->getDate()) ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= Moment::dayFromDate($last_log->getDate()) ?>
            </i>
        </article>
    </content>
</div>

<div class="number_bubble">
    <p>
        Candidatures traitées
    </p>

    <p class="number">
        <?= $nb_applications ?>
    </p>
</div>

<div class="number_bubble">
    <p>
        Offres traitées
    </p>

    <p class="number">
        <?= $nb_offers ?>
    </p>
</div>

<div class="dashboard_bubble">
    <h2>
        Mot de passe
    </h2>

    <content>
        <article>
            <p>
                Premier chagement : 
            </p>
    
            <i>
                <?= $first_password_change ? Moment::dayFromDate($first_password_change->getDate()) : "Non réalisé" ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= $last_password_change ? Moment::dayFromDate($last_password_change->getDate()) : "Non réalisé" ?>
            </i>
        </article>
    </content>
</div>

<div class="number_bubble">
    <p>
        Contrats traités
    </p>

    <p class="number">
        <?= $nb_contracts ?>
    </p>
</div>

<div class="number_bubble">
    <p>
        Rendez-vous
    </p>

    <p class="number">
        <?= $nb_meetings ?>
    </p>
</div>

<?php if($user->getId() === $_SESSION['user']->getId() || AuthMiddleware::isAdminOrMore()) : ?>
    <footer class="form-section add_button">
        <a 
            href="<?= APP_PATH ?>\preferences\users\profile\password\edit\<?= $user->getId() ?>" 
            class="action_button"
        >
            <p>
                Réinitialiser le mot de passe
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\reset\blue.svg" 
                alt=""
            >
        </a>

        <a 
            href="<?= APP_PATH ?>\preferences\users\profile\edit\<?= $user->getId() ?>" 
            class="action_button reverse_color"
        >
            <p>
                Modifier
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\edit\white.svg" 
                alt=""
            >
        </a>
    </footer>
<?php endif?>
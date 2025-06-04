<?php

use App\Core\Middleware\AuthMiddleware;
use App\Core\Tools\DataFormat\TimeManager;

?>

<div class="dashboard_bubble bold">
    <header>
        <h2>
            <?= $user->getCompleteName() ?>
        </h2>

        <p>
            <?= $role->getTitled() ?>
        </p>

        <?php if($user->getDesactivated()): ?>
            <div class="double-items desactivated">
                <img
                    src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg"
                    alt=""
                >

                <i>
                    Compte désactivé
                </i>
            </div>
        <?php endif ?>
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
                <?= TimeManager::dayFromDate($user->getCreated()) ?> 
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
                <?= $first_log ? TimeManager::dayFromDate($first_log->getDate()) : 'Aucun connexion' ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernière connexion : 
            </p>
    
            <i>
                <?= $last_log ? TimeManager::dayFromDate($last_log->getDate()) : 'Aucun connexion' ?>
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
                <?= $first_password_change ? TimeManager::dayFromDate($first_password_change->getDate()) : "Non réalisé" ?>
            </i>
        </article>
    
        <article>
            <p>
                Dernier changement : 
            </p>
    
            <i>
                <?= $last_password_change ? TimeManager::dayFromDate($last_password_change->getDate()) : "Non réalisé" ?>
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

<footer class="form-section add_button">
    <?php if($user->getId() === $_SESSION['user']->getId()): ?>
        <a 
            href="<?= APP_PATH ?>\preferences\users\profile\password\edit\<?= $user->getId() ?>" 
            class="action_button"
        >
            <p>
                Modifier le mot de passe
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
                Modifier les informations
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\edit\white.svg" 
                alt=""
            >
        </a>
    <?php elseif(AuthMiddleware::isAdminOrMore()): ?>
        <a 
            href="<?= APP_PATH ?>/preferences/users/fetch_reset_password/<?= $user->getId() ?>" 
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

        <?php if(AuthMiddleware::roleIsMore($user->getId())): ?>
            <a 
                href="<?= APP_PATH ?>\preferences\users\edit\<?= $user->getId() ?>" 
                class="action_button reverse_color"
            >
                <p>
                    Modifier les informations
                </p>

                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\edit\white.svg" 
                    alt=""
                >
            </a>

            <?php if($user->getDesactivated()):?>
                <a
                    href="<?= APP_PATH ?>\preferences\users\activate\<?= $user->getId() ?>"
                    class="action_button"
                    onclick="return confirm('Êtes-vous sûr de vouloir réactiver ce compte ?')"
                >
                    <p>
                        Réactiver le compte
                    </p>

                    <img
                        src="<?= APP_PATH ?>\layouts\assets\img\reset\blue.svg"
                        alt=""
                    >
                </a>
            <?php else: ?>
                <a 
                    href="<?= APP_PATH ?>\preferences\users\profile\desactivate\<?= $user->getId() ?>" 
                    class="action_button cancel_button"
                    onclick="return confirm('Êtes-vous sûr de vouloir désactiver ce compte ?')"
                >
                    <p>
                        Désactiver le compte
                    </p>

                    <img 
                        src="<?= APP_PATH ?>\layouts\assets\img\close\white.svg" 
                        alt=""
                    >
                </a>
            <?php endif ?>
        <?php endif?>
    <?php endif ?>
</footer>
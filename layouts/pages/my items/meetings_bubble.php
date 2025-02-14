<?php

use App\Core\FormsManip;

?>

<div class="meeting_bubble">
    <header>
        <h2><?php echo FormsManip::majusculeFormat($item['nom']) . ' ' . $item['prenom']; ?></h2>
        <p><?= $item['etablissement'] ?></p>
    </header>
    <content>
        <div>
            <p>Prévu le</p>
            <p><?= $item['date']; ?></p>
        </div>
        <div>
            <p>Prévu à</p>
            <p><?= $item['heure']; ?></p>
        </div>
    </content>
    <content>
        <div>
            <p>Compte rendu</p>
        </div>
        <?php if(empty($item['description'])): ?>
            <p style="color: var(--grey)">Aucun compte rendu saisi pour le moment.</p>
        <?php else: ?>
            <p><?= $item['description']; ?></p>    
        <?php endif?>    
    </content>
    <footer>
        <?php if ($_SESSION['user']->getRole() != INVITE): ?>
            <?php if(time() < strtotime($item['date'] . ' ' . $item['heure'])): ?>
                <a 
                    class="action_button grey_color" 
                    href="<?= APP_PATH ?>/candidates/meeting/delete/<?= urlencode($item['key_meeting']); ?>"
                >
                    <p>Annuler</p>
                    <img 
                        src="<?= APP_PATH ?>\layouts\assets\img\logo\trash.svg" 
                        alt="supprimer"
                    >
                </a>    
            <?php endif ?>
            <a 
                class="action_button reverse_color" 
                href="<?= APP_PATH ?>/candidates/meeting/edit/<?= urlencode($item['key_meeting']); ?>"
            >
                <p>Éditer</p>
                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\logo\white-edit.svg" 
                    alt="modifier"
                >
            </a>
        <?php endif ?>
    </footer>
</div>
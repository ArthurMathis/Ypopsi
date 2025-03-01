<div class="meeting_bubble">
    <header>
        <h2><?php echo forms_manip::majusculeFormat($item['nom']) . ' ' . $item['prenom']; ?></h2>
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
        <?php if($_SESSION['user_role'] != INVITE): ?>
            <a class="action_button grey_color" href="index.php?candidates=delete-meetings&key_meeting=<?= urlencode($item['key_meeting']); ?>&key_candidate=<?= urlencode($key_candidate); ?>">
                <p>Annuler</p>
                <img src="layouts\assets\img\logo\trash.svg" alt="Logo de modification du rendez-vous, représenté par un carnet et un stylo">
            </a>    
            <a class="action_button reverse_color" href="index.php?candidates=edit-meetings&key_meeting=<?= $item['key_meeting']; ?>">
                <p>Éditer</p>
                <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du rendez-vous, représenté par un carnet et un stylo">
            </a>
        <?php endif ?>
    </footer>
</div>

<script>
    console.log(JSON.stringify(<?php echo json_encode($item); ?>));
</script>
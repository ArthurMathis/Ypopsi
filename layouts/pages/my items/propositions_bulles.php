<div class="propositions_bulle">
    <header>
        <h2><?= $item['poste']; ?></h2>
        <p><?= $item['service']; ?></p>
        <p><?= $item['etablissement']; ?></p>
    </header>
    <article>
        <h3><?= $item['type_de_contrat']; ?></h3>
        <?php if(!empty($item['signature'])): ?>
            <p class="acceptee">Acceptée</p>
        <?php elseif(!empty($item['statut'])) : ?>
            <p class="refusee">Refusée</p>
        <?php else : ?>
            <p class="en-attente">En attente</p>
        <?php endif ?>        
    </article>
    <content>
        <div>
            <p>Proposé le</p>
            <p><?= $item['proposition']; ?></p>
        </div>
        <div>
            <p>Début du contrat</p>
            <p><?= $item['date_debut']; ?></p>
        </div>
        <div>
            <p>Fin du contrat</p>
            <p><?= $item['date_fin']; ?></p>
        </div>
        <div>
            <p>Horaire</p>
            <p><?= $item['heures']; ?> heures</p>
            <?php if($item['nuit'] == 'true'): ?>
                <p>Emploi de nuit</p>
            <?php endif ?>    
            <?php if($item['week_end'] == 'true'): ?>
                <p>Emploi de week-end</p>
            <?php endif ?>  
        </div>
    </content>
    <?php if(empty($item['signature']) && empty($item['statut'])): ?>
        <footer>
            <?php if($_SESSION['user_role'] != INVITE): ?>
                <a class="circle_button" href="index.php?candidats=reject-propositions&cle_proposition=<?= $item['cle']; ?>">
                    <img src="layouts\assets\img\logo\white-close.svg" alt="Logo de refus de la proposition, représenté par une croix">
                </a>
                <a class="circle_button" href="index.php?candidats=inscript-contrats-from-proposition&cle_proposition=<?= $item['cle']; ?>">
                    <img src="layouts\assets\img\logo\white-valider.svg" alt="Logo de d'acceptation de la proposition, représenté par une coche">
                </a>
            <?php endif ?>
        </footer>
    <?php endif ?>  
</div>
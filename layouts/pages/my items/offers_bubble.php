<?php

    use App\Core\Tools\TimeManager;
    use App\Core\Middleware\AuthMiddleware;
    
?>

<div class="propositions_bulle">
    <header>
        <h2>
            <?= $item['poste']; ?>
        </h2>

        <p>
            <?= $item['service']; ?>
        </p>

        <p>
            <?= $item['etablissement']; ?>
        </p>
    </header>

    <article>
        <h3>
            <?= $item['type_de_contrat']; ?>
        </h3>

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
            <p>
                Proposé le
            </p>

            <p>
                <?= $item['proposition']; ?>
            </p>
        </div>

        <div>
            <p>
                Début du contrat
            </p>

            <p>
                <?= $item['date_debut']; ?>
            </p>
        </div>

        <div>
            <p>
                Fin du contrat
            </p>

            <p>
                <?= $item['date_fin']; ?>
            </p>
        </div>

        <div>
            <p>
                Horaire
            </p>

            <article>
                <?php if(!empty($item['heures'])): ?>
                    <p>
                        <?= $item['heures']; ?> heures
                    </p>
                <?php endif ?>

                <?php 
                    switch($item) {
                        case $item['nuit'] && $item['week_end']:
                            echo "<p>Emploi de nuit et de week-end</p>";
                            break;

                        case $item['nuit']:
                            echo "<p>Emploi de nuit</p>";
                            break;

                        case $item['week_end']:
                            echo "<p>Emploi de week-end</p>";
                            break;
                    } 
                ?>
            </article>
        </div>

        <?php if(!empty($item['salaire'])) : ?>
            <div>
                <p>
                    Rémunération proposée
                </p>

                <p>
                    <?= $item['salaire'] ?>€
                </p>
            </div>
        <?php endif ?>
    </content>

    <?php if(empty($item['signature']) && empty($item['statut']) && ($item['date_fin'] == null || TimeManager::dayFromDate(TimeManager::currentTimeManager()->getDate()) < $item['date_fin'])): ?>
        <footer>
            <?php if(AuthMiddleware::isUserOrMore()): ?>
                <a 
                    class="action_button grey_color" 
                    href="<?= APP_PATH ?>/candidates/offers/reject/<?= urlencode($key_candidate) ?>/<?= urlencode($item['cle']) ?>"
                >
                    <p>
                        Refuser
                    </p>

                    <img 
                        src="<?= APP_PATH ?>\layouts\assets\img\close\black.svg" 
                        alt="Refuser"
                    >
                </a>

                <a 
                    class="action_button reverse_color" 
                    href="<?= APP_PATH ?>/candidates/contracts/sign/<?= urlencode($key_candidate) ?>/<?= urlencode($item['cle']) ?>"
                >

                    <p>
                        Accepter
                    </p>

                    <img 
                        src="<?= APP_PATH ?>\layouts\assets\img\valid\white.svg" 
                        alt="Accepter"
                    >
                </a>
            <?php endif ?>
        </footer>
    <?php endif ?>  
</div>
<aside>
    <div class="aside-wrapper">
        <header>
            <h2><?= $item['candidate']['Gender'] ? 'M' : 'Mme'; ?>. <?= $item['candidate']['Name']; ?> <?= $item['candidate']['Firstname']; ?></h2>    
            <h3><?= $item['applications'][0]['type_de_contrat']; ?></h3>
            <p><?php 
                if($item['applications'][0]['acceptee'])
                    echo ACCEPTED;
                elseif($item['applications'][0]['refusee']) 
                    echo REFUSED;  
                else 
                    echo UNTREATED;   
            ?></p>  
        </header>
        <section>
            <div>
                <p>Disponibilité</p>
                <p><?= $item['candidate']['Availability']; ?></p>
            </div>
            <div>
                <p>Service demandé</p>
                <?php if(empty($item['candidatures'][0]['service'])): ?>
                    <p>non renseigné</p>
                <?php else: ?>
                    <p><?= $item['candidatures'][0]['service']; ?></p>
                <?php endif ?>
            </div>
            <div>
                <p>Etablissement demandé</p>
                <?php if(empty($item['candidatures'][0]['etablissement'])): ?>
                    <p>non renseigné</p>
                <?php else: ?>
                    <p><?= $item['candidatures'][0]['etablissement']; ?></p>
                <?php endif ?>
            </div>
        </section>
        <section>
            <div>
                <p>Numéro de téléphone</p>
                <p><?= $item['candidate']['Phone']; ?></p>
            </div>
            <div>
                <p>Adresse email</p>
                <p><?= $item['candidate']['Email']; ?></p>
            </div>
            <div>
                <p>Adresse</p>
                <div>
                    <p><?= $item['candidate']['Address']; ?></p>
                    <p><?= $item['candidate']['City']; ?></p>
                    <p><?= $item['candidate']['PostCode']; ?></p>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <?php if($_SESSION['user_role'] != INVITE): ?>
            <a class="action_button reverse_color" href="mailto:<?= $item['candidate']['Email']; ?>">
                <p>Contacter</p>
                <img src="layouts\assets\img\logo\white-paperplane.svg" alt="Logo d'envoi d'un courrier, représenté par un avion en papier">
            </a>
            <a class="action_button form_button" href="index.php?candidates=edit-candidates&key_candidate=<?= $item['candidate']['Id']; ?>">
                <p>Modifier</p>
                <img src="layouts\assets\img\logo\edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
            </a>  
        <?php endif ?>    
    </footer>
</aside>
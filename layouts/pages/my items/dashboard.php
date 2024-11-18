<section class="onglet">
    <div class="dashboard_bubble">
        <h2>Qualifications</h2>
        <?php if(isset($item['candidate']['qualifications']) && !empty($item['candidate']['qualifications'])): ?>
            <?php foreach($item['candidate']['qualifications'] as $obj): ?>
                <article>
                    <p><?= $obj['titled']; ?></p>
                    <i><?= $obj['year']; ?></i>
                </article>
            <?php endforeach ?>   
        <?php else: ?>
            <i>Aucune qualification renseignée</i>
        <?php endif ?>
    </div>
    <div class="number_bubble">
        <p>Contrats</p>
        <p class="number">
            <?php
                $compt = 0; 
                $size = empty($contracts) ? 0 :count($contracts);
                for($i = 0; $i < $size; $i++) {
                    if(!empty($contracts[$i]['signature'])){
                        $compt++;
                    }
                }

                echo $compt;
            ?>        
        </p>
    </div>
    <div class="number_bubble">
        <p>Offres d'emplois</p>
        <p class="number"><?= empty($item['contracts']) ? 0 : count($item['contracts'])?></p>
    </div>
    <div class="number_bubble">
        <p>Candidatures</p>
        <p class="number"><?= empty($item['applications']) ? 0 : count($item['applications'])?></p>
    </div>
    <div class="number_bubble">
        <p>Rendez-vous</p>
        <p class="number"><?= empty($item['meeting']) ? 0 : count($item['meeting'])?></p>
    </div>
    <div class="dashboard_bubble">
        <h2>Aides au recrutement</h2>
        <?php if(isset($item['candidate']['qualifications']) && !empty($item['candidate']['qualifications'])): ?>
            <?php foreach($item['candidate']['qualifications'] as $obj): ?>
                <article>
                    <p><?= $obj['titled']; ?></p>
                    <i><?= $obj['year']; ?></i>
                </article>
            <?php endforeach ?>  
        <?php else: ?>
            <i>Aucune aide renseignée</i>
        <?php endif ?>
    </div>
    <div class="dashboard_bubble" id="rating_bubble">
        <h2>Notation</h2>
        <content>
            <article>
                <div>
                    <p for="a">A</p>
                    <input type="checkbox" name="a" id="a" disabled <?php if($item['candidate']['A']) echo 'checked'; ?> onclick="return false;">
                </div>
                <div>
                    <p for="b">B</p>
                    <input type="checkbox" name="b" id="b" disabled <?php if($item['candidate']['B']) echo 'checked'; ?>>
                </div>
                <div>
                    <p for="c">C</p>
                    <input type="checkbox" name="c" id="c" disabled <?php if($item['candidate']['C']) echo 'checked'; ?>>
                </div>
            </article>
            <p class="number"><?php echo !empty($item['candidate']['Rating']) ? $item['candidate']['Rating'] : "?"; ?>/5</p>
        </content>
    </div>
    <div class="dashboard_bubble">
        <h2>Remarque</h2>
        <?php if(!empty($item['candidate']['Description'])): ?>
            <textarea><?= $item['candidate']['Description'] ?></textarea>
        <?php else: ?>
            <i>Aucune remarque saisie</i>
        <?php endif ?>
    </div>
    <?php if($_SESSION['user_role'] != INVITE): ?>
        <a class="action_button reverse_color add_button" href="index.php?candidates=edit-ratings&key_candidate=<?=$candidate['Id'] ?>">
            <p>Noter</p>
            <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
        </a>
    <?php endif ?>
</section>
<div class="grid">
<article>
    <div class="notation_bulle">
        <h2>Notation</h2>
        <li class="notation">
            <?php if(empty($candidate['Rating'])): ?>
                <ul class="bille_notation"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation"><img src="<?= ETOILE_BK; ?>"></ul>
            <?php else: ?>
                <ul class="bille_notation <?php if(0 < $candidate['Rating']) echo "active"; ?>"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation <?php if(1 < $candidate['Rating']) echo "active"; ?>"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation <?php if(2 < $candidate['Rating']) echo "active"; ?>"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation <?php if(3 < $candidate['Rating']) echo "active"; ?>"><img src="<?= ETOILE_BK; ?>"></ul>
                <ul class="bille_notation <?php if(4 < $candidate['Rating']) echo "active"; ?>"><img src="<?= ETOILE_BK; ?>"></ul>
            <?php endif ?>
        </li>
    </div>
    <div id="carcatéristiques" class="notation_bulle">
        <h2>Caractéristiques</h2>
        <content>
            <div>
                <p for="a">A</p>
                <input type="checkbox" name="a" id="a" disabled <?php if($candidate['A']) echo 'checked'; ?>>
            </div>
            <div>
                <p for="b">B</p>
                <input type="checkbox" name="b" id="b" disabled <?php if($candidate['B']) echo 'checked'; ?>>
            </div>
            <div>
                <p for="c">C</p>
                <input type="checkbox" name="c" id="c" disabled <?php if($candidate['C']) echo 'checked'; ?>>
            </div>
        </content>
    </div>
</article>
<div class="notation_bulle">
    <h2>Remarque</h2>
    <?php if(isset($candidate['Description']) && empty($candidate['Description'])): ?>
        <p style="color: var(--grey)">Aucun descriptif enregistré</p>
    <?php else: ?>
        <p><?= $candidate['Description']; ?></p>
    <?php endif ?>    
</div>
</div>
<?php if($_SESSION['user_role'] != INVITE): ?>
    <a id="edit_button" class="circle_button" href="index.php?candidates=edit-rating&key_candidate=<?=$candidate['Id'] ?>">
        <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
    </a>
<?php endif ?>
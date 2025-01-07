<form class="big-form" method="post" action="index.php?preferences=inscript-services">
    <div class="form-container">
        <h3>Saisissez les informations du nouveau service</h3>
        <section>
            <div class="input-container">
                <p>Intitulé</p>
                <input type="text" id="titled" name="titled" placeholder="Service informatique">
            </div>
            <div class="input-container">
                <p>Description</p>
                <textarea name="description" id="description"></textarea>
            </div>
        </section>
        <section>
            <p>Fait partie des établissements : </p>
            <?php foreach($establishments as $elmt): ?>
                <div class="checkbox-item">
                    <input type="checkbox" id="establishment_<?= $elmt['id'] ?>" name="establishments[]" value="<?= $elmt['id'] ?>">
                    <label for="establishment_<?= $elmt['id'] ?>"><?= $elmt['text'] ?></label>
                </div>
            <?php endforeach ?>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div>
</form>
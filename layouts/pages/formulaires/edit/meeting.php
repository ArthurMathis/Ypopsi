<form class="big-form" method="post" action="index.php?candidates=update-meetings&key_meeting=<?= $meeting['key_meeting']; ?>&key_candidate=<?= $meeting['key_candidate']; ?>">
    <div class="form-container">
    <h3>Saissisez les informations du rendez-vous</h3>
        <section>
            <p>Entretien</p>
            <div class="autocomplete">
                <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur" autocomplete="off" value="<?= $meeting['Recruteur']; ?>">
                <article></article>
            </div>
            <div class="autocomplete">
                <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off" value="<?= $meeting['Etablissement']; ?>">
                <article></article>
            </div>
        </section>
        <section class="double-items">
            <div class="input-container">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?= $meeting['Date']; ?>" min="<?= Moment::currentMoment()->getDate(); ?>">
            </div>
            <div class="input-container">
                <label for="time">Horaire</label>
                <input type="time" name="time" id="time" value="<?= $meeting['Horaire']; ?>">
            </div>
        </section>
        <section>
            <label for="description">Compte rendu</label>
            <textarea name="description" id="description"><?= $meeting['description']; ?></textarea>
        </section>
        <section class="buttons_actions">
            <button type="submit" value="new_user">Enregistrer</button>
        </section>
    </div>  
</form>

<script>
    const recruteur = <?php echo json_encode(array_map(function($c) { return $c['name']; }, $users)); ?>;
    const etablissement = <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $establisments)); ?>;

    new AutoComplete(document.getElementById('recruteur'), recruteur);
    new AutoComplete(document.getElementById('etablissement'), etablissement);
</script>
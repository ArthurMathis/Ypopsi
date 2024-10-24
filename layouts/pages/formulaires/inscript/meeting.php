<form method="post" action="index.php?candidates=inscript-meeting&key_candidate=<?= $key_candidate; ?>">
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <p>Entretien</p>
        <div class="autocomplete">
            <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur" autocomplete="off" value="<?= $_SESSION['user_identifier']; ?>">
            <article></article>
        </div>
        <div class="autocomplete">
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off" value="<?= $user_establishment ?>">
            <article></article>
        </div>
    </section>
    <section class="double-items">
        <div class="input-container">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" min="<?= Moment::currentMoment()->getDate(); ?>">
        </div>
        <div class="input-container">
            <label for="time">Horaire</label>
            <input type="time" name="time" id="time">
        </div>
    </section>
    <button type="submit" value="new_user">Enregistrer</button>
</form>

<script>
    const recruteur = <?php echo json_encode(array_map(function($c) { return $c['name']; }, $users)); ?>;
    const etablissement = <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $establisments)); ?>;

    new AutoComplete(document.getElementById('recruteur'), recruteur);
    new AutoComplete(document.getElementById('etablissement'), etablissement);
</script>
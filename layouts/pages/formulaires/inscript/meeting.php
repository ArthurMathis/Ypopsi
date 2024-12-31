<form method="post" action="index.php?candidates=inscript-meetings&key_candidate=<?= $key_candidate; ?>">
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <p>Entretien</p>
        <div class="autocomplete">
            <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur" autocomplete="off" value="<?= $_SESSION['user_name'] . " " . $_SESSION['user_firstname']; ?>">
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

<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs"; 
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('recruteur'), <?php echo json_encode(array_map(function($c) { return ['text' => $c['name'], 'key' => $c['id']]; }, $users)); ?>);                                                                                                                                                                                                                                                  
    new AutoComplete(document.getElementById('etablissement'), <?php echo json_encode(array_map(function($c) { return ['text' => $c['Titled'], 'key' => $c['Id']]; }, $establisments)); ?>);

    // On gère l'émission des données
    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
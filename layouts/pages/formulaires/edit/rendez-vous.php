<form method="post" action="index.php?candidats=update-rendez-vous&cle_candidat=<?= $cle_candidat; ?>&cle_utilisateur=<?= $cle_utilisateur; ?>&cle_instant=<?= $cle_instant; ?>">
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <p>Entretien</p>
        <div class="autocomplete">
            <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur" autocomplete="off" value="<?= $item['Recruteur']; ?>">
            <article></article>
        </div>
        <div class="autocomplete">
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off" value="<?= $item['Etablissement']; ?>">
            <article></article>
        </div>
    </section>
    <section class="double-items">
        <div class="input-container">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="<?= $item['Date']; ?>" min="<?php echo Instants::currentInstants()->getDate(); ?>">
        </div>
        <div class="input-container">
            <label for="time">Horaire</label>
            <input type="time" name="time" id="time" value="<?= $item['Horaire']; ?>">
        </div>
    </section>
    <button type="submit" value="new_user">Enregistrer</button>
</form>

<script>
    console.log('On lance la récupération des tableaux PHP.');  

    // On récupère la liste des utilisateurs depuis PHP
    const recruteur = <?php echo json_encode(array_map(function($c) {
        return $c['Identifiant_Utilisateurs'];
    }, $utilisateur)); ?>;
    console.log(recruteur);

    // On récupère la liste des établissements depuis PHP
    const etablissement = <?php echo json_encode(array_map(function($c) {
        return $c['Intitule_Etablissements'];
    }, $etablissement)); ?>;
    console.log(etablissement);

    new AutoComplete(document.getElementById('recruteur'), recruteur);
    new AutoComplete(document.getElementById('etablissement'), etablissement);
</script>
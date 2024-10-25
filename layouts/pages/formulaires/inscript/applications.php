<form class="small-form" method="post" action="index.php?applications=inscript-applications">
    <h3>Saisissez les informations de la candidature</h3>
    <section>
        <p>Emploi</p>
        <div class="autocomplete">
            <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off">
            <article></article>
        </div>
        <div class="autocomplete">
            <input type="text" id="service" name="service" placeholder="Services" autocomplete="off">
            <article></article>
        </div>
        <div class="autocomplete">
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissements" autocomplete="off">
            <article></article>
        </div>
    </section>
    <section>
        <p>Infos</p>
        <div class="autocomplete">
            <input type="text" id="type_de_contrat" name="type_de_contrat" placeholder="Type de contrat" autocomplete="off">
            <article></article>
        </div>
        <input type="Date" id="disponibilite" name="disponibilite" min="<?php echo Moment::currentMoment()->getDate(); ?>">
        <div class="autocomplete">
            <input type="text" id="source" name="source" placeholder="Sources" autocomplete="off">
            <article></article>
        </div>
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>

<script>
    new AutoComplete(document.getElementById('poste'), <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $job)); ?>);
    new AutoComplete(document.getElementById('service'), <?php echo json_encode(array_map(function($c) {  return $c['titled'];  }, $service)); ?>);
    new AutoComplete(document.getElementById('etablissement'), <?php echo json_encode(array_map(function($c) {  return $c['titled'];  }, $establishment)); ?>);
    new AutoComplete(document.getElementById('type_de_contrat'), <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $typeOfContract)); ?>);
    new AutoComplete(document.getElementById('source'), <?php echo json_encode(array_map(function($c) { return $c['titled']; }, $source)); ?>);
</script>
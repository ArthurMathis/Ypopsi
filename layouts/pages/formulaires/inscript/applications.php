<form class="big-form" method="post" action="index.php?applications=inscript-applications">
    <div class="form-container">
        <h3>Saisissez les informations de la candidature</h3>
        <section>
            <div class="input-container">
                <p>Poste *</p>
                <div class="autocomplete">
                    <input type="text" id="poste" name="poste" placeholder="AGENT ADMINISTRATIF" autocomplete="off">
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Service</p>
                <div class="autocomplete">
                    <input type="text" id="service" name="service" placeholder="ACCUEIL-STANDARD" autocomplete="off">
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Etablissement</p>
                <div class="autocomplete">
                    <input type="text" id="etablissement" name="etablissement" placeholder="Clinique du Diaconat Roosevelt" autocomplete="off">
                    <article></article>
                </div>
            </div>
        </section>
        <section>
            <div class="input-container">
                <p>Type de contrat</p>
                <div class="autocomplete">
                    <input type="text" id="type_de_contrat" name="type_de_contrat" placeholder="CDI" autocomplete="off">
                    <article></article>
                </div>
            </div>
            <div class="input-container">
                <p>Disponibilité *</p>
                <input type="Date" id="disponibilite" name="disponibilite" min="<?php echo Moment::currentMoment()->getDate(); ?>">
            </div>
            <div class="input-container">
                <p>Source *</p>
                <div class="autocomplete">
                    <input type="text" id="source" name="source" placeholder="HelloWork" autocomplete="off">
                    <article></article>
                </div>
            </div>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </div>
</form>

<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs"; 
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('poste'), <?= json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $job)); ?>);
    new AutoComplete(document.getElementById('service'), <?php echo json_encode(array_map(function($c) {  return ['text' => $c['text'], 'key' => $c['id']];  }, $service)); ?>);
    new AutoComplete(document.getElementById('etablissement'), <?php echo json_encode(array_map(function($c) {  return ['text' => $c['text'], 'key' => $c['id']];  }, $establishment)); ?>);
    new AutoComplete(document.getElementById('type_de_contrat'), <?php echo json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $typeOfContract)); ?>);
    new AutoComplete(document.getElementById('source'), <?php echo json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $source)); ?>);

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
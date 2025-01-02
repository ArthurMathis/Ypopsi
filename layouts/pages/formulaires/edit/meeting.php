<?php $editable = time() < strtotime($item['date'] . ' ' . $item['heure']); ?>
<form class="big-form" method="post" action="index.php?candidates=update-meetings&key_meeting=<?= $meeting['key_meeting']; ?>&key_candidate=<?= $meeting['key_candidate']; ?>">
    <div class="form-container">
    <h3>Saissisez les informations du rendez-vous</h3>
        <section>
            <p>Entretien</p>
            <div class="autocomplete">
                <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur" autocomplete="off" value="<?= $meeting['Recruteur']; ?>" <?php if(!$editable) echo "readonly"; ?>>
                <article></article>
            </div>
            <div class="autocomplete">
                <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off" value="<?= $meeting['Etablissement']; ?>"  <?php if(!$editable) echo "readonly"; ?>>
                <article></article>
            </div>
        </section>
        <section class="double-items" <?php if(!$editable): ?> style="display: none" <?php endif ?>>
            <div class="input-container">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?= $meeting['Date']; ?>" <?php if($editable): ?> min="<?= Moment::currentMoment()->getDate(); ?>" <?php endif ?>>
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

<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs";
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs";
    
    const recruteur = <?php echo json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $users)); ?>;
    const etablissement = <?php echo json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $establisments)); ?>;

    new AutoComplete(document.getElementById('recruteur'), recruteur);
    new AutoComplete(document.getElementById('etablissement'), etablissement);

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
<form class="small-form" method="post" action="index.php?preferences=inscript-services">
    <h3>Saissez les informations du service</h3>
    <section>
        <p>Informations relatives à la fondation</p>
        <input type="text" id="service" name="service" placeholder="Service">
        <div class="autocomplete">
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement">
            <article></article>
        </div>
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>
<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs";
    new AutoComplete(document.getElementById('etablissement'), AutoComplete.arrayToSuggestions(<?= json_encode($etablissements) ?>));
</script>
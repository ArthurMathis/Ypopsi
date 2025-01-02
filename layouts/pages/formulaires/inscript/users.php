<form class="big-form" method="post" action="index.php?preferences=get-inscript-users">
    <div class="form-container">
        <h3>Saissiez les informations du nouvel utilisateurs</h3>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="text" id="email" name="email" placeholder="Adresse mail">
        </section>
        <section>
            <p>Statut</p>
            <div class="autocomplete">
                <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off">
                <article></article>
            </div>
            <select name="role">
                <?php foreach($roles as $r): ?>
                    <option value="<?= $r['id']; ?>">
                        <?= $r['titled']; ?>
                    </option>
                <?php endforeach ?>    
            </select>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </div>
</form>
<script type="module">
    import { AutoComplete } from "./layouts/assets/scripts/modules/AutoComplete.mjs";
    new AutoComplete(document.getElementById('etablissement'), AutoComplete.arrayToSuggestions(<?= json_encode($etablissements) ?>));
</script>
<form class="big-form" method="post" action="index.php?applications=inscript-candidates">
    <div class="form-container">
        <h3>Nouveau candidat</h3>
        <section>
            <div class="input-container">
                <p>Nom *</p>
                <input type="text" id="nom" name="nom" placeholder="Dupond">
            </div>
            <div class="input-container">
                <p>Prénom *</p>
                <input type="text" id="prenom" name="prenom" placeholder="Jean">
            </div>
            <div class="input-container">
                <p>Civilité *</p>
                <select id="genre" name="genre">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>    
            </div>
        </section>
        <section>
            <div class="input-container">
                <p>Adresse email</p>
                <input type="email" id="email" name="email" placeholder="jean.dupond@example.com">
            </div>
            <div class="input-container">
                <p>Numéro de téléphone</p>
                <input type="tel" id="telephone" name="telephone" placeholder="06.12.34.57.89">
            </div>
        </section>
        <section>
            <div class="input-container">
                <p>Adresse</p>
                <input type="text" id="adresse" name="adresse" placeholder="1er Grand Rue">
            </div>
            <div class="double-items">
                <div class="input-container">
                    <p>Commune</p>
                    <input type="text" id="ville" name="ville" placeholder="Colmar">
                </div>
                <div class="input-container">
                    <p>Code postal</p>
                    <input type="number" id="code-postal" name="code-postal" placeholder="68000">
                </div>
            </div>
        </section>
        <section id='diplome-section' class="imp-section">
            <p>Diplômes</p>
            <button class="form_button" type="button">
                <img src="layouts\assets\img\logo\blue\add.svg" alt="">
            </button>
        </section>
        <section id='aide-section' class="imp-section">
            <parse_str>Aides au recrutement</parse_str>
            <button class="form_button" type="button">
                <img src="layouts\assets\img\logo\blue\add.svg" alt="">
            </button>
        </section>
        <section id='visite-section' class="imp-section">
            <p>Visite médicale</p>
            <input id="viste_medicale" name="viste_medicale" type="date" min="<?= date('Y-m-d'); ?>">
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div> 
</form>

<script type="module">
    import { formManipulation } from "./layouts/assets/scripts/modules/FormManipulation.mjs";

    document.addEventListener('elementCreated', function(e) {
        if(e.detail.element.parentNode === document.getElementById('aide-section')) {
            const aideSection = document.getElementById('aide-section');
            const inputAide = aideSection.querySelectorAll('select');
            
            const obj = new formManipulation.cooptInput(inputAide[inputAide.length - 1], 'coopteur', 3, <?= json_encode($employer); ?>); // 3 -> Id 
            obj.input.addEventListener('change', (e) => obj.react());
        }
    });

    new formManipulation.implementInputAutoCompleteDate('diplome', 'diplome-section', <?= json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $diplome)); ?>, 'Licence', <?= count($diplome); ?>, null); 
    new formManipulation.implementInputList('aide', 'aide-section', <?= json_encode(array_map(function($c) { return ['text' => $c['text'], 'key' => $c['id']]; }, $aide)); ?>, <?= count($aide); ?>);

    document.querySelector('form').addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
<form 
    class="big-form" 
    method="post" 
    action="<?= APP_PATH ?>/candidates<?= $action_method ?>"
>
    <div class="form-container">
        <h3>
            Nouveau candidat
        </h3>

        <section>
            <div class="input-container">
                <label for="name">
                    Nom *
                </label>

                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Dupond"
                    required
                >
            </div>

            <div class="input-container">
                <label for="firstname">
                    Prénom *
                </label>

                <input 
                    type="text" 
                    id="firstname" 
                    name="firstname" 
                    placeholder="Jean"
                    required
                >
            </div>

            <div class="input-container">
                <label for="gender">
                    Civilité *
                </label>

                <select 
                    id="gender" 
                    name="gender"
                >
                    <option 
                        value="1" 
                        selected
                    >
                        Homme
                    </option>

                    <option 
                        value="0"
                    >
                        Femme
                    </option>
                </select>    
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="email">
                    Adresse email
                </label>

                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="jean.dupond@example.com"
                >
            </div>

            <div class="input-container">
                <label for="phone">
                    Numéro de téléphone
                </label>
                
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    placeholder="06.12.34.57.89"
                >
            </div>
        </section>

        <section>
            <div class="input-container">
                <label for="address">
                    Adresse
                </label>

                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                    placeholder="1er Grand Rue"
                >
            </div>

            <div class="double-items">
                <div class="input-container">
                    <label for="city">
                        Commune
                    </label>

                    <input 
                        type="text" 
                        id="city" 
                        name="city" 
                        placeholder="Colmar"
                    >
                </div>

                <div class="input-container">
                    <label for="postcode">
                        Code postal
                    </label>

                    <input 
                        type="number" 
                        id="postcode" 
                        name="postcode" 
                        placeholder="68000"
                    >
                </div>
            </div>
        </section>

        <section
            id='qualifications-section' 
            class="imp-section"
        >
            <label>
                Diplômes
            </label>

            <button 
                class="form_button" 
                type="button"
            >
                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\logo\blue\add.svg" 
                    alt=""
                >
            </button>
        </section>

        <section 
            id='helps-section' 
            class="imp-section"
        >
            <label>
                Aides au recrutement
            </label>
            
            <button 
                class="form_button" 
                type="button"
            >
                <img 
                    src="<?= APP_PATH ?>\layouts\assets\img\logo\blue\add.svg" 
                    alt=""
                >
            </button>
        </section>

        <section 
            id='visite-section' 
            class="imp-section"
        >
            <label>
                Visite médicale
            </label>

            <input 
                id="visite_medicale" 
                name="visite_medicale" 
                type="date" 
                min="<?= date('Y-m-d'); ?>"
            >
        </section>

        <div class="form-section">
            <button 
                class="action_button grey_color"
                type="button"
                onclick="window.history.back()"
            >
                Annuler
            </button>

            <button 
                type="submit" 
                class="submit_button" 
                value="<?= $action_value ?>"
            >
                Enregistrer
            </button>
        </div>
    </div> 
</form>

<script type="module">
    import { AutoComplete } from "<?= APP_PATH  ?>\\layouts\\scripts\\modules/AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules/FormManipulation.mjs";

    document.addEventListener('elementCreated', function(e) {
        if(e.detail.element.parentNode === document.getElementById('aide-section')) {
            const aideSection = document.getElementById('aide-section');
            const inputAide = aideSection.querySelectorAll('select');
            
            const obj = new formManipulation.cooptInput(
                inputAide[inputAide.length - 1], 
                'employee', 
                3,                                                                                              // 3 -> Id 
                <?= json_encode($employee_list); ?>
            ); 
            obj.input.addEventListener('change', (e) => obj.react());
        }
    });

    new formManipulation.implementInputAutoCompleteDate(
        'qualifications', 
        'qualifications-section', 
        AutoComplete.arrayToSuggestions(<?= json_encode($qualifications_list) ?>), 
        'Licence', 
        <?= count($qualifications_list); ?>, 
        null
    ); 
    new formManipulation.implementInputList(
        'helps', 
        'helps-section', 
        AutoComplete.arrayToSuggestions(<?= json_encode($helps_list) ?>), 
        <?= count($helps_list); ?>
    );

    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
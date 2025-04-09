<form
    class="small-form"
    method="post"
    action="<?= APP_PATH ?>/preferences/users/profile/update/<?= $user->getId() ?>"
>
    <h3>
        <?php if(!$completed): ?>
            Nouvel utilisateur
        <?php else: ?>
            Mise à jour de <?= $user->getCompleteName() ?>
        <?php endif ?>
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

                <?php if($completed): ?>
                    value="<?= $user->getName() ?>"
                <?php endif ?>
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

                <?php if($completed): ?>
                    value="<?= $user->getFirstname() ?>"
                <?php endif ?>
            >
        </div>

        <div class="input-container">
            <label for="email">
                Email *
            </label>

            <input 
                type="text" 
                id="email" 
                name="email" 
                placeholder="jean.dupond@diaconat-mulhouse.fr""
                required

                <?php if($completed): ?>
                    value="<?= $user->getEmail() ?>"
                <?php endif ?>
            >
        </div>
    </section>

    <section>
        <div class="input-container">
            <label for="establishment">
                Etablissement *
            </label>

            <div class="autocomplete">
                <input 
                    type="text" 
                    id="establishment" 
                    name="establishment" 
                    placeholder="Clinique du Diaconat Roosevelt" 
                    autocomplete="off"
                    required

                    <?php if($completed): ?>
                        value="<?= $establishment->getTitled() ?>"
                    <?php endif ?>
                >

                <article></article>
            </div>
        </div>

        <div class="input-container">
            <label for="role">
                Rôle *
            </label>

            <select id="role" name="role" required>
                <?php foreach($role_list as $obj): ?>
                    <option 
                        value="<?= $obj->getId() ?>"
                        <?php if($completed && $user->getRole() == $obj->getId()): ?>
                            selected
                        <?php endif ?>
                    >
                        <?= $obj->getTitled() ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </section>

    <div class="form-section">
        <button 
            class="action_button grey_color"
            type="button"
            onclick="window.history.back()"
        >
            <p>Annuler</p>

            <img
                src="<?= APP_PATH ?>\layouts\assets\img\arrow\left\black.svg"
                alt="Annuler"
            >
        </button>

        <button 
            type="submit" 
            class="action_button reverse_color"
            value="<?= $completed ? 'update_user' : 'new_user' ?>"
        >
            <p>Enregistrer</p>
            
            <img
                src="<?= APP_PATH ?>\layouts\assets\img\save\white.svg"
                alt="Enregistrer"
            >
        </button>
    </div>
</form>

<script type="module">
    import { AutoComplete } from "<?= APP_PATH  ?>\\layouts\\scripts\\modules/AutoComplete.mjs"; 
    import { formManipulation } from "<?= APP_PATH ?>\\layouts\\scripts\\modules/FormManipulation.mjs";

    new AutoComplete(document.getElementById('establishment'), AutoComplete.arrayToSuggestions(<?= json_encode($establishments_list) ?>));
    document.querySelector('form')
            .addEventListener('submit', (e) => formManipulation.manageSubmit(e));
</script>
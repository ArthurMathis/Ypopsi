<form 
    class="small-form" 
    method="POST" 
    action="<?= APP_PATH ?>/prefrences/xlsxLoader/import"
>
    <h3>
        Importation de données
    </h3>

    <div class="input-container">
        <i>Le fichier doit être situé dans le dossier Ypopi ou un de ces enfant et seul les fichiers de type : <b><?= $accepted_files ?></b> sont pris en charge.</i>
    </div>

    <div class="input-container">
        <label for="file">
            Choisissez le fichier source
        </label>

        <input 
            type="text" 
            name="file" 
            id="file" 
            placeholder="./database/assets/file.xlsx" 
            required
        >
    </div>

    <div class="form-section">
        <button 
            class="action_button grey_color" 
            type="button" 
            onclick="window.history.back()"
        >
            <p>
                Annuler
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\arrow\left\black.svg" 
                alt="Annuler"
            >
        </button>

        <button 
            class="action_button reverse_color" 
            type="button" 
            onclick="showConfirmation()"
        >
            <p>
                Importer 
            </p>

            <img 
                src="<?= APP_PATH ?>\layouts\assets\img\save\white.svg" 
                alt="Télécharger"
            >
        </button>
    </div>
</form>

<script>
    const showConfirmation = () => {
        const form = document.querySelector('form');

        if (form.checkValidity()) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous êtes sur le point d'importer un fichier. Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, importer !',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup  : 'notification',
                    title  : 'notification-title',
                    content: 'notification-content',
                    confirmButton: 'action_button reverse_color',
                    cancelButton: 'action_button cancel_button',
                    actions: 'notification-actions',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    Swal.fire({
                        title: 'Annulé',
                        text: 'Aucune modification n\'a été apportée.',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup  : 'notification',
                            title  : 'notification-title',
                            content: 'notification-content',
                            confirmButton: 'action_button reverse_color',
                            cancelButton: 'action_button cancel_button',
                            actions: 'notification-actions',
                        }   
                    });
                }
            });
        } else {
            form.reportValidity();
        }
    }
</script>
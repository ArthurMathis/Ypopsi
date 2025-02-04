<div>
    <header>
        <h2><?php echo strtoupper($items['user']['name']) . " " . FormsManip::nameFormat($items['user']['firstname']); ?></h2>
        <p><?php echo FormsManip::nameFormat($items['user']['titled_role']);?></p>
    </header>
    <content>
    <div class="container">
            <p>Etablissement : </p>
            <p><?= $items['user']['establishments']; ?></p>
        </div>
        <div class="container">
            <p>Email :</p>
            <p><?= $items['user']['email']; ?></p>
        </div>
    </content>
    <footer>
        <?php if($items['user']['role'] > $_SESSION['user_key']): ?>
            <a class="action_button grey_color" href="index.php?preferences=display-reset-password&user_key=<?= $items['user']['id']; ?>">
                <p>Réinitialiser le mot de passe</p>
                <img src="layouts\assets\img\logo\reset.svg" alt="">
            </a>
        <?php endif ?>
        <?php if($_SESSION['user_key'] <= ADMIN || $items['user']['id'] == $_SESSION['user_key']): ?>
                <a class="action_button reverse_color" href="index.php?preferences=edit-users&user_key=<?= $items['user']['id']; ?>">
                    <p>Modifier</p>
                    <img src="layouts\assets\img\logo\white\edit.svg" alt="">
                </a>
            <?php endif ?>
    </footer>
</div>
<?php if($_SESSION['user_role'] != INVITE): ?>
    <a href="<?php if(isset($link)) echo $link; ?>" class="action_button reverse_color add_button">
        <p>Ajouter</p>
        <img src="layouts\assets\img\logo\white-plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
    </a>
<?php endif ?>
<?php 

use App\Core\Middleware\AuthMiddleware;

?>

<?php if(AuthMiddleware::isUserOrMore()): ?>
    <a href="<?php if(isset($link)) echo $link; ?>" class="action_button reverse_color add_button">
        <p>Ajouter</p>
        <img src="<?= APP_PATH ?>\layouts\assets\img\logo\white-plus.svg" alt="">
    </a>
<?php endif ?>
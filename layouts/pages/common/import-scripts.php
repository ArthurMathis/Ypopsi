<?php if(!empty($scripts)): ?>
    <?php foreach($scripts as $s) : ?>
        <script type="module" src="<?= SCRIPTS.DS.$s; ?>"></script>
    <?php endforeach ?>
<?php endif ?>
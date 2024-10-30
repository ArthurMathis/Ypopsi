<?php if(!empty($scripts)): ?>
    <?php foreach($scripts as $s) : ?>
        <script type="module" src="<?= JAVASCRIPT.DS.$s; ?>"></script>
    <?php endforeach ?>
<?php endif ?>
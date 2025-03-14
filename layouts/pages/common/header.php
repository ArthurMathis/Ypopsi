<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($name) && !empty($name)) echo $name; else echo 'Diaconat - Ypopsi'; ?></title>

    <!-- On ajoute le logo de l'application -->
    <link rel="icon" href="<?= APP_PATH ?>/layouts/assets/img/ypopsi/blue.svg">

    <!-- Inclusion des feuilles de style -->
    <link rel="stylesheet" href="<?= APP_PATH ?>/layouts/stylesheet/styles.css">
    <?php if (!empty($cssFiles)) foreach ($cssFiles as $file) echo '<link rel="stylesheet" href="' . APP_PATH . '/' . $file . '">'; ?>

    <!-- Bibliothèque JS pour la gestion des notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<form method="post" action="index.php?preferences=update-users&user_key=<?= $user['id']; ?>">
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <p>Informations personnelles</p>
        <input type="text"  id="nom"    name="nom"      Placeholder="Nom"       value="<?= $user['name'] ?>">
        <input type="text"  id="prenom" name="prenom"   Placeholder="Prénom"    value="<?= $user['firstname'] ?>">
        <input type="email" id="email"  name="email"    Placeholder="Email"     value="<?= $user['email'] ?>">
    </section>
    <section>
        <p>Rôle</p>
        <select if="role" name="role">
            <?php foreach($role as $r): ?>
                <option value="<?= $r['id']; ?>" <?php if($user['role'] == $r['id']) echo 'selected'; ?>><?= $r['titled']; ?></option>
            <?php endforeach ?>    
        </select>
    </section>
    <button type="submit" value="new_user">Enregistrer</button>
</form>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Administration : Membres</h1>
        <nav><a href="/">Retour Accueil</a></nav>
    </header>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Nom / Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <form action="/admin-users" method="POST">
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                        <input type="hidden" name="action" value="update">
                        <tr>
                            <td>
                                <img src="/uploads/profiles/<?= $u['image'] ?>" class="avatar-sm">
                            </td>
                            <td>
                                <input type="text" name="nom" value="<?= $u['nom'] ?>">
                                <input type="text" name="prenom" value="<?= $u['prenom'] ?>">
                            </td>
                            <td><input type="email" name="mail" value="<?= $u['mail'] ?>"></td>
                            <td><select name="role" class="form-select">
                                        <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="modo" <?= $u['role'] == 'modo' ? 'selected' : '' ?>>Modo</option>
                                        <option value="user" <?= $u['role'] == 'user' ? 'selected' : '' ?>>User</option>

                                    </select></td>
                            <td>
                                <button type="submit">Modifier</button>
                                <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                                    <a href="/admin-users?delete=<?= $u['id'] ?>"
                                        style="color:red;"
                                        onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                                <?php else: ?>
                                    (Moi)
                                <?php endif; ?>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
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
                    <tr>
                        <td style="text-align:center;"><img src="/uploads/profiles/<?= $u['image'] ?>" class="avatar-sm"></td>
                        <td><?= htmlspecialchars($u['nom'] . " " . $u['prenom']) ?></td>
                        <td><?= htmlspecialchars($u['mail']) ?></td>
                        <td><strong><?= htmlspecialchars($u['role']) ?></strong></td>
                        <td style="text-align:center;">
                            <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                                <a href="/admin-users?delete=<?= $u['id'] ?>" 
                                   style="color:red;" 
                                   onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                            <?php else: ?>
                                (Moi)
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
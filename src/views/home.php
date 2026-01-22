<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Mini Réseau Social</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Mini-RS</h1>
        <nav>
            <?php if (isset($_SESSION['user'])) : ?>
                <a href="/profil" class="user-pill">
                    <img src="/uploads/profiles/<?= $_SESSION['user']->getImage() ?>" class="avatar-lg">
                    <span><?= htmlspecialchars($_SESSION['user']->getPrenom()) ?></span>
                </a>
                <?php if ($_SESSION['user']->getRole() === 'admin'): ?>
                    <a href="/admin-users" class="btn-admin">Administration</a>
                <?php endif; ?>
                <a href="/deconnexion" class="btn-danger">Déconnexion</a>
            <?php else : ?>
                <a href="/connexion">Connexion</a>
                <a href="/inscription" class="btn-primary">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['user'])) : ?>
            <section class="post-form">
                <h3>Quoi de neuf, <?= $_SESSION['user']->getPrenom() ?> ?</h3>
                <form action="/" method="POST">
                    <input type="text" name="title" placeholder="Titre de votre post" required>
                    <textarea name="content" placeholder="Exprimez-vous..." required></textarea>
                    <button type="submit" class="btn-primary">Publier</button>
                </form>
            </section>
        <?php endif; ?>

        <section class="feed">
            <?php foreach ($posts as $post) : ?>
                <article class="post">
                    <div class="post-header">
                        <img src="/uploads/profiles/<?= $post->getUserImage() ?>" class="avatar-md">
                        <div class="post-info">
                            <strong><?= $post->getUserPrenom() ?></strong>
                            <div class="post-actions">
                                <?php 
                                $isOwner = (isset($_SESSION['user']) && $_SESSION['user']->getId() == $post->getIdUser());
                                $isAdminOrModo = (isset($_SESSION['user']) && ($_SESSION['user']->getRole() === 'admin' || $_SESSION['user']->getRole() === 'modo'));
                                
                                if ($isOwner): ?>
                                    <a href="/edit-post?id=<?= $post->getId() ?>" class="btn-edit">Modifier</a>
                                <?php endif; ?>

                                <?php if ($isOwner || $isAdminOrModo): ?>
                                    <a href="/delete-post?id=<?= $post->getId() ?>" class="btn-delete" onclick="return confirm('Supprimer ce post définitivement ?')">Supprimer</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="post-content">
                        <h3><?= $post->getTitle() ?></h3>
                        <p><?= $post->getContent() ?></p>
                    </div>

                    <div class="comments-section">
                        <h5>Commentaires</h5>
                        <?php foreach ($post->comments as $comment): ?>
                            <div class="comment <?= $comment['parent_id'] ? 'is-reply' : '' ?>">
                                <div class="comment-header">
                                    <img src="/uploads/profiles/<?= $comment['image'] ?>" class="avatar-sm">
                                    <strong><?= $comment['prenom'] ?></strong>
                                </div>
                                
                                <p><?= $comment['content'] ?></p>
                                
                                <div class="comment-actions">
                                    <?php if (isset($_SESSION['user'])): ?>
                                        <button onclick="toggleReply(<?= $comment['id'] ?>)">Répondre</button>
                                        
                                        <?php if ($_SESSION['user']->getId() == $comment['id_user'] || $_SESSION['user']->getRole() !== 'user'): ?>
                                            <a href="/delete-comment?id=<?= $comment['id'] ?>" class="btn-delete-small" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <form action="/add-comment?id=<?= $post->getId() ?>" method="POST" id="reply-<?= $comment['id'] ?>" class="reply-form" style="display:none;">
                                    <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                                    <textarea name="content" placeholder="Répondre..." required></textarea>
                                    <button type="submit">Envoyer</button>
                                </form>
                            </div>
                        <?php endforeach; ?>

                        <?php if (isset($_SESSION['user'])): ?>
                            <form action="/add-comment?id=<?= $post->getId() ?>" method="POST" class="main-comment-form">
                                <textarea name="content" placeholder="Écrire un commentaire..." required></textarea>
                                <button type="submit">Commenter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>

    <script>
        function toggleReply(id) {
            const f = document.getElementById('reply-' + id);
            f.style.display = (f.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
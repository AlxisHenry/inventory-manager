<?php include '../index.php'; ?>

<section class="section form-section user-section">
    <div class="form-section-card">
        <div class="card-action">
            <div class="new">
                <div class="refresh-database">
                    <i class="fa-solid fa-rotate"></i> <span>Rafraîchir la liste</span>
                </div>
            </div>
            <div class="exist config-active-action">
                Tous les utilisateurs
            </div>
        </div>
        <?php
        $query = connectPdo()->query('SELECT * FROM `utilisateurs` WHERE id > 0;');
        if ($query->fetchColumn()) {
            include COMPONENTS . '/all-users.php';
        } else {
            include COMPONENTS . '/users-not-found.php';
        }
        $query->closeCursor();
        ?>
    </div>

</section>

<script type="module" src="<?= DOMAIN . "/js/pages/users.js" ?>"></script>

</body>

</html>
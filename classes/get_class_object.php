<?php

spl_autoload_register('loadClass');

function loadClass($class) {
    if (file_exists(ROOT . '/classes/' . $class . '.class.php')) {
        require_once ROOT . '/classes/' . $class . '.class.php';
    } else {
        if (file_exists(ROOT . '/parc/classes/' . $class . '.class.php')) {
            require_once ROOT . '/parc/classes/' . $class . '.class.php';
        } else {
            echo 'La classe ' . $class . ' n\'a pas été trouvée.';
        }
    }
}

function Access_OBJECT_(string|int $value, string $by):Access {
    $QUERY = getRequest($by, 'Access');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Access::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function Alertes_OBJECT_(string|int $value, string $by):Alertes {
    $QUERY = getRequest($by, 'Alertes');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Alertes::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function Articles_OBJECT_(string|int $value, string $by):Articles|bool {
    $QUERY = getRequest($by, 'Articles');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Articles::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function Centres_OBJECT_(string|int $value, string $by):Centres {
    $QUERY = getRequest($by, 'Centres');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Centres::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function Familles_OBJECT_(string|int $value, string $by):Familles|bool {
    $QUERY = getRequest($by, 'Familles');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Familles::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;

}

function Mouvements_OBJECT_(string|int $value, string $by):Mouvements|bool {
    $QUERY = getRequest($by, 'Mouvements');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Mouvements::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function Utilisateurs_OBJECT_(string|int $value, string $by):Utilisateurs|bool {
    $QUERY = getRequest($by, 'Utilisateurs');
    $QUERY = connectPdo()->prepare($QUERY);
    $QUERY->bindValue(':value', $value, PDO::PARAM_STR|PDO::PARAM_INT);
    $QUERY->execute();
    $QUERY->setFetchMode(PDO::FETCH_CLASS, Utilisateurs::class);
    $RESULT = $QUERY->fetch();
    $QUERY->closeCursor();
    return $RESULT;
}

function getRequest(string|int $by, string $table):string {
    return match ($table) {
        'Access' => match ($by) {
            'username' => "SELECT * FROM `access` WHERE `username`=:value",
            'password' => "SELECT * FROM `access` WHERE `password`=:value",
            'type' => "SELECT * FROM `access` WHERE `type`=:value",
            'derniereConnection' => "SELECT * FROM `access` WHERE `derniereConnection`=:value",
            'status' => "SELECT * FROM `access` WHERE `status`=:value",
            'commentaire' => "SELECT * FROM `access` WHERE `commentaire`=:value",
            'dateCreation' => "SELECT * FROM `access` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `access` WHERE `dateModification`=:value",
            'CreateUser' => "SELECT * FROM `access` WHERE `CreateUser`=:value",
            'EditUser' => "SELECT * FROM `access` WHERE `EditUser`=:value",
            default => "SELECT * FROM `access` WHERE `id`=:value",
        },
        'Alertes' => match ($by) {
            'mail' => "SELECT * FROM `alertes` WHERE `mail`=:value",
            'mailModification' => "SELECT * FROM `alertes` WHERE `mailModification`=:value",
            'menu' => "SELECT * FROM `alertes` WHERE `menu`=:value",
            'menuModification' => "SELECT * FROM `alertes` WHERE `menuModification`=:value",
            'seuil' => "SELECT * FROM `alertes` WHERE `seuil`=:value",
            'seulModification' => "SELECT * FROM `alertes` WHERE `seulModification`=:value",
            default => "SELECT * FROM `alertes` WHERE `id`=:value",
        },
        'Articles' => match ($by) {
            'id' => "SELECT * FROM `articles` WHERE `id`=:value",
            'famille' => "SELECT * FROM `articles` WHERE `famille`=:value",
            'nom' => "SELECT * FROM `articles` WHERE `nom`=:value",
            'commentaire' => "SELECT * FROM `articles` WHERE `commentaire`=:value",
            'code' => "SELECT * FROM `articles` WHERE `code`=:value",
            'localisation' => "SELECT * FROM `articles` WHERE `localisation`=:value",
            'dateCreation' => "SELECT * FROM `articles` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `articles` WHERE `dateModification`=:value",
            'createUser' => "SELECT * FROM `articles` WHERE `createUser`=:value",
            'editUser' => "SELECT * FROM `articles` WHERE `editUser`=:value",
            default => "SELECT * FROM `articles` WHERE `id`=:value",
        },
        'Centres' => match ($by) {
            'code' => "SELECT * FROM `centres` WHERE `code`=:value",
            'commentaire' => "SELECT * FROM `centres` WHERE `commentaire`=:value",
            'dateCreation' => "SELECT * FROM `centres` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `centres` WHERE `dateModification`=:value",
            'createUser' => "SELECT * FROM `centres` WHERE `createUser`=:value",
            'editUser' => "SELECT * FROM `centres` WHERE `editUser`=:value",
            default => "SELECT * FROM `centres` WHERE `id`=:value",
        },
        'Familles' => match ($by) {
            'nom' => "SELECT * FROM `familles` WHERE `nom`=:value",
            'commentaire' => "SELECT * FROM `familles` WHERE `commentaire`=:value",
            'dateCreation' => "SELECT * FROM `familles` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `familles` WHERE `dateModification`=:value",
            'createUser' => "SELECT * FROM `familles` WHERE `createUser`=:value",
            'editUser' => "SELECT * FROM `familles` WHERE `editUser`=:value",
            default => "SELECT * FROM `familles` WHERE `id`=:value",
        },
        'Mouvements' => match ($by) {
            'dateMouvement' => "SELECT * FROM `mouvements` WHERE `dateMouvement`=:value",
            'creator' => "SELECT * FROM `mouvements` WHERE `creator`=:value",
            'type' => "SELECT * FROM `mouvements` WHERE `type`=:value",
            'orderNumber' => "SELECT * FROM `mouvements` WHERE `orderNumber`=:value",
            'quantite' => "SELECT * FROM `mouvements` WHERE `quantite`=:value",
            'article' => "SELECT * FROM `mouvements` WHERE `article`=:value",
            'users' => "SELECT * FROM `mouvements` WHERE `users`=:value",
            'centreDeCout' => "SELECT * FROM `mouvements` WHERE `centreDeCout`=:value",
            'commentaire' => "SELECT * FROM `mouvements` WHERE `commentaire`=:value",
            'dateCreation' => "SELECT * FROM `mouvements` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `mouvements` WHERE `dateModification`=:value",
            'createUser' => "SELECT * FROM `mouvements` WHERE `createUser`=:value",
            'editUser' => "SELECT * FROM `mouvements` WHERE `editUser`=:value",
            default => "SELECT * FROM `mouvements` WHERE `id`=:value",
        },
        'Utilisateurs' => match ($by) {
            'etablissement' => "SELECT * FROM `utilisateurs` WHERE `etablissement`=:value",
            'matricule' => "SELECT * FROM `utilisateurs` WHERE `matricule`=:value",
            'nom' => "SELECT * FROM `utilisateurs` WHERE `nom`=:value",
            'prenom' => "SELECT * FROM `utilisateurs` WHERE `prenom`=:value",
            'centreDeCout' => "SELECT * FROM `utilisateurs` WHERE `centreDeCout`=:value",
            'centreAffection' => "SELECT * FROM `utilisateurs` WHERE `centreAffection`=:value",
            'dateCreation' => "SELECT * FROM `utilisateurs` WHERE `dateCreation`=:value",
            'dateModification' => "SELECT * FROM `utilisateurs` WHERE `dateModification`=:value",
            default => "SELECT * FROM `utilisateurs` WHERE `id`=:value",
        },
        default => false,
    };
}
<?php

spl_autoload_register(function ($className) {
    // Vérifier si la classe existe déjà (classe native ou déjà chargée)
    if (class_exists($className, false)) {
        return;
    }

    // Définir le chemin de base pour les classes
    $baseDir = __DIR__ . '/classes/'; // Assurez-vous que vos classes sont dans un dossier "classes"

    // Générer le chemin du fichier
    $file = $baseDir . $className . '.php';

    // Vérifier si le fichier existe avant de l'inclure
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Ne pas mourir pour des classes non trouvées dans le cadre de classes natives
        error_log("La classe {$className} n'a pas pu être chargée. Fichier manquant : {$file}");
    }
});

?>

<?php
// Récupérer le dossier des photos
$picturesFolder = __DIR__ .'/../../../src/uploads/' . $invoiceDetails[0]['pictures_folder'];
// Chemin public pour afficher les images
$publicBasePath = '/FactureSterna/src/uploads/' . $invoiceDetails[0]['pictures_folder'];

// echo $picturesFolder;
// Vérifier si le dossier existe
if (is_dir($picturesFolder)) {
    // Récupérer les fichiers du dossier
    $pictures = array_diff(scandir($picturesFolder), array('.', '..'));
    
    // Filtrer uniquement les images (par extension)
    //$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    /*$pictures = array_filter($pictures, function ($file) use ($picturesFolder, $allowedExtensions) {
        $filePath = $picturesFolder . '/' . $file;
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return is_file($filePath) && in_array($fileExtension, $allowedExtensions);
    });*/

    // Afficher les colonnes dans le tableau
    if (!empty($pictures)) {
        echo '<tr>';

        // Si une seule photo, occuper toute la largeur
        if (count($pictures) === 1) {
            echo '<tr>'; 
            echo '<td colspan="4" style="text-align: center;">';
            $filePath = $publicBasePath  . '/' . reset($pictures);
            echo '<img src="' . htmlspecialchars($filePath) . '" alt="Photo" style="max-width: 300px; height: auto;">';
            echo '</td>';
            echo '</tr>'; // Fin de la ligne
        } else {
            // Afficher plusieurs colonnes pour chaque photo
            foreach ($pictures as $picture) {
                $filePath = $publicBasePath  . '/' . $picture;
                echo '<tr>'; // Début d'une ligne
                echo '<td style="text-align: center; padding: 10px;">';
                echo '<img src="' . htmlspecialchars($filePath) . '" alt="Photo" style="max-width: 300px; height: auto;">';
                echo '</td>';
                echo '</tr>'; // Fin de la ligne
            }
        }

        echo '</tr>';
    } else {
        echo '<tr><td colspan="4" style="text-align: center;">Aucune photo disponible</td></tr>';
    }
} else {
    echo '<tr><td colspan="4" style="text-align: center;">Dossier introuvable </td></tr>' . $publicBasePath  ;
}
?>

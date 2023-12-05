<?php
include('../connect.php'); // Inclure le fichier de connexion à la base de données
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['num_trajet'])) {
    // Collecter les données du formulaire
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];
    $num_trajet = $_GET['num_trajet'];

    // Préparer la requête SQL pour insérer le escale
    $query = "INSERT INTO ESCALE (NUM_TRAJET, ADRESSE, CODE_POSTAL) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    // Associer les valeurs et exécuter la requête
    $stmt->bind_param("isi", $num_trajet, $adresse, $code_postal);
    if ($stmt->execute()) {
        header("Refresh:1; url=ajout_escale.php?num_trajet=$num_trajet");
        echo "Nouvelle escale ajoutée avec succès! Redirection en cours...";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
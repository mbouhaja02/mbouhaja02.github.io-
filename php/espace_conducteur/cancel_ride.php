<?php
include('../../connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if num_trajet is set and not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num_trajet'])) {
    // Sanitize the input to prevent SQL injection
    $num_trajet = $_POST['num_trajet'];
    
    // Prompt a confirmation before deletion
    $confirm_delete = isset($_POST['confirm_delete']) ? $_POST['confirm_delete'] : null;

    if ($confirm_delete === 'yes') {
        // Perform a database query based on the ride number
        $query1 = "DELETE FROM TRAJET WHERE NUM_TRAJET = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("i", $num_trajet);
        
        if ($stmt1->execute()) {
            header("Refresh:1; url=info_vehicule.php");
            echo "Trajet correctement supprimée. Attention, toutes les informations en relation avec ce trajet ont été supprimées.";
        } else {
            echo "Erreur lors de l'exécution de la requête 1";
        }
        // Close statement 1
        $stmt1->close();
    } else if ($confirm_delete === 'no') {
        header("Refresh:1; url=mes_trajets.php");
        // Backtrack or handle the situation if user chooses "No"
        echo "Suppression annulée. Le trajet n'a pas été supprimée.";
    } else {
        // Display a confirmation message
        echo '<form method="post" action="">
            <input type="hidden" name="num_trajet" value="' . $num_trajet . '">
            <input type="hidden" name="confirm_delete" value="yes">
            <p>Are you sure you want to delete this ride? All related information will also be deleted.</p>
            <button type="submit">Yes, Delete</button>
            <button type="submit" name="confirm_delete" value="no">No, Cancel</button>
        </form>';
    }
}
?>

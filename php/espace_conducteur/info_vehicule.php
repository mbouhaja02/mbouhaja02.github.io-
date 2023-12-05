<!DOCTYPE html>
<html>
<head>
    <title>Driver Space - Manage Car and Rides</title>
    <!-- Add your CSS or external stylesheet links here -->
    <link rel="stylesheet" type="text/css" href="../../css/esp_conducteur.css">
    <script>
        function fetchResultsFromDB() {
            var num_etudiant = document.getElementById('num_etudiant').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("results").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "fetch_info_vehicule.php?num_etudiant=" + num_etudiant, true);
            xhttp.send();
        }
    </script>
<script>
    function editCell(cell, columnName, numImmatricule) {
        let content = cell.innerHTML;

        let input = document.createElement("input");
        input.type = "text";
        input.value = content;
        input.style.width = "100%";

        cell.innerHTML = "";
        cell.appendChild(input);

        let saveButton = document.createElement("button");
        saveButton.innerText = "Save";
        cell.appendChild(saveButton);

        input.focus();

        saveButton.addEventListener("click", function() {
            let newValue = input.value;
            cell.innerHTML = newValue;

            // Send the updated value to the server using AJAX
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Handle the response from the server if needed
                    console.log(this.responseText);
                    cell.removeChild(saveButton); // Remove the Save button after updating
                }
            };
            xhttp.open("POST", "update_car.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("columnName=" + columnName + "&newValue=" + newValue + "&numImmatricule=" + numImmatricule);
        });
    }
</script>
</head>
<body>
    <?php include('../header.php'); ?>

    <div class="container">
        <div class="sidebar">
            <h2>Navigation</h2>
            <ul>
                <li><a href="info_vehicule.php">Mon véhicule</a></li>
                <li><a href="#">Mes trajets à venir</a></li>
                <li><a href="demandes_resa.php" >Demandes de réservations</a></li>
                <li><a href="prop_escales.php" >Propositions d'escales</a></li>
            </ul>
        </div>
        <div class="main-content" id="mainContent">
            <!-- Your content related to managing cars and rides goes here -->
            <h2>Welcome to the Driver Space</h2>

            <form id="studentNumberForm" onsubmit="event.preventDefault(); fetchResultsFromDB();">
                <div class="form-group">
                    <label for="num_etudiant">Student Number:</label>
                    <input type="text" id="num_etudiant" name="num_etudiant" placeholder="Enter your student number" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit">
                </div>
            </form>

            <div id="results"></div>
        </div>
    </div>

    <?php include('../../footer.php'); ?>
</body>
</html>

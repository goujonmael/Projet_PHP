<!DOCTYPE HTML>
<html>
<head>
    <title>Ajout d'un contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #FF0000;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: underline;
            color: #FF0000;
        }
</style>
</head>
<body>
    <h1>Ajout d'un patient</h1>
    <div class="container">
    <?php
        $server = 'localhost';
        $db = 'php_project';
        $login = "etu";
        $mdp = "\$iutinfo";

        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Récupération des données du formulaire HTML
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $adresse = $_POST['adresse'];
                $date_de_naissance = $_POST['date_de_naissance'];
                $lieu_de_naissance = $_POST['lieu_de_naissance'];
                $numero_securite_sociale = $_POST['numero_securite_sociale'];
                $idMedecin = $_POST['idMedecin']; // Ajoutez le champ de sélection du médecin référent

                $sql = "INSERT INTO patient (Nom, Prenom, Adresse, Date_de_naissance, Lieu_de_naissance, Numero_Securite_Sociale, idMedecin) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }
                $test = $stmt->execute([$nom, $prenom, $adresse, $date_de_naissance, $lieu_de_naissance, $numero_securite_sociale, $idMedecin]);
                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }

                // Vérification de l'insertion
                if ($stmt->rowCount() > 0) {
                    echo "Le patient a été ajouté avec succès. <br>";
                    echo '<a href="saisie.html">Accueil</a>';
                } else {
                    echo "Une erreur s'est produite lors de l'ajout du patient.";
                }
            }
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
        ?>

        <!-- Formulaire HTML pour saisir un nouveau patient -->
        <form method="post" action="ajoutcontact.php">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="date_de_naissance">Date de naissance :</label>
            <input type="text" id="date_de_naissance" name="date_de_naissance" required>

            <label for="lieu_de_naissance">Lieu de naissance :</label>
            <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" required>

            <label for="numero_securite_sociale">Numéro de sécurité sociale :</label>
            <input type="text" id="numero_securite_sociale" name="numero_securite_sociale" required>

            <!-- Champ de sélection du médecin référent -->
            <label for="idMedecin">Médecin Référent :</label>
            <select id="idMedecin" name="idMedecin">
                <!-- Remplacez les options ci-dessous par les médecins de votre base de données -->
                <option value="1">Médecin 1</option>
                <option value="2">Médecin 2</option>
                <!-- Ajoutez d'autres options si nécessaire -->
            </select>

            <input type="submit" value="Ajouter le patient">
        </form>
    </div>
</body>
</html>
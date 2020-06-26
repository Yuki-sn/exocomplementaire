<?php 
 // Connexion à la BDD
try{
    $bdd = new PDO('mysql:host=localhost;dbname=exo_supplementaire;charset=utf8', 'root', '');

    // Ligne permettant d'afficher les erreurs SQL à l'écran
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(Exception $e){

    die('Il y a un problème avec la bdd : ' . $e->getMessage());
}
// Fonction pour simplifier htmlspecialchars
function _(string $str){
    return htmlspecialchars($str);
};

if(
    isset($_POST['name']) &&
    isset($_POST['species']) &&
    isset($_POST['birthdate']) // si champ remplis
){    
    // 2eme étape : vérifications de la validité des champs (n champs = n vérifications)

    // Si le champ prénom n'est pas correct, on crée une erreur dans le tableau $errors
    if(mb_strlen($_POST['name']) < 2 || mb_strlen($_POST['name']) > 50){
        $errors[] = 'Le prénom doit avoir entre 2 et 40 caractères !';
    }

    // Si le champ nom n'est pas correct, on crée une erreur dans le tableau $errors
    if(mb_strlen($_POST['species']) < 2 || mb_strlen($_POST['species']) > 50){
        $errors[] = 'Le nom doit avoir entre 2 et 40 caractères !';
    }

    if(!preg_match('/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/', $_POST['birthdate'])){
        $errors[] = 'La date doit etre sous format : jour / mois / année';
    }

    // si pas erreur 
    if(!isset($errors)){
        // Requête préparée pour inséréer l'animal' (pas requête direct car il y a des variables à mettre dans la requête)
        $response = $bdd->prepare('INSERT INTO animals(name,species,birthdate) VALUES(?,?,?)');

        // Liaison des valeurs des marqueurs et execution de la requête
        $response->execute([
            $_POST['name'],
            $_POST['species'],
            $_POST['birthdate'],
        ]);
        // Si l'insertion a réussi (rowCount retournera donc 1), alors on crée un emssage de succès, sinon message d'erreur
        if($response->rowCount() > 0){
            $successMessage = 'L\'animal a bien étais ajouté';
        } else {
            $errors[] = 'Problème avec la base de données, veuillez ré-essayer';
        }
    }

}
$tee = $bdd->query("SELECT * FROM animals");

$animals = $tee->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coucou</title>
</head>
<style>

    body{
        background-color:lightgrey;
        text-align:center;
    }
    h1.main-title{
        text-align: center;
    }

    div.container{
        margin: 40px;
    }
    div.container table{
        margin: auto;
        border: medium solid #6495ed;
        border-collapse: collapse;
        text-align: center;
    }

    div.container table tr th {
        border: thin solid #6495EE;
        padding: 10px;
        min-width: 150px;
        background-color: #D0E3FA;
    }

    div.container table tr td {
        border: 1px solid #6495EE;
        padding: 8px;
    }

</style>
<body>
    <h1 class="main-title">Liste d'animaux</h1>
    <div class="container">
        <?php
        // Si il y a des animaux
        if(!empty($animals)){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Espèce</th>
                        <th>Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
        <?php
            // Affichage des animaux
            foreach($animals as $animal)
            {
                echo '<tr>
                        <td>' . ucfirst( _( $animal['name'] ) ). '</td>
                        <td>' . ucfirst( _( $animal['species'] ) ) . '</td>
                        <td>' . _(strftime('%d-%m-%Y', time($animal['birthdate']))) . '</td>
                    </tr>';
            }
        ?>
                </tbody>
            </table>
        <?php
        } else {
            echo '<p class="error">Aucun animal à afficher</p>';
        } 
        ?>
    </div>
<?php
    // Si il y a des erreurs, on les affiches
    if(isset($errors)){
        foreach($errors as $error){
            echo '<p style="color:red;">' . $error . '</p>';
        }
    }
    // Si message de succès existe, on l'affiche. Sinon on affiche le formulaire
    if(isset($successMessage)){
        echo '<p style="color:green;">' . $successMessage . '</p>';
    } else {
    
        ?>
    <h1 class="main-title">ajouter un animal</h1>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Nom">
        <input type="text" name="species" placeholder="Espèces">
        <input type="date" name="birthdate">
        <input type="submit">
    </form>
    <?php
    }
    ?>
</body>
</html>
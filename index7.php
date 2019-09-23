<?php


require __DIR__ . '/vendor/autoload.php';

$pdo = new PDO('mysql:host=localhost;dbname=PHP', "root", "root"); // CONNEXION TO DB


if (!empty($_POST)) {
    $name = $_POST["name"];
    echo "Je recupere les données de mon formulaire";
    $stmt = $pdo->prepare('INSERT INTO users (name) VALUES (:name)'); // PREPARE QUERY
    $stmt->execute(["name" => $name]); // EXECUTE QUERY
    
    $newQuery = $pdo->prepare('SELECT * FROM users WHERE name = ?'); // PREPARE QUERY
    $newQuery->execute([$name]); // EXECUTE QUERY
    $allUsers = $newQuery->fetchAll(PDO::FETCH_OBJ); // FETCH RESULT OF QUERY
    
    // ACUTELLEMENT ON CRE UN USER ENSUITE ON RECUPERE TOUT LES USER QUI ONT LE MEME NOM
    // TP MOI JE VOUDRAIS RECUPERER TOUT LES USERS PAR DEFAULT, PUIS SAVOIR COMBIEN DE USER AVEC LE NOM QUE JAI CREE JAI EN DB
    // FAIRE UNE QUERY POUR RECUPERER TOUT LES USERS
    // FAIRE UNE QUERY POUR RECUPERER CB DE USER AVEC LE NOM QUE JAI CREE IL Y A EN DB
}

    //affiche les dernièers membres par id du plus récent au moins récent
    $users = $pdo->prepare('SELECT * FROM users ORDER BY id DESC LIMIT 0,15');
    $users->execute();


?>

<form method="POST">
    <label for="">Mon nom</label>
    <input type="text" name="name">
    <button type="submit">Envoyer</button>
</form>

<?php
//affiche les dernièers membres par id du plus récent au moins récent
$users = $pdo->prepare('SELECT * FROM users ORDER BY id DESC LIMIT 0,15');
$users->execute();
$allUsers = $users->fetchAll(PDO::FETCH_OBJ);

if (!empty($_POST))
{
    echo "<p style='color:green;'>le membre " . $_POST["name"] . " vient d'être entré en base</p> </br></br>" ;
}

?>

<?php if (!empty($allUsers)): ?>
    <?php foreach ($allUsers as $key => $value): ?>
        <tr>
            <td>Id : <?php echo $value->id; ?></td>
            <td>Name : <?php echo $value->name; ?></td>
            <br>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

<!--  Connexion à ma dbb via pdo -->
<?php 
try
{
// Connexion à Mysql
 $mysqlClient = new PDO(
    'mysql:host=localhost;dbname=we_love_food;charset=utf8',
    // id (ne pas faire ça en prod)
    'root',
    // mp (ne pas faire ça en prod)
    'root',
    // cette ligne active l'affiche d'erreur sql
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);
}
// En cas d'erreur, PDO renvoie ce qu'on appelle une exception, qui permet de « capturer » l'erreur etd 'arrêter le processus.
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

// Si tout va bien on continu

// Je récupère le contenu de la table recipes
    // je prépare ma requête sql dans une variable qui récupère toutes les recettes
    // $sqlQuery = 'SELECT * FROM recipes';
    
    // requête qui sélectionne tous les champs de la table recipes lorsque le champ is_enabled est égal à vrai
    // le  représente les arguments nommées
    // les ? vont être remplacés par de var que l'on va soumettre à PDO
    $sqlQuery = "SELECT * FROM `recipes` WHERE author = :author";

// $recipesStatement contient quelque chose d'inexploitable directement par php car c'est : un objet PDOStatement. Cet objet va contenir la requête SQL que nous devons exécuter, et par la suite, les informations récupérées en base de données.
$recipesStatement = $mysqlClient->prepare($sqlQuery);

// Pour récupérer les données, on va demander à cet objet d'exécuter la requête SQL et de récupérer toutes les données dans un format "exploitable" pour nous, c'est-à-dire sous forme d'un tableau PHP.
$recipesStatement->execute([
    'author' => $_GET['author'],
]);
$recipes = $recipesStatement->fetchAll();

// J'affiche mes recettes
foreach($recipes as $recipe){ ?>

<h1><?php echo $recipe['title']; ?></h1>
<p><?php echo $recipe['recipe']; ?></p>
<p><?php echo $recipe['author']; ?></p>
<?php
}
?>
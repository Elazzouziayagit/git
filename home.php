<?php
// Configuration de la base de données
$host = "localhost";
$dbname = "bib";
$username = "root"; // Remplacez par votre utilisateur MySQL
$password = "Ibrahimrh";     // Remplacez par votre mot de passe MySQL

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le nombre total de documents empruntés
    $query = "SELECT COUNT(*) AS total FROM EMPRUNT";
    $stmt = $pdo->query($query);
    $totalDocumentsEmpruntes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupérer le nombre de livres en rayon
    $query = "SELECT COUNT(*) AS total FROM EXEMPLAIRE WHERE STATUTEXEM = 'en rayon'";
    $stmt = $pdo->query($query);
    $livresEnRayon = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupérer le nombre d'emprunts en retard
    $query = "SELECT COUNT(*) AS total FROM EXEMPLAIRE e
              JOIN EMPRUNT em ON e.IDEXEMPLAIRE = em.IDEXEMPLAIRE
              WHERE e.STATUTEXEM = 'en retard'";
    $stmt = $pdo->query($query);
    $empruntsRetard = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupérer le nombre total d'utilisateurs
    $query = "SELECT COUNT(*) AS total FROM UTILISATEUR";
    $stmt = $pdo->query($query);
    $totalUtilisateurs = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupérer le nombre de relances envoyées
    $query = "SELECT COUNT(*) AS total FROM RELANCE";
    $stmt = $pdo->query($query);
    $totalRelances = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Récupérer le nombre de périodiques disponibles
    $query = "SELECT COUNT(*) AS total FROM PERIODIQUE";
    $stmt = $pdo->query($query);
    $totalPeriodiques = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Réponse JSON pour le frontend
    $response = [
        'totalDocumentsEmpruntes' => $totalDocumentsEmpruntes,
        'livresEnRayon' => $livresEnRayon,
        'empruntsRetard' => $empruntsRetard,
        'totalUtilisateurs' => $totalUtilisateurs,
        'totalRelances' => $totalRelances,
        'totalPeriodiques' => $totalPeriodiques
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    // Gérer les erreurs de connexion ou d'exécution
    echo json_encode(['error' => $e->getMessage()]);
}
?>

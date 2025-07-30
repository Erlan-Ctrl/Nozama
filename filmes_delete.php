<?php
require_once __DIR__ . '/../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $sql = 'DELETE FROM filmes WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Filme deletado com sucesso!";
        } else {
            echo "Nenhum filme deletado (ID inexistente).";
        }
    } else {
        echo "ID não informado.";
    }
} else {
    echo "Requisição inválida.";
}

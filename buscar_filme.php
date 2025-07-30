<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexao.php';

if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID não fornecido'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = (int) $_GET['id'];
if ($id <= 0) {
    echo json_encode(['erro' => 'ID inválido'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $sql = "SELECT id, title, director, year, poster_url, synopsis
              FROM filmes
             WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $filme = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($filme) {
        $filme['year'] = isset($filme['year']) && $filme['year'] !== '' ? (int)$filme['year'] : null;
        foreach (['title','director','poster_url','synopsis'] as $k) {
            if (!isset($filme[$k]) || $filme[$k] === null) $filme[$k] = '';
        }

        echo json_encode($filme, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        echo json_encode(['erro' => 'Filme não encontrado'], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro na consulta: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

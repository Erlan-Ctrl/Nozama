<?php
declare(strict_types=1);

require_once __DIR__ . '/../conexao.php';

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Requisição inválida.";
    exit;
}

$id         = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title      = trim($_POST['title']      ?? '');
$director   = trim($_POST['director']   ?? '');
$yearStr    = trim($_POST['year']       ?? '');
$poster_url = trim($_POST['poster_url'] ?? '');
$synopsis   = trim($_POST['synopsis']   ?? '');

if ($id <= 0) {
    echo "ID inválido.";
    exit;
}
if ($title === '') {
    echo "Título é obrigatório.";
    exit;
}

$year = null;
if ($yearStr !== '') {
    if (!ctype_digit($yearStr)) {
        echo "Ano inválido.";
        exit;
    }
    $year = (int)$yearStr;
    if ($year < 1888 || $year > 2100) {
        echo "Ano fora do intervalo permitido (1888–2100).";
        exit;
    }
}

if ($poster_url !== '' && !filter_var($poster_url, FILTER_VALIDATE_URL)) {
    echo "URL do pôster inválida.";
    exit;
}

if (mb_strlen($synopsis) > 5000) {
    echo "Sinopse muito longa (máx. 5000 caracteres).";
    exit;
}

try {
    $sqlCheck = "SELECT COUNT(*)
                   FROM filmes
                  WHERE id <> :id
                    AND title = :title
                    AND (director = :director OR (director IS NULL AND :director IS NULL))
                    AND (year = :year OR (year IS NULL AND :year IS NULL))";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtCheck->bindValue(':title', $title, PDO::PARAM_STR);
    $stmtCheck->bindValue(':director', $director !== '' ? $director : null, $director !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmtCheck->bindValue(':year', $year !== null ? $year : null, $year !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $stmtCheck->execute();

    if ((int)$stmtCheck->fetchColumn() > 0) {
        echo "Erro: Já existe um filme com o mesmo título, diretor e ano.";
        exit;
    }

    $sql = "UPDATE filmes
               SET title = :title,
                   director = :director,
                   year = :year,
                   poster_url = :poster_url,
                   synopsis = :synopsis
             WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':director', $director !== '' ? $director : null, $director !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':year', $year !== null ? $year : null, $year !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $stmt->bindValue(':poster_url', $poster_url !== '' ? $poster_url : null, $poster_url !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':synopsis', $synopsis !== '' ? $synopsis : null, $synopsis !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo "Filme atualizado com sucesso!";
        } else {
            echo "Nenhuma alteração realizada, mas a operação foi um sucesso.";
        }
    } else {
        echo "Erro ao atualizar filme.";
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo "Erro interno ao atualizar.";
    exit;
}

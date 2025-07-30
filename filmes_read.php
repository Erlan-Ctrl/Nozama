<?php
declare(strict_types=1);

require_once __DIR__ . '/../conexao.php';

try {
    $sql = 'SELECT id, title, director, year, poster_url, synopsis FROM filmes ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    foreach ($rows as &$r) {
        if (isset($r['year']) && $r['year'] !== null && $r['year'] !== '') {
            $r['year'] = (int)$r['year'];
        } else {
            $r['year'] = null;
        }

        foreach (['title','director','poster_url','synopsis'] as $k) {
            if (!isset($r[$k]) || $r[$k] === null) {
                $r[$k] = '';
            }
        }
    }
    unset($r);

    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    ) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html lang="pt-br"><head><meta charset="utf-8"><title>Filmes</title>';
    echo '<style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;padding:24px}';
    echo '.card{border:1px solid #eee;border-radius:10px;padding:16px;margin:12px 0;box-shadow:0 2px 8px rgba(0,0,0,.04)}';
    echo '.row{display:flex;gap:16px;align-items:flex-start}.poster{width:100px;height:140px;object-fit:cover;border-radius:6px;background:#eee}';
    echo '.meta{color:#666;font-size:14px}</style></head><body>';

    echo '<h1>Registros encontrados: ' . count($rows) . '</h1>';
    foreach ($rows as $linha) {
        $poster = $linha['poster_url'] ?: '';
        echo '<div class="card">';
        echo '<div class="row">';
        if ($poster !== '') {
            echo '<img class="poster" src="' . htmlspecialchars($poster, ENT_QUOTES, 'UTF-8') . '" alt="Pôster">';
        }
        echo '<div>';
        echo '<h2 style="margin:0 0 6px 0">' . htmlspecialchars($linha['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
        $meta = [];
        if ($linha['director'] !== '') $meta[] = htmlspecialchars($linha['director'], ENT_QUOTES, 'UTF-8');
        if ($linha['year'] !== null)   $meta[] = (string)$linha['year'];
        echo '<div class="meta">' . implode(' • ', $meta) . '</div>';
        if ($linha['synopsis'] !== '') {
            echo '<p style="margin-top:8px">' . nl2br(htmlspecialchars($linha['synopsis'], ENT_QUOTES, 'UTF-8')) . '</p>';
        }
        echo '<pre style="background:#fafafa;border:1px solid #f0f0f0;padding:8px;border-radius:8px;">';
        var_dump($linha);
        echo '</pre>';
        echo '</div></div></div>';
    }

    echo '</body></html>';

} catch (Throwable $e) {
    http_response_code(500);
    if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
    ) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['erro' => 'Erro ao listar filmes.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo "Erro ao listar filmes.";
    exit;
}

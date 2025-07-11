<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alta'])) {
    $marca = $_POST['marca'] ?? '';
    $model = $_POST['model'] ?? '';
    $combustible = $_POST['combustible'] ?? '';
    
    if ($marca && $model && $combustible) {
        $id = uniqid('cotxe:');
        $cotxe = ['marca' => $marca, 'model' => $model, 'combustible' => $combustible];
        $memcached->set($id, json_encode($cotxe));
        $ids = $memcached->get('cotxes:ids') ?: [];
        $ids[] = $id;
        $memcached->set('cotxes:ids', $ids);
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['baixa'], $_POST['id'])) {
    $id = $_POST['id'];
    $memcached->delete($id);
    $ids = $memcached->get('cotxes:ids') ?: [];
    $ids = array_filter($ids, fn($v) => $v !== $id);
    $memcached->set('cotxes:ids', $ids);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestió de Cotxes amb Memcached</title>
    <style>
        body { font-family: Arial; padding: 2em; background: #f5f5f5; }
        h1 { color: #333; }
        form { margin-bottom: 1em; }
        input, button { margin: 0.2em; padding: 0.4em; }
        ul { list-style-type: none; padding-left: 0; }
        li { background: #fff; margin: 0.5em 0; padding: 0.5em; border-radius: 5px; }
        button[name="baixa"] { background: #ff4d4d; color: white; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Cotxes amb Memcached + PHP</h1>

    <form method="POST">
        <input type="text" name="marca" placeholder="Marca" required>
        <input type="text" name="model" placeholder="Model" required>
        <input type="text" name="combustible" placeholder="Combustible" required>
        <button type="submit" name="alta">Afegir cotxe</button>
    </form>

    <ul>
        <?php
        $ids = $memcached->get('cotxes:ids') ?: [];
        foreach ($ids as $id) {
            $json = $memcached->get($id);
            if (!$json) continue;
            $d = json_decode($json, true);
            echo "<li><b>{$d['marca']} {$d['model']}</b> ({$d['combustible']})
                    <form method='POST' style='display:inline'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' name='baixa'>X</button>
                    </form>
                  </li>";
        }
        ?>
    </ul>
</body>
</html>

<?php
if (isset($_GET['pokemon'])) {
    $pokemon = strtolower(trim($_GET['pokemon']));
    $url = 'https://pokeapi.co/api/v2/pokemon/' . urlencode($pokemon);

    // Obtener datos de la API usando file_get_contents()
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        $error = "No se encontró el Pokémon '$pokemon'. Por favor, intenta de nuevo.";
    } else {
        $data = json_decode($response, true);

        // Extraer información relevante
        $name = ucfirst($data['name']);
        $image = $data['sprites']['front_default'];
        $height = $data['height'] / 10; 
        $weight = $data['weight'] / 10; 

        $abilities = [];
        foreach ($data['abilities'] as $ability) {
            $abilities[] = $ability['ability']['name'];
        }

        $types = [];
        foreach ($data['types'] as $type) {
            $types[] = $type['type']['name'];
        }
    }
} else {
    // Redirigir al inicio si no se recibe ningún parámetro
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información de <?php echo isset($name) ? $name : 'Pokémon'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">↩ Volver al inicio</a>
    <h1>Información de <?php echo isset($name) ? $name : ''; ?></h1>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php else: ?>
        <img src="<?php echo $image; ?>" alt="Imagen de <?php echo $name; ?>">
        <p><strong>Altura:</strong> <?php echo $height; ?> metros</p>
        <p><strong>Peso:</strong> <?php echo $weight; ?> kg</p>
        <p><strong>Tipos:</strong> <?php echo implode(', ', $types); ?></p>
        <p><strong>Habilidades:</strong> <?php echo implode(', ', $abilities); ?></p>
    <?php endif; ?>
</body>
</html>

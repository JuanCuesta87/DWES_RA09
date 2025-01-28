<?php
/**
 * Obtiene los datos de un Pokémon desde la PokeAPI.
 *
 * @param string $pokemon Nombre o ID del Pokémon a buscar.
 * @return array|null Arreglo con los datos del Pokémon o null si no se encuentra.
 */
function getPokemonData($pokemon) {
    $url = 'https://pokeapi.co/api/v2/pokemon/' . urlencode($pokemon);

    // Obtener datos de la API usando file_get_contents()
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        return null;
    } else {
        $data = json_decode($response, true);
        return $data;
    }
}

/**
 * Extrae información relevante de los datos del Pokémon.
 *
 * @param array $data Arreglo asociativo con los datos del Pokémon.
 * @return array Arreglo con la información procesada del Pokémon.
 */
function extractPokemonInfo($data) {
    // Extraer información relevante
    $info = [];

    $info['name'] = ucfirst($data['name']);
    $info['image'] = $data['sprites']['front_default'];
    $info['height'] = $data['height'] / 10; // Convertir decímetros a metros
    $info['weight'] = $data['weight'] / 10; // Convertir hectogramos a kilogramos

    $info['abilities'] = [];
    foreach ($data['abilities'] as $ability) {
        $info['abilities'][] = $ability['ability']['name'];
    }

    $info['types'] = [];
    foreach ($data['types'] as $type) {
        $info['types'][] = $type['type']['name'];
    }

    return $info;
}

if (isset($_GET['pokemon'])) {
    $pokemon = strtolower(trim($_GET['pokemon']));

    // Obtener los datos del Pokémon usando la función
    $data = getPokemonData($pokemon);

    if ($data === null) {
        $error = "No se encontró el Pokémon '$pokemon'. Por favor, intenta de nuevo.";
    } else {
        // Extraer la información relevante usando la función
        $info = extractPokemonInfo($data);

        // Desestructurar el arreglo $info para facilitar su uso en el HTML
        $name = $info['name'];
        $image = $info['image'];
        $height = $info['height'];
        $weight = $info['weight'];
        $abilities = $info['abilities'];
        $types = $info['types'];
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

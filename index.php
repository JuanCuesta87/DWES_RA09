<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Pokedex</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Bienvenido a Mi Pokedex</h1>
        <form action="pokemon.php" method="get">
            <label for="pokemon">Ingresa el nombre o ID de un Pokémon:</label><br><br>
            <input type="text" id="pokemon" name="pokemon" required>
            <br><br>
            <input type="submit" value="Buscar">
        </form>
    </body>
</html>

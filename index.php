<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TV-Serien-Planer</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <?php
        $mysqli = new mysqli('localhost', 'root', '', 'tv_series_planner');
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $hasBeenAdded = false;
        $hasBeenDeleted = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['task'] == 'delete') {
                $statement = $mysqli->prepare('DELETE FROM tv_series WHERE id = ?');
                $statement->bind_param('i', $_POST['id']);
                if ($statement->execute()) {
                    $hasBeenDeleted = true;
                } else {
                    die('Error: ' . $mysqli->error);
                }
            } else if ($_POST['task'] == 'add') {
                $name = $_POST['name'];
                $episode = $_POST['episode'];
                if ($name == '' || $episode == '') {
                    die('Fehler! Mind. eins der Felder ist leer');
                }


                $statement = $mysqli->prepare('INSERT INTO tv_series (name, episode) VALUES(?, ?)');
                $statement->bind_param('ss', $name, $episode);

                if ($statement->execute()) {
                    $hasBeenAdded = true;
                } else {
                    die('Error: ' . $mysqli->error);
                }
            }
        }

        $sql = 'SELECT id, name, episode FROM tv_series';
        $result = $mysqli->query($sql);
    ?>
    
        <h1>TV-Serien-Planer</h1>
        <br>
        <table>
            <tr>
                <th>Name</th>
                <th>Episode</th>
                <th></th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['episode']) ?></td>
                    <td>
                        <form action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                            <button name="task" value="delete">löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>


        </table>
        <br>

        <form action="index.php" method="post">
            <label>Name: <input type="text" name="name" /></label>
            <label>Letzte gesehene Episode: <input type="text" name="episode" /></label>
            <button name="task" value="add">Speichern</button>
        </form>
        <?php if ($hasBeenAdded): ?>
            <p>Serie wurde erfolgreich hinzugefügt</p>
        <?php endif; ?>
        <?php if ($hasBeenDeleted): ?>
            <p>Serie wurde erfolgreich gelöscht</p>
        <?php endif; ?>
    
    </body>
</html>
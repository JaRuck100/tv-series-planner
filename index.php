<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TV-Series-Planer</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
    <?php
        $mysqli = new mysqli('localhost', 'root', '', 'tv_series_planner');

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $sql = "SELECT name, episode FROM tv_series";
        $result = $mysqli->query($sql);
    ?>
    
        <h1>TV-Series-Planer</h1>
        <br>
        <table>
            <tr>
                <th>Name</th>
                <th>Episode</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["episode"]) ?></td>
                </tr>
            <?php endwhile; ?>


        </table>
        <br>


        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php
                $name = $_POST['name'];
                $episode = $_POST['episode'];


                $statement = $mysqli->prepare('INSERT INTO tv_series (name, episode) VALUES(?, ?)');
                $statement->bind_param('ss', $name, $episode);

                if ($statement->execute()) {
                    echo "Serie wurde erfolgreich hinzugefügt";
                } else {
                    echo "Error: " . $mysqli->error;
                }
            ?>

            <br>
            <p><?= htmlspecialchars($_POST['name']); ?></p>
            <p><?= htmlspecialchars($_POST['episode']); ?></p>
        <?php endif; ?>

        <form action="index.php" method="post">
            <label>Name: <input type="text" name="name" /></label>
            <label>Letzte gesehene Episode: <input type="text" name="episode" /></label>
            <button>Speichern</button>
        </form>
    
    </body>
</html>
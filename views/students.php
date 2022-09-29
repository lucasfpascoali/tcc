<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styleIndex.css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<h2 id="logoText" style="color: #fff;">E.E.B Apolônio Ireno Cardoso</h2>
<main>
    <?php
    require __DIR__ . "/../autoload.php";

    $students = (new \Source\Models\Student())->all();
    if ($students) {
    ?>
       <table border='1'>
        <thead>
            <tr>
                <td>Nome</td>
                <td>Sobrenome</td>
                <td>Matrícula</td>
                <td>Data de Nascimento</td>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>{$student->first_name}</td>";
                echo "<td>{$student->last_name}</td>";
                echo "<td>{$student->registration}</td>";
                echo "<td>{$student->birth_date}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Sem alunos cadastrados";
        }
        ?>
</main>
</body>
</html>

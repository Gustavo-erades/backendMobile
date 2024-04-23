<!DOCTYPE html>
<?php 
    include_once'../connBanco.php';
    $sql="SELECT * FROM anestesico.anestesicoTatabela";
    $result=$conn->query("SELECT * FROM anestesicoTabela");
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Consultar Anestésicos Locais</title>
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Pesquisar" id="campoInput">
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Anestésico</th>
                        <th>Dose máxima (por kg peso corporal)</th>
                        <th>Máximo absoluto (independente do peso)</th>
                        <th>Número de tubetes</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                        while($row=$result->fetch(PDO::FETCH_ASSOC)){
                            echo "<tr>";
                            echo "<td>";
                            echo $row['anestesicoLocal'];
                            echo "</td>";
                            echo "<td>";
                            echo number_format($row['doseMaxima'], 1);
                            echo "</td>";
                            echo "<td>";
                            echo number_format($row['maximoAbsoluto'], 1);
                            echo "</td>";
                            echo "<td>";
                            echo number_format($row['numTubetes'], 1);
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.getElementById('campoInput').addEventListener('input', function() {
            var searchText = this.value.toLowerCase();
            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td');
                var isMatch = false;

                for (var i = 0; i < cells.length; i++) {
                    var cellText = cells[i].textContent.toLowerCase();
                    if (cellText.indexOf(searchText) !== -1) {
                        isMatch = true;
                        break;
                    }
                }

                if (isMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html>

<head>
    <title>Ravi Veritabanı</title>
    <style>
        td {
            padding: 15px;
        }
    </style>
</head>

<body>
    <h2>Filtreler:</h2>
    <form method="GET">
        <select name="filter">
            <option value="islenmis_vefat_tarihi">Vefat Tarihi</option>
            <option value="kabile">Kabile</option>
            <option value="rivayet_sayisi_ck">Rivayet Sayısı</option>
            <option value="guvenilirlik_is">Güvenilirlik Durumu</option>
            <option value="cinsiyet">Cinsiyet</option>
            <option value="meslek_1">Geçim Vasıtaları</option>
            <option value="profil">Profilleri</option>
        </select>
        <input type="text" id="fname" name="fname">
        <input type="submit" value="Filtrele">
        <button name="retrieveAll" type="submit" value="all">Tüm Ravileri Göster</button>
    </form>

    <?php
    if (isset($_GET['filter'])) {
        $servername = "172.19.0.3";
        $username = "mariadb";
        $password = "mariadb";
        $dbname = "mariadb";
        $tableName = 'raviler_kesik';

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $filter = $_GET['filter'];
        $val = $_GET['fname'];
        $retrieveAll = $_GET['retrieveAll'] ?? null;

        $sql = ($retrieveAll) ? "SELECT * FROM $tableName" : "SELECT * FROM $tableName WHERE $filter LIKE '$val%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Sonuçlar:</h2>";
            echo '<table>
            <thead>
                <tr>
                    <th>İsim</th>
                    <th>Vefat Tarihi</th>
                    <th>Kabile</th>
                    <th>Rivayet Sayısı</th>
                    <th>Güvenilirlik Durumu</th>
                    <th>Geçim Durumu</th>
                    <th>Cinsiyet</th>
                </tr>
            </thead>
            <tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                    <td>' . $row["isim"] . '</th>
                    <td>' . (int)$row["islenmis_vefat_tarihi"] . '</th>
                    <td>' . $row["kabile"] . '</th>
                    <td>' . (int)$row["rivayet_sayisi_ck"] . '</th>
                    <td>' . $row["guvenilirlik_is"] . '</th>
                    <td>' . $row["meslek_1"] . '</th>
                    <td>' . $row["cinsiyet"] . '</th>
                </tr>';
            }

            echo '</table>';
        } else {
            echo "<p>Seçilen filtreler için herhangi bir sonuç bulunamadı.</p>";
        }

        $conn->close();
    }
    ?>
</body>

</html>

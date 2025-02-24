<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            margin: 1em;
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }
        input {
            height: 30px;
            width: 20%;
        }
    </style>
</head>
<body>
    <h1>Countries List</h1>
    <div class="container"> 
        <p><b>Add Country</b></p>
        <form action="" method="post">
            <input type="text" name="txtName" id="txtName" placeholder="Name" required>
            <input type="text" name="txtIsoCode" id="txtIsoCode" placeholder="ISO Code" required>
            <input type="text" name="txtRegion" id="txtRegion" placeholder="Region" required>
            <input type="number" name="txtPopulation" id="txtPopulation" placeholder="Population" required>
            <input type="submit" name="submit" value="Add">
        </form>
    </div>
    <?php

    include 'db.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

        $name = $_POST['txtName'];
        $iso_code = $_POST['txtIsoCode'];
        $region = $_POST['txtRegion'];
        $population = $_POST['txtPopulation'];
        $created_at = date('Y-m-d H:i:s');


        $stmt = $conn->prepare("INSERT INTO countries (name, iso_code, region, population) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $iso_code, $region, $population);


        if ($stmt->execute()) {
            echo "New country added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM countries";
    
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>ISO Code</th><th>Region</th><th>Population</th><th>Created At</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["iso_code"] . "</td>";
            echo "<td>" . $row["region"] . "</td>";
            echo "<td>" . $row["population"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</body>
</html>
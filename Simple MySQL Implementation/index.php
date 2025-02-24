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
    // Include the database connection file
    include 'db.php';

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Get form data
        $name = $_POST['txtName'];
        $iso_code = $_POST['txtIsoCode'];
        $region = $_POST['txtRegion'];
        $population = $_POST['txtPopulation'];
        $created_at = date('Y-m-d H:i:s');

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO countries (name, iso_code, region, population) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $iso_code, $region, $population);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New country added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // SQL query to fetch data from the 'countries' table
    $sql = "SELECT * FROM countries";
    
    // Execute the query and store the result set
    $result = $conn->query($sql);

    // Check if the query execution was successful
    if ($result === false) {
        // If the query failed, display an error message and terminate the script
        die("Error executing query: " . $conn->error);
    }

    // Check if there are any rows in the result set
    if ($result->num_rows > 0) {
        // If there are rows, start the HTML table
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>ISO Code</th><th>Region</th><th>Population</th><th>Created At</th></tr>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // For each row, create a new table row and display the data
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["iso_code"] . "</td>";
            echo "<td>" . $row["region"] . "</td>";
            echo "<td>" . $row["population"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "</tr>";
        }
        // End the HTML table
        echo "</table>";
    } else {
        // If there are no rows, display a message indicating that there are no results
        echo "0 results";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
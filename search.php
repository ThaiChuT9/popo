<?php 
        $conn = new mysqli("localhost", "root", "", "yessir");
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Check if a search query is provided
        if (isset($_GET['query'])) {
            $searchQuery = $conn->real_escape_string($_GET['query']);
            $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$searchQuery%'";
        }
        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $products[] = $row;
          }
        }
    ?>
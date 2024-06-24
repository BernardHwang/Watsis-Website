<?php

   include('server/connection.php');

   // to select one random product from each category
   $stmt = $conn->prepare("SELECT * FROM (
      SELECT * FROM products ORDER BY RAND()
   ) AS rand_products
   GROUP BY product_type
   LIMIT 4");

   $stmt->execute();

   $featured_products = $stmt->get_result();

?>
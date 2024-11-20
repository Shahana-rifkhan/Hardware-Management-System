<?php
//Start the Session
session_start();
	
//including the database connection file.
include_once("Includes/connect.php");

if(!isset($_SESSION['admin']) && empty($_SESSION['admin']) ){
    header('location:AdminLogin.php');
   }
?>


<html>
<head>
<?php include 'Includes/Navigation.php'; ?>

<link rel="stylesheet" type="text/css" href="your_website_domain/css_root/flaticon.css">
<script src="https://kit.fontawesome.com/39d1910945.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">

<!-- Custom StyleSheet -->
<link rel="stylesheet" href="./css/Style.css" />
<link rel="stylesheet" href="./css/flaticon.css" />
</head>
<body>
    
<div class="cardBox">
    <div class="card">
        <div>
            <?php
        $sql = "SELECT COUNT(customer_id) AS NumberOfCustomers FROM customer";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $NumberOfCustomers = $row["NumberOfCustomers"];
        ?>
            <div class="numbers"><?php echo $row["NumberOfCustomers"] ?></div>
            <a href="../Admin/Customers.php" class="cardName">Customers</a>
        </div>
        <div class="iconBox">
        <i style="color: #FF6347;" class="fas fa-users"></i>
        </div>
    </div>

    <div class="card">
        <div>
        <?php
        $sql = "SELECT Count(product_id) AS TotalProducts FROM product;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $NumberOfProducts = $row["TotalProducts"];
        ?>
           <div class="numbers"><?php echo $row["TotalProducts"] ?></div>
           <a href="../Admin/Products.php" class="cardName">Products</a>
        </div>
        <div class="iconBox">
        <i style="color: #00FF7F;" class="flaticon-screws"></i>
        </div>
    </div>

    <div class="card">
        <div>
        <?php
        $sql = "SELECT COUNT(order_id) AS NumberOfOrders FROM orders";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $NumberOfOrders = $row["NumberOfOrders"];
        ?>
            <div class="numbers"><?php echo $row["NumberOfOrders"] ?></div>
            <a href="../Admin/Orders.php" class="cardName">Orders</a>
        </div>
        <div class="iconBox">
        <i style="color: #00BFFF;" class="fas fa-cart-plus"></i>
        </div>
    </div>

    <div class="card">
        <div>
        <?php
        $sql = "SELECT SUM(total_price) AS Total FROM orders WHERE order_status = 'Delivered' Group by Month(order_datetime) desc";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $Total = $row["Total"];
        ?>
            <div class="numbers">Rs.<?php echo $row["Total"] ?></div>
            <a href="Sales_Report.php" class="cardName">Monthly Sales</a>
        </div>
        <div class="iconBox">
        <i style="color: #FF00FF;" class="fas fa-rupee-sign"></i>
        </div>
    </div>
</div>

<div class="details">
     <div class="recentOrders">
       <div class="cardHeader">
           <h2>Recent Orders</h2>
           <a href="../Admin/Orders.php" class="btn">View All</a>
       </div>
       <table>
           <thead>
               <tr style="background: #243a6f;">
                   <td style="color: white;">Name</td>
                   <td style="color: white;">Total Price</td>
                   <td style="color: white;">Order Status</td>
                   <td style="color: white;">Payment</td>
                   <td style="color: white;">Order Date</td>
                   <td style="color: white;">Operations</td>
               </tr>
           </thead>
           <tbody>

           <?php
    $sql = "SELECT * FROM orders JOIN customer ON orders.customer_id=customer.customer_id ORDER BY `orders`.`order_id` DESC LIMIT 7";
    $result = mysqli_query($conn, $sql);
    

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

            ?>
         <tr>
            <td><?php echo $row["name"]?></td>
            <td>Rs.<?php echo $row["total_price"] ?></td>
            <td>
                <span class="status"><?php if($row["order_status"] == 'Cancelled'){?>
                <span style="background:#FF0000; border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'Delivered'){?>
                <span style="background:#7CFC00;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'In Progress'){?>
                <span style="background:#ffff00;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'Ready To Delivery'){?>
                <span style="background:#FFA500;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'Accepted'){?>
                <span style="background:#ff00ff;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'On The Way'){?>
                <span style="background:pink;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?>
                <?php if($row["order_status"] == 'Order Placed'){?>
                <span style="background:#00BFFF;  border-radius: 4px; padding: 2px 4px;"><?php echo $row["order_status"] ?></span><?php } ?></span>
            </td>
            <td><?php echo $row["payment_method"] ?></td>
            <td><?php echo date('M j g:i A', strtotime($row["order_datetime"]));?></td>
            <td><a href='Order_Process.php?id=<?php echo $row["order_id"] ?>'>Change Status</a> 
        </tr>

               <?php
        }
      } else {
        echo "0 results";
      }
?>

           </tbody>
       </table>
     </div>

     <div class="recentCustomers">
     <div class="cardHeader">
           <h2>Recent Customers</h2>
           <a href="../Admin/Customers.php" class="btn">View All</a>
       </div>
       <table>
           <thead>
               <tr style="background: #243a6f;">
                   <td style="color: white;">Name</td>
                   <td style="color: white;">Company</td>
               </tr>
           </thead>
           <tbody>

           <?php
    $sql = "SELECT * FROM customer ORDER BY `customer`.`customer_id` DESC LIMIT 7";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

            ?>
               <tr>
               <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["company"] ?></td>
               </tr>

               <?php
        }
      } else {
        echo "0 results";
      }
?>

           </tbody>
       </table>
     </div>
</div>
<br>
    </br>

<?php include 'Includes/Footer.php'; ?>
</body>
</html>  
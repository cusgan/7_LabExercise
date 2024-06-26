<!doctype html>
<html lang="en">
    
    <?php require_once 'includes/head.php'; ?>
    <head>
        <style>
            
            .nav.tabletab {
                background-color: #CC222A !important;
                border-color: #CC222A;
                color: #F9D802;
            }
        </style>
    </head>
    

    <body>        
        <?php 
        session_start();
        include_once('api/connect.php');
        include_once 'includes/header.php'; ?>
        <main>
            <?php require_once 'includes/login.php'; ?>
            <?php require_once 'includes/signup.php'; ?>
            <?php require_once('includes/signupbusiness.php'); ?>
            <?php
                $menuid = $_SESSION['menuid'];
                $sql ="SELECT SUM(buyprice*qty) FROM tblMenuItem WHERE menuid='$menuid'";
                $result = mysqli_query($connection,$sql);
                $profits = mysqli_fetch_array($result)[0];
            ?>
            <br>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-1"></div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h2><?php echo $_SESSION['bname']; ?> Report</h2>
                        </div>
                        <div class="col-3">
                            <a name="" id="btnReturnToBusiness" class="btn btn-secondary" href="business.php" "button">Return to my Business Page</a>
                         </div>
                    </div><br>
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item">
                            <a class="nav-link active tabletab" aria-current="page" data-bs-toggle="pill" data-bs-target="#report1" href="#pills-home">Tables</a>
                        </li>
                        <li class="nav-item tabletab">
                            <a class="nav-link" data-bs-toggle="pill" data-bs-target="#report2" href="#pills-profile">Statistics</a>
                        </li>
                        <li class="nav-item tabletab">
                            <a class="nav-link" data-bs-toggle="pill" data-bs-target="#report3" href="#pills-contact">Charts</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent"><br>
                        <!-- first tab -->
                        <div class="tab-pane fade show active" id="report1" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <h3>All Items by Price (Ascending)</h3>
                            <div
                                class="table-responsive"
                            >
                                <table
                                    class="table table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">Menu Item ID</th>
                                            <th scope="col">Menu Item Name</th>
                                            <th scope="col">Menu Item Description</th>
                                            <th scope="col">Price of Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $item = 1;
                                            $item_res = mysqli_query($connection,"SELECT * FROM tblmenuitem WHERE menuid='".$_SESSION['menuid']."' ORDER BY buyprice ASC");
                                            while($item = mysqli_fetch_array($item_res)){
                                                echo "<tr>
                                                        <td scope=\"row\">#$item[0]</td>
                                                        <td>$item[2]</td>
                                                        <td>$item[3]</td>
                                                        <td>₱".number_format($item[4],2)."</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>

                            <h3>Items with 5 or more in stock</h3>
                            <div
                                class="table-responsive"
                            >
                                <table
                                    class="table table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">Menu Item ID</th>
                                            <th scope="col">Menu Item Name</th>
                                            <th scope="col">Quantity in Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $item = 1;
                                            $item_res = mysqli_query($connection,"select * from tblmenuitem where menuid='".$_SESSION['menuid']."' and qty>=5");
                                            while($item = mysqli_fetch_array($item_res)){
                                                echo "<tr>
                                                        <td scope=\"row\">#$item[0]</td>
                                                        <td>$item[2]</td>
                                                        <td>$item[4] in stock</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>

                            <h3>Total Assets Value</h3>
                            <div
                                class="table-responsive"
                            >
                                <table
                                    class="table table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th scope="col">Total Assets</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $item = 1;
                                            $item_res = mysqli_query($connection,"select SUM(qty*buyprice) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                            while($item = mysqli_fetch_array($item_res)){
                                                $money = number_format($item[0],2);
                                                echo "<td>₱$money</td>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!-- second tab -->
                        <div class="tab-pane fade" id="report2" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            <h3>Statistics</h3>
                            <div
                                class="row justify-content-center align-items-center g-2"
                            >
                                <div class="col">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h3 class="card-title">
                                                <?php
                                                    $item = 1;
                                                    $item_res = mysqli_query($connection,"select COUNT(itemid) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                                    while($item = mysqli_fetch_array($item_res)){
                                                        echo $item[0];
                                                    }
                                                ?>
                                            </h3>
                                            <h4 class="card-subtitle mb-2 text-body-secondary">Total No. of Menu Items</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h3 class="card-title">₱
                                                <?php
                                                    $item = 1;
                                                    $item_res = mysqli_query($connection,"select ROUND(SUM(buyprice),2) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                                    while($item = mysqli_fetch_array($item_res)){
                                                        echo $item[0];
                                                    }
                                                ?>
                                            </h3>
                                            <h4 class="card-subtitle mb-2 text-body-secondary">Total Cost of Menu Items</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h3 class="card-title">₱
                                                <?php
                                                    $item = 1;
                                                    $item_res = mysqli_query($connection,"select ROUND(AVG(buyprice),2) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                                    while($item = mysqli_fetch_array($item_res)){
                                                        echo $item[0];
                                                    }
                                                ?>
                                            </h3>
                                            <h4 class="card-subtitle mb-2 text-body-secondary">Average Menu Item Cost</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h3 class="card-title">
                                                <?php
                                                    $item = 1;
                                                    $item_res = mysqli_query($connection,"select ROUND(AVG(qty),2) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                                    while($item = mysqli_fetch_array($item_res)){
                                                        echo $item[0];
                                                    }
                                                ?>
                                            </h3>
                                            <h4 class="card-subtitle mb-2 text-body-secondary">Average Quantity in Stock</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h3 class="card-title">₱
                                                <?php
                                                    $item = 1;
                                                    $item_res = mysqli_query($connection,"select ROUND(AVG(buyprice*qty),2) from tblmenuitem where menuid='".$_SESSION['menuid']."'");
                                                    while($item = mysqli_fetch_array($item_res)){
                                                        echo $item[0];
                                                    }
                                                ?>
                                            </h3>
                                            <h4 class="card-subtitle mb-2 text-body-secondary">Average Asset Value per Item</h4>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            

                        </div>
                        <!-- third tab -->
                        <div class="tab-pane fade" id="report3" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                            <h3>Charts</h3>
                            <div
                                class="row justify-content-center align-items-center g-2"
                            >
                                <div class="col">
                                    <canvas id="myChart" style="width:100%;max-width:700px">
                                        <script>
                                            new Chart("myChart", {
                                                type: "pie",
                                                data: {
                                                    labels: ['Pizza', 'Fries', 'Burger', 'Cake'],
                                                    datasets: [{
                                                    backgroundColor: ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9"],
                                                    data: [20, 15, 50, 10]
                                                    }]
                                                },
                                                options: {
                                                    title: {
                                                    display: true,
                                                    text: "Product Stock"
                                                    }
                                                }
                                            });
                                        </script>
                                    </canvas>
                                </div>

                                <div class="col">
                                    <canvas id="myChart2" style="width:100%;max-width:700px">
                                        <script>
                                            new Chart("myChart2", {
                                                type: "line",
                                                data: {
                                                    labels: ['Pizza', 'Fries', 'Burger', 'Cake'],
                                                    datasets: [{
                                                    backgroundColor:"rgba(0,0,255,1.0)",
                                                    borderColor: "rgba(0,0,255,0.1)",
                                                    data: [20, 15, 30, 50],
                                                    fill: false
                                                    }]
                                                },
                                                options:{
                                                    title: {
                                                    legend: {display: false},
                                                    display: true,
                                                    text: "Item Price",
                                                    }}
                                            });
                                        </script>
                                    </canvas>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                
                
            </div>
            
            
            
        </main>

        <footer>
            
            <?php include_once 'includes/footer.php'; ?>
        </footer>

        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>

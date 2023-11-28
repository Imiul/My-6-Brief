<?php

    session_start();
    include('../-- Database/db-connection.php');

    if (!$_SESSION['name'] || $_SESSION['user_type'] != "User") {
        header("Location: ../Login.php");
        exit();
    }

    if (isset($_POST['add_transaction'])) {

        $accountId = $_POST['AccountId'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];

        if ($type === 0 || $amount == 0 || empty($amount)) {
            echo "<script>alert('Inputs should not be empty');</script>";
        } else {

            $query = "
                INSERT INTO transaction (type, amount, account_id)
                VALUES ('$type', '$amount', '$accountId');
            ";
            $run_query = mysqli_query($cnx, $query);


            if ($type == "credit") {
                
                $update_amount = "
                    UPDATE account
                    SET balance =   balance + $amount
                    WHERE id = $accountId
                ";

                $updating = mysqli_query($cnx, $update_amount);
                echo "<script>window.alert('Balance Updated Succesfully & Transaction Added');</script>";

            } else {

                $update_amount = "
                    UPDATE account
                    SET balance =   balance - $amount
                    WHERE id = $accountId
                ";

                $updating = mysqli_query($cnx, $update_amount);
                echo "<script>window.alert('Transaction Added & Balance Updated Succesfully');</script>";

            }
        }
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../Login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Transaction's</title>
</head>
<body>

<div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="Data.php"  class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" >Your Personal Data</a>
                    <a href="my_transaction.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    </div>
                </div>
                </div>
                <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    
                </div>
                </div>
                
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- <button >Log Out</button> -->
                    <form method="post" style="display: flex; align-items: center;">
                        <?php
                        echo "<h3 style='color: white; margin-right: 30px;'> ( User Name : " . $_SESSION['name']. " )</h3>";
                        ?>
                        <button style="color: red;" name="logout" type="submit">Log Out</button>
                    </form>
                </div>
            </div>
            </div>

            
        </nav>


        <!-- HEADER ===================== -->
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">User Dashboard</h1>
            </div>
        </header>


        <section id="add" class="mt-12 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 " >
            <!-- <h3 class="sm:px-20">Add A User</h3> -->
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <select name="AccountId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Choose One Of Your Account</option>
                    <?php
                    
                        $user_name = $_SESSION['name'];
                        $find_user_id = "SELECT * FROM user WHERE username = '$user_name'";
                        $run_find_user_id = mysqli_query($cnx, $find_user_id);

                        foreach($run_find_user_id as $user) {
                            
                            $id_to_find = $user['id'];
                            $fetchaccount = "SELECT * FROM account WHERE user_id = $id_to_find";
                            $data = $cnx->query($fetchaccount);

                            foreach($data as $user_account) {
                                echo "<option value='" . $user_account['id'] ."' > ( Account Id : " . $user_account['id'] . " ) ( Rib : " . $user_account['rib'] . " )</option>";
                            }
                        }

                    ?>
                </select>
                <select name="type" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Transaction Type</option>
                    <option value="credit">credit</option>
                    <option value="debit">debit</option>
                </select>    
                <input name="amount" type="number" placeholder="Amount" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                
                <button type="submit" name="add_transaction" class="bg-gray-600 text-white text-xl rounded">Make A Transaction</button>
            </form>
        </section>

        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light" >
                        <thead class="border-b font-medium dark:border-neutral-500  border-2 border-gray-600 bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Ville</th>
                                <th scope="col" class="px-6 py-4">Quartier</th>
                                <th scope="col" class="px-6 py-4">rue</th>
                                <th scope="col" class="px-6 py-4">code postal</th>
                                <th scope="col" class="px-6 py-4">email</th>
                                <th scope="col" class="px-6 py-4">phone</th>
                            </tr>
                        </thead>
                        <tbody class=" border-2 border-gray-600">

                        <?php

                            $user_name = $_SESSION['name'];

                            $find_username = "SELECT * FROM user WHERE username = '$user_name'";
                            $run_find_username = mysqli_query($cnx, $find_username);

                            foreach($run_find_username as $user) {
                                
                                echo "<tr>";
                                echo "<td scope='col' class='px-6 py-4'>" . $user['id'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $user['username'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $user['role_id'] . "</th>";

                                $find_address = "SELECT * FROM address WHERE id = " . $user['address_id'] ."";
                                $run_find_address = mysqli_query($cnx, $find_address);

                                foreach($run_find_address as $addressInfo) {
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['ville'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['quartier'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['rue'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['code_postal'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['email'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['telephone'] . "</th>";
                                }

                                echo "</tdscope=>";
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            </main>
    </div>


</body>
</html>





    

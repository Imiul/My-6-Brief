
<?php
    
    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }
    include('../../-- DATABASE/db-connection.php');


    if (isset($_POST['add_account'])) {
        $userId = $_POST['userId'];
        $rib = time();
        // echo $rib;
        $devise = $_POST['devise'];
        $balance = $_POST['balance'];

        if (empty($userId) || empty($devise) || empty($balance)) {
            echo "<script>window.alert('Inputs should not be empty');</script>";
        } else {

            $query = "
                INSERT INTO account (rib, devise, balance, user_id)
                VALUES ('$rib', '$devise', '$balance', '$userId');
            ";

            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('Account Added succesfuly');</script>";

        }
    }

    if (isset($_GET['rm'])) {
        $id_to_remove = $_GET['rm'];

        $query = "
            DELETE FROM `account` WHERE `id` = '$id_to_remove';
        ";

        $run_query = mysqli_query($cnx, $query);
        echo "<script>window.alert('Account Deleated Succesfully');</script>";
        header("Location: Accounts.php");
    }


    if (isset($_POST['logout'])) {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: ../../Login.php');
        exit();
    }

    $fetchUsers = "SELECT * FROM user";
    $userData = $cnx->query($fetchUsers);

    $fetchAccounts = "SELECT * FROM account";
    $accountData = $cnx->query($fetchAccounts);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body>

<div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="../index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" >Home</a>
                    <a href="bank.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Bank's</a>
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    </div>
                </div>
                </div>
                <div class="hidden md:block">

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
            </div>

            
        </nav>


        <!-- PAGE CONTENT ===================== -->
        <section class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" >
            <form method="post" placeholder class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <select name="userId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Choose User to Create An Account </option>
                    <?php

                        foreach($userData as $user) {
                            echo "<option value='" . $user['id'] . "' >" . $user['username'] . "</option>";
                        }
                    ?>  
                </select>
                <input name="rib" type="text" hidden placeholder="Rib" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="devise" type="text" placeholder="Devise" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="balance" type="text" placeholder="Balance" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">

                <button type="submit" name="add_account" class="bg-gray-600 text-white text-xl rounded">Add Account</button>
            </form>
        </section>


        <!-- PAGE CONTENT ===================== -->
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Rib</th>
                                <th scope="col" class="px-6 py-4">Devise</th>
                                <th scope="col" class="px-6 py-4">Balance</th>
                                <th scope="col" class="px-6 py-4">User Id</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                                foreach($accountData as $account) {
                                    echo "<tr class='border-b dark:border-neutral-500'>";
                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" .$account['id'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" .$account['rib'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" .$account['devise'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" .$account['balance'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" .$account['user_id'] . "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                        echo "<a href='Accounts.php?upd=". $account['id'] . "' class='bg-blue-600 mr-4 py-2 px-8 text-white font-bold' >Edit</a>";
                                        echo "<a href='Accounts.php?rm=". $account['id'] . "' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </main>
    </div>


</body>
</html>





    

<?php

    include('../../-- Database/db-connection.php');

    $fetchRoles = "SELECT * FROM role;";
    $rolesData = $cnx->query($fetchRoles);



    if (isset($_POST['add_user'])) {
        
        $username = $_POST('UserName');
        $password = $_POST('password');
        $address_id = $_POST('AddressId');
        $userRole = $_POST('userRole');

        if (empty($username) || empty($password) || empty($address_id)) {
            echo "<script>window.alert('Inputs Shuld Not Be Empty');</script>";
        } else {

            $query = "
                INSERT INTO user (username, password, role_id, address_id)
                VALUES ($username, $password, $userRole, $address_id)
            ";
        }
    }

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
                    <a href="Users.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </nav>


        <!-- PAGE CONTENT ===================== -->
        <section id="add" class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 " >
            <!-- <h3 class="sm:px-20">Add A User</h3> -->
            <form id="add_user" action="Users.php" placeholder class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <input name="UserName" type="text" placeholder="User UserName" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="password" type="text" placeholder="Password" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                <input name="AddressId" type="text" placeholder="User Address Id" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                <select name="userRole" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                    <option value="">Choose User Role</option>
                    <?php
                        foreach($rolesData as $role) {
                            echo "<option value=" . $role['name'] . ">" . $role['name'] . "</option>";
                        }
                    ?>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>

                <button type="submit" class="bg-gray-600 text-white text-xl rounded">Add User</button>
            </form>
        </section>

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
                                <th scope="col" class="px-6 py-4">UserName</th>
                                <th scope="col" class="px-6 py-4">Password</th>
                                <th scope="col" class="px-6 py-4">Address Id</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">1</td>
                                <td class="whitespace-nowrap px-6 py-4">t-amiine</td>
                                <td class="whitespace-nowrap px-6 py-4">hdfkjbds</td>
                                <td class="whitespace-nowrap px-6 py-4">1</td>
                                <td class="whitespace-nowrap px-6 py-4">Admin</td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <button class="bg-blue-600 py-2 px-8 text-white font-bold">Edit</button>
                                    <button class="bg-red-600 py-2 px-8 text-white font-bold">Remove</button>
                                </td>
                            </tr>
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





    

<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}


if (isset($_POST['checkinfo'])) {
    //VENDOR
    if ($_POST['role'] == "vendor") {
        if (checkUniqueUsername($_POST['vendorUsername']) == true) {
            if (checkUniqueBusinessName_UniqueBusinessAddress($_POST['vendorBusinessName'], $_POST['vendorBusinessAddress']) == true) {
                $pass = password_hash($_POST['vendorPassword'], PASSWORD_DEFAULT);

                // Getting data from register.php and database
                $account = json_decode(file_get_contents('../database/accounts.db'), true);
                $business = json_decode(file_get_contents('../database/business.db'), true);

                // First user
                if ($account == null) {
                    $account = [];
                }
                if ($business == null) {
                    $business = [];
                }

                //Array push

                $account_data = array('username' => $_POST['vendorUsername'], 'password' =>  $pass, 'role' => $_POST['role']);
                $business_data = array('username' => $_POST['vendorUsername'], 'business_name' => $_POST['vendorBusinessName'], 'business_address' => $_POST['vendorBusinessAddress']);
                array_push($account, $account_data);
                array_push($business, $business_data);
                $account = json_encode($account);
                $business = json_encode($business);

                // Upload profile picture



                $info = pathinfo($_FILES['vendorProfilePicture']['name']);
                $ext = $info['extension'];
                $newname = $_POST['vendorUsername'] . "." . $ext;
                $target = '../database/profile_picture/' . $newname;
                move_uploaded_file($_FILES['vendorProfilePicture']['tmp_name'], $target);

                // Write to database

                file_put_contents('../database/business.db', $business);
                file_put_contents('../database/accounts.db', $account);
                header("location: success.php");
            } else {
                header("location: fail.php");
            }
        } else {
            header("location: fail.php");
        }

        //CUSTOMER
    }
    if ($_POST['role'] == 'customer') {
        if (checkUniqueUsername($_POST['customerUsername']) == true) {
            $pass = password_hash($_POST['customerPassword'], PASSWORD_DEFAULT);

            // Getting data from register.php and database
            $account = json_decode(file_get_contents('../database/accounts.db'), true);
            $customer = json_decode(file_get_contents('../database/customers.db'), true);

            // First user
            if ($account == null) {
                $account = [];
            }
            if ($customer == null) {
                $customer = [];
            }

            //Array push

            $account_data = array('username' => $_POST['customerUsername'], 'password' =>  $pass, 'role' => $_POST['role']);
            $customer_data = array('username' => $_POST['customerUsername'], 'customer_name' => $_POST['customerName'], 'customer_address' => $_POST['customerAddress']);
            array_push($account, $account_data);
            array_push($customer, $customer_data);
            $account = json_encode($account);
            $customer = json_encode($customer);

            // Upload profile picture

            $info = pathinfo($_FILES['customerProfilePicture']['name']);
            $ext = $info['extension'];
            $newname = $_POST['customerUsername'] . "." . $ext;
            $target = '../database/profile_picture/' . $newname;
            move_uploaded_file($_FILES['customerProfilePicture']['tmp_name'], $target);

            // Write to database
            file_put_contents('../database/customers.db', $customer);
            file_put_contents('../database/accounts.db', $account);
            header("location: success.php");
        } else {
            header("location: fail.php");
        }

        //SHIPPER
    }
    if ($_POST['role'] == 'shipper') {
        if (checkUniqueUsername($_POST['shipperUsername']) == true) {
            $pass = password_hash($_POST['shipperPassword'], PASSWORD_DEFAULT);

            // Getting data from register.php and database
            $account = json_decode(file_get_contents('../database/accounts.db'), true);
            $shipper = json_decode(file_get_contents('../database/shippers.db'), true);

            // First user
            if ($account == null) {
                $account = [];
            }
            if ($shipper == null) {
                $shipper = [];
            }

            //Array push

            $account_data = array('username' => $_POST['shipperUsername'], 'password' =>  $pass, 'role' => $_POST['role']);
            $shipper_data = array('username' => $_POST['shipperUsername'], 'distribution_hub' => $_POST['shipperDistributionHub']);
            array_push($account, $account_data);
            array_push($shipper, $shipper_data);
            $account = json_encode($account);
            $shipper = json_encode($shipper);

            // Upload profile picture

            $info = pathinfo($_FILES['shipperProfilePicture']['name']);
            $ext = $info['extension'];
            $newname = $_POST['shipperUsername'] . "." . $ext;
            $target = '../database/profile_picture/' . $newname;
            move_uploaded_file($_FILES['shipperProfilePicture']['tmp_name'], $target);

            // Write to database
            file_put_contents('../database/shippers.db', $shipper);
            file_put_contents('../database/accounts.db', $account);
            header("location: success.php");
        } else {
            header("location: fail.php");
        }
    }
}

function checkUniqueBusinessName_UniqueBusinessAddress($business_name, $business_address)
{
    $content = file_get_contents('../database/business.db');
    $arr = json_decode($content, true);
    if ($arr !== null) {
        foreach ($arr as $key => $item) {
            if ($business_name == $item['business_name']) {

                return false;
            }
            if ($business_address == $item['business_address']) {

                return false;
            }
        }
        return true;
    } else {
        return true;
    }
}

function checkUniqueUsername($usrn)
{
    $account = json_decode(file_get_contents('../database/accounts.db'), true);
    if ($account !== null) {
        foreach ($account as $key => $item) {
            if ($usrn == $item['username']) {

                return false;
            }
        }
        return true;
    } else {
        return true;
    }
}

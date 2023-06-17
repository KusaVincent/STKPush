<?php

function property_data_insert($deposit, $id, $dbh, $checkout_request_id, $result_code)
{
    $paid = 1;

    if ($result_code == 1037) {
        $results['server_response'] = "timeout";
        // echo json_encode($results);
    } elseif ($result_code == 0) {
        $results['server_response'] = "successful";

        $sql = "UPDATE property SET paid=:paid,checkoutRequestID=:checkout_request_id,propertyDeposit=:deposit WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':paid', $paid, PDO::PARAM_STR);
        $query->bindParam(':checkout_request_id', $checkout_request_id, PDO::PARAM_STR);
        $query->bindParam(':deposit', $deposit, PDO::PARAM_STR);
        $query->execute();
    } elseif ($result_code == 1032) {

        $results['server_response'] = "cancelled";
        // echo json_encode($results);
        # code...
    } else {
        $results['server_response'] = "limited";
        // echo json_encode($results);
    }

    $_SESSION['message'] =  $results['server_response'];
}

function user_data_insert($deposit, $id, $dbh, $checkout_request_id, $result_code)
{
    $rental_owner_activation = "activated";
    $depo = $deposit;
    if ($result_code == 1037) {
        $results['server_response'] = "timeout";
        // echo json_encode($results);
    } elseif ($result_code == 0) {
        $results['server_response'] = "successful";

        $sql = "UPDATE user SET rental_owner_activation=:rental_owner_activation,mpesaCheckoutRequestID=:checkout_request_id WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':rental_owner_activation', $rental_owner_activation, PDO::PARAM_STR);
        $query->bindParam(':checkout_request_id', $checkout_request_id, PDO::PARAM_STR);
        $query->execute();
    } elseif ($result_code == 1032) {

        $results['server_response'] = "cancelled";
        // echo json_encode($results);
        # code...
    } else {
        $results['server_response'] = "limited";
        // echo json_encode($results);
    }

    $_SESSION['message'] =  $results['server_response'];
}
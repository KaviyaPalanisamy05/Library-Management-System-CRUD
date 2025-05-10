<?php
include("db.php");

if (isset($_POST['save_newuser'])) {
    $book_name = mysqli_real_escape_string($conn, $_POST['book_name']);
    $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $return_date = mysqli_real_escape_string($conn, $_POST['return_date']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $query = "INSERT INTO lend (book_name, author_name, customer_name, return_date, price)
              VALUES ('$book_name', '$author_name', '$customer_name', '$return_date', '$price')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Details Added Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error: ' . mysqli_error($conn)]);
    }
}

if (isset($_POST['delete_user'])) {
    $customer_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "DELETE FROM lend WHERE id='$customer_id'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Details Deleted Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Deletion Failed']);
    }
}

if (isset($_POST['edit_user'])) {
    $customer_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "SELECT * FROM lend WHERE id='$customer_id'";
    $query_run = mysqli_query($conn, $query);
    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $data = mysqli_fetch_assoc($query_run);
        echo json_encode(['status' => 200, 'data' => $data]);
    } else {
        echo json_encode(['status' => 404, 'message' => 'Record not found']);
    }
}

if (isset($_POST['update_user'])) {
    $customer_id = mysqli_real_escape_string($conn, $_POST['id']);
    $book_name = mysqli_real_escape_string($conn, $_POST['ebook_name']);
    $author_name = mysqli_real_escape_string($conn, $_POST['eauthor_name']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['ecustomer_name']);
    $return_date = mysqli_real_escape_string($conn, $_POST['ereturn_date']);
    $price = mysqli_real_escape_string($conn, $_POST['eprice']);

    $query = "UPDATE lend SET 
                book_name='$book_name',
                author_name='$author_name',
                customer_name='$customer_name',
                return_date='$return_date',
                price='$price'
              WHERE id='$customer_id'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Details Updated Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Update Failed: ' . mysqli_error($conn)]);
    }
}

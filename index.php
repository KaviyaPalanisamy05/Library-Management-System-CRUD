<!-- database connectivity -->
<?php
include("db.php");
$sql = "SELECT * from lend";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <center>
        <h2>LIBRARY MANAGEMENT SYSTEM</h2>
    </center>
    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew" style="margin-right: 100px;">Create New</button><br><br>

    <!-- Add Modal -->
    <div class="modal fade" id="addnew" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formadd">
                    <div class="modal-body">
                        <input type="text" class="form-control mb-2" placeholder="Book Name" name="book_name" required>
                        <input type="text" class="form-control mb-2" placeholder="Author Name" name="author_name" required>
                        <input type="text" class="form-control mb-2" placeholder="Customer Name" name="customer_name" required>
                        <input type="date" class="form-control mb-2" name="return_date" required>
                        <input type="number" class="form-control mb-2" placeholder="Price" name="price" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edituser">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Book</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="text" class="form-control mb-2" id="ebook_name" name="ebook_name" required>
                        <input type="text" class="form-control mb-2" id="eauthor_name" name="eauthor_name" required>
                        <input type="text" class="form-control mb-2" id="ecustomer_name" name="ecustomer_name" required>
                        <input type="date" class="form-control mb-2" id="ereturn_date" name="ereturn_date" required>
                        <input type="number" class="form-control mb-2" id="eprice" name="eprice" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <center>
        <table class="table table-striped table-bordered" id="customer" style="width:1200px;">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Customer</th>
                    <th>Return Date</th>
                    <th>Price</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php $s = 1;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $s++ ?></td>
                        <td><?php echo $row['book_name'] ?></td>
                        <td><?php echo $row['author_name'] ?></td>
                        <td><?php echo $row['customer_name'] ?></td>
                        <td><?php echo $row['return_date'] ?></td>
                        <td><?php echo $row['price'] ?></td>
                        <td>
                            <button class="btn btn-success useredit" data-bs-toggle="modal" data-bs-target="#edit" value="<?php echo $row['id'] ?>">Edit</button>
                            <button class="btn btn-danger userdelete" value="<?php echo $row['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </center>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add book
        $('#formadd').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("save_newuser", true);
            $.ajax({
                type: "POST",
                url: "backend.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status == 200) {
                        $('#addnew').modal('hide');
                        $('#formadd')[0].reset();
                        $('#customer').load(location.href + " #customer");
                    }
                }
            });
        });

        // Delete book
        $(document).on('click', '.userdelete', function() {
            if (confirm('Are you sure you want to delete this record?')) {
                $.post("backend.php", {
                    delete_user: true,
                    user_id: $(this).val()
                }, function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    $('#customer').load(location.href + " #customer");
                });
            }
        });

        // Load data for edit
        $(document).on('click', '.useredit', function() {
            $.post("backend.php", {
                edit_user: true,
                user_id: $(this).val()
            }, function(response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
                    $('#id').val(res.data.id);
                    $('#ebook_name').val(res.data.book_name);
                    $('#eauthor_name').val(res.data.author_name);
                    $('#ecustomer_name').val(res.data.customer_name);
                    $('#ereturn_date').val(res.data.return_date);
                    $('#eprice').val(res.data.price);
                }
            });
        });

        // Update book
        $('#edituser').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("update_user", true);
            $.ajax({
                type: "POST",
                url: "backend.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status == 200) {
                        $('#edit').modal('hide');
                        $('#customer').load(location.href + " #customer");
                    }
                }
            });
        });
    </script>
</body>

</html>
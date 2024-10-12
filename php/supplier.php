<?php include('header.php'); ?>
<body>
<?php include('navbar.php'); ?>
<div class="container">
    <h4 class="page-header text-center">SUPPLIER MANAGEMENT</h1>
    <div class="row">
        <div class="col-md-12">
            <a href="#addsupplier" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Supplier</a>
        </div>
    </div>
    <div style="margin-top:10px;">
        <table class="table table-striped table-bordered">
            <thead>
            <th class="wrap_content">Action</th>
            <th>Name</th>
            <th>Address</th>
            </thead>
            <tbody>
            <?php
            $where = "";
            $sql="select * from supplier where status=1 order by id desc";
            $query=$conn->query($sql);
            while($row=$query->fetch_array()){
                ?>
                <tr>
                    <td class="wrap_content">
                        <a href="#editsupplier<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <a href="#deletesupplier<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        <?php include('supplier_modal.php'); ?>
                    </td>
                    <td><?php echo $row['name']; ?><br /><b><?php echo $row['contact']; ?></b></td>
                    <td><?php echo $row['address']; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('modal.php'); ?>
</body>
</html>
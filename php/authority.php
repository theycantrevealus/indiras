<?php include('header.php'); ?>
<body>
<?php include('navbar.php'); ?>
<div class="container">
    <h4 class="page-header text-center">AUTHORITY MANAGEMENT</h1>
    <div class="row">
        <div class="col-md-12">
<!--            <a href="#addauthority" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Authority</a>-->
        </div>
    </div>
    <div style="margin-top:10px;">
        <table class="table table-striped table-bordered">
            <thead>
            <th class="wrap_content">Action</th>
            <th>Name</th>
            </thead>
            <tbody>
            <?php
            $where = "";
            $sql="select * from authority where status = 1";
            $query=$conn->query($sql);
            while($row=$query->fetch_array()){
                ?>
                <tr>
                    <td class="wrap_content">
                        <a href="#editauthority<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        <?php include('authority_modal.php'); ?>
                    </td>
                    <td><?php echo $row['name']; ?></td>
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
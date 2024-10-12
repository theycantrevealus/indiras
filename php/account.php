<?php
if (!isset($_SESSION['username'])) {
    header('Location:login.php');
} else {
    if($_SESSION['authority'] !== 'ADM') {
        header('Location:403.php');
    }
}

include('header.php');
?>
<body>
<?php include('navbar.php'); ?>
<div class="container">
    <h4 class="page-header text-center">ACCOUNT MANAGEMENT</h4>
    <div class="row">
        <div class="col-md-12">
            <select id="catList" class="btn btn-default">
                <option value="0">All Authority</option>
                <?php
                $sql="select * from authority";
                $catquery=$conn->query($sql);
                while($catrow=$catquery->fetch_array()){
                    $catid = isset($_GET['authority']) ? $_GET['authority'] : 0;
                    $selected = ($catid == $catrow['id']) ? " selected" : "";
                    echo "<option$selected value=".$catrow['id'].">".$catrow['name']."</option>";
                }
                ?>
            </select>
            <a href="#addaccount" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Account</a>
        </div>
    </div>
    <div style="margin-top:10px;">
        <table class="table table-striped table-bordered">
            <thead>
            <th class="wrap_content">Action</th>
            <th>Username</th>
            <th>Name</th>
            <th>Authority</th>
            </thead>
            <tbody>
            <?php
            $where = ["account.status=1"];
            if(isset($_GET['authority']))
            {
                $authid=$_GET['authority'];
                array_push($where, "account.authority=$authid");
            }

            if(count($where) > 0) {
                $sql="select account.id, account.username, account.name as account_name, account.contact, account.authority, authority.name as authority_name from account left join authority on authority.id=account.authority WHERE " . join(" AND ", $where) . " order by account.name asc";
            } else {
                $sql="select account.id, account.username, account.name as account_name, account.contact, account.authority, authority.name as authority_name from account left join authority on authority.id=account.authority order by account.name asc";
            }

            $query=$conn->query($sql);
            while($row=$query->fetch_array()){
                ?>
                <tr>
                    <td class="wrap_content">
                        <a href="#editaccount<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <a href="#deleteaccount<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        <?php include('account_modal.php'); ?>
                    </td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['account_name']; ?></td>
                    <td><?php echo $row['authority_name']; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('modal.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#catList").on('change', function(){
            if($(this).val() == 0)
            {
                window.location = 'account.php';
            }
            else
            {
                window.location = 'account.php?authority='+$(this).val();
            }
        });
    });
</script>
</body>
</html>
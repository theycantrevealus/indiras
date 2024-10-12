<?php include('header.php'); ?>
<body>
<?php include('navbar.php'); ?>
<div class="container">
	<h4 class="page-header text-center">PRODUCTS MANAGEMENT</h4>
	<div class="row">
		<div class="col-md-2">
			<select id="catList" class="btn btn-default">
			<option value="0">All Category</option>
			<?php
				$sql="select * from category";
				$catquery=$conn->query($sql);
				while($catrow=$catquery->fetch_array()){
					$catid = isset($_GET['category']) ? $_GET['category'] : 0;
					$selected = ($catid == $catrow['categoryid']) ? " selected" : "";
					echo "<option$selected value=".$catrow['categoryid'].">".$catrow['catname']."</option>";
				}
			?>
			</select>
		</div>
        <div class="col-md-2">
            <select id="catList" class="btn btn-default">
                <option value="0">All Supplier</option>
                <?php
                $sql="select * from supplier";
                $catquery=$conn->query($sql);
                while($catrow=$catquery->fetch_array()){
                    $catid = isset($_GET['supplier']) ? $_GET['supplier'] : 0;
                    $selected = ($catid == $catrow['id']) ? " selected" : "";
                    echo "<option$selected value=".$catrow['id'].">".$catrow['name']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" value="<?php echo isset($_GET['search_name']) ? $_GET['search_name'] : ""; ?>" placeholder="Search Product. Type and press enter" name="search_name" />
        </div>
        <div class="col-md-2">
            <a href="#addproduct" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Product</a>
        </div>
        <div class="col-md-2">
            <a href="#importproduct" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Import</a>
        </div>
	</div>
	<div style="margin-top:10px;">
		<table class="table table-striped">
			<thead>
                <th class="wrap_content">Action</th>
				<th>Product Name</th>
                <th>Supplier</th>
				<th class="wrap_content" colspan="2">Price</th>
			</thead>
			<tbody>
				<?php
					$where = ["product.status=1"];
					if(isset($_GET['category']))
					{
						$catid=$_GET['category'];
                        array_push($where, "product.categoryid = $catid");
					}

                    $fields = "
                    product.productid,
                    product.categoryid,
                    product.productname,
                    product.supplierid,
                    product.price,
                    product.photo,
                    
                    category.catname,
                    supplier.name as suppliername
                    ";

                    if(count($where) > 0) {
                        $sql="select $fields from product left join category on category.categoryid=product.categoryid left join supplier on product.supplierid = supplier.id WHERE " . join(" AND ", $where) . " order by product.categoryid asc, productname asc";
                    } else {
                        $sql="select $fields from product left join category on category.categoryid=product.categoryid left join supplier on product.supplierid = supplier.id order by product.categoryid asc, productname asc";
                    }

					$query=$conn->query($sql);
					while($row=$query->fetch_array()){
						?>
						<tr>
                            <td class="wrap_content">
                                <a href="#editproduct<?php echo $row['productid']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a> <a href="#deleteproduct<?php echo $row['productid']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                                <?php include('product_modal.php'); ?>
                            </td>
							<td>
                                <table>
                                    <tr>
                                        <td class="wrap_content" style="padding: 10px">
                                            <a href="<?php if(empty($row['photo'])){echo "upload/noimage.jpg";} else{echo $row['photo'];} ?>"><img src="<?php if(empty($row['photo'])){echo "upload/noimage.jpg";} else{echo $row['photo'];} ?>" height="30px" width="40px"></a>
                                        </td>
                                        <td>
                                            <b><?php echo $row['productname']; ?></b><br />
                                            <?php echo $row['catname']; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php echo $row['suppliername']; ?>
                            </td>
                            <td class="wrap_content">Rp. </td>
							<td class="wrap_content text-right"><?php echo number_format($row['price'], 2); ?></td>
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
				window.location = 'product.php';
			}
			else
			{
				window.location = 'product.php?category='+$(this).val();
			}
		});
	});
</script>
</body>
</html>
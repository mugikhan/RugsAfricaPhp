<?php

    if(isset($_GET['id'])){
        $query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
        confirm($query);

        while($row = fetch_array($query)) {
            $productTitle = escape_string($row['product_title']);
            $productCatID = escape_string($row['product_category_id']);
            $productPrice = escape_string($row['product_price']);
            $productQuantity = escape_string($row['product_quantity']);
            $productDesc = escape_string($row['product_desc']);
            $productShortDesc = escape_string($row['product_short_desc']);
            //$productImage = escape_string($row['product_image']);
            $productImage = display_image($row['product_image']);
        }

        edit_product();
    }
?>
<div class="col-md-12">

    <div class="row">
        <h1 class="page-header">
            Edit Product

        </h1>
    </div>



    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">

            <div class="form-group">
                <label for="product-title">Product Title </label>
                <input type="text" name="product_title" class="form-control" value="<?php echo $productTitle ?>">

            </div>


            <div class="form-group">
                <label for="product-desc">Product Description</label>
                <textarea name="product_desc" id="" cols="30" rows="10" class="form-control"><?php echo $productDesc ?></textarea>
            </div>



            <div class="form-group row">

                <div class="col-xs-3">
                    <label for="product-price">Product Price</label>
                    <input type="number" name="product_price" class="form-control" size="60" value="<?php echo $productPrice ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="product-short-desc">Product Short Description</label>
                <textarea name="product_short_desc" id="" cols="15" rows="5" class="form-control"><?php echo $productShortDesc ?></textarea>
            </div>


        </div><!--Main Content-->


        <!-- SIDEBAR-->


        <aside id="admin_sidebar" class="col-md-4">
            <div class="form-group">
                <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
                <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
            </div>


            <!-- Product Categories-->

            <div class="form-group">
                <label for="product-title">Product Category</label>
                <hr>
                <select name="product_category_id" id="" class="form-control" required>
                    <option value="<?php echo $productCatID; ?>"><?php echo show_product_category($productCatID); ?></option>
                    <?php show_categories_admin(); ?>
                </select>


            </div>

            <!-- Product Brands-->
            <div class="form-group">
                <label for="product-quantity">Product Quantity</label>
                <input type="number" name="product_quantity" class="form-control" value="<?php echo $productQuantity ?>">
            </div>


            <!-- Product Tags -->
            <!--<div class="form-group">
                  <label for="product-title">Product Keywords</label>
                  <hr>
                <input type="text" name="product_tags" class="form-control">
            </div>-->

            <!-- Product Image -->
            <div class="form-group">
                <label for="product-title">Product Image</label>
                <input type="file" name="file"><br>
                <img src="../../resources/<?php echo $productImage ?>" style="height: 200px; width: 200px">

            </div>

        </aside><!--SIDEBAR-->
    </form>
</div>
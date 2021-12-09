<section class="checkout-page">
    <div class="container">
        <div class="heading-sub">
            <h3 class="pull-left">Product</h3>
            <ul class="other-link-sub pull-right">
                <li><a href="#home">Home</a></li>

                <li><a class="active" href="#cart">Wishlist</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>


        <div class="checkout-cart-form">
            <div class="row">
                <div class="col-md-12">

                    <table class="table shop_table">
                        <thead>
                            <tr>

                                <th class="product-thumbnail">ID</th>
                                <th class="product-thumbnail">IMAGE</th>
                                <th class="product-name">PRODUCT NAME</th>
                                <th class="product-price">PRICE</th>


                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($carts as $row) : ?>

                                <tr class="cart_item">
                                    <td class="product-thumbnail">
                                        <span><?php echo $row['id'] ?></span>
                                    </td>

                                    <td class="product-thumbnail">



                                        <a href="<?php echo base_url('product/view/' . $row['id']) ?>"><img src="<?php echo base_url('upload/product/' . $row['image_link']) ?>" alt="images" class="img-responsive"></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="<?php echo $row['name'] ?>"><?php echo $row['name']; ?></a>
                                    </td>
                                    <td class="product-price">
                                        <p class="price"><?php echo number_format($row['price']); ?> VNĐ</p>
                                    </td>


                                    <td class="">

                                        <a onclick="return confirm('Are you want to delete?')" href="<?php echo base_url('wishlist/del/' . $row['id']) ?>" class="avatar avatar-lg rounded-circle" title="Delete <?php echo $row['name'] ?>">
                                            <img src="<?php echo public_url('admin/assets') ?>/img/trash-outline.svg" style="height: 24px; width:5000px; margin-top:70px; margin-left: -230px;" alt="Image placeholder">
                                        </a>


                                    </td>



                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            </div>


        </div>

    </div>
</section>
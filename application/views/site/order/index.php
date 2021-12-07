<section class="checkout-page">
    <div class="container">
        <div class="heading-sub">
            <h3 class="pull-left">history</h3>
            <ul class="other-link-sub pull-right">
                <li><a href="#home">Home</a></li>

                <li><a class="active" href="#cart">Order</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>


        <div class="checkout-cart-form">
            <div class="row">
                <div class="col-md-12">

                    <table class="table shop_table">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">IMAGE</th>
                                <th class="product-name">PRODUCT NAME</th>
                                <th class="product-price">PRICE</th>
                                <th class="quantity">QUANTITY</th>
                                <th class="product-subtotal">STATUS</th>
                                <th class="">ACTION</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($ordered as $row) : ?>

                                <tr class="cart_item">


                                    <td class="product-thumbnail">



                                        <a href="<?php echo base_url('product/view/' . $row->id) ?>"><img src="<?php echo base_url('upload/product/' . $row->image_link) ?>" alt="images" class="img-responsive"></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="<?php echo $row->product_name; ?>"><?php echo $row->product_name; ?></a>
                                    </td>
                                    <td class="product-price">
                                        <p class="price"><?php echo number_format($row->amount); ?> VNĐ</p>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="quantity">
                                            <input name="qty_<?php echo $row->id ?>" value="<?php echo $row->qty; ?>" min="1">
                                        </div>
                                    </td>
                                    <td class="product-price product-subtotal">
                                        <?php
                                        if ($row->status == '0') {
                                            echo 'Pending';
                                        } else if ($row->status == 1) {
                                        ?>
                                            <span>Delivered</span>

                                        <?php
                                        } else {
                                            echo 'Received';
                                        }
                                        ?>
                                    </td>
                                    <td class="">

                                        <a onclick="return confirm('Are you want to delete?')" href="<?php echo base_url('order/delete/' . $row->id) ?>" class="avatar avatar-lg rounded-circle" title="Delete <?php echo $row->product_name ?>">
                                            <img src="<?php echo public_url('admin/assets') ?>/img/trash-outline.svg" style="height: 24px; width:5000px; margin-top:70px; margin-left: -156px;" alt="Image placeholder">
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
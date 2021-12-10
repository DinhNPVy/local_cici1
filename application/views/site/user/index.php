<head>
    <?php $this->load->view('admin/head'); ?>
</head>
<section style="padding: 0px 93px 250px 379px;">


    <div class="container">
        <div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <a href="<?php echo base_url() ?>" title="Localware electronics store"><img style="border-radius: 50%; height: 80px" src="<?php echo public_url() ?>site/image/3meoww (2).png" alt="images" class="img-reponsive"></a>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1" style="font-size: 14px;">
                            <?php echo $user->name ?>
                        </h5>
                        <p class="mb-0 font-weight-bold" style="font-size: 12px;">
                            Student in their third year
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="row">

            <div class="col-xl-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0" style="font-size: 14px;">Profile Information</h6>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="<?php echo site_url('user/edit') ?>">
                                    <i class="fas fa-user-edit text-secondary" style="font-size: 18px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <p class="" style="font-size: 14px;">
                            Hi, I’m <?php echo $user->name ?>, My group chose the CodeIgniter framework as a third-year student at Ho Chi Minh City University of Education, based on the factors of ease of purchase, speed, and convenience.
                        </p>
                        <hr class="horizontal gray-light my-4">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0"><strong class="text-dark" style="font-size: 14px;">Full Name:</strong> <span style="font-size: 14px;">&nbsp; <?php echo $user->name ?> </span> </li>
                            <li class="list-group-item border-0 ps-0 "><strong class="text-dark" style="font-size: 14px;">Mobile:</strong> <span style="font-size: 14px;">&nbsp; <?php echo $user->phone ?> </span></li>
                            <li class="list-group-item border-0 ps-0 "><strong class="text-dark" style="font-size: 14px;">Email:</strong> <span style="font-size: 14px;">&nbsp; <?php echo $user->email ?> </span></li>
                            <li class="list-group-item border-0 ps-0 "><strong class="text-dark" style="font-size: 14px;">Location:</strong> <span style="font-size: 14px;">&nbsp; VietNam </span></li>
                            <li class="list-group-item border-0 ps-0 pb-0">
                                <strong class="text-dark" style="font-size: 14px;">Social:</strong> &nbsp;
                                <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-facebook fa-lg" style="height: 19px; font-size: 18px;"></i>
                                </a>
                                <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-twitter fa-lg" style="height: 19px; font-size: 18px;"></i>
                                </a>
                                <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-instagram fa-lg" style="height: 19px; font-size: 18px;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
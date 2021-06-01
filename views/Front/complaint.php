<?php
require "panier.class.php";
require "C:/xampp/htdocs/Naturimal/Controller/commandeC.php";
require "C:/xampp/htdocs/Naturimal/Controller/reclamationC.php";

$db = getConnexion();
$panier = new panier();
$comC = new commandeC();
$recC = new reclamationC();
if (isset($_GET['assistance'])) {
    header('location: chat/users.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('HeaderClient.php');
    ?>

</head>

<body class="goto-here">
    <div class="hero-wrap hero-bread" style="background-image: url('images/Botanique.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2" style="color:black"><a href="Accueil.php">Home</a></span> <span>Boutique</span></p>
                    <h1 class="mb-0 bread" style="color:black">Mes Achats</h1>
                </div>
            </div>
        </div>
    </div>
    <?php


    $ids_commandes = $recC->get_id_commandes_in_reclamation();
    foreach ($ids_commandes as $id_co) :
        //echo $id_co->id_commande;
    ?>
        <section class="ftco-section ftco-cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ftco-animate">
                        <div class="cart-list">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr class="text-center">
                                        <th>&nbsp;</th>
                                        <th>Product name</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $ids_produit = array();
                                    $email = $_SESSION['user'];
                                    $adresse = $comC->get_adresse_commande($email);

                                    $products = $recC->get_reclamation_for_complaints($email, $id_co->id_commande, "jardinage");

                                    if (!empty($products)) {
                                        foreach ($products as $product) {
                                            array_push($ids_produit, $product->idproduit);
                                            $fullname = $product->nom . " " . $product->prenom;
                                        }

                                        $purchases = $panier->product_table($db, $ids_produit, "jardinage");
                                        $i = 0;
                                        $tot = 0;
                                        if (!empty($purchases)) {
                                            foreach ($purchases as $product) :

                                    ?>
                                                <div class="itemsspecial">
                                                    <tr class="text-center">
                                                        <td class="image-prod">
                                                            <div class="img" style="background-image:url(<?= "images/" . $product->ImageArticle; ?>);"></div>
                                                        </td>

                                                        <td class="product-name">
                                                            <h3><?= $product->NomArticle; ?></h3>
                                                            <p><?= $product->DescriptionArticle; ?></p>
                                                        </td>

                                                    </tr><!-- END TR-->
                                                </div>
                                            <?php
                                            endforeach;
                                        }
                                    }

                                    //   ############################# ACCESS #########################################

                                    $ids_produit = array();
                                    $adresse = $comC->get_adresse_commande($email);
                                    $products = $recC->get_reclamation_for_complaints($email, $id_co->id_commande, "access");
                                    if (!empty($products)) {
                                        foreach ($products as $product) {
                                            array_push($ids_produit, $product->idproduit);
                                            $fullname = $product->nom . " " . $product->prenom;
                                        }

                                        $purchases = $panier->product_table($db, $ids_produit, "access");
                                        $i = 0;
                                        $tot = 0;
                                        if (!empty($purchases)) {
                                            foreach ($purchases as $product) :

                                            ?>
                                                <div class="itemsspecial">
                                                    <tr class="text-center">
                                                        <td class="image-prod">
                                                            <div class="img" style="background-image:url(<?= "images/" . $product->image; ?>);"></div>
                                                        </td>

                                                        <td class="product-name">
                                                            <h3><?= $product->nom; ?></h3>
                                                        </td>

                                                    </tr><!-- END TR-->
                                                </div>
                                            <?php
                                            endforeach;
                                        }
                                    }


                                    //   ############################# ALIMENT #########################################

                                    $ids_produit = array();
                                    $adresse = $comC->get_adresse_commande($email);
                                    $products = $recC->get_reclamation_for_complaints($email, $id_co->id_commande, "aliment");
                                    if (!empty($products)) {
                                        foreach ($products as $product) {
                                            array_push($ids_produit, $product->idproduit);
                                            $fullname = $product->nom . " " . $product->prenom;
                                        }

                                        $purchases = $panier->product_table($db, $ids_produit, "aliment");
                                        $i = 0;
                                        $tot = 0;
                                        if (!empty($purchases)) {
                                            foreach ($purchases as $product) :

                                            ?>
                                                <div class="itemsspecial">
                                                    <tr class="text-center">
                                                        <td class="image-prod">
                                                            <div class="img" style="background-image:url(<?= "images/" . $product->image; ?>);"></div>
                                                        </td>

                                                        <td class="product-name">
                                                            <h3><?= $product->nom; ?></h3>
                                                        </td>
                                                    </tr><!-- END TR-->
                                                </div>
                                    <?php
                                            endforeach;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">

                    <div class="col-lg-12 mt-5 cart-wrap ftco-animate">
                        <div class="cart-total mb-3">
                            <h3>Information : </h3>
                            <p>full name : <?= $fullname ?></p>
                            <p>Adress : <?= $adresse ?></p>
                            <form action="#" class="info">
                                <div class="form-group">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="cart-detail p-3 p-md-4">
                        <a href="chat/users.php">
                            <input type="submit" value="ask for assistance" name="assistance" class="btn btn-primary py-3 px-4"></input>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
    <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
        <div class="container py-4">
            <div class="row d-flex justify-content-center py-5">
                <div class="col-md-6">
                    <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
                    <span>Get e-mail updates about our latest shops and special offers</span>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <form action="#" class="subscribe-form">
                        <div class="form-group d-flex">
                            <input type="text" class="form-control" placeholder="Enter email address">
                            <input type="submit" value="Subscribe" class="submit px-3">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer class="ftco-footer ftco-section">
        <div class="container">
            <div class="row">
                <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Vegefoods</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Menu</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Shop</a></li>
                            <li><a href="#" class="py-2 d-block">About</a></li>
                            <li><a href="#" class="py-2 d-block">Journal</a></li>
                            <li><a href="#" class="py-2 d-block">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Help</h2>
                        <div class="d-flex">
                            <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
                                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
                                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
                                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><a href="#" class="py-2 d-block">FAQs</a></li>
                                <li><a href="#" class="py-2 d-block">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>



    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

    <!-- <script type ="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>  -->

    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script src="store.js"></script>

    <script>
        $(document).ready(function() {

            var quantitiy = 0;
            $('.quantity-right-plus').click(function(e) {

                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                var quantity = parseInt($('#quantity').val());

                // If is not undefined

                $('#quantity').val(quantity + 1);


                // Increment

            });

            $('.quantity-left-minus').click(function(e) {
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                var quantity = parseInt($('#quantity').val());

                // If is not undefined

                // Increment
                if (quantity > 0) {
                    $('#quantity').val(quantity - 1);
                }
            });

        });
    </script>
    <?php


    ?>
</body>

</html>
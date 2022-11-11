<?=template_header('Place Order')?>
<?php if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") :?>
<div class="placeorder">
    <h1>Your Order Has Been Placed</h1>
    <p >Thank you for ordering with mygruhini, we'll contact you by email with your order details.</p>
</div>
<?php else:?>
    <?=header("location:index.php?page=login");?>
<?php endif; ?>

<?=template_footer()?>
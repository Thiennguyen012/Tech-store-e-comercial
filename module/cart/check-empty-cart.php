<script>
    function checkCartBeforeCheckout() {
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;

        if (!cartHasItem) {
            alert("Your cart is empty. Please add some products before checking out.");
        } else {
            window.location.href = '?act=checkout';
        }
    }
</script>
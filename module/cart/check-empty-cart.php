<script>
    function checkCartBeforeCheckout() {
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;

        if (!cartHasItem) {
            // Hiển thị modal thay vì alert
            const emptyCartModal = new bootstrap.Modal(document.getElementById('emptyCartModal'));
            emptyCartModal.show();
        } else {
            window.location.href = '?act=checkout';
        }
    }
</script>
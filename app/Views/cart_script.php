<script>
    $(document).ready(() => {
        // Cargar el carrito desde localStorage
        var cart = JSON.parse(localStorage.getItem('cart')) || {};
        var newQuantity = parseInt(localStorage.getItem('newQuantity')) || 0; // Hacer newQuantity global

        // Actualizar la interfaz del carrito
        function updateCartInterface(cart) {
            var cartHtml = '';
            var totalQuantity = 0;

            if (Object.keys(cart).length === 0) {
                cartHtml = '<li><p class="text-center">Tu carrito de compras está vacío!</p></li>';
            } else {
                for (var id in cart) {
                    if (cart.hasOwnProperty(id) && typeof cart[id] === 'object' && cart[id] !== null) {
                        var product = cart[id];
                        cartHtml += '<li>' +
                            '<div class="text-center container-cart">' +
                            '<img src="<?php echo site_url(); ?>membresias/' + id + '/' + product.img + '" alt="' + product.name + '" title="' + product.name + '" width="50" />' +
                            '<button class="quantity-decrease btn" data-id="' + id + '">-</button>' +
                            '<span class="quantity">' + product.quantity + '</span>' +
                            '<button class="quantity-increase btn" data-id="' + id + '">+</button>' +
                            '<span class="name-product">' + product.name + '</span>' +
                            '<strong class="quantity-price">S/' + (product.quantity * product.price) + '</strong>' +
                            '<button class="remove-button btn btn-danger" data-id="' + id + '">X</button>' +
                            '</div>' +
                            '</li>';
                        totalQuantity += product.quantity;
                    }
                }
                cartHtml += '<li class="divider"></li><li><a href="<?php echo site_url() . "carrito"; ?>">Ver carrito</a></li>';
            }

            $('#list-of-products').html(cartHtml);
            $('#cart-total').text(totalQuantity);
        }

        function updateProductQuantity(id, quantityChange) {
            if (cart.hasOwnProperty(id)) {
                cart[id].quantity += quantityChange;
                if (cart[id].quantity <= 0) {
                    delete cart[id];
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                newQuantity = Object.values(cart).reduce((sum, product) => sum + product.quantity, 0);
                localStorage.setItem('newQuantity', newQuantity.toString());
                $('#cart-total').text(newQuantity);
                updateCartInterface(cart);
            } else {
                console.log('El producto no se encuentra en el carrito');
            }
        }

        // Función para eliminar un producto del carrito
        const removeItem = (id) => {
            if (cart.hasOwnProperty(id)) {
                delete cart[id];
                localStorage.setItem('cart', JSON.stringify(cart));
                newQuantity = Object.values(cart).reduce((sum, product) => sum + product.quantity, 0);
                localStorage.setItem('newQuantity', newQuantity.toString());
                $('#cart-total').text(newQuantity);
                updateCartInterface(cart);
            } else {
                console.log('El producto no se encuentra en el carrito');
            }
        };

        // Actualizar la interfaz del carrito al cargar la página
        updateCartInterface(cart);

        $('#button-cart').click(function() {
            var productId = <?php echo $obj_products->id; ?>;
            var quantity = parseInt($('#input-quantity').val());
            console.log('Cantidad ingresada:', quantity);

            if (!cart[productId]) {
                cart[productId] = {
                    name: '<?php echo addslashes($obj_products->name); ?>',
                    price: <?php echo $obj_products->price; ?>,
                    img: '<?php echo $obj_products->img; ?>',
                    quantity: quantity
                };
            } else {
                cart[productId].quantity += quantity;
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            $.ajax({
                url: '<?php echo site_url("cart/add_cart"); ?>',
                method: 'POST',
                data: {
                    membership_id: productId,
                    name: '<?php echo addslashes($obj_products->name); ?>',
                    price: <?php echo $obj_products->price; ?>,
                    img: '<?php echo $obj_products->img; ?>',
                    qty: cart[productId].quantity
                },
                success: function(response) {
                    console.log('Producto agregado al carrito exitosamente');
                    newQuantity = Object.values(cart).reduce((sum, product) => sum + product.quantity, 0);
                    localStorage.setItem('newQuantity', newQuantity.toString());
                    $('#cart-total').text(newQuantity);
                    updateCartInterface(cart);
                },
                error: function(xhr, status, error) {
                    console.error('Error al agregar el producto al carrito:', error);
                }
            });
        });

        // Manejador de eventos para el botón de eliminar producto
        $(document).on('click', '.remove-button', function() {
            const id = $(this).data('id');
            removeItem(id);
        });

        // Controlador de eventos para el botón de aumentar la cantidad
        $(document).on('click', '.quantity-increase', function() {
            const id = $(this).data('id');
            updateProductQuantity(id, 1);
        });

        // Controlador de eventos para el botón de disminuir la cantidad
        $(document).on('click', '.quantity-decrease', function() {
            const id = $(this).data('id');
            updateProductQuantity(id, -1);
        });
    });
</script>
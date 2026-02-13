<?php 
namespace App\Libraries;

class Cart  {  
    protected $cart;   

    //add cart
    public function add_cart($productId, $name, $price, $quantity = 1, $contable = 1)
    {
        //call session library
        $session = \Config\Services::session();
        //get content session cart
        $cart = $session->get('cart') ?? [];
        // Agrega el producto al carrito
        if (isset($cart[$productId])) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            $cart[$productId]['qty'] += $quantity;
        } else {
            // Agregamos el nuevo artículo
            $cart[$productId] = array(
                                    'product_id' => $productId,                     
                                    'name' => $name,
                                    'price' => $price,
                                    'qty' => $quantity,
                                    'contable' => $contable,
                                    );
            
        }
        // Guarda el carrito actualizado en la sesión
        $session->set('cart', $cart);
        return true;
    }

    public function edit_cart($productId, $quantity = 1)
    {
        //call session library
        $session = \Config\Services::session();
        //get content session cart
        $cart = $session->get('cart');
        // Agrega el producto al carrito
        if (isset($cart[$productId])) {
            // Si el producto ya está en el carrito, actualiza la cantidad
            $cart[$productId]['qty'] = $quantity;
        }
        // Guarda el carrito actualizado en la sesión
        $session->set('cart', $cart);
        return true;
    }

    public function remove_cart($productId)
    {
        //call session library
        $session = \Config\Services::session();
        //get content session cart
        $cart = $session->get('cart');
        unset($cart[$productId]);
        // Guarda el carrito actualizado en la sesión
        $session->set('cart', $cart);
        return true;
    }

    public function content()
    {
        //call session library
        $session = \Config\Services::session();
        // Obtiene el carrito actual de la sesión
        $cart = $session->get('cart');
        return $cart;
    }

    //count element cart
    public function cart_count()
    {
        //call session library
        $session = \Config\Services::session();
        // Obtiene el carrito actual de la sesión
        $cart = $session->get('cart') ?? [];
        $count_cart = count($cart);
        return $count_cart;
    }
    
    //get total
    public function total()
    {
        //cal session library
        $session = \Config\Services::session();
        $total = 0;
        $cart = $session->get('cart') ?? [];
        foreach ($cart as $productId => $value) {
            $price = intval($value['price']);
            $qty = intval($value['qty']);
            $total += $price * $qty;
        }
        return $total;
    }

    //get total
    public function cart_destroy()
    {   
        //delete array
        unset($_SESSION["cart"]);
    }
} 

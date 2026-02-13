const mp = new MercadoPago('TEST-6b5d9746-551d-44fa-bc07-01d32c92e73b');
			const bricksBuilder = mp.bricks();
			mp.bricks().create("wallet", "wallet_container", {
				initialization: {
					preferenceId: "<?php echo $preference->id;?>",
				},
			});
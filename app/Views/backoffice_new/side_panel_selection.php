<!-- Panel lateral personalizado para selección de lote y usuario -->
<div class="side-panel-custom">
    <div class="side-panel-header">
        <img alt="Logo" src="<?php echo site_url() . 'assets/front/img/logo/Recursovivencia.png'; ?>" width="40"
            style="margin-bottom: 10px;" />

        <!-- Panel lateral estilo minimalista -->
        <div class="panel-minimalista">
            <div class="panel-header">
                <img src="<?php echo site_url() . 'assets/front/img/logo/Recursovivencia.png'; ?>" width="32"
                    style="margin-bottom: 8px;" />
                <div class="panel-title">Tu selección</div>
                <div class="panel-login-msg">
                    <span class="panel-login-icon">&#128100;</span>
                    <span class="panel-login-text">Logueado como:
                        <b><?php echo $obj_customer['name'] . ' ' . $obj_customer['lastname']; ?></b></span>
                </div>
            </div>
            <form class="panel-form">
                <input type="text" class="panel-input"
                    value="<?php echo $obj_customer['name'] . ' ' . $obj_customer['lastname']; ?>" readonly />
                <input type="text" class="panel-input" value="<?php echo $obj_customer['dni']; ?>" readonly />
                <input type="text" class="panel-input" value="<?php echo $obj_customer['email']; ?>" readonly />
                <div class="panel-timer">
                    <span class="panel-timer-label">Tiempo restante:</span>
                    <span id="timer" class="panel-timer-value">10:00</span>
                </div>
                <div class="panel-lote-card" id="side-panel-selection-content">
                    <!-- JS: Detalle del lote seleccionado -->
                </div>
                <button type="submit" class="panel-btn">Finalizar Compra</button>
            </form>
        </div>
        <style>
        .panel-minimalista {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px 0 #0001;
            border: 1.5px solid #e3e6ef;
            min-width: 340px;
            max-width: 370px;
            padding: 28px 22px 22px 22px;
            margin-left: 16px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            position: relative;
        }

        .panel-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 12px;
        }

        .panel-title {
            font-size: 19px;
            font-weight: 700;
            color: #1a4e9b;
            margin-bottom: 0;
        }

        .panel-login-msg {
            background: #eafaf3;
            color: #1a4e9b;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .panel-login-icon {
            font-size: 18px;
            margin-right: 4px;
        }

        .panel-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .panel-input {
            background: #f8fafd;
            border: 1px solid #e3e6ef;
            color: #222;
            font-weight: 600;
            border-radius: 7px;
            padding: 8px 12px;
            font-size: 15px;
        }

        .panel-timer {
            background: #eafaf3;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 600;
            color: #1a4e9b;
            margin-bottom: 6px;
        }

        .panel-timer-value {
            font-size: 20px;
            font-weight: 700;
            color: #1a4e9b;
            background: #fff;
            border-radius: 8px;
            padding: 2px 14px;
            border: 1px solid #e3e6ef;
        }

        .panel-lote-card {
            background: #f8fafd;
            border-radius: 10px;
            border: 1.5px solid #e3e6ef;
            padding: 14px 16px;
            margin-bottom: 8px;
            min-height: 80px;
            font-size: 15px;
            color: #222;
            box-shadow: 0 1px 6px 0 #00000011;
        }

        .panel-btn {
            background: #1a4e9b;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-size: 17px;
            font-weight: 700;
            margin-top: 10px;
            transition: background 0.2s;
            box-shadow: 0 2px 8px 0 #1a4e9b22;
        }

        .panel-btn:hover {
            background: #163b6b;
        }
        </style>
        <script>
        // Temporizador de reserva (10 minutos)
        let timerValue = 600;
        let timerInterval;

        function startTimer() {
            const timerEl = document.getElementById('timer');
            if (!timerEl) return;
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                if (timerValue <= 0) {
                    clearInterval(timerInterval);
                    timerEl.textContent = '00:00';
                    return;
                }
                let min = Math.floor(timerValue / 60);
                let sec = timerValue % 60;
                timerEl.textContent = `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
                timerValue--;
            }, 1000);
        }
        document.addEventListener('DOMContentLoaded', startTimer);
        </script>
        clearInterval(timerInterval);
        timerEl.textContent = '00:00';
        return;
        }
        let min = Math.floor(timerValue / 60);
        let sec = timerValue % 60;
        timerEl.textContent = `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
        timerValue--;
        }, 1000);
        }
        document.addEventListener('DOMContentLoaded', startTimer);
        </script>
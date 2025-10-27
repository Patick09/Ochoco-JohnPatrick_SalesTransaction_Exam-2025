<!DOCTYPE html>
<html>
<head>
    <title>Transaction Processing System (TPS)</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100%;
            background: linear-gradient(135deg, #1a0033, #2d1b69, #4a148c, #6a1b9a, #8e24aa);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: #ffffff;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 30px 40px;
            background: rgba(0, 0, 0, 0.3);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .form-label {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        input, select, textarea {
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid #6a1b9a;
            width: 100%;
            font-size: 16px;
            margin-top: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #1a0033;
            transition: all 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #e1bee7;
            box-shadow: 0 0 15px rgba(225, 190, 231, 0.5);
            background: rgba(255, 255, 255, 1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        th, td {
            padding: 16px;
            text-align: left;
            color: #ffffff;
        }

        th {
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:nth-child(even) {
            background: rgba(106, 27, 154, 0.1);
        }

        tr:hover {
            background: rgba(225, 190, 231, 0.2);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        td:last-child {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            font-size: 14px;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a0033, #6a1b9a);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2d1b69, #8e24aa);
            color: #ffffff;
        }

        .btn-success {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f57c00, #ff9800);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ff9800, #ffb74d);
        }

        .btn-danger {
            background: linear-gradient(135deg, #c62828, #f44336);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #f44336, #ef5350);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #424242, #616161);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #616161, #757575);
        }

        .btn-dark {
            background: linear-gradient(135deg, #1a0033, #2d1b69);
        }

        .btn-dark:hover {
            background: linear-gradient(135deg, #2d1b69, #4a148c);
        }

        .stats-card {
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.4);
            margin: 15px;
            border: 2px solid rgba(106, 27, 154, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .stats-card h1 {
            font-size: 48px;
            color: #e1bee7;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 10px 0;
        }

        .stats-card h2 {
            color: #ffffff;
            margin-bottom: 15px;
        }

        .flex-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin: 20px 0;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4caf50;
            color: #ffffff;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: #ffffff;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f57c00, #ff9800);
            color: #ffffff;
        }

        .badge-danger {
            background: linear-gradient(135deg, #c62828, #f44336);
            color: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: #f44336 !important;
        }

        .form-text {
            color: #e1bee7;
            font-size: 14px;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-text {
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            color: #ffffff;
            border: 2px solid #6a1b9a;
            border-right: none;
            padding: 12px 16px;
            border-radius: 10px 0 0 10px;
            font-weight: 600;
        }

        .input-group input {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .table-dark {
            background: linear-gradient(135deg, #1a0033, #2d1b69);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(106, 27, 154, 0.05);
        }

        /* Card Styles */
        .card {
            background: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(106, 27, 154, 0.3);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(225, 190, 231, 0.5);
        }

        .card.border-primary {
            border-color: #6a1b9a !important;
            box-shadow: 0 0 20px rgba(106, 27, 154, 0.3);
        }

        .card-header {
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            color: #ffffff;
            padding: 15px 20px;
            border-radius: 13px 13px 0 0;
            border-bottom: none;
        }

        .card-body {
            padding: 20px;
            color: #ffffff;
        }

        .card-title {
            color: #e1bee7;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-text {
            color: #ffffff;
            margin-bottom: 10px;
        }

        /* List Group (for selected items) */
        .list-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.25);
        }

        .list-group-item {
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(106, 27, 154, 0.35);
            color: #ffffff;
        }

        /* Sales create: customer products grid */
        #customer-products .card {
            border-color: rgba(106, 27, 154, 0.45);
        }

        #customer-products .card .btn {
            margin-top: 8px;
        }

        /* Selected product summary card */
        #selected-product-summary .card {
            border-color: rgba(225, 190, 231, 0.4);
        }

        /* Form Check Styles */
        .form-check {
            margin-bottom: 15px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            margin-top: 0;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #6a1b9a;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            border-color: #8e24aa;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(106, 27, 154, 0.3);
        }

        .form-check-label {
            color: #ffffff;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        /* Button Group Styles */
        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-group .btn {
            margin: 0;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-dialog {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid rgba(106, 27, 154, 0.5);
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-content {
            background: transparent;
            border: none;
            border-radius: 15px;
        }

        .modal-header {
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            color: #ffffff;
            padding: 20px;
            border-radius: 13px 13px 0 0;
            border-bottom: none;
        }

        .modal-body {
            padding: 20px;
            color: #ffffff;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(106, 27, 154, 0.3);
            background: rgba(0, 0, 0, 0.3);
            border-radius: 0 0 13px 13px;
        }

        .btn-close {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-close:hover {
            color: #e1bee7;
        }

        /* Alert Styles */
        .alert-info {
            background: rgba(33, 150, 243, 0.2);
            border: 2px solid #2196f3;
            color: #ffffff;
        }

        .alert-warning {
            background: rgba(255, 152, 0, 0.2);
            border: 2px solid #ff9800;
            color: #ffffff;
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.2);
            border: 2px solid #f44336;
            color: #ffffff;
        }

        /* Badge Styles */
        .badge-info {
            background: linear-gradient(135deg, #2196f3, #42a5f5);
            color: #ffffff;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #424242, #616161);
            color: #ffffff;
        }

        /* Text Colors */
        .text-muted {
            color: #e1bee7 !important;
        }

        .text-warning {
            color: #ff9800 !important;
        }

        .text-danger {
            color: #f44336 !important;
        }

        .text-success {
            color: #4caf50 !important;
        }

        /* Button Variants */
        .btn-info {
            background: linear-gradient(135deg, #1a0033, #8e24aa);
            color: #ffffff;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #2d1b69, #ab47bc);
            color: #ffffff;
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid #8e24aa;
            color: #e1bee7;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #1a0033, #8e24aa);
            color: #ffffff;
            border-color: #8e24aa;
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid #616161;
            color: #616161;
        }

        .btn-outline-secondary:hover {
            background: #616161;
            color: #ffffff;
        }

        .btn-outline-danger {
            background: transparent;
            border: 2px solid #c62828;
            color: #ffcdd2;
        }

        .btn-outline-danger:hover {
            background: linear-gradient(135deg, #1a0033, #c62828);
            color: #ffffff;
            border-color: #ef5350;
        }

        /* Form Styles */
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            color: #1a0033;
            border: 2px solid #6a1b9a;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #e1bee7;
            box-shadow: 0 0 15px rgba(225, 190, 231, 0.5);
        }

        /* Utility Classes */
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mb-5 {
            margin-bottom: 3rem;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .ms-2 {
            margin-left: 0.5rem;
        }

        .py-5 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .w-100 {
            width: 100%;
        }

        .d-grid {
            display: grid;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .h-100 {
            height: 100%;
        }

        .d-inline {
            display: inline;
        }

        .d-inline-block {
            display: inline-block;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .flex-row {
                flex-direction: column;
                align-items: center;
            }
            
            .stats-card h1 {
                font-size: 36px;
            }

            .card-body {
                padding: 15px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                width: 100%;
                margin-bottom: 5px;
            }

            .modal-dialog {
                width: 95%;
                margin: 10px;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }

            .stats-card {
                margin: 10px 0;
                padding: 20px;
            }

            .stats-card h1 {
                font-size: 28px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 12px;
            }

            .btn-lg {
                padding: 12px 24px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="stats-card">
                {!! session('success') !!}
            </div>
        @endif

        {{-- Page-specific content --}}
        @yield('content')
    </div>

    <script>
        // Modal functionality
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'flex';
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
                event.target.style.display = 'none';
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    openModal.classList.remove('show');
                    openModal.style.display = 'none';
                }
            }
        });

        // Bootstrap modal data attributes
        document.addEventListener('DOMContentLoaded', function() {
            // Handle data-bs-toggle="modal" attributes
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetModal = this.getAttribute('data-bs-target');
                    if (targetModal) {
                        showModal(targetModal.replace('#', ''));
                    }
                });
            });

            // Handle data-bs-dismiss="modal" attributes
            document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modal = this.closest('.modal');
                    if (modal) {
                        hideModal(modal.id);
                    }
                });
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FTAD OneView v1.0 </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #800000;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #fff;
            /* Light on desktop */
            transition: background-color 0.3s ease;
        }

        .navbar-toggler {
            border-color: #800000;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(128,0,0, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }


        .navbar .nav-link {
            position: relative;
            color: #800000 !important;
            font-weight: 500;
            padding: 8px 12px;
            transition: color 0.3s ease;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            left: 0;
            bottom: 0;
            background-color: #800000;
            transition: width 0.3s;
        }

        .navbar .nav-link:hover::after {
            width: 100%;
        }

        .navbar .nav-link:hover {
            color: #a00000 !important;
        }

        .navbar .nav-link.btn {
            border: 2px solid #800000;
            color: #800000 !important;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .navbar .nav-link.btn:hover {
            background-color: #800000;
            color: #fff !important;
        }


        .hero-section {
            background: url("<?= base_url(); ?>assets/images/bgwel.jpg") no-repeat center left;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #fff;
            height: 600px;
            /* ✅ Fixed height */
            position: relative;
            display: flex;
            align-items: center;
        }

        .hero-section .left {
            padding: 0 40px;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.1rem;
            margin-top: 20px;
            color: #f0f0f0;
        }

        .hero-section .btn {
            font-size: 1rem;
            padding: 12px 30px;
        }

        .hero-section .btn-outline-light {
            color: #fff;
            border-color: #fff;
        }

        .hero-section .btn-light {
            background-color: #fff;
            color: var(--primary-color);
        }

        .feature-icons {
            background-color: #fff;
            padding: 40px 20px;
            text-align: center;
        }

        .feature-icons i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .feature-icons p {
            margin-top: 10px;
        }

        .highlight-text {
            color: #ffc107;
            /* Example: Bootstrap warning yellow */
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .hero-section {
                text-align: center;
            }

            .hero-section .left,
            .hero-section .right {
                padding: 20px;
            }

            .navbar .nav-link {
                color: #800000 !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <img src="<?= base_url(); ?>assets/images/ftad-logo.jpg" alt="Logo" height="80" width="200">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>Pages/about">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="manualsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manuals
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="manualsDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('resources/FTAD_Manual-for-Dissemination.pdf'); ?>" target="_blank">FTAD Manual</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('resources/GAD_Manual_FTAD-for-Dissemination-1.pdf'); ?>" target="_blank">GAD Manual</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url(); ?>Pages/authors">Authors</a></li>
                </ul>
            </div>
        </div>
    </nav>
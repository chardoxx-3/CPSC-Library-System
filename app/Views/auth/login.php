<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CPSC Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6C5DD3;
            --accent: #F97316; /* Orange accent for pop */
            --glass: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
            --text-dark: #1F2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F0F2F5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* --- Dynamic Background Shapes --- */
        .shape {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            animation: float 10s infinite alternate;
        }
        .shape-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #6C5DD3, #8B5CF6);
            border-radius: 50%;
        }
        .shape-2 {
            bottom: -10%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #FF6B6B, #FF8E53);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(20px, 40px) rotate(10deg); }
        }

        /* --- Glass Card --- */
        .login-wrapper {
            width: 1000px;
            max-width: 90%;
            height: 600px;
            display: flex;
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Left Side (Visual) */
        .visual-panel {
            width: 50%;
            background: linear-gradient(135deg, rgba(108, 93, 211, 0.9), rgba(139, 92, 246, 0.9)), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&q=80');
            background-size: cover;
            background-blend-mode: multiply;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
        }
        
        .visual-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .floating-icon {
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            margin-bottom: 20px;
        }

        /* Right Side (Form) */
        .form-panel {
            width: 50%;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255,255,255,0.6);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #A098AE;
            z-index: 2;
            transition: 0.3s;
        }

        .form-control-custom {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid transparent;
            background: #fff;
            border-radius: 15px;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-dark);
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 8px 25px rgba(108, 93, 211, 0.15);
        }
        
        .form-control-custom:focus + i { color: var(--primary); }

        .btn-gradient {
            background: linear-gradient(90deg, #6C5DD3 0%, #8B5CF6 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(108, 93, 211, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(108, 93, 211, 0.4);
        }

        /* Mobile */
        @media (max-width: 992px) {
            .login-wrapper { flex-direction: column; height: auto; max-width: 450px; }
            .visual-panel { display: none; }
            .form-panel { width: 100%; padding: 3rem 2rem; }
        }
    </style>
</head>
<body>

<!-- Animated Background -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>

<div class="login-wrapper">
    <!-- Left Side: Brand & Vibe -->
    <div class="visual-panel">
        <div>
            <!-- LOGO REPLACEMENT HERE -->
            <div class="floating-icon">
                <img src="<?= base_url('images/logo.png') ?>" alt="Logo" style="width: 35px; height: auto;">
            </div>
            
            <h1 class="fw-bold display-5 mb-3">Welcome Back!</h1>
            <p class="lead opacity-75 fs-6">
                Dive back into the ocean of knowledge. Your next favorite book is waiting.
            </p>
        </div>
        
        <div class="d-flex align-items-center gap-3 opacity-75">
            <small>CPSC Library System &copy; 2025</small>
        </div>
    </div>

    <!-- Right Side: Interaction -->
    <div class="form-panel">
        <div class="mb-5">
            <h2 class="fw-bold text-dark mb-1">Sign In</h2>
            <p class="text-muted">Enter your credentials to access your account.</p>
        </div>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-danger rounded-4 border-0 shadow-sm d-flex align-items-center mb-4" 
                 style="background: #FFF4F4; color: #D32F2F; font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <form action="<?= site_url('auth/login') ?>" method="post">
            <div class="input-group-custom">
                <input type="text" name="username" class="form-control-custom" placeholder="Username" required>
                <i class="fas fa-user"></i>
            </div>

            <div class="input-group-custom">
                <input type="password" name="password" class="form-control-custom" placeholder="Password" required>
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit" class="btn btn-gradient w-100 mb-4">
                Sign In <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center">
            <span class="text-muted small">New to CPSC Library?</span>
            <a href="<?= site_url('auth/register') ?>" class="fw-bold ms-1 text-decoration-none" style="color: var(--primary);">Create Account</a>
        </div>
    </div>
</div>

</body>
</html>
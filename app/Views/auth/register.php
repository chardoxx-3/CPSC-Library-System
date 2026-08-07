<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - CPSC Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6C5DD3;
            --surface: #ffffff;
            --bg: #F3F5F9;
            --text: #303972;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            /* Subtle grid pattern background */
            background-image: radial-gradient(#6C5DD3 0.5px, transparent 0.5px), radial-gradient(#6C5DD3 0.5px, var(--bg) 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .reg-container {
            width: 100%;
            max-width: 900px;
            background: var(--surface);
            border-radius: 30px;
            box-shadow: 0 40px 80px rgba(108, 93, 211, 0.15);
            overflow: hidden;
            display: flex;
            position: relative;
        }
        
        /* Decorative sidebar strip */
        .deco-strip {
            width: 15px;
            background: linear-gradient(180deg, #6C5DD3 0%, #a29bfe 100%);
        }

        .content-area {
            flex: 1;
            padding: 3.5rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3rem;
        }

        .brand-pill {
            background: rgba(108, 93, 211, 0.1);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Floating Inputs */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating-custom input {
            width: 100%;
            border: 2px solid #EBE9F6;
            border-radius: 12px;
            padding: 15px 20px;
            font-weight: 500;
            color: var(--text);
            background: #FAFAFB;
            transition: all 0.3s;
        }

        .form-floating-custom input:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(108, 93, 211, 0.1);
            outline: none;
        }

        .form-floating-custom label {
            position: absolute;
            left: 15px;
            top: -10px;
            background: white;
            padding: 0 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #A098AE;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #BDBDBD;
            font-weight: 700;
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #EBE9F6;
        }

        .btn-register {
            background: var(--primary);
            color: white;
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 1rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 93, 211, 0.4);
        }
        
        .btn-register:hover::before {
            left: 100%;
        }

        /* Mobile tweaks */
        @media(max-width: 768px) {
            .content-area { padding: 2rem; }
            .header-section { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>

<div class="reg-container">
    <div class="deco-strip"></div>
    
    <div class="content-area">
        <div class="header-section">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--text);">Create Account</h2>
                <p class="text-muted mb-0">Join the CPSC Library community today.</p>
            </div>
            <div class="brand-pill">
                <i class="fas fa-crown"></i> Free Membership
            </div>
        </div>

        <form action="<?= site_url('auth/store') ?>" method="post">
            
            <div class="section-title">
                <i class="fas fa-id-card text-primary"></i> Personal Info
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating-custom">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="Enter full name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating-custom">
                        <label>Contact No.</label>
                        <input type="text" name="contact_number" placeholder="Enter contact no." required>
                    </div>
                </div>
            </div>

            <div class="form-floating-custom">
                <label>Address</label>
                <input type="text" name="address" placeholder="Your home address" required>
            </div>

            <div class="section-title">
                <i class="fas fa-shield-alt text-primary"></i> Account Security
            </div>

            <div class="form-floating-custom">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating-custom">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Choose username" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating-custom">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Create password" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Register Now <i class="fas fa-chevron-right ms-2" style="font-size: 0.8rem;"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted small">Already a member?</span>
            <a href="<?= site_url('auth') ?>" class="fw-bold text-decoration-none ms-1" style="color: var(--primary);">Login Here</a>
        </div>
    </div>
</div>

</body>
</html>
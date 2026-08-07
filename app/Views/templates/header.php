<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPSC Library - Member Portal</title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #F3F5F9;
            --primary: #6C5DD3; 
            --primary-light: #EBE9F6;
            --secondary: #A098AE;
            --text-dark: #303972;
            --sidebar-width: 280px; /* Increased width for spaciousness */
            --radius-xl: 20px;
            --radius-md: 15px;
            --card-shadow: 0px 10px 60px rgba(226, 236, 249, 0.5);
        }
        
        body {
            background-color: var(--bg-body);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- Spacious Sidebar Redesign --- */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 2.5rem 2rem; /* Increased Padding */
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4rem; /* More space between logo and menu */
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            /* Optional: Add a subtle drop shadow to the logo */
            filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.1));
        }
        
        /* Navigation Links */
        .sidebar .nav-link {
            color: var(--secondary);
            font-weight: 500;
            font-size: 1rem;
            padding: 16px 20px; /* Bigger touch targets */
            border-radius: var(--radius-md);
            margin-bottom: 12px; /* More space between items */
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link i {
            width: 28px; /* Wider icon area */
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .sidebar .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
            transform: translateX(5px); /* Subtle movement on hover */
        }

        .sidebar .nav-link.active {
            background-color: var(--primary);
            color: #fff;
            box-shadow: 0 8px 20px rgba(108, 93, 211, 0.3); /* Softer, larger shadow */
        }

        /* Section Headers (Admin/Menu) */
        .sidebar-header {
            text-transform: uppercase;
            font-weight: 700;
            font-size: 0.75rem;
            color: #C1BBEB; /* Lighter purple/gray */
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            padding-left: 20px;
            margin-top: 20px;
        }

        /* --- Main Content Adjustment --- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 3rem; /* More padding for content area */
            min-height: 100vh;
        }

        /* Rest of your Card styles... */
        .card-custom {
            background: white;
            border-radius: var(--radius-xl);
            border: none;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        
        /* ... [Keep the rest of the styles from previous Header file] ... */
        .hero-banner {
            background: linear-gradient(135deg, #6C5DD3 0%, #8B7AF0 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .book-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            position: relative;
            height: 100%;
            border: 1px solid transparent;
            transition: all 0.3s;
        }
        .status-pill {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-active { background: #E2FBD7; color: #34A853; }
        .status-overdue { background: #FFEAEA; color: #EB5757; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1.5rem; }
        }
    </style>
</head>
<body>
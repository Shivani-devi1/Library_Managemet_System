<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }

        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #2980b9;
            color: #fff;
            padding: 1rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0.5rem 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #495057;
            color: #e9ecef;
        }

        nav ul li a .icon {
            margin-right: 0.5rem;
        }

        main {
            flex: 1;
            padding: 2rem;
        }

        .content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s;
        }

        .content:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            nav {
                padding: 0.5rem;
            }
            
            nav ul li {
                margin: 0.25rem 0;
            }
            
            main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            Admin Dashboard
        </header>
        
        <main>
            <div class="content">
            <nav>
            <ul>
                <li><a href="manage_books.php">Manage Books</a></li>
                <li><a href="manage_ebooks.php">Manage Ebooks</a></li>
                <li><a href="manage_audiobooks.php">Manage Audiobooks</a></li>
                <li><a href="manage_journals.php">Manage Journals</a></li>
            </ul>
        </nav>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>

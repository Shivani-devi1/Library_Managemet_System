<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <style>
     
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('background.jpg') no-repeat center center fixed; 
            background-size: cover; 
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5em;
            margin: 20px 0;
            color: #2c3e50;
            text-align: center;
        }

        p {
            font-size: 1.2em;
            margin: 15px 0;
            text-align: center;
        }

        
        a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
            margin: 5px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #ecf0f1;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: inline-block;
        }

        a:hover {
            background-color: #2980b9;
            color: #fff;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            width: 90%;
            max-width: 600px;
            margin-top: 10%;
        }

       
        footer {
            margin-top: auto;
            padding: 10px 0;
            background-color: #2c3e50;
            color: #ecf0f1;
            width: 100%;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 0.9em;
        }

      
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1em;
            }

            .container {
                padding: 20px;
                margin-top: 5%;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5em;
            }

            p {
                font-size: 0.9em;
            }

            .container {
                padding: 15px;
                margin-top: 5%;
            }

            a {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Library</h1>
        <p>
            <a href="login.php">Login</a> 
            <a href="register.php">Register</a>
            <a href="admin_login.php">Admin</a>
        </p>
    </div>
   
    <?php include 'footer.php'; ?>
</body>
</html>

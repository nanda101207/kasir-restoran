<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background-color: #7892B0;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #555B7B;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 10px #333;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin: 15px 0;
        }
        label {
            display: inline-block;
            width: 90px;
        }
        input[type="text"], input[type="password"] {
            padding: 8px;
            width: 200px;
            border: none;
            border-radius: 5px;
            background-color: #ddd;
        }
        .login-button {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #3b5998;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        .login-button:hover {
            background-color: #2d4373;
        }
    </style>
</head>
<body>
    <form class="login-container" action="process_login.php" method="POST">
        <h2>Login</h2>
        <div class="form-group">
            <label for="username">username :</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">password :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button class="login-button" type="submit">Login</button>
    </form>
</body>
</html>

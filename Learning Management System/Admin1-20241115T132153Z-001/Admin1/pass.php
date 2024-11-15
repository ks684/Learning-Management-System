<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40;
            padding: 80;
            height: 30vh;
   
            background: url('../images/bg.gif');
            background-repeat:no-repeat;
        }

        
        form {
            background-color:cyan;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            margin-left: 50%;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

<h1 ><p align="center"> Admin Login </p></h1>

    </head>
<body>

    <form method="post" action="admin_authenticate.php">
        <label for="password">Password:</label>
        <input type="password" name="password" required >
        <button type="submit">Login</button>
    </form>
</body>
</html>

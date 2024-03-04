<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
           
            text-align: center;
            padding: 50px;
        }

        p {
            font-size: 24px;
            color: #2ecc71; /* Green color for success message */
        }

        a {
            display: block;
            margin-top: 20px;
            padding: 10px;
            background-color: #645CBB; /* Blue color for the back to home button */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            
        }

        a:hover {
            background-color: #A084DC; /* Darker blue color on hover */
        }

        .container{
           
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
           
        }
    </style>
</head>
<body>
   <div class="container">
   <p>Thank you for your payment!</p>
    <a href="./">Back to Home</a>
   </div>
</body>
</html>

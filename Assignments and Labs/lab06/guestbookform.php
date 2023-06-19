<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab06 Task 2 - Guestbook</h1>
    <hr>
    <form action="guestbooksave.php" method="post">
        <fieldset>
            <legend><b>Enter your details to sign our guest book</b></legend>
            <p>Name: <input name="name" /></p>
            <p>E-mail: <input name="email" /></p>
            <input type="submit" value="Sign" />
            <input type="reset" value="Reset Form" />
        </fieldset>
    </form>
    <p><a href="guestbookshow.php">View Guest Book</a></p>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="#"><img src="https://via.placeholder.com/150x50" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Cards</a></li>
                <li><a href="#">Decks</a></li>
                <li><a href="#">Credits</a></li>
                <li><a href="#">Terms and Services</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
    </header>
    <div class="container-wide">
        <div class="panel panel-full">
            <h1>Welcome to my website</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eleifend enim vitae augue faucibus, vel
                aliquet odio consequat. Nam imperdiet volutpat risus, at rhoncus ex efficitur sit amet. Donec eu nunc
                urna.</p>
        </div>
    </div>
    <footer>
        <p>&copy;
            <?php echo date("Y"); ?> My Website. All Rights Reserved.
        </p>
    </footer>
</body>

</html>
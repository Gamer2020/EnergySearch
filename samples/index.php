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
                <li>
                    <a href="#">About</a>
                    <ul>
                        <li><a href="#">Submenu item 1</a></li>
                        <li><a href="#">Submenu item 2</a></li>
                        <li><a href="#">Submenu item 3</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="panel">
            <h1>Welcome to my website</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eleifend enim vitae augue faucibus, vel
                aliquet odio consequat. Nam imperdiet volutpat risus, at rhoncus ex efficitur sit amet. Donec eu nunc
                urna.</p>
        </div>
        <aside>
            <h2>Widgets</h2>
            <ul>
                <li>Widget 1</li>
                <li>Widget 2</li>
                <li>Widget 3</li>
            </ul>
        </aside>
    </div>
    <footer>
        <p>&copy;
            <?php echo date("Y"); ?> My Website. All Rights Reserved.
        </p>
    </footer>
</body>

</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body { font-family: sans-serif; }
        span { color: green; }
    </style>
</head>
<body>
    <h1>Hello <span>{{ $name }} ({{ $username }})</span>!</h1>
    <h2>Welcome to Football Portfolio!</h2>
    <p>Now that you're registered, you now use the bookmark feature to save matches, teams, competitions etc.</p>
    <ul>
        <li><a href="https://football-portfolio.test/search/matches">Check out matches here!</a></li>
        <li><a href="https://football-portfolio.test/search/competition">Check out competitions here!</a></li>
        <li><a href="https://football-portfolio.test/search/teams">Check out teams here!</a></li>
        <li><a href="https://football-portfolio.test/search/persons">Check out persons here!</a></li>
    </ul>
</body>
</html>

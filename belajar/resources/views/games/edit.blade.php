<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Edit Data</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Game</h2>
        <form action="/games/{{$game->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Game Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $game->name }}" required>
            </div>
            <div class="form-group">
                <label for="developer">Developer</label>
                <input type="text" class="form-control" id="developer" name="developer" value="{{ $game->developer }}" required>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" value="{{ $game->year }}" required>
            </div>
            <div class="form-group">
                <label for="game_play">Game Play ID</label>
                <input type="number" class="form-control" id="game_play" name="game_play" value="{{ $game->game_play }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>

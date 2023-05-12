<!doctype html>
<html lang="en">
<body>
<h1>Movie List</h1>
<table border=1>
    <tr>
        <td>name</td>
        <td>language</td>
        <td>subscription</td>
        <td>year</td>
    </tr>
    @foreach($movies as $movie)
    <tr>
        
        <td><a href="{{ route('movie',$movie['name']) }}">{{$movie['name']}}</a></td>
        <td>{{$movie['language']}}</td>
        <td>{{$movie['subscription']}}</td>
        <td>{{$movie['year']}}</td>
        
    </tr>
    @endforeach
</table>
</body>
</html>
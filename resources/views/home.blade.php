<!doctype html>
<html lang="en">
    <head>
        <title>Movie List</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <input type="text" id="search" name="search" placeholder="Search">
<br></br>
<body>
<h1>Movie List</h1>
<select name="language" id="language">
    <option value="none" selected disabled hidden>Select a Language</option>    
    <option value="All">All</option>
    <option value="English">English</option>
    <option value="Hindi">Hindi</option>
   
</select>
<table border=1>
    <tr>
        <td>name</td>
        <td>language</td>
        <td>subscription</td>
        <td>year</td>
    </tr>
    <tbody id="tbody">
        @if(count($movies)==0)
        <tr>
            <td colspan="4">No Movie found</td>
        </tr>
        @else
        @foreach($movies as $movie)
        <tr>
            
            <td>{{$movie['name']}}</td>
            <td>{{$movie['language']}}</td>
            <td>
            @if($movie['subscription']==1  && $user['subscription']==0)
                <button type="button" onclick="window.location='{{ route('payment') }}'">payment</button>
            @else
                <button type="button" onclick="window.location='{{ route('movie') }}'">movie</button>
            @endif
            </td>
            <td>{{$movie['year']}}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
    
</table>
<script>
    $(document).ready(function(){
        $("#language").on('change',function(){
            var language=$(this).val();
            var search=$('#search').val();
            console.log(search);
            $.ajax({
                type:'GET',
                url:'{{route("home")}}',
                data:{'language':language,'search':search},
                success:function(data){
                    console.log(data);
                    var movies=data.movies;
                    var user=data.user;
                    var html='';
                    if(movies.length>0){
                        for(var i=0;i<movies.length;i++){
                            if(movies[i]['language']==language || language=='All'){
                                html+='<tr><td>'+movies[i]['name']+'</td>';
                                html+='<td>'+movies[i]['language']+'</td>';
                                if(movies[i]['subscription']==1 && user['subscription']==0)
                                    html+='<td><button type="button" onclick="window.location=\'{{ route('payment') }}\'">Payment</button></td>';
                                else
                                    html+='<td><button type="button" onclick="window.location=\'{{ route('movie') }}\'">Watch</button></td>';
                                html+='<td>'+movies[i]['year']+'</td></tr>';
                            }

                        }
                    }
                    else{
                        html+='<tr><td>No Movie found</td></tr>';
                    }
                    $('#tbody').html(html)
                }
            });
        });
        $('#search').on('keyup',function(){
            $value=$(this).val();
            var language=$('#language').val();
            console.log(language);
            $.ajax({
                type:'GET',
                url:'{{route("home")}}',
                data:{'search':$value,'language': language},
                success:function(data){
                    console.log(data);
                    var movies=data.movies;
                    var html='';
                    if(movies.length>0){
                        for(var i=0;i<movies.length;i++){
                            html+='<tr><td>'+movies[i]['name']+'</td>';
                                html+='<td>'+movies[i]['language']+'</td>';
                                  if(movies[i]['subscription']==1)
                                    html+='<td><button type="button" onclick="window.location=\'{{ route('payment') }}\'">Payment</button></td>';
                                 else
                                    html+='<td><button type="button" onclick="window.location=\'{{ route('movie') }}\'">Watch</button></td>';
                                html+='<td>'+movies[i]['year']+'</td></tr>';
                        }
                    }
                    else{
                        html+='<tr><td>No Movie found</td></tr>';
                    }
                    $('#tbody').html(html)
                }
            });
        })
    })
</script>
</body>
</html>
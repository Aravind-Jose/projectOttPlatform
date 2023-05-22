
<html lang="en">
    
  <head>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   @if($errors)
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  </head>
  <body>
  <div id="custombody">
  @if(count($corrections)==0)
  @else
    @foreach($corrections as $correction)
    <li>{{$correction}}</li>
    @endforeach
  @endif
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <form action="{{route('registration')}}" method="POST">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input style="width:300px;" name="name" class="form-control"  >
    
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input style="width:300px;" name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
   
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Phone Number</label>
    <input style="width:300px;" name="phoneNo" class="form-control" >
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input style="width:300px;" name="password" type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
$(document).ready(function(){
  $("#password").keyup(function(){
    var password = $("#password").val();
    //console.log(password);
    //var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: "{{route('registrationView')}}",
      type:'GET',
      data: {
        "password": password,       
      },
      success: function(data){
        var html='';
        var corrections=data.corrections;
        console.log(corrections);
        for(var i=0;i<corrections.length;i++){
          html+='<li>'+corrections[i]+'</li>';
        }
        $("#custombody").html(html);
      }
    });
  });
});
</script>
  </body>
</html>
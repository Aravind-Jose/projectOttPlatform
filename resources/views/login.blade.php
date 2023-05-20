<!doctype html>
<html lang="en">
  <head>
  @if($errors)
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
    @endif
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   
  </head>
  <body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <form action="{{route('login')}}" method="POST">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address </label>
    <input style="width:300px;" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <h4>OR</h4>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Phone Number </label>
    <input style="width:300px;" name="phoneNo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input style="width:300px;" name="password" type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </body>
</html>
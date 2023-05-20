<!doctype html>
<html lang="en">
<body>
<h1>Movie name : {{$movie}}</h1>
<?php if($available==0) : ?>
   <h1>Watch</h1>
<?php endif; ?>
<?php if($available==1 && $user==1) : ?>
   <h1>watch</h1>
<?php endif; ?>
<?php if($available==1 && $user==0) : ?>
   <h1>Need subscription</h1>
<?php endif; ?>
</body>
</html>
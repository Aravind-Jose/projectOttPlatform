<!doctype html>
<html lang="en">
<body>
<h1>movie {{$movie}}</h1>
<?php if($available==true) : ?>
   <h1>Watch</h1>
<?php endif; ?>
<?php if($available==false) : ?>
   <h1>subscription</h1>
<?php endif; ?>
</body>
</html>
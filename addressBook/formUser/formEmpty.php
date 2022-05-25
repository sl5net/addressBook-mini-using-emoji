<?php
echo '
<form method="post">
  id          : <input name="id"  value="' . @$dataIn['id'] . '">
  name        : <input name="name"  value="' . @$dataIn['name'] . '">
  phone number: <input name="phone" value="' . @$dataIn['phone'] . '">
  city        : <input name="city"  value="' . @$dataIn['city'] . '">
  comment     : <input name="comment"   value="' . @$dataIn['comment'] . '">
  <input type="submit"> <input type="reset"">
</form>

';
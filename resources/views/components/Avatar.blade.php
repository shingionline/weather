<?php

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

$display_name = $user->name.' '.$user->surname;
$avatar = asset('/images/menu-dark.svg');

?>

<a 
id="navbarDropdown"
class="nav-link px-0"
href="#"
role="button"
data-toggle="dropdown"
aria-haspopup="true"
aria-expanded="false" title="{{ $display_name }}">

<!-- Desktop -->
<span class="d-none d-md-block">
<div class="row">
<div class="col pl-md-3 pr-md-0"><img src="{{ $avatar }}" class="profile_image"></div>
</div>
</span>

<!-- Mobile -->
<span class="d-block d-md-none">
<div class="row">
<div class="col-2 pl-3 pr-0"><img src="{{ $avatar }}" class="profile_image"></div>
</div>
</span>

</a>
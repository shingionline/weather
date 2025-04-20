<a class="dropdown-item" 
  href="{{ route('logout') }}" 
  onclick="event.preventDefault(); 
  document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" 
  action="/logout" 
  method="POST" 
  class="d-none">@csrf</form>
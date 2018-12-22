

  <nav class="indigo">
    <div class="container">
        <div class="nav-wrapper">
          <div class="brand-logo">
             @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
            @else
                    
                        
               {{ Auth::user()->email }}
                    
            @endif
        </div>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="sass.html">In Store Orders</a></li>
            <li><a href="badges.html">Order History</a></li>
            <li><a href="collapsible.html">Search</a></li>
            <li>
                <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
               
            </li>
          </ul>
          <ul class="side-nav" id="mobile-demo">
            <li><a href="sass.html">In Store Orders</a></li>
            <li><a href="badges.html">Order History</a></li>
            <li><a href="collapsible.html">Search</a></li>
            <li>
                <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
          </ul>
        </div>
    </div>
  </nav>
          









{{-- 
<nav class="nav-wrapper indigo">
    <div class="container">
        <div class="brand-logo">
             @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
            @else
                    
                        
               {{ Auth::user()->email }}
                    
            @endif
        </div>

        <a href="#" class="sidenav-trigger" data-target="mobile-links">
            <i class="material-icons">menu</i>
        </a>
        <ul class="right">
            <li><a href="#">In Store Orders</a></li>
            <li><a href="#">Order History</a></li>
            <li><a href="#">Search</a></li>
            <li> <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form></li>
        </ul>
    </div>
</nav>
 --}}


                 
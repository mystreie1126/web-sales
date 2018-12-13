       <div class="container"> 
           <div>
                <a href="{{ route('logout') }}" class="btn right" 
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
   
           @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
            @else
                    
                        
                <p>Hello, <span class="cyan-text">{{ Auth::user()->name }}</span></p>
                <p>{{Auth::user()->email}}</p>     
            @endif
        </div>
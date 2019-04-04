
<header class="main-header">
    <nav class="indigo">
      <div class="container">
        <div class="nav-wrapper">
          @if(Auth::check())
            <a href="{{route('home')}}" class="shop_name_logo">{{Auth::User()->name}}</a>
          @else
            <a href="#" class="brand-logo red-text">You are not Logged in!</a>
          @endif
          <a href="#" data-activates="mobile-nav" class="button-collapse">
            <i class="fa fa-bars"></i>
          </a>
          <ul class="right">
            {{-- <li>
              <a class="active-link" href="{{route('countStock')}}">Counting Stock</a>
            </li> --}}
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
          <ul class="side-nav" id="mobile-nav">
            <h4 class="purple-text text-darken-4 center">Quazzu</h4>
            <li>
              <div class="divider"></div>
            </li>
            
           {{--  <li>
              <a href="signup.html">
                <i class="fa fa-users grey-text text-darken-4"></i> Sign Up</a>
            </li> --}}
            <li>
              <div class="divider"></div>
            </li>
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

    <!-- Showcase -->
  {{--   <div class="showcase container">
      <div class="row">
        <div class="col s12 m10 offset-m1 center">
          <p class="flow-text">Annocement</p>
          <p class="broadcast">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit fugit deserunt quos provident aliquam inventore.</p>
          <br>
        </div>
      </div>
    </div> --}}
  </header>

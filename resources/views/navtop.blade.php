
<header class="main-header">
    <nav class="indigo">
      <div class="container">
        <div class="nav-wrapper">
            <ul>
               

              @if(Auth::check())
              
                <li>
                  <a href="{{route('home')}}" class="shop_name_logo col s3">
                    @if(Auth::User()->shop_id == 27)
                      WareHouse
                    @else
                    {{Auth::User()->name}}
                    @endif
                  </a>
                </li>
              
                <li>
                  <a class="active-link" href="{{route('countStock')}}">Update Stock</a>
                </li>
                <li>
                  <a href="{{route('updatedStockHistory')}}">Updated Record</a>
                </li>
                 <li>
                  <a href="{{route('preown')}}">Phone Stock</a>
                </li>
              @else
                <li>
                 <span class="flow-text red-text">Please log in</span>
                </li>
              @endif


                <li class="right">
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

          </ul>
          

          <ul id="side-nav" class="side-nav">
             @if(Auth::check())
                <li class="left">
                  <a href="{{route('home')}}" class="shop_name_logo left">{{Auth::User()->name}}</a>
                </li>
                <li>
                  <a class="active-link" href="{{route('countStock')}}">Update Stock</a>
                </li>
                <li>
                  <a href="{{route('updatedStockHistory')}}">Updated Record</a>
                </li>

                 <li>
                  <a href="{{route('preown')}}">Phone Stock</a>
                </li>
                
              @endif
                <li class="right">
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


  </header>

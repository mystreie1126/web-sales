
<header class="main-header">
    <nav class="indigo">
      <div class="container">
        <div class="nav-wrapper">
            <ul>
              @if(Auth::check())

                @if(Auth::user()->user_type < 10)

                <li>
                  <a href="{{route('home')}}" class="shop_name_logo col s3">

                    {{Auth::User()->name}}

                  </a>
                </li>

                <li>
                  <a href="{{route('preown')}}">Device List</a>
                </li>
                
                 <li>
                  <a href="{{route('parts_stockTake')}}">Parts stock check</a>
                </li>

                 @elseif(Auth::user()->user_type > 10)

               <li>
                  <a class="active-link" href="{{route('stockTake')}}">Branch Stock Take</a>
                </li>

                <li>
                   <a class="active-link" href="{{route('MyStockTake')}}">My StockTake</a>
                 </li>

                  @endif
                  
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
               {{--  <li>
                  <a class="active-link" href="{{route('countStock')}}">Update Stock</a>
                </li>
                <li>
                  <a href="{{route('updatedStockHistory')}}">Updated Record</a>
                </li> --}}

                 <li>
                  <a href="{{route('preown')}}">Device List</a>
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

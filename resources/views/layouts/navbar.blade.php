<nav class="navbar navbar-default ">
    <div class="container-fluid ">
        <div class="navbar-header ">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="#">@yield('title')</a>
        </div>
        <div class="collapse navbar-collapse ">
            <ul class="nav navbar-nav navbar-right">
                
                <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           	<p>{{ Auth::user()->name }}</p>
							<b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                        <li>
                          <br>
                          <form action="{{ route('resets', ['id' => Auth::user()->id ]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            
                            <button type="submit" onclick="return confirm('are you sure? if you do resets, it means your data will be reseted and everything were be gone, it will make you to start from the beginning.')" class="btn-block"><b>Resets Saldo</b></button>
                          </form>
                          <br>
                         
                        </li>
                        <div class="divider"></div>
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
                </li>
				
            </ul>

        </div>
    </div>
</nav>
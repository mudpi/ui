<!-- Branding Image -->
<nav class="navbar is-stretched text-primary-light" :class="{'active': showNav}" role="navigation" aria-label="main navigation">
    <div class="container">
        
    <div class="nav-brand">
        <a class="flex align-items-center justify-content-center" href="/dashboard.php">
            <img src="img/mudpi_logo_grad.png" class="mr-1" style="max-width:32px;">
        </a>
    </div>

    <svg class="nav-menu-icon" @click="toggleNav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
    </svg>


    <div class="nav-menu">
        <!-- Left Side Of Navbar -->
        <ul class="nav-left">
            <li class="nav-item"><a href="/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a href="/toggles.php">Toggles</a></li>
            <li class="nav-item"><a href="/displays.php">Displays</a></li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav-right">
            <!-- Authentication Links -->
                <!-- <li class="nav-item"><a href="{{url('/config')}}">Config</a></li> -->
                <li class="nav-item"><a href="/logs.php">Logs</a></li>
        </ul>
    </div>
    </div>
</nav>
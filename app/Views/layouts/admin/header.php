<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?= session()->name?></span>
                        <span class="text-muted text-xs block">menu <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="<?= base_url('logout');?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            
            <?php if (session()->role[0]['name'] == 'ADMIN' || session()->role[0]['name'] == 'USER'):?>
            <li class="active">
                <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">E-commerce</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <?php if (session()->role[0]['name'] == 'ADMIN' || session()->role[0]['name'] == 'USER'):?>
                    <li class="active">
                        <a href="<?= base_url('dashboard/productos') ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Productos</span></a>
                    </li>
                    <?php endif ?>
                    <?php if (session()->role[0]['name'] == 'ADMIN'):?>                    
                    <li class="active">
                        <a href="<?= base_url('dashboard/productos/list') ?>"><i class="fa fa-th-large"></i> <span class="nav-label">lista</span></a>
                    </li>
                    <?php endif ?>
                    <?php if (session()->role[0]['name'] == 'ADMIN'):?>
                    <li class="active">
                        <a href="<?= base_url('dashboard/productos/create') ?>"><i class="fa fa-th-large"></i> <span class="nav-label">create</span></a>
                    </li>
                    <?php endif ?>
                </ul>
            </li>
            <?php endif ?>
            <li>
                <a href="minor.html"><i class="fa fa-th-large"></i> <span class="nav-label">Minor view</span> </a>
            </li>
        </ul>

    </div>
</nav>
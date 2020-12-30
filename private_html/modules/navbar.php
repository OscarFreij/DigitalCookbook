<nav class="navbar navbar-expand-lg navbar-dark ">
    <a class="navbar-brand" href="/<?=$site_pre_url?>">
        <img src="" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
        DigitalCookbook
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($active_page == "home") echo("active")?>">
                <a class="nav-link" navType="normal" href="/<?=$site_pre_url?>?page=home">Hem</a>
            </li>
            <li class="nav-item <?php if($active_page == "shoppinglist") echo("active")?>">
                <a class="nav-link" navType="normal" href="/<?=$site_pre_url?>?page=shoppinglist">Inköpslista</a>
            </li>
            <li class="nav-item <?php if($active_page == "browse") echo("active")?>">
                <a class="nav-link" navType="normal" href="/<?=$site_pre_url?>?page=browse">Bläddra recept</a>
            </li>
            <li class="nav-item <?php if($active_page == "about") echo("active")?>">
                <a class="nav-link" navType="normal" href="/<?=$site_pre_url?>?page=about">Om hemsidan</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if($active_page == "account" || $active_page == "cookbook" || $active_page == "settings") echo("active")?>" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                    if(isset($_SESSION['email']))
                    {
                        echo('<img src="'.$_SESSION['picture'].'" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">');
                    }
                ?>
                Konto
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="/<?=$site_pre_url?>?page=account">Mitt konto</a>
                    <a class="dropdown-item" href="/<?=$site_pre_url?>?page=cookbook">Min kokbok</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/<?=$site_pre_url?>?page=settings">Inställningar</a>
                    <div class="dropdown-divider"></div>
                    <?php
                        if (isset($_SESSION['email']))
                        {
                            if ($_SESSION['email'] != "")
                            {
                                echo('<a class="dropdown-item" href="/'.$site_pre_url.'?page=logout">Logout</a>');
                            }
                            else
                            {
                                echo('<a class="dropdown-item" href="'.$client->createAuthUrl().'">Login</a>');
                            }
                        }
                        else
                        {
                            echo('<a class="dropdown-item" href="'.$client->createAuthUrl().'">Login</a>');
                        }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</nav>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <title>Document</title>

    <!-- CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Other CSS -->
    <link rel="stylesheet" href="static/css/master.css">
    <link rel="stylesheet" href="static/css/navbar.css">
    <link rel="stylesheet" href="static/css/media-navbar.css">

    <!-- JS -->
    <!-- Jquery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Other JS -->
    <script src="static/js/navbar-dropdown-hover.js"></script>


    <!-- Dependency CSS & JS -->
    <?php
        if ($requireQuillJS)
        {
            echo
            (
                '
                    <!-- QuillJS Library -->
                        <!-- Theme included stylesheets -->
                        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                        <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

                        <!-- Main Quill library -->
                        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
                    
                        <!-- Core build with no theme, formatting, non-essential modules -->
                        <link href="//cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet">
                        <script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script>
                '
            );              
        }

        if ($activePage == "recipe")
        {
            if (isset($_GET['edit']))
            {
                if ($_GET['edit'] == "true")
                {
                    echo('<link rel="stylesheet" href="static/css/edit-recipe.css">');
                    echo('<link rel="stylesheet" href="static/css/media-edit-recipe.css">');
                    echo('<script src="static/js/edit-recipe.js"></script>');
                }
                else if ($_GET['edit'] == "false")
                {
                    echo('<link rel="stylesheet" href="static/css/view-recipe.css">');
                    echo('<link rel="stylesheet" href="static/css/media-view-recipe.css">');
                    echo('<script src="static/js/view-recipe.js"></script>');
                }
                else
                {
                    echo('<link rel="stylesheet" href="static/css/view-recipe.css">');
                    echo('<link rel="stylesheet" href="static/css/media-view-recipe.css">');
                    echo('<script src="static/js/view-recipe.js"></script>');
                }
            }
            else
            {
                echo('<link rel="stylesheet" href="static/css/view-recipe.css">');
                echo('<link rel="stylesheet" href="static/css/media-view-recipe.css">');
                echo('<script src="static/js/view-recipe.js"></script>');
            }
        }
        else
        {
            if (file_exists("static/css/$activePage.css"))
            {
                echo('<link rel="stylesheet" href="static/css/'.$activePage.'.css">');
            }
            
            if (file_exists("static/css/media-$activePage.css"))
            {
                echo('<link rel="stylesheet" href="static/css/media-'.$activePage.'.css">');
            }
            
            if (file_exists("static/js/$activePage.js"))
            {
                echo('<script src="static/js/'.$activePage.'.js"></script>');
            }
        }
        
    ?>
</head>
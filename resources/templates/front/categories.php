
<!--<div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">

        <//?php
            get_categories();
        ?>
    </div>
</div>-->

<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark blue-grey darken-4 mt-3 mb-5">

    <!-- Navbar brand -->
    <span class="navbar-brand">Categories:</span>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <ul class="navbar-nav mr-auto">
            <?php get_categories(); ?>
        </ul>
        <!-- Links -->
        <form class="form-inline" action="search_result.php" method="post">
            <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="query">
                <button class="btn blue-grey darken-4" type="submit" name="search">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>

    </div>
    <!-- Collapsible content -->
</nav>

<!doctype html>
<html>
<head>
    <title>{$title|default:"VOA Newsletter Archive"}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald" rel="stylesheet" />
    <link href="assets/style.css" rel="stylesheet" />
    <meta name="robots" content="noindex" />
</head>
<body>

    <header>
        <inner>
{block name="header"}{/block}
        </inner>
    </header>

    <main>
        <inner>
{block name="body"}{/block}
        </inner>
        <sidebar>
            <inner>
{block name="sidebar"}{/block}
            </inner>
        </sidebar>
    </main>

    <footer>
        <inner>
{block name="footer"}Footer{/block}
        </inner>
    </footer>

</body>
</html>

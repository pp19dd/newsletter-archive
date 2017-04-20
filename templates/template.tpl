<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{$title|default:"VOA Newsletter Archive"}</title>
    <link rel="canonical" href="{$canonical}" />
    <link href="{$home}/assets/style.css?ver={$version}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="This is a web archive of today@VOA, a daily e-mail newsletter featuring VOA's best content." />
{block name="head"}{/block}
</head>
<body>
{include file="metrics.tpl"}
    <header>
        <inner>
            <stuff>
                <div class="logo">
                    <a href="{$home}/"><img class="variant" src="{$home}/assets/logo.png" /></a>
                    <p class="tagline">Informing, engaging &amp; connecting the people of the world.</p>
                    <p class="variant"><a href="http://www.voanews.com/subscribe.html">Subscribe</a></p>
                </div>
                <div class="heading">
                    <h1 class="variant"><a href="{$home}/">Newsletter Archive</a></h1>
                    <span class="hidden tagline">Informing, engaging &amp; connecting the people of the world.</span>
                    <p class="variant">
                        This is an online archive of today@VOA, a daily e-mail newsletter highlighting the best of VOA's unique content.
                        <span class="hidden"> <a href="http://www.voanews.com/subscribe.html">Subscribe</a></span>
                    </p>
                </div>
            </stuff>
        </inner>
    </header>

    <main>
        <content>
            <inner>
{block name="body"}{/block}
            </inner>
        </content>
        <sidebar>
            <inner>
{block name="sidebar"}{/block}
            </inner>
        </sidebar>
    </main>

    <footer>
        <inner>
            <p>This is an online archive of today@VOA, a daily e-mail newsletter highlighting the best of VOA's unique content.</p>
            <p><a href="http://www.voanews.com/subscribe.html">Subscribe to Today@VOA Newsletter</a></p>
        </inner>
    </footer>
{block name="bottom"}{/block}
</body>
</html>

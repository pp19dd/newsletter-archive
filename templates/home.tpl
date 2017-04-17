{extends file="template.tpl"}

{block name="sidebar"}

{foreach from=$counts key=year item=months}
<year>
    {foreach from=$months key=month item=days}
    <month>

        <h2>{$month} {$year}</h2>

        {foreach from=$days key=day item=count}
        <day{if $view == $day} class="current"{/if}><a href="{$home}/day-{$day}/">{$day|date_format:"%A, %m/%d"}</a>{if $count>1} ({$count}){/if}</day>
        {/foreach}

    </month>
    {/foreach}
</year>
{/foreach}

{/block}

{block name="body"}
{if isset($missing)}

<missing>
    <h1>404 Error: page not found</h1>
</missing>

{else}
{if isset($posts)}
{foreach from=$posts item=post}

<newsletter-day>{$view|date_format:"l, d F Y"}</newsletter-day>
{*<!--
    <newsletter-day>{$post.title}</newsletter-day>
-->*}

<newsletter>
    {$post.html}
{*<!--
    <pre>{$post|replace:">":">\n"|escape:htmlall}</pre>
-->*}

</newsletter>
{/foreach}
{/if}
{/if}

{/block}

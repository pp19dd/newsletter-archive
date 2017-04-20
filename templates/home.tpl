{extends file="template.tpl"}

{block name="sidebar"}

{$count = 0}
{foreach from=$counts key=year item=months}
                <year>
{foreach from=$months key=month item=days}
{$count = $count + 1}
{if $count <=4}
                    <month>
                        <h2>{$month} {$year}</h2>
                        <days>
{foreach from=$days key=day item=count}
                            <day{if $view == $day} class="current"{/if}>
                                <a href="{$home}/day-{$day}/">
                                    {$day|date_format:"%m/%d"} <span class="ld">{$day|date_format:"%A"}</span><span class="sd">{$day|date_format:"%a"}</span> 
                                </a>
                                {if $count>1} ({$count}){/if}
                            </day>
{/foreach}
                        </days>
                    </month>
{/if}
{/foreach}
                </year>
{/foreach}
                <more>
                    <a href="{$home}/all/">Older Archives</a>
                </more>
{/block}

{block name="body"}
{if isset($missing)}

<missing>
    <h1>404 Error: page not found</h1>
</missing>

{else}
{if isset($posts)}
                <newsletters>
{foreach from=$posts item=post}
                    <newsletter-day>{$view|date_format:"l, d F Y"}</newsletter-day>
                    <newsletter>
{$post.html|replace:"medium=email":"medium=referral"|replace:"source=newsletter":"source=archives"|indent:24}
                    </newsletter>
{/foreach}
                </newsletters>
                <after-newsletters>
                </after-newsletters>
{/if}
{/if}

{/block}

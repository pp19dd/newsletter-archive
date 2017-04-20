{extends file="home.tpl"}

{block name="head"}
<style>
sidebar { display: none }
</style>
{/block}

{block name="sidebar"}
{/block}

{block name="body"}

                <all-head>
                    <h1>All today@VOA Archives</h1>
                </all-head>
                <all-months>
{foreach from=$counts key=year item=months}
{foreach from=$months key=month item=days}
                    <month>
                        <h2>{$month} {$year}</h2>
                        <days>
{foreach from=$days key=day item=count}
                            <day{if $view == $day} class="current"{/if}><a href="{$home}/day-{$day}/">{$day|date_format:"%m/%d %A"}</a>{if $count>1} ({$count}){/if}</day>
{/foreach}
                        </days>
                    </month>
{/foreach}
{/foreach}
                </all-months>

{/block}

{extends file="template.tpl"}

{block name="sidebar"}

{foreach from=$counts key=year item=months}
                <year>
{foreach from=$months key=month item=days}
                    <month>
                        <h2>{$month} {$year}</h2>
                        <days>
{foreach from=$days key=day item=count}
                            <day{if $view == $day} class="current"{/if}><a href="{$home}/day-{$day}/">{$day|date_format:"%A, %m/%d"}</a>{if $count>1} ({$count}){/if}</day>
{/foreach}
                        </days>
                    </month>

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
{$post.html|indent:24}
                    </newsletter>
{/foreach}
                </newsletters>
                <after-newsletters>
                </after-newsletters>
{/if}
{/if}

{/block}

{block name="bottom"}
<script>
function adjust_height() {
    var h = $("main content inner").height();
    var running_h = 0;
    var move_nodes = [];
    $("sidebar month").each(function() {
        var th = $(this).height();
        running_h += th;

        //if( running_h > h - (th*0.333) ) {
        if( running_h > (h - (th*0.5)) ) {
            // $("days", this).before("<div>+ More</div>");
            // $("days", this).hide();
            move_nodes.push( this );
        }
        // console.info( "h = ", h, ", running_g = " + running_h);
    });

    if( move_nodes.length == 0 ) {
        $("more").hide();
    }

    $.each(move_nodes, function() {
        // $("after-newsletters").append(this);
        $(this).hide();
    });
}

{if $view != "all"}
adjust_height();
{/if}
</script>
{/block}

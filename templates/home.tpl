{extends file="template.tpl"}

{block name="header"}
<h1>VOA Newsletter Archive</h1>
{/block}

{block name="body"}
[body]
<pre>{$counts|print_r}</pre>
{/block}

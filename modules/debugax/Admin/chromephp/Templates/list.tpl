[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]
[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]
<script type="text/javascript">
<!--
window.onload = function ()
{
    top.reloadEditFrame();
    [{if $updatelist == 1}]
        top.oxid.admin.updateList('[{ $oxid }]');
    [{/if}]
}
//-->
</script>
<form name="search" id="search" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="actedit" value="[{ $actedit }]">
    <input type="hidden" name="cl" value="chromephp_admin_list">
    <input type="hidden" name="oxid" value="x">
</form>
<div id="liste">
    <div align="right">
       <h1>ChromePHP</h1>
    </div>
</div>
<div id="chromePHPList">
    [{include file="pagetabsnippet.tpl" noOXIDCheck="true"}]
</div>
<script type="text/javascript">
if (parent.parent)
{   parent.parent.sShopTitle   = "[{$actshopobj->oxshops__oxname->getRawValue()|oxaddslashes}]";
    parent.parent.sMenuItem    = "[{ oxmultilang ident="GENERAL_MENUITEM" }]";
    parent.parent.sMenuSubItem = "[{ oxmultilang ident="ARTICLE_LIST_MENUSUBITEM" }]";
    parent.parent.sWorkArea    = "[{$_act}]";
    parent.parent.setTitle();
}
</script>
</body>
</html>
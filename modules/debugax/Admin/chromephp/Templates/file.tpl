[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
[{include file='../../../modules/debugax/Admin/globalInlude/style.tpl'}]
<script type="text/javascript" src="../modules/debugax/Admin/globalInlude/jquery.js"></script>


[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="oxidCopy" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="chromephp_admin_file">
    <input type="hidden" name="language" value="[{ $actlang }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="chromephp_admin_file">
    <input type="hidden" name="fnc" value="">

    <table border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_READING" }]<br>
                        </td>
                        <td class="edittext"><br><br></td>
                    </tr>
                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_SLEEP" }]
                        </td>
                        <td class="edittext">
                            <input type="text" name="editval[sleep]" size="1" value="[{if !isset($edit.sleep) || empty($edit.sleep)}]3[{else}][{$edit.sleep}][{/if}]"/>[{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_SLEEP_SEK" }]
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_LIMIT" }]
                        </td>
                        <td class="edittext">
                            <input type="text" name="editval[limit]" size="2" value="[{if !isset($edit.limit) || empty($edit.limit)}]30[{else}][{$edit.limit}][{/if}]"/>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext paddingTop10" width="120">
                            [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_READING_COMPLETE" }]
                        </td>
                        <td class="edittext paddingTop10">
                            <input type="radio" name="editval[send]" value="0" class="edittext typ data"  [{if $edit.send == 0}]CHECKED[{/if}] [{ $readonly }]>[{ oxmultilang ident="CHROMEPHP_NO" }]
                            <br>
                            <input type="radio" name="editval[send]" value="1" class="edittext typ data"  [{if $edit.send == 1}]CHECKED[{/if}] [{ $readonly }]>[{ oxmultilang ident="CHROMEPHP_YES" }]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext paddingTop10">
                        </td>
                        <td class="edittext paddingTop10">
                            <input type="submit" class="edittext btn" id="oLockButton" name="saveArticle" value="[{ oxmultilang ident="GENERAL_SAVE" }]" onClick="Javascript:document.myedit.fnc.value='save'" [{ $readonly }] ><br>
                        </td>
                    </tr>

                    <tr class="paddingTop40">
                        <td class="edittext paddingTop40" width="120">
                            [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_COUND" }]
                        </td>
                        <td class="edittext paddingTop40">
                            [{$iCountMysql}]
                        </td>
                    </tr>
                    [{if $iCountMysql > 0}]
                        <tr>
                            <td class="edittext paddingTop10" width="120">
                                [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_CLEAR" }]
                            </td>
                            <td class="edittext paddingTop10">
                                <input type="submit" class="btn edittext" name="deleteMysql" value="[{ oxmultilang ident="CHROMEPHP_FILEMANAGER_MYSQL_CLEAR_BUTTON" }]" onClick="Javascript:document.myedit.fnc.value='deleteMysql'" ><br>
                            </td>
                        </tr>
                    [{/if}]
                </table>
            </td>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">
                        [{foreach from=$aFileInfo item=aFileName key=sFileInfo name=loop}]
                            <tr>
                                <td class="edittext" width="120">
                                    [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_FILENAME" }]
                                </td>
                                <td class="edittext">
                                    <a href="[{$sUrlDir}][{$sFileInfo}]" target="_blank">[{$sFileInfo}]</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="edittext" width="120">
                                    [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_FILEDATUM" }]
                                </td>
                                <td class="edittext">
                                    [{$aFileName.1}]
                                </td>
                            </tr>
                            <tr>
                                <td class="edittext" width="120">
                                    [{ oxmultilang ident="CHROMEPHP_FILEMANAGER_FILESIZE" }]
                                </td>
                                <td class="edittext">
                                    [{$aFileName.2}][{ oxmultilang ident="CHROMEPHP_FILEMANAGER_FILESIZE_KB" }]
                                </td>
                            </tr>
                             <tr>
                                <td class="edittext" width="120">
                                </td>
                                <td class="edittext">
                                    [{$aFileName.3}][{ oxmultilang ident="CHROMEPHP_FILEMANAGER_FILESIZE_MB" }]
                                    <br><br>
                                </td>
                            </tr>
                        [{/foreach}]
                </table>
            </td>
        </tr>
    </table>

</form>

<script type="text/javascript">
<!--
/*
window.onload = function ()
{
    [{ if $updatelist == 1}]
        top.oxid.admin.updateList('[{ $oxid }]');
    [{ /if}]
    var oField = top.oxid.admin.getLockTarget();
    oField.onchange = oField.onkeyup = oField.onmouseout = top.oxid.admin.unlockSave;
}*/
//-->

</script>
[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
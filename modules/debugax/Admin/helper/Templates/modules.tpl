[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{ assign var="myConfig" value=$oView->getConfig() }]
[{include file='../../../modules/debugax/Admin/globalInlude/jquery-ui.tpl'}]
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/globalInlude/jquery.js"></script>
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/globalInlude/jquery-ui.js"></script>
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/helper/Templates/inc/jquery.cookie.js"></script>
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/helper/Templates/inc/jquery.treeview.js"></script>
[{include file='../../../modules/debugax/Admin/helper/Templates/inc/script.tpl'}]
[{include file='../../../modules/debugax/Admin/globalInlude/style.tpl'}]
[{include file='../../../modules/debugax/Admin/helper/Templates/inc/style.tpl'}]
[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="oxidCopy" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="helper_admin_modules">
    <input type="hidden" name="language" value="[{ $actlang }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="helper_admin_modules">
    <input type="hidden" name="fnc" value="">
    <table border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">

					[{if $aModules}]
					    <ul id="modules" class="treeview">
					        [{foreach from=$aModules item=aModulesLists key=sOxidClassName name=loop}]
					            <li>
					                <span class="oxidCore">[{ $sOxidClassName }]</span>
					                <ul>
					                    [{foreach from=$aModulesLists item=oModuleList  name=loop2}]
					                        <li>
					                            <span class="moduleName">[{$oModuleList->getClassName()}]</span>
					                            <ul>
					                                <li><span><p class="treeviewbold">PathModule:</p> [{$oModuleList->getModulePathForFronend()}]</span></li>
                                                    [{if $oModuleList->isEncode() !== null }]
					                                   <li><span><p class="treeviewbold">Is verschlüsselt: [{if $oModuleList->isEncode()}]Ja[{else}]Nein[{/if}]</span></li>
                                                       [{if $oModuleList->getEncodeInfo() !== null }]
                                                            <li class="open"><span class="moduleName">Class Info:</span>
                                                                <ul class="open">
                                                                    <li class="open"><pre>[{$oModuleList->getEncodeInfo()}]}<br>    }</pre></li>
                                                                </ul>
                                                            </li>
                                                       [{/if}]
                                                    [{/if}]
					                                <li class="open"><span class="moduleName">Überladen Funktionsnamen:</span>
					                                    <ul class="open">
					                                        [{foreach from=$oModuleList->getFunctions() item=sFunction name=loop3}]
					                                            <li class="open">function <p class="black">[{$sFunction}]</p></li>
					                                        [{/foreach}]
					                                    </ul>
					                                </li>
					                            </ul>
					                        </li>
					                    [{/foreach}]

					                </ul>
					            </li>
					        [{/foreach}]
					    </ul>
					[{/if}]

                </table>
            </td>
            <td valign="top" class="edittext">

            	<table cellspacing="0" cellpadding="0" border="0">

                    <tr>
                        <td class="edittext" width="120">
                            Analize
                        </td>
                        <td class="edittext">
							<a class="btn" href="/index.php?cl=helper_modules&start=true" target="_blank" id="analize">Start</a>
                        </td>
                    </tr>
            	</table>

            </td>
        </tr>
    </table>

</form>


[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
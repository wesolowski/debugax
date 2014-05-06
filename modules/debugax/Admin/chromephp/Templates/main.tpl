[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{ assign var="myConfig" value=$oView->getConfig() }]
[{include file='../../../modules/debugax/Admin/globalInlude/jquery-ui.tpl'}]
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/globalInlude/jquery.js"></script>
<script type="text/javascript" src="[{$myConfig->getShopUrl()}]/modules/debugax/Admin/globalInlude/jquery-ui.js"></script>
[{include file='../../../modules/debugax/Admin/chromephp/Templates/inc/script.tpl'}]
[{include file='../../../modules/debugax/Admin/globalInlude/style.tpl'}]
[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="oxidCopy" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="chromephp_admin_main">
    <input type="hidden" name="language" value="[{ $actlang }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="chromephp_admin_main">
    <input type="hidden" name="fnc" value="">
    <table border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">

                    <tr>
                        <td class="edittext" width="120">
                        [{ oxmultilang ident="GENERAL_ACTIVE" }]
                        </td>
                        <td class="edittext">
                            <input class="edittext" id="active" type="checkbox" name="editval[debugActive]" value='1' [{if $edit.debugActive == 1}]checked[{/if}] [{ $readonly }]>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_DEBUG_SENDDATA" }]
                        </td>
                        <td class="edittext">
                            <input type="radio" name="editval[sendData]"  value="1" class="edittext typ data"  [{if $edit.sendData == 1 || !isset($edit.sendData)}]CHECKED[{/if}] [{ $readonly }]>[{ oxmultilang ident="CHROMEPHP_DEBUG_SENDDATA_HEADER" }]
                            <br>
                            <input type="radio" name="editval[sendData]" value="2" class="edittext typ data"  [{if $edit.sendData == 2}]CHECKED[{/if}] [{ $readonly }]>[{ oxmultilang ident="CHROMEPHP_DEBUG_SENDDATA_FILE" }]
                            <br>
                            <input type="radio" name="editval[sendData]" id="sendMysql" value="3" class="edittext typ data"  [{if $edit.sendData == 3}]CHECKED[{/if}] [{ $readonly }]>[{ oxmultilang ident="CHROMEPHP_DEBUG_SENDDATA_MYSQL" }]
                            <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext"><strong>[{oxmultilang ident='CHROMEPHP_AUTHORIZATION_MAIN'}]</strong></td>
                        <td  class="edittext">
                                [{*if $iProductiveModus != 1}]
                                    <input type="radio" value="1" class="authorization" name="editval[iAuthorization]" [{if $edit.iAuthorization == "1"}] checked[{/if}]>[{oxmultilang ident='CHROMEPHP_AUTHORIZATION_NONE'}]&nbsp;
                                [{/if*}]
                               <input type="radio" value="2" class="authorization" name="editval[iAuthorization]" [{if $edit.iAuthorization == "2"}] checked[{/if}]>[{oxmultilang ident='CHROMEPHP_AUTHORIZATION_IP'}]&nbsp;
                               <input type="radio" value="3" class="authorization" name="editval[iAuthorization]" [{if $edit.iAuthorization == "3"}] checked[{/if}]>[{oxmultilang ident='CHROMEPHP_AUTHORIZATION_SUFIX'}]&nbsp;
                               <div id="info1" title="Help">
                                    <p>[{oxmultilang ident='CHROMEPHP_HELP_AUTHORIZATION'}]</p>
                                </div>
                                <input type="button" id="opener" class="btnShowHelpPanel">
                                <br>
                        </td>
                    </tr>
                    <tr class="edittext" id="authorizationDiv">
                        <td class="edittext"></td>
                         <td  class="edittext">
                                <input type="text" [{if ( $edit.iAuthorization == 1 || empty($edit.iAuthorization) && $iProductiveModus != 1 ) }]class="none"[{/if}] id="authorizationText" name="editval[sAuthorizationText]" value="[{$edit.sAuthorizationText}]"/>
                            <br><br>

                        </td>
                    </tr>

                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_DEBUG_TYP" }]
                        </td>
                        <td class="edittext">
                            <br>
                            <input type="radio" name="editval[sqlCheck]"  value="1" class="edittext typ debug count" [{if $edit.sendData == "3"}] disabled[{/if}] [{if $edit.sendData != '3' && $edit.sqlCheck == 1}]CHECKED[{/if}] [{ $readonly }]><span [{if $edit.sendData == "3"}] class="disabled"[{/if}]>[{ oxmultilang ident="CHROMEPHP_DEBUG_TYP_COUNT" }]</span>
                            <br>
                            <input type="radio" name="editval[sqlCheck]" value="2" class="edittext typ debug sql"  [{if $edit.sqlCheck == 2}]CHECKED[{/if}] [{ $readonly }]><span>[{ oxmultilang ident="CHROMEPHP_DEBUG_TYP_ALL_SQL" }]</span>
                            <br>
                            <input type="radio" name="editval[sqlCheck]" value="3" class="edittext typ debug cud"  [{if $edit.sqlCheck == 3}]CHECKED[{/if}] [{ $readonly }]><span>[{ oxmultilang ident="CHROMEPHP_DEBUG_TYP_ALL_CUD" }]</span>
                            <br>
                            <input type="radio" name="editval[sqlCheck]" value="4" class="edittext typ debug"  [{if $edit.sendData == "3"}] disabled[{/if}] [{if $edit.sendData != '3' &&  $edit.sqlCheck == 4}]CHECKED[{/if}] [{ $readonly }]><span [{if $edit.sendData == "3"}] class="disabled"[{/if}]>[{ oxmultilang ident="CHROMEPHP_DEBUG_TYP_SQL_ERROR" }]</span>
                            <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" width="120">
                            [{ oxmultilang ident="CHROMEPHP_DEBUG_FILTER" }]
                        </td>
                        <td class="edittext">
                            <input class="edittext" type="hidden" name="filter[usermodel]" value='0' >
                            <input class="edittext" type="hidden" name="filter[backtrace]" value='0' >
                            <input class="edittext" type="hidden" name="filter[search]"    value='0' >

                            <input class="edittext filter" type="checkbox" name="filter[usermodel]" value='1' [{if $edit.filter.usermodel == 1}]checked[{/if}] [{ $readonly }]> <span>[{ oxmultilang ident="CHROMEPHP_DEBUG_FILTER_USER_MODEL" }]</span>
                            <div id="info2" title="Help">
                                <p>[{oxmultilang ident='CHROMEPHP_HELP_USER_MODEL'}]</p>
                            </div>
                            <input type="button" id="opener2" class="btnShowHelpPanel">
                            <br><br>
                            <input class="edittext filter backtrace" type="checkbox" name="filter[backtrace]" value='1' [{if $edit.filter.backtrace == 1}]checked[{/if}] [{ $readonly }]> <span>[{ oxmultilang ident="CHROMEPHP_DEBUG_FILTER_BACKTRACE" }]</span>
                            <div id="info3" title="Help">
                                <p>[{oxmultilang ident='CHROMEPHP_HELP_BACKTRACE'}]</p>
                            </div>
                            <input type="button" id="opener3" class="btnShowHelpPanel">
                            <br><br>
                            <input class="edittext filter search" type="checkbox" name="filter[search]" value='1' [{if $edit.filter.search == 1}]checked[{/if}] [{ $readonly }]> <span>[{ oxmultilang ident="CHROMEPHP_DEBUG_FILTER_SEARCH" }]</span>&nbsp;&nbsp;
                            <span id="sSearchText" [{if empty($edit.filter.sSearchText)}] class="none"[{/if}]>
                                [{oxmultilang ident='CHROMEPHP_DEBUG_FILTER_SEARCH_TEXT'}] <input type="text"  name="filter[sSearchText]" value="[{$edit.filter.sSearchText}]">
                                <div class="btn" id="newSearchText">[{oxmultilang ident='CHROMEPHP_DEBUG_FILTER_SEARCH_ADD_TEXT'}]</div>
                                [{foreach from=$aMoreSearchText item=sMoreFilterText key=key name=loopMoreText}]
                                     <input type="text" class="newInput" value="[{$sMoreFilterText}]" name="sSerchMore[]" />
                                [{/foreach}]

                            </span>
                            <div id="info4" title="Help">
                                <p>[{oxmultilang ident='CHROMEPHP_HELP_SEARCH'}]</p>
                            </div>
                            <input type="button" id="opener4" class="btnShowHelpPanel">
                            <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext" width="120">
                            <br>
                            [{ oxmultilang ident="CHROMEPHP_SYSTEM_INFO" }]
                        </td>
                        <td class="edittext">
                            <br>
                            <input class="edittext" type="checkbox" name="editval[info]" value='1' [{if $edit.info == 1}]checked[{/if}] [{ $readonly }]>
                            [{ oxinputhelp ident="HELP_GENERAL_ACTIVE" }]
                            </span>
                            <div id="info5" title="Help">
                                <p>[{oxmultilang ident='CHROMEPHP_HELP_SYSTEM_INFO'}]</p>
                            </div>
                            <input type="button" id="opener5" class="btnShowHelpPanel">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext"><br><br>
                        </td>
                        <td class="edittext"><br><br>
                            <input type="submit" class="edittext btn" id="oLockButton" name="saveArticle" value="[{ oxmultilang ident="GENERAL_SAVE" }]" onClick="Javascript:document.myedit.fnc.value='save'"><br>
                        </td>
                    </tr>


                </table>
            </td>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">

                    <tr>
                        <td class="edittext " width="120">
                        </td>
                        <td class="edittext">
                            <input type="submit" class="edittext btn" id="oLockButtonBackup" name="backup" value="[{ oxmultilang ident="CHROMEPHP_BACKUP" }]" onClick="Javascript:document.myedit.fnc.value='backup'" [{ $readonly }] [{ if $edit.debugActive != 1 }]disabled[{/if}] [{ $readonly }]><br>
                        </td>
                    </tr>

                     <tr>
                        <td class="edittext paddingTop10" width="120">
                            [{ oxmultilang ident="CHROMEPHP_CHECK_SESSION" }]
                        </td>
                        <td class="edittext paddingTop10">
                            <div class="infoCheck">[{ oxmultilang ident="CHROMEPHP_CHECK_SESSION_ISSET" }]
                            [{if $sSession}]
                                Ja</div>
                                <div class="infoCheck">[{ oxmultilang ident="CHROMEPHP_CHECK_SESSION_IDENT" }] : [{$sSession}]</div>
                            [{else}]
                                Nein</div>
                            [{/if}]
                        </td>
                    </tr>
                    <tr>
                        <td class="edittext paddingTop10" width="120">
                            [{ oxmultilang ident="CHROMEPHP_CHECK_FUNCTION" }]
                        </td>
                        <td class="edittext paddingTop10">
                            [{foreach from=$aFnCheck item=bResult key=sFunctionName name=loop}]
                                <div class="infoCheck">[{$sFunctionName}] : [{if $bResult == 1}]Ja[{else}]Nein[{/if}]
                                   [{* <div id="info[{$sFunctionName}]" title="Help">
                                        <p>[{oxmultilang ident="CHROMEPHP_HELP_$sFunctionName"}]</p>
                                    </div>
                                    <input type="button" id="opener[{$sFunctionName}]" class="btnShowHelpPanel">*}]</div>
                            [{/foreach}]
                        </td>
                    </tr>

                    <tr>
                        <td class="edittext paddingTop10" width="120">
                            [{ oxmultilang ident="CHROMEPHP_CHECK_PERFORM" }]
                        </td>
                        <td class="edittext paddingTop10">
                            [{if !empty($aPerformTest)}]

                                 [{foreach from=$aPerformTest item=sResult key=sName name=loop}]
                                     <div class="infoCheck">[{$sName}] : [{$sResult}]</div>
                                 [{/foreach}]

                            [{else}]
                                [{ oxmultilang ident="CHROMEPHP_PERFORMTEST_NO_TEST" }]
                            [{/if}]

                        </td>
                    </tr>
           <tr>
                        <td class="edittext paddingTop10" width="120">
                            [{ oxmultilang ident="CHROMEPHP_CHECK_MYSQL" }]
                        </td>
                        <td class="edittext paddingTop10">
                            <div class="infoCheck">[{ oxmultilang ident="CHROMEPHP_CHECK_MYSQL_TABLE" }] [{if $bMySqlDB}]Ja[{else}]Nein[{/if}]</div>

                            [{foreach from=$aMySqlInfo item=aInfo key=key name=loop}]
                                <br>
                                 <div class="infoCheck">[{ oxmultilang ident="CHROMEPHP_CHECK_MYSQL_IDENT" }]: [{$aInfo.ident}]</div>
                                 <div class="infoCheck">[{ oxmultilang ident="CHROMEPHP_CHECK_MYSQL_COUNT" }]: [{$aInfo.count}]</div>
                            [{/foreach}]
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</form>

[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
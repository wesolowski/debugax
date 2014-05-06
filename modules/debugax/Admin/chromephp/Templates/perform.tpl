[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
<script type="text/javascript">
<!--
function DeleteTest( iIndex )
{
    var oForm = document.getElementById("myedit");
    oForm.fnc.value="deleteOne";
    oForm.deleteOne.value=iIndex;

    oForm.submit();
}


//-->
</script>
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
    <input type="hidden" name="cl" value="chromephp_admin_perform">
    <input type="hidden" name="language" value="[{ $actlang }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="chromephp_admin_perform">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="deleteOne" value="">
    <input type="hidden" name="comment" value="[{$comment}]">

    <table border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">

                <table cellspacing="0" cellpadding="0" border="0">
                        [{if $bPerformTestResult != true}]
                            <tr>
                                <td class="edittext" width="120">
                                    [{ oxmultilang ident="CHROMEPHP_PERFORMTEST_COMMENT" }]
                                </td>
                                <td class="edittext">
                                    <input class="edittext" type="text" size="50" name="comment" value='[{$comment}]'  [{if $bPerform }]disabled[{/if}]>
                                </td>
                            </tr>
                        [{/if}]
                        [{foreach from=$aUrls item=sUrl key=id name=loop}]
                            <tr>
                                <td class="edittext" width="120">
                                    [{ oxmultilang ident="CHROMEPHP_PERFORMTEST_URL_$id" }]
                                </td>
                                <td class="edittext">
                                    <input class="edittext" type="text" size="120" name="aUrls[[{$id}]]" value='[{$sUrl}]'  [{if $bPerform }]disabled[{/if}]>
                                    [{ oxinputhelp ident="HELP_GENERAL_ACTIVE" }]
                                </td>
                            </tr>
                        [{/foreach}]
                    <tr>
                        <td class="edittext"><br><br>
                        </td>
                        <td class="edittext"><br><br>
                            [{if $bPerformTestResult != true}]
                                <input type="submit" class="btn edittext" id="oLockButton" name="save" value="[{if !$bPerform }][{ oxmultilang ident="CHROMEPHP_PERFORMTEST_BUTTOM_START" }][{else}][{ oxmultilang ident="CHROMEPHP_PERFORMTEST_BUTTOM_STOP" }][{/if}]" onClick="Javascript:document.myedit.fnc.value='[{if $bPerform }]stopPerformTest[{else}]startPerformTest[{/if}]'"><br>
                            [{/if}]

                        </td>
                    </tr>


                </table>
            </td>
            <td>
                <table cellspacing="0" cellpadding="0" border="0">
                        <td class="edittext paddingTop10">
                            [{if !empty($aPerformTest)}]
                                [{if $aPerformTest|@count  < 2}] [{/if}]
                                 [{foreach from=$aPerformTest item=aResult key=iKey name=loop}]
                                    <hr>
                                    <input style="margin-top: 2px;float: left; margin-right: 10px;[{if $aPerformTest|@count  < 2}]display: none [{/if}]" type="checkbox" class="btn" name="deleteMore[]" value="[{$iKey}]">
                                    <a href="Javascript:DeleteTest('[{$iKey}]');" class="deleteText [{if $aPerformTest|@count  < 2}]none[{/if}]"><span class="ico"></span><span style="display: inline-block; padding: 3px;">[{ oxmultilang ident="GENERAL_DELETE" }]</span></a>
                                    [{foreach from=$aResult item=sResult key=sName name=loop}]

                                        <div class="infoCheck">[{$sName}] : [{$sResult}]</div>

                                    [{/foreach}]

                                 [{/foreach}]
                                 <hr>
                                 <input type="submit" class="btn edittext[{if $aPerformTest|@count  < 2}] none[{/if}]" name="delete" value="[{ oxmultilang ident="CHROMEPHP_PERFORMTEST_DELETE_MORE" }]" onClick="Javascript:document.myedit.fnc.value='deleteMore';" [{ $readonly }]><br>
                            [{/if}]

                        </td>
                </table>
            </td>
        </tr>
    </table>

</form>
[{if $bPerform}]

    [{foreach from=$aUrlsIframe item=sUrl key=id name=loop}]
        <IFRAME id="frame[{$id}]" src="[{ $sUrl }]" scrolling="auto" width="300" height="250" ></IFRAME>
    [{/foreach}]

[{/if}]

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
document.getElementById('frame1').onload= function() {
    performCheck.iframe('iframe1');
};

$('#frame2').load(function() {
  performCheck.iframe('iframe2');
});

$('#frame3').load(function() {
  performCheck.iframe('iframe3');
});

(function($) {
    performCheck = {
        iframe1: null,
        iframe2: null,
        iframe3: null,

        iframe: function(config){
            var self = this;
            if(config == 'iframe3')
            {
                self.iframe3 = true;
            }
            else if(config == 'iframe2')
            {
                self.iframe2 = true;
            }
            else if(config == 'iframe1')
            {
                self.iframe1 = true;
            }

            if(self.checkLoadIframe() == true)
            {
                $('input#oLockButton').trigger("click");
            }

        },

        checkLoadIframe: function(){
            var self = this;
            return (self.iframe1 == true && self.iframe2 == true && self.iframe3 == true) ? true : false;
        }
    };
})(jQuery);
</script>
[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
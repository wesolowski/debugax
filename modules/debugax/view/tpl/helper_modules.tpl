[{if $bResult }]
		[{ assign var="iPercent" value=$iProgress/$iCountResult*100 }]
[{else}]
		[{ assign var="iPercent" value=100 }]
[{/if}]
<html>
	<head>
		<title>
            [{ $iPercent|round:0 }]%
        </title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        [{if $bResult }]
            <meta http-equiv="refresh" content="0; URL=[{$oViewConf->getSelfLink()}]cl=[{ $sView }]">
        [{/if}]
	</head>
	<body>
				[{ $iProgress }] / [{ $iCountResult }] ( [{ $iPercent|round:0 }] % )
	</body>
</html>
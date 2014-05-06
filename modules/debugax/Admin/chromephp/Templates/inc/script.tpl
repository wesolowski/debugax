<script type="text/javascript">



$(document).ready(function() {

    function disableAllText(config)
    {
        config.next().addClass('disabled');
    }

    function enableAllText(config)
    {
        config.next().removeClass('disabled');
    }

    function disableDebug()
    {
        var filter = $('input.filter'),
            debug = $('input.debug');

        filter.prop('disabled', true);
        debug.prop('disabled', true);
        disableAllText(filter);
        disableAllText(debug);

    }

    function enableDebug()
    {
        var filter = $('input.filter'),
            debug = $('input.debug');

        filter.prop('disabled', false);
        debug.prop('disabled', false);
        enableAllText(filter);
        enableAllText(debug);

        if($('input#sendMysql').is(':checked') == true)
        {
                var debug = $('input.debug');
                disableAllText(debug);
                debug.attr('disabled',true).attr('checked', false);
                $('input.sql').attr({
                    'checked'  : true,
                    'disabled' : false
                }).next().removeClass('disabled');
                // $('input.count').attr('disabled',false).next().removeClass('disabled');
                $('input.cud').attr('disabled',false).next().removeClass('disabled');
        }
    }



    var inputActive = $('input#active');
    if(inputActive.is(':checked') == false)
    {
        disableDebug();
    }
    inputActive.on('click',function(){

        if($(this).is(':checked') == true)
        {
            enableDebug();
        }  
        else
        {
            disableDebug();
        }       

    });

    $('input.authorization').on('click',function(){


            var value = $(this).attr('value'),
                valueText = $('input#authorizationText')
                ;
            if(value == 1)
            {
                valueText.attr('value','').hide();
            } 
            else if(value == 2)
            { 
                valueText.attr('value','[{$myIp}]').show();
            } 
            else
            {
                valueText.show();  
            }
        
    });
    

    $('input.debug').on('click',function(){
 

            var $this = $(this),
                value = $this.attr('value'),
                filter = $('input.filter'),
                searchText = $('span#sSearchText')
            ;
            if(value == 4)
            {
                disableAllText(filter);
                filter.attr('checked', false);
                $('input.backtrace').attr('checked', true);
                filter.prop('disabled', true);
                searchText.hide();
            }
            else if( value == 1 )
            {
                enableAllText(filter);
                filter.prop('disabled', false);
                $('input.backtrace').attr('checked', false).prop('disabled', true).next().addClass('disabled');
            }
            else 
            {
                enableAllText(filter);
                filter.prop('disabled', false);
            }            

    });


    $('input.search').on('click',function(){
        var searchText = $('span#sSearchText');

        if($(this).is(':checked') == true)
        {
            searchText.show();
        }  
        else
        {
             searchText.hide();
        }
    });

    $('input.data').on('click',function(){

        if(inputActive.is(':checked') == true)
        {
            var $this = $(this),
                debug = $('input.debug');

            debug.attr('disabled',true);
            if($this.attr('value') == 3)
            {
                disableAllText(debug);
                debug.attr('disabled',true).attr('checked', false);
                $('input.sql').attr({
                    'checked'  : true,
                    'disabled' : false
                }).next().removeClass('disabled');
                // $('input.count').attr('disabled',false).next().removeClass('disabled');
                $('input.cud').attr('disabled',false).next().removeClass('disabled');
            }
            else
            {
                enableAllText(debug);
                debug.attr('disabled',false);
            }
        }
    });

    
    $('div#newSearchText').on('click',function(){

        var spanDiv = $('span#sSearchText');
        $('<input type="text" class="newInput" value="" name="sSerchMore[]" />').appendTo(spanDiv);
        
    });
 });

   $.fx.speeds._default = 1000;
    $(function() {
        $( "#info1" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#info1')
        $( "#opener" ).click(function() {
            $( "#info1" ).dialog( "open" );
            return false;
        });
    });

    $(function() {
        $( "#info2" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#info2')
        $( "#opener2" ).click(function() {
            $( "#info2" ).dialog( "open" );
            return false;
        });
    });

    $(function() {
        $( "#info3" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#info3')
        $( "#opener3" ).click(function() {
            $( "#info3" ).dialog( "open" );
            return false;
        });
    });

    $(function() {
        $( "#info4" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#info4')
        $( "#opener4" ).click(function() {
            $( "#info4" ).dialog( "open" );
            return false;
        });
    });

    $(function() {
        $( "#info5" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#info5')
        $( "#opener5" ).click(function() {
            $( "#info5" ).dialog( "open" );
            return false;
        });
    });
    $(function() {
        $( "#infostartDebug" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#infostartDebug')
        $( "#openerstartDebug" ).click(function() {
            $( "#infostartDebug" ).dialog( "open" );
            return false;
        });
    });
    $(function() {
        $( "#infostopDebug" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#infostopDebug')
        $( "#openerstopDebug" ).click(function() {
            $( "#infostopDebug" ).dialog( "open" );
            return false;
        });
    });


    $(function() {
        $( "#infobacktrace" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#infobacktrace')
        $( "#openerbacktrace" ).click(function() {
            $( "#infobacktrace" ).dialog( "open" );
            return false;
        });
    });

        $(function() {
        $( "#infochromephp" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode"
        });
    $('#infochromephp')
        $( "#openerchromephp" ).click(function() {
            $( "#infochromephp" ).dialog( "open" );
            return false;
        });
    });
</script>
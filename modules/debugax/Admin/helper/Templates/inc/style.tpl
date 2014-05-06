<style type="text/css">

.oxidCore{
    font-weight: bold;
    color: #6D6D6D
}

.moduleName
{
    color: #000;
    font-weight: bold;
}


.black
{
    display: inline;
    color: #000;
}

p.treeviewbold{
    color: #000;
    display: inline;
    font-weight: bold;
}

.treeview, .treeview ul {
    color: #6D6D6D;
    line-height: 17px;
    padding: 0;
    margin: 0;
    list-style: none;
}

.treeview ul {
    background-color: white;
    margin-top: 4px;
}

.treeview .hitarea {
    background: url(/modules/debugax/Admin/images/treeview-default.gif) -64px -25px no-repeat;
    height: 16px;
    width: 16px;
    margin-left: -16px;
    float: left;
    cursor: pointer;
}
/* fix for IE6 */
* html .hitarea {
    display: inline;
    float:none;
}

.treeview li {
    margin: 0;
    padding: 3px 0pt 3px 16px;
}

.treeview a.selected {
    background-color: #eee;
}

#treecontrol { margin: 1em 0; display: none; }

.treeview .hover { color: red; cursor: pointer; }

.treeview li { background: url(/modules/debugax/Admin/images/treeview-default-line.gif) 0 0 no-repeat; }
.treeview li.collapsable, .treeview li.expandable { background-position: 0 -176px; }

.treeview .expandable-hitarea { background-position: -80px -3px; }

.treeview li.last { background-position: 0 -1766px }
.treeview li.lastCollapsable, .treeview li.lastExpandable { background-image: url(/modules/debugax/Admin/images/treeview-default.gif); }
.treeview li.lastCollapsable { background-position: 0 -111px }
.treeview li.lastExpandable { background-position: -32px -67px }

.treeview div.lastCollapsable-hitarea, .treeview div.lastExpandable-hitarea { background-position: 0; }

.treeview-red li { background-image: url(/modules/debugax/Admin/images/treeview-red-line.gif); }
.treeview-red .hitarea, .treeview-red li.lastCollapsable, .treeview-red li.lastExpandable { background-image: url(/modules/debugax/Admin/images/treeview-red.gif); }

.treeview-black li { background-image: url(/modules/debugax/Admin/images/treeview-black-line.gif); }
.treeview-black .hitarea, .treeview-black li.lastCollapsable, .treeview-black li.lastExpandable { background-image: url(/modules/debugax/Admin/images/treeview-black.gif); }

.treeview-gray li { background-image: url(/modules/debugax/Admin/images/treeview-gray-line.gif); }
.treeview-gray .hitarea, .treeview-gray li.lastCollapsable, .treeview-gray li.lastExpandable { background-image: url(/modules/debugax/Admin/images/treeview-gray.gif); }

.treeview-famfamfam li { background-image: url(/modules/debugax/Admin/images/treeview-famfamfam-line.gif); }
.treeview-famfamfam .hitarea, .treeview-famfamfam li.lastCollapsable, .treeview-famfamfam li.lastExpandable { background-image: url(/modules/debugax/Admin/images/treeview-famfamfam.gif); }

.treeview .placeholder {
    background: url(/modules/debugax/Admin/images/ajax-loader.gif) 0 0 no-repeat;
    height: 16px;
    width: 16px;
    display: block;
}

.filetree li { padding: 3px 0 2px 16px; }
.filetree span.folder, .filetree span.file { padding: 1px 0 1px 16px; display: block; }
.filetree span.folder { background: url(/modules/debugax/Admin/images/folder.gif) 0 0 no-repeat; }
.filetree li.expandable span.folder { background: url(/modules/debugax/Admin/images/folder-closed.gif) 0 0 no-repeat; }
.filetree span.file { background: url(/modules/debugax/Admin/images/file.gif) 0 0 no-repeat; }



</style>
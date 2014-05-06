<?php
/**
 *    This file is part of OXID eShop Community Edition.
 *
 *    OXID eShop Community Edition is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    OXID eShop Community Edition is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @package   lang
 * @copyright (C) OXID eSales AG 2003-2011
 * @version OXID eShop CE
 * @version   SVN: $Id$
 */

$sLangName  = "Deutsch";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
            'charset'                                      => 'UTF-8',

            'debugax'                                      => 'DebugAx',
            'debugaxmenu'                                  => 'DebugAx',
            'helpermenu'                                   => 'Helper',
            'helper_modules'                               => 'Modules',
            'chromephpmenu_menu'                           =>   'Main',
            'chromephpmenu_perform'                        =>   'Perform Test',
            'chromephpmenu_file'                           =>   'Datei/MySql-verwaltung',
            'chromephpmenu'                                =>   'ChromePHP',


            'CHROMEPHP_PERFORMTEST_URL_1'                  => 'Startseite',
            'CHROMEPHP_PERFORMTEST_URL_2'                  => 'List-Seite',
            'CHROMEPHP_PERFORMTEST_URL_3'                  => 'Details-Seite',

            'CHROMEPHP_PERFORMTEST_URL_DETAILS'            => 'Details-Seite (Result): ',
            'CHROMEPHP_PERFORMTEST_URL_LIST'               => 'List-Seite (Result): ',
            'CHROMEPHP_PERFORMTEST_URL_START'              => 'Startseite (Result): ',
            'CHROMEPHP_PERFORMTEST_URL_COMMENT'            => 'Comment',
            'CHROMEPHP_PERFORMTEST_COMMENT'                => 'Comment (Optional)',
            'CHROMEPHP_PERFORMTEST_DELETE_MORE'            => 'Delete',
            'CHROMEPHP_PERFORMTEST_NO_TEST'                => 'Kein Test vorhanden',

            'CHROMEPHP_PERFORMTEST_BUTTOM_START'           => ' Start Test ',
            'CHROMEPHP_PERFORMTEST_BUTTOM_STOP'            => ' Der Test läuft ',
            'CHROMEPHP_SYSTEM_INFO'                        => 'System Info Active',

            'CHROMEPHP_DEBUG_TYP'                          =>   'Debug Typ',
            'CHROMEPHP_DEBUG_TYP_COUNT'                    =>   'SQL-Abfragen zählen',

            'CHROMEPHP_DEBUG_TYP_ALL_SQL'                  =>   'Alle SQL-Abfragen sehen',
            'CHROMEPHP_DEBUG_TYP_ALL_CUD'                  =>   'Insert/Update/Delete-Abfragen sehen',
            'CHROMEPHP_DEBUG_TYP_SQL_ERROR'                =>   'SQL-Fehler',

            'CHROMEPHP_DEBUG_FILTER'                       =>   'Options',
            'CHROMEPHP_DEBUG_FILTER_USER_MODEL'            =>   'User Model',
            'CHROMEPHP_DEBUG_FILTER_SEARCH'                =>   'Search',
            'CHROMEPHP_DEBUG_FILTER_SEARCH_TEXT'           =>   'Text:',
            'CHROMEPHP_DEBUG_FILTER_SEARCH_ADD_TEXT'       =>   'Neuer Text',
            'CHROMEPHP_DEBUG_FILTER_BACKTRACE'             =>   'Backtrace / Result',


            'CHROMEPHP_BACKUP'                             =>   'backup - wiederherstellen',
            'CHROMEPHP_CHECK_FUNCTION'                     =>   'Function check:',
            'CHROMEPHP_CHECK_SESSION'                      =>   'Session:',
            'CHROMEPHP_CHECK_SESSION_IDENT'                =>   'Ident:',
            'CHROMEPHP_CHECK_SESSION_ISSET'                =>   'Session gesetzt:',
            'CHROMEPHP_CHECK_PERFORM'                      =>   'Perform Test',
            'CHROMEPHP_CHECK_MYSQL'                        =>   'MySql:',
            'CHROMEPHP_CHECK_MYSQL_TABLE'                  =>   'Tabelle existiert: ',
            'CHROMEPHP_CHECK_MYSQL_IDENT'                  =>   'Mysql Ident',
            'CHROMEPHP_CHECK_MYSQL_COUNT'                  =>   'Anzahl der Einträge',


            'CHROMEPHP_DEBUG_SENDDATA_FILE'                => 'Datei',
            'CHROMEPHP_DEBUG_SENDDATA_HEADER'              => 'Header',
            'CHROMEPHP_DEBUG_SENDDATA_MYSQL'               => 'MySql',
            'CHROMEPHP_DEBUG_SENDDATA'                     =>  'Info übermitteln',


            'CHROMEPHP_FILEMANAGER_FILENAME'               => 'Dateiname: ',
            'CHROMEPHP_FILEMANAGER_FILESIZE'               => 'Dateigröße: ',
            'CHROMEPHP_FILEMANAGER_FILESIZE_KB'            => ' KB',
            'CHROMEPHP_FILEMANAGER_FILESIZE_MB'            => ' MB',
            'CHROMEPHP_FILEMANAGER_FILEDATUM'              => 'Datum',

            'CHROMEPHP_FILEMANAGER_MYSQL_READING'          => 'Verwaltung des MysqlDatei versenden',
            'CHROMEPHP_FILEMANAGER_MYSQL_SLEEP'            => 'Warten',
            'CHROMEPHP_FILEMANAGER_MYSQL_SLEEP_SEK'        => ' sek.',
            'CHROMEPHP_FILEMANAGER_MYSQL_READING_COMPLETE' => 'Mysql-Record nach Absenden löschen:',
            'CHROMEPHP_FILEMANAGER_MYSQL_CLEAR'            => 'MySQL-Tabelle löschen',
            'CHROMEPHP_FILEMANAGER_MYSQL_CLEAR_BUTTON'     => ' löschen ',
            'CHROMEPHP_FILEMANAGER_MYSQL_COUND'            => 'MySQL-Record',
            'CHROMEPHP_FILEMANAGER_MYSQL_LIMIT'            => 'Limit',





            //Tabs
            'CHROMEPHP_ACTIVE'                             =>   'Active',
            'CHROMEPHP_ACTIVE_HELP'                        =>   'Prod....',

            'CHROMEPHP_AUTHORIZATION_MAIN'                 =>   'Autorisation',
            'CHROMEPHP_AUTHORIZATION_NONE'                 =>   'None',
            'CHROMEPHP_AUTHORIZATION_PRODUCTIVE'           =>   'Zeit:',
            'CHROMEPHP_AUTHORIZATION_PRODUCTIVE_MIN'       =>   ' Min.',
            'CHROMEPHP_AUTHORIZATION_IP'                   =>   'IP Adresse:',
            'CHROMEPHP_AUTHORIZATION_SUFIX'                =>   'Suffix:',
            'CHROMEPHP_SHOP'                               =>   'Nach Shop(s)Id:',
            'CHROMEPHP_SHOP_HELP'                          =>   'FirePHP kann man in jeder Subshops deaktivieren oder aktivieren',
            'CHROMEPHP_YES'                                =>   'Ja',
            'CHROMEPHP_NO'                                 =>   'Nein',
            'CHROMEPHP_SAVE'                               =>   'Save',

            'CHROME_EXCEPTION_PERFORMTEST_START'           => 'PerformTest Fail! Mysql_driver.inc kann nicht getaucht sein',
            'CHROME_EXCEPTION_CREATE_SQL'                  => 'Fehler! Bitte SQL-Query manuell ausführen',



            //HELP!!!
            'CHROMEPHP_HELP_AUTHORIZATION'                 =>   'IP: Deine IP (wird automatisch gefullt)<br>
                                                                 Suffix: z.B.debug (eshop.de/index.php?debug)',
            'CHROMEPHP_HELP_USER_MODEL'                     => 'Du kannst selber definieren durch Funktion: <br>startDebug() und stopDebug() ,<br>wann Sql-Abfrage (Debug Typ) sehen solltest'   ,
            'CHROMEPHP_HELP_BACKTRACE'                     => 'Gibt zusätzlich zu jeder Ausgabe noch den Backtrace und das Ergebnis der Abfragen zurück. Kann nicht in Kombination mit "SQL-Abfragen zählen" verwendet werden.'   ,
            'CHROMEPHP_HELP_SEARCH'                     => 'Du kannst selber definieren, welche SQL-Abfragen angezeigt werden sollen.
Wenn du z.B. alle SQL-Abfragen von der Tabelle "oxarticles" sehen möchtest,
gibst du in das Textfeld "oxarticle" ein ( das Script zeigt uns alle SQL-Abfragen mit dem Wort "oxarticle" )
Zusätzliche Suchwörter können über den Button „Neuer Text“ hinzugefügt werden. Diese sind „Oder“ verknüpft.

',
            'CHROMEPHP_HELP_SYSTEM_INFO'                     => 'Schreibt bei jedem Seitenaufruf zuerst folgende Variablen in die Javascript Console:
$_SERVER, $_SESSION, $_POST, $_GET (sofern vorhanden)
'   ,

            'CHROMEPHP_HELP_startDebug'                  => 'Wenn die Funktion gesetzt ist , wird Debug eingezeigt',
            'CHROMEPHP_HELP_stopDebug'                  => 'Debug wird beendet',
            'CHROMEPHP_HELP_backtrace'                  => 'Die Methode gibt Komplete Backtrace (da wo eingesetzt wird) in JS-Konsole',


            'CHROMEPHP_HELP_chromephp'                  => "",

);

/*
[{ oxmultilang ident="NXS_WEBMILES"               =>   '',
*/
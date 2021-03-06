{* $Id: MediaAttach_admin_def_view.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Definition management *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="easymoblog.gif" set="icons/large" __alt="Upload definitions" }</div>

    {if $modules eq 0}
    <p class="z-center z-warningmsg">
        {gt text="MediaAttach could not find a module, for which it has been activated. Please go to the module settings and activate MediaAttach for one or more modules of your choice."}
    </p>
    {else}
    <h2>{gt text="Upload definitions"}</h2>

    {foreach item="currentdef" from=$definitions}
    <fieldset>
        <legend>{zmodgetinfo modname=$currentdef.modname info="displayname"} ({$currentdef.modname})</legend>

        {assign var="currentmod" value=$currentdef.modname}
        {if $currentdef.state eq 0}
        <p><a id="new_definition{$currentmod}_switch" href="javascript:void(0);" style="display: none">{gt text="Create a new definition"}</a></p>
        <div id="new_definition{$currentmod}">
            <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="createdefinition"}" method="post" enctype="application/x-www-form-urlencoded">
                <div>
                    <input type="hidden" name="authid" value="{$authid}" />
                    <fieldset>
                        <legend>{gt text="Add definition"}</legend>

                        <div class="z-formrow">
                            <label for="MediaAttach_modname">{gt text="Module"}</label>
                            <span>{$currentmod}</span>
                            <input type="hidden" id="MediaAttach_modname" name="modname" value="{$currentmod}" />
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_groups{$currentmod}">{gt text="Groups"}</label>
                            <select id="MediaAttach_groups{$currentmod}" name="groups[]" size="5" multiple="multiple">
                                {foreach item="currentgroup" from=$groups}
                                <option value="{$currentgroup.gid}" selected="selected">{$currentgroup.groupname}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_displayfiles">{gt text="Show uploaded files in the user section"}</label>
                            <select id="MediaAttach_displayfiles" name="displayfiles" size="1">
                                <option value="0">{gt text="None"}</option>
                                <option value="1">{gt text="Only own"}</option>
                                <option value="2">{gt text="All"}</option>
                            </select>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_sendmails{$currentmod}">{gt text="Send a mail after uploading"}</label>
                            <input type="checkbox" id="MediaAttach_sendmails{$currentmod}" name="sendmails" value="1" onclick="maCheckMailDiv('{$currentmod}')" onkeyup="maCheckMailDiv('{$currentmod}')" />
                        </div>
                        <div id="divmail{$currentmod}">
                            <div class="z-formrow">
                                <label for="MediaAttach_recipient">{gt text="Recipient of the mail"}</label>
                                <input type="text" id="MediaAttach_recipient" name="recipient" maxlength="100" />
                            </div>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_maxsize">{gt text="Maximum file size during upload"}</label>
                            <span><input type="text" id="MediaAttach_maxsize" name="maxsize" maxlength="20" value="2000" />&nbsp;{gt text="KB"}</span>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_downloadmode">{gt text="Download mode"}</label>
                            <select id="MediaAttach_downloadmode" name="downloadmode" size="1">
                                <option value="0" selected="selected">{gt text="Physical"}</option>
                                <option value="1">{gt text="Inline"}</option>
                            </select>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_naming{$currentmod}">{gt text="Naming convention"}</label>
                            <select id="MediaAttach_naming{$currentmod}" name="naming" size="1" onchange="maCheckNamingDiv('{$currentmod}')" onblur="maCheckNamingDiv('{$currentmod}')" onkeyup="maCheckNamingDiv('{$currentmod}')">
                                <option value="0" selected="selected">{gt text="Original filename"}</option>
                                <option value="1">{gt text="Random filename"}</option>
                                <option value="2">{gt text="Numbered with prefix"}</option>
                            </select>
                            <div id="divnamingprefix{$currentmod}">
                                <div class="z-formrow">
                                    <label for="MediaAttach_namingprefix">{gt text="Prefix"}</label>
                                    <input type="text" id="MediaAttach_namingprefix" name="namingprefix" maxlength="40" />
                                </div>
                            </div>
                        </div>
                        <div class="z-formrow">
                            <label for="MediaAttach_numfiles">{gt text="Number of files"}</label>
                            <select id="MediaAttach_numfiles" name="numfiles" size="1">
                                <option value="1" selected="selected">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="z-formbuttons">
                            <input name="submit" type="submit" value="{gt text="Add definition"}"/>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

        <script type="text/javascript">
            /* <![CDATA[ */
            initNewDefinition('{$currentmod}');

            function maSwitchNewDef{$currentmod}(event) {{
                maSwitchDisplayState('new_definition{$currentmod}');
                Event.stop(event);
            }}
            $('new_definition{$currentmod}_switch').observe('click', maSwitchNewDef{$currentmod});
            $('new_definition{$currentmod}_switch').observe('keypress', maSwitchNewDef{$currentmod});
            /* ]]> */
        </script>

        {else}
        <p>
            <a id="show_definition{$currentmod}_switch" href="javascript:void(0);" style="display: none">
                <span id="showlink{$currentmod}one">{gt text="Show definition"}</span>
                <span id="showlink{$currentmod}two" style="display: none">{gt text="Hide definition"}</span>
            </a>
        </p>
        <div id="show_definition{$currentmod}" class="z-form">
            <h3 class="z-formnote">{gt text="Definition for"} {$currentmod}</h3>
            <div class="z-formrow">
                <span class="z-label">{gt text="Module"}</span>
                <span>{$currentmod}</span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Groups"}</span>
                <span>
                    {foreach name="grouploop" item="currentgroup" from=$currentdef.groups}{$currentgroup.groupname}{if $smarty.foreach.grouploop.last ne true}, {/if}{/foreach}
                </span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Show uploaded files in the user section"}</span>
                <span>
                    {if $currentdef.displayfiles eq 0}{gt text="None"}
                    {elseif $currentdef.displayfiles eq 1}{gt text="Only own"}
                    {elseif $currentdef.displayfiles eq 2}{gt text="All"}
                    {/if}
                </span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Send a mail after uploading"}</span>
                <span>
                    {if $currentdef.sendmails eq 1}{gt text="Yes"}
                    {else}{gt text="No"}
                    {/if}
                </span>
            </div>
            {if $currentdef.sendmails eq 1}
            <div class="z-formrow">
                <span class="z-label">{gt text="Recipient of the mail"}</span>
                <span>{$currentdef.recipient}</span>
            </div>
            {/if}
            <div class="z-formrow">
                <span class="z-label">{gt text="Maximum file size during upload"}</span>
                <span>{math equation="x/1024" x=$currentdef.maxsize format="%.1f"}&nbsp;{gt text="KB"}</span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Download mode"}</span>
                <span>
                    {if $currentdef.downloadmode eq 1}{gt text="Inline"}
                    {else}{gt text="Physical"}
                    {/if}
                </span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Naming convention"}</span>
                <span>
                    {if $currentdef.naming eq 0}{gt text="Original filename"}
                    {elseif $currentdef.naming eq 1}{gt text="Random filename"}
                    {elseif $currentdef.naming eq 2}{gt text="Numbered with prefix"} <em>{$currentdef.namingprefix}</em>
                    {/if}
                </span>
            </div>
            <div class="z-formrow">
                <span class="z-label">{gt text="Number of files"}</span>
                <span>{$currentdef.numfiles}</span>
            </div>
            <p class="z-formnote"><a href="{zmodurl modname="MediaAttach" type="admin" func="editdefinition" did=$currentdef.did}">{gt text="Edit this definition"}</a></p>
        </div>

        <script type="text/javascript">
            /* <![CDATA[ */
            initShowDefinition('{$currentmod}');

            function maSwitchShowDef{$currentmod}(event) {{
                maCheckDefLink('{$currentmod}');
                Event.stop(event);
            }}
            $('show_definition{$currentmod}_switch').observe('click', maSwitchShowDef{$currentmod});
            $('show_definition{$currentmod}_switch').observe('keypress', maSwitchShowDef{$currentmod});
            /* ]]> */
        </script>
        {/if}
    </fieldset>
    {/foreach}
    {/if}

</div>
{include file="MediaAttach_admin_footer.tpl"}

{* $Id: MediaAttach_import_mod.tpl $ *}
{* Purpose of this template: Import from other modules *}
{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="edit.gif" set="icons/large"}</div>
    <h2>{gt text="Import files from another module"}</h2>

    <p class="z-informationmsg">
        {gt text="MediaAttach has found the following modules from which files can be imported."} {gt text="The upload filesize limits are not being used here."}
        {gt text="Existing hierarchies are converted in the form of Categories."}
    </p>

    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="importmodprocess"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{$authid}" />
            <fieldset>
                {foreach item="importMod" from=$importModules}
                <div class="z-formnote">
                    <input type="radio" name="importmod" value="{$importMod}" /> <label>{$importMod}</label>
                </div>
                {/foreach}
            </fieldset>
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text="Start import"}" />
            </div>
        </div>
    </form>
</div>
{* $Id: MediaAttach_admin_quotas.tpl 155 2006-09-11 20:11:19Z weckamc $ *}
{* Purpose of this template: Quota management *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg modname="core" src="encrypted.gif" set="icons/large" __alt="Quotas"}</div>
    <h2>{gt text="Quotas"}</h2>

    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="updategroupquotas"}" method="post" enctype="application/x-www-form-urlencoded">
        <fieldset>
            <legend>{gt text="Groups"}</legend>
            <input type="hidden" name="authid" value="{$authid}" />
            {counter start=0 skip=1 assign="currentgroupnum"}
            {foreach item="currentquota" from=$groupquotas}
            {counter assign="currentgroupnum"}
            <div class="z-formrow">
                <label for="MediaAttach_amountg{$currentgroupnum}">{$currentquota.name}</label>
                <span>
                    <input type="hidden" name="gid{$currentgroupnum}" maxlength="10" value="{$currentquota.gid}" />
                    <input type="text" id="MediaAttach_amountg{$currentgroupnum}" name="amountg{$currentgroupnum}" value="{$currentquota.amount}" style="text-align: right" />&nbsp;{gt text="MB"}<br />
                </span>
            </div>
            {/foreach}
            <input type="hidden" name="numgroups" value="{$currentgroupnum}" />
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text="Change quotas"}" />
            </div>
        </fieldset>
    </form>
    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="updateuserquotas"}" method="post" enctype="application/x-www-form-urlencoded">
        <fieldset>
            <legend>{gt text="Users"}</legend>
            <input type="hidden" name="authid" value="{$authid}" />
            {if $userquotas eq 0}
            <p class="z-formnote">{gt text="No user quotas defined"}</p>
            {else}
            {counter start=0 skip=1 assign="currentgroupnum"}
            {foreach item="currentquota" from=$userquotas}
            {counter assign="currentusernum"}
            <div class="z-formrow">
                <label for="MediaAttach_amountu{$currentusernum}">{$currentquota.name}</label>
                <div>
                    <input type="hidden" name="uid{$currentusernum}" maxlength="10" value="{$currentquota.uid}" />
                    <input type="text" id="MediaAttach_amountu{$currentusernum}" name="amountu{$currentusernum}" value="{$currentquota.amount}" style="text-align: right" />&nbsp;{gt text="MB"}
                    <a href="{zmodurl modname="MediaAttach" type="admin" func="deleteuserquota" uid=$currentquota.uid}" title="{gt text="Delete"}">{zimg src="edit_remove.gif" modname="core" set="icons/extrasmall" __alt="Delete" }</a><br />
                </div>
            </div>
            {/foreach}
            <input type="hidden" name="numusers" value="{$currentusernum}" />
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text="Change quotas"}" />
            </div>
            {/if}
        </fieldset>
    </form>
    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="createuserquota"}" method="post" enctype="application/x-www-form-urlencoded">
        <fieldset>
            <legend>{gt text="New user quota"}</legend>
            <input type="hidden" name="authid" value="{$authid}" />
            <div class="z-formrow">
                <label for="newuname">{gt text="Name"}</label>
                <div>
                    <input type="text" name="uname" id="newuname" value="" />
                    {zimg id="ajax_indicator" style="display: none" modname="core" set="icons/extrasmall" src="indicator_circle.gif" __alt=""}
                </div>
            </div>
            <div id="username_choices" class="autocomplete_user"></div>
            <script type="text/javascript">
                // <![CDATA[
                new Ajax.Autocompleter('newuname', 'username_choices', document.location.pnbaseURL + 'ajax.php?module=Users&func=getusers', {{paramName: 'fragment', minChars: 2}});
                // ]]>
            </script>
            <div class="z-formrow">
                <label for="MediaAttach_amount">{gt text="Quota"}</label>
                <span>
                    <input type="text" id="MediaAttach_amount" name="amount" maxlength="10" value="0" style="text-align: right" />&nbsp;{gt text="MB"}<br /><br />
                </span>
            </div>
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text="Create Quota"}" />
            </div>
        </fieldset>
    </form>

</div>
{include file="MediaAttach_admin_footer.tpl"}
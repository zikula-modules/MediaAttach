{* $Id: MediaAttach_admin_modifyconfig.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Configuration *}

{include file="MediaAttach_admin_header.tpl"}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{zimg src="package_settings.gif" modname="core" set="icons/large" __alt="Configuration" }</div>

    <h2>{gt text="Settings"}</h2>

    {zform id="MediaAttach_config" cssClass="z-form" enctype="application/x-www-form-urlencoded"}
    {zformsetinitialfocus inputId="uploaddir"}
    {zformvalidationsummary}

    <fieldset>
        <legend>{gt text="General Settings"}</legend>
        <div class="z-formrow">
            <label>{gt text="MediaAttach installation directory"}</label>
            {$mediaattachdir}
        </div>
        <div class="z-formrow">
            <label>{gt text="HTML root"}</label>
            {$docroot}
        </div>
        <div class="z-formrow">
            {zformlabel for="uploaddir" __text="Upload folder (absolute, ideally outside the HTML root)"}
            {zformtextinput id="uploaddir" size="40" maxLength="200" text=$pncore.MediaAttach.uploaddir}
            {if !$updirexists}<em class="z-formnote dirnotokay">{gt text="This directory does not exist"}</em>
            {elseif !$updirisdir}<em class="z-formnote dirnotokay">{gt text="This is not a directory"}</em>
            {elseif !$updiriswritable}<em class="z-formnote dirnotokay">{gt text="This directory is not writable for the web server"}</em>
            {else}<em class="z-formnote dirokay">{gt text="Everything allright"}</em>
            {/if}
        </div>
        <div class="z-formrow">
            {zformlabel for="cachedir" __text="Cache folder (absolute, inside HTML root)"}
            {zformtextinput id="cachedir" size="40" maxLength="200" text=$pncore.MediaAttach.cachedir}
            {if !$cachedirexists}<em class="z-formnote dirnotokay">{gt text="This directory does not exist"}</em>
            {elseif !$cachedirisdir}<em class="z-formnote dirnotokay">{gt text="This is not a directory"}</em>
            {elseif !$cachediriswritable}<em class="z-formnote dirnotokay">{gt text="This directory is not writable for the web server"}</em>
            {else}<em class="z-formnote dirokay">{gt text="Everything allright"}</em>
            {/if}
        </div>
        {if $mailer}
        <div class="z-formrow">
            {zformlabel for="mailfiles" __text="Allow users sending files in mails to theirselves"}
            {zformcheckbox id="mailfiles" checked=$pncore.MediaAttach.mailfiles}
        </div>
        <div id="ma_mailer">
            <div class="z-formrow">
                {zformlabel for="maxmailsize" text="Maximum filesize for mails"}
                <span>{zformintinput id="maxmailsize" size="10" maxLength="10" text=$maxmailsize} {gt text="KB"}</span>
            </div>
        </div>
        {/if}
        <div class="z-formrow">
            {zformlabel for="usequota" __text="Activate quotas"}
            {zformcheckbox id="usequota" checked=$pncore.MediaAttach.usequota}
        </div>
        <div class="z-formrow">
            {zformlabel for="ownhandling" __text="Users are able to edit and delete their own files"}
            {zformcheckbox id="ownhandling" checked=$pncore.MediaAttach.ownhandling}
        </div>
        <div class="z-formrow">
            {zformlabel for="usefrontpage" __text="Activate frontpage in user section"}
            {zformcheckbox id="usefrontpage" checked=$pncore.MediaAttach.usefrontpage}
        </div>
        <div class="z-formrow">
            {zformlabel for="useaccountpage" __text="Activate account page in user section"}
            {zformcheckbox id="useaccountpage" checked=$pncore.MediaAttach.useaccountpage}
        </div>
    </fieldset>

    <fieldset>
        <legend>{gt text="Image settings"}</legend>

        <div class="z-formrow">
            {zformlabel for="thumb1width" __text="Default sizes of thumbnails (you can create as many formats as desired):"}

            {zformvolatile}
            {foreach name="thumbLoop" item="thumbsize" from=$thumbsizes}
            <div class="z-formlist">
                {zformintinput id="thumb`$smarty.foreach.thumbLoop.iteration`width" size="6" maxLength="4" text=$thumbsize[0]} x
                {zformintinput id="thumb`$smarty.foreach.thumbLoop.iteration`height" size="6" maxLength="4" text=$thumbsize[1]} {gt text="pixels"}
                {zformradiobutton id="defaultthumb`$smarty.foreach.thumbLoop.iteration`" value=$smarty.foreach.thumbLoop.iteration dataField='defaultthumb' mandatory='1'}
            </div>
            {/foreach}
            <div class="z-formlist">
                {zformintinput id="thumb`$smarty.foreach.thumbLoop.iteration+1`width" size="6" maxLength="4" text=""} x
                {zformintinput id="thumb`$smarty.foreach.thumbLoop.iteration+1`height" size="6" maxLength="4" text=""} {gt text="pixels"}
            </div>
            {/pnformvolatile}
        </div>

        <div class="z-formrow">
            {zformlabel for="shrinkimages" __text="Shrink big images"}
            {zformcheckbox id="shrinkimages" checked=$pncore.MediaAttach.shrinkimages}
        </div>

        <div id="ma_shrinksize">
            <div class="z-formrow">
                {zformlabel for="shrinkwidth" __text="Maximum image size:"}
                <span>
                    {zformintinput id="shrinkwidth" size="8" maxLength="4" text=$pncore.MediaAttach.shrinkwidth} x
                    {zformintinput id="shrinkheight" size="8" maxLength="4" text=$pncore.MediaAttach.shrinkheight} {gt text="pixels"}
                </span>
            </div>
        </div>

        <div class="z-formrow">
            {zformlabel for="usethumbcropper" __text="Allow cropping of thumbnails"}
            {zformcheckbox id="usethumbcropper" checked=$pncore.MediaAttach.usethumbcropper}
        </div>

        <div id="ma_cropsizemode">
            <div class="z-formrow">
                {zformlabel for="cropsizemode" __text="Behaviour of the selection tool"}
                {zformdropdownlist id="cropsizemode"}
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>{gt text="Categorization settings"}</legend>
        <div class="z-formrow">
            {zformlabel for="catmodecategories" __text="MediaAttach categories (Categories module)"}
            {zformcheckbox id="catmodecategories" checked=$cat_use_categories}
        </div>
        <div class="z-formrow">
            {zformlabel for="catmodemodules" __text="Modules"}
            {zformcheckbox id="catmodemodules" checked=$cat_use_modules}
        </div>
        <div class="z-formrow">
            {zformlabel for="catmodeusers" __text="Users"}
            {zformcheckbox id="catmodeusers" checked=$cat_use_users}
        </div>
        <div class="z-formrow">
            {zformlabel for="catdefaultmode" __text="Default mode"}
            {zformdropdownlist id="catdefaultmode"}
        </div>
    </fieldset>

    <div class="z-formbuttons">
        {zmodcallhooks hookobject="module" hookaction="modifyconfig" hookid="MediaAttach" module="MediaAttach"}
        {zformbutton id="submit" commandName="submit" text="Settings"}
    </div>

    {/pnform}

    <script type="text/javascript">
        /* <![CDATA[ */
        {if $pncore.MediaAttach.mailfiles eq 0}
        $('ma_mailer').hide();
        {/if}
        $('mailfiles').observe('click', maCheckMailerEntry);
        $('mailfiles').observe('keyup', maCheckMailerEntry);

        {if $pncore.MediaAttach.shrinkimages eq 0}
        $('ma_shrinksize').hide();
        {/if}
        $('shrinkimages').observe('click', maCheckShrinkEntry);
        $('shrinkimages').observe('keyup', maCheckShrinkEntry);

        {if $pncore.MediaAttach.usethumbcropper eq 0}
        $('ma_cropsizemode').hide();
        {/if}
        $('usethumbcropper').observe('click', maCheckCropSizeEntry);
        $('usethumbcropper').observe('keyup', maCheckCropSizeEntry);

        $('catmodecategories').observe('change', maCheckCatMode1);
        $('catmodecategories').observe('keyup', maCheckCatMode1);
        $('catmodemodules').observe('change', maCheckCatMode2);
        $('catmodemodules').observe('keyup', maCheckCatMode2);
        $('catmodeusers').observe('change', maCheckCatMode3);
        $('catmodeusers').observe('keyup', maCheckCatMode3);
        $('catdefaultmode').observe('change', maCheckCatModes);
        $('catdefaultmode').observe('keyup', maCheckCatModes);
        /* ]]> */
    </script>

    {if $updirexists}
    {if $updirisdir}
    {if $updiriswritable && $htaccessexists == 0}
    <form class="z-form" action="{zmodurl modname="MediaAttach" type="admin" func="generatehtaccess"}" method="post" enctype="application/x-www-form-urlencoded" id="MediaAttach_htaccess">
        <fieldset>
            <legend>{gt text="Generate .htaccess"}</legend>
            <p class="z-formnote z-warningmsg">{gt text="MediaAttach can automatically write a .htaccess file into your upload directory to avoid direct access to uploaded files. Notice that not all webservers support .htaccess files."}</p>
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text="Generate"}" />
            </div>
        </fieldset>
    </form>
    {/if}
    {/if}
    {/if}

    <table class="z-datatable">
        <thead>
            <tr>
                <th colspan="2">{gt text="Important settings in php.ini, which are relevant for uploads"}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="z-odd">
                <td>open_basedir</td>
                <td>{$open_basedir|default:"&nbsp;"}</td>
            </tr>
            <tr class="z-even">
                <td>upload_tmp_dir</td>
                <td>{$upload_tmp_dir|default:"&nbsp;"}</td>
            </tr>
            <tr class="z-odd">
                <td>file_uploads</td>
                <td>{$file_uploads|default:"&nbsp;"}</td>
            </tr>
            <tr class="z-even">
                <td>upload_max_filesize</td>
                <td>{$upload_max_filesize|default:"&nbsp;"}</td>
            </tr>
            <tr class="z-odd">
                <td>post_max_size</td>
                <td>{$post_max_size|default:"&nbsp;"}</td>
            </tr>
            <tr class="z-even">
                <td>max_input_time</td>
                <td>{$max_input_time|default:"&nbsp;"}</td>
            </tr>
        </tbody>
    </table>

    <p class="z-informationmsg">
        {gt text="Version check"} |
        {gt text="Your version"}: {$yourversion} |
        {if $yourversion < $newestversion}
        {gt text="There is a new Version available"}: {$newestversion} |
        <a href="http://code.zikula.org/mediaattach/downloads" title="{gt text="Download the newest version of MediaAttach"}">{gt text="Download now"}</a> |
        {else}
        {gt text="Your version is the newest."}
        {/if}
    </p>

</div>
{include file="MediaAttach_admin_footer.tpl"}
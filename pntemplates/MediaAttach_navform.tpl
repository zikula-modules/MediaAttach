{* $Id: $ *}
{* Purpose of this template: navigation form *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}
{zconfiggetvar name="entrypoint" assign="ourEntry"}

<form action="{$ourEntry|default:"index.php"}" id="maNavForm" class="z-form" method="get">
    <div>
        <input type="hidden" name="module" value="{zmodgetinfo module="MediaAttach" info="displayname"}" />
        <input type="hidden" name="type" value="{$hiddenType}" />
        <input type="hidden" name="func" value="{$hiddenFunc}" />
        <fieldset>

            {if $categorization == true}
            {if $cat_use_categories || $cat_use_modules || $cat_use_users}
            <label for="MediaAttach_catmode">{gt text="Display mode:"}</label>
            <select id="MediaAttach_catmode" name="catmode">
                <option value="0"{if $catmode eq 0} selected="selected"{/if}>{gt text="No categorization"}</option>
                {if $cat_use_categories}
                <option value="1"{if $catmode eq 1} selected="selected"{/if}>{gt text="Categories"}</option>
                {/if}
                {if $cat_use_modules}
                <option value="2"{if $catmode eq 2} selected="selected"{/if}>{gt text="Modules"}</option>
                {/if}
                {if $cat_use_users}
                <option value="4"{if $catmode eq 4} selected="selected"{/if}>{gt text="Users"}</option>
                {/if}
            </select>
            {/if}
            <input type="hidden" name="cat_id" value="{$cat_id|default:0}" />
            {/if}

            {if $sorting == true}
            <label for="MediaAttach_sortby">{gt text="Sort by"}</label>
            &nbsp;
            <select id="MediaAttach_sortby" name="sortby">
                <option value="date"{if $sortby eq "date"} selected="selected"{/if}>{gt text="date"}</option>
                <option value="title"{if $sortby eq "title"} selected="selected"{/if}>{gt text="title"}</option>
                <option value="module"{if $sortby eq "module"} selected="selected"{/if}>{gt text="module"}</option>
                <option value="username"{if $sortby eq "username"} selected="selected"{/if}>{gt text="username"}</option>
                <option value="filename"{if $sortby eq "filename"} selected="selected"{/if}>{gt text="filename"}</option>
                <option value="filetype"{if $sortby eq "filetype"} selected="selected"{/if}>{gt text="filetype"}</option>
                <option value="filesize"{if $sortby eq "filesize"} selected="selected"{/if}>{gt text="filesize"}</option>
            </select>
            <select id="MediaAttach_sortdir" name="sortdir">
                <option value="asc"{if $sortdir eq "asc"} selected="selected"{/if}>{gt text="ascending"}</option>
                <option value="desc"{if $sortdir eq "desc"} selected="selected"{/if}>{gt text="descending"}</option>
            </select>
            {/if}

            {if $categorization == true}
            <br />
            {/if}

            {if $perpage == true}
            <label for="MediaAttach_perpage">{gt text="Entries per page"}</label>
            &nbsp;
            <select id="MediaAttach_perpage" name="itemsperpage" style="width: 50px; text-align: right">
                <option value="5"{if $itemsperpage eq 5} selected="selected"{/if}>5</option>
                <option value="10"{if $itemsperpage eq 10} selected="selected"{/if}>10</option>
                <option value="15"{if $itemsperpage eq 15} selected="selected"{/if}>15</option>
                <option value="20"{if $itemsperpage eq 20} selected="selected"{/if}>20</option>
                <option value="30"{if $itemsperpage eq 30} selected="selected"{/if}>30</option>
                <option value="50"{if $itemsperpage eq 50} selected="selected"{/if}>50</option>
                <option value="100"{if $itemsperpage eq 100} selected="selected"{/if}>100</option>
            </select>
            {/if}

            {if $displayswitch == true}
            <input type="checkbox" id="MediaAttach_preview" name="preview" value="1"{if $preview} checked="checked"{/if} style="margin-left: 35px" />
            <label for="MediaAttach_preview" class="maleft">{gt text="Preview"}</label>

            <input type="checkbox" id="MediaAttach_onlyimages" name="onlyimages" value="1"{if $onlyimages} checked="checked"{/if} style="margin-left: 35px" />
            <label for="MediaAttach_onlyimages" class="maleft">{gt text="Only images"}</label>
            {/if}
            {if $preview && $onlyimages}
            <select id="MediaAttach_thumbnr" name="thumbnr" style="width: 100px">
                {zmodgetvar module="MediaAttach" name="thumbsizes" assign="thumbsizes"}
                {foreach name="thumbLoop" item="thumbsize" from=$thumbsizes}
                <option value="{$smarty.foreach.thumbLoop.iteration}"{if $smarty.foreach.thumbLoop.iteration eq $thumbnr} selected="selected"{/if}>{$thumbsize[0]} x {$thumbsize[1]} px&nbsp;</option>
                {/foreach}
            </select>
            {/if}

            <input type="submit" name="changenow" id="MediaAttach_submit" value="{gt text="OK"}" />
        </fieldset>
    </div>
</form>

<script type="text/javascript">
    /* <![CDATA[ */
    {if $categorization == true}
    {if $cat_use_categories || $cat_use_modules || $cat_use_users}
    $('MediaAttach_catmode').observe('change', maSubmitNaviForm);
    {/if}
    {/if}
    {if $sorting == true}
    $('MediaAttach_sortby').observe('change', maSubmitNaviForm);
    $('MediaAttach_sortdir').observe('change', maSubmitNaviForm);
    {/if}
    {if $perpage == true}
    $('MediaAttach_perpage').observe('change', maSubmitNaviForm);
    {/if}
    {if $displayswitch == true}
    $('MediaAttach_preview').observe('click', maSubmitNaviForm);
    $('MediaAttach_preview').observe('keypress', maSubmitNaviForm);
    $('MediaAttach_onlyimages').observe('click', maSubmitNaviForm);
    $('MediaAttach_onlyimages').observe('keypress', maSubmitNaviForm);
    {/if}
    {if $preview && $onlyimages}
    $('MediaAttach_thumbnr').observe('change', maSubmitNaviForm);
    {/if}

    $('MediaAttach_submit').hide();
    /* ]]> */
</script>

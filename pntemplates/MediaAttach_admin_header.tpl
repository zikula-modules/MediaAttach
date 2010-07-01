{* $Id: MediaAttach_admin_header.tpl 220 2007-08-11 15:23:48Z weckamc $ *}
{* Purpose of this template: Admin header *}

{zajaxheader modname="MediaAttach" filename=MediaAttach.js}
{zpageaddvar name="javascript" value="javascript/ajax/validation.js"}

{admincategorymenu xhtml=1}

<div class="z-adminbox">
    <h1>{zmodgetinfo modname="MediaAttach" info="displayname"} ({zmodgetinfo modname="MediaAttach" info="version"})</h1>
    <div class="z-menu">{moduleadminlinks modname="MediaAttach"}</div>
</div>
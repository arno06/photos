{if !$request_async}{include file="includes/head.tpl"}{/if}
<div id="wall" data-images='{$content.images_json}' data-concurrent-loading="5"></div>
{if !$request_async}{include file="includes/footer.tpl"}{/if}
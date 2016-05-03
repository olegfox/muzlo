<!doctype html>
<html lang="ru">
<head>  
    <title>{$meta_title} :: {$SETTINGS.site_name}</title> 
    {if ! empty ($obj.products.items.text)}<meta property="og:description" content="{$obj.products.items.text}" />{/if}
    {*if $IS_ADMIN == 1*}
    <link rel="stylesheet" type="text/css" href="{$THEME}/css/nf_pp.css" />
    {*/if*}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="{$THEME}/images/favicon.ico">
    <link rel="stylesheet" href="{$THEME}/css/vendor.937833d2.css">
    <link rel="stylesheet" href="{$THEME}/css/main.d8dc03e2.css">
    {*if $IS_ADMIN == 1*}<script src="{$THEME}/js/nf_pp.js"></script>{*/if*}
</head>
 
<body ng-app="muzloTemplateApp">
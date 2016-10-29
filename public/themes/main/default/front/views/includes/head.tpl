<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset={$configuration.global_encoding}" >
        <base href="{$configuration.server_url}"/>
		<title>{$head.title}</title>
        {if !null == $content.canonical && !empty($content.canonical)}
            <link rel="canonical" href="{$content.canonical}">
        {/if}
		<meta name="description" content="{$head.description}"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='https://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
		<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
		<link type="text/css" rel="stylesheet" href="{$path_to_theme}/css/style.css">
{foreach from=$styles item=style}
		<link type="text/css" rel="stylesheet" href="{$style}">
{/foreach}
{foreach from="$scripts" item=script}
        <script type="text/javascript" src="{$script}"></script>
{/foreach}
	</head>
	<body>
	{if $user_is.USER}
	<div class="mdl-layout mdl-js-layout">
		<header class="mdl-layout__header mdl-layout__header--scroll">
			<div class="mdl-layout__header-row">
				<!-- Title -->
				<span class="mdl-layout-title">Photos{if $content.secondTitle} - {$content.secondTitle}{/if}</span>
				<!-- Add spacer, to align navigation to the right -->
				<div class="mdl-layout-spacer"></div>
				<!-- Navigation -->
				<nav class="mdl-navigation">
					<a class="mdl-navigation__link" href="bye">Déconnexion</a>
				</nav>
			</div>
		</header>
		<div class="mdl-layout__drawer">
			<span class="mdl-layout-title">Photos{if $content.secondTitle} - {$content.secondTitle}{/if}</span>
			<nav class="mdl-navigation">
				<a class="mdl-navigation__link" href="t/nous">Nous</a>
				<a class="mdl-navigation__link" href="t/arnaud">Arnaud</a>
				<a class="mdl-navigation__link" href="t/sihem">Sihem</a>
				<a class="mdl-navigation__link" href="bye">Déconnexion</a>
			</nav>
		</div>
		<main class="mdl-layout__content">
			<div class="page-content">
	{/if}
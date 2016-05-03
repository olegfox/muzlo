{if $IS_AJAX eq 0}

{include file='_header.tpl'}

	<div class="centralBlock">
		{if $IS_ADMIN == 1}
		<aside>
			<!-- LEFT MENU -->
			{include file='_leftMenu.tpl'}
		</aside>
		{/if}
		<!-- C O N T E N T -->
		<section class="content">			
{/if}
			<!-- SPECIAL OFFERS -->


			<article>				
				{$content}
			</article>

			<script>
			var meta_title = '{$meta_title}';
			</script>

{if $IS_AJAX eq 0}

		</section>	
	</div>	
	{include file='_footer.tpl'}

{/if}
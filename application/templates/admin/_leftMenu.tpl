{if $IS_ADMIN == 1}

				<h1 style="text-align:center;"><a href="/admin/">Админка</a></h1>

				<div class="sidebar">

					<ul class="menu">						

						<li>
							<div>
								<a href="/admin/users/edit/{$LOGIN->id}/"><img src="{$THEME}/img/lg.png" /></a>
								<span><a href="/admin/users/edit/{$LOGIN->id}/">{$LOGIN->first_name} {$LOGIN->last_name}</a></span>
								<p><a class="ext" href="/admin/logout/"><i class="icon-off"></i> Выход</a></p>
							</div>
						</li>

						<li>
							<div>
								<a href="/admin/settings/"><img src="{$THEME}/img/ic1.png"></a>
								<span><a href="/admin/settings/">Настройки сайта</a></span>
								<p>Различные настройки сайта</p>
							</div>
						</li>


						<li>
							<div>
								<a href="/admin/patterns/"><img src="{$THEME}/img/ic1.png"></a>
								<span><a href="/admin/patterns/">Шаблоны</a></span>
								<p>Список шаблонов</p>
							</div>
						</li>

						<li>
							<div>
								<a href="/admin/patterns_dirs/"><img src="{$THEME}/img/ic1.png"></a>
								<span><a href="/admin/patterns_dirs/">Директории шаблонов</a></span>
								<p>Список директорий шаблонов</p>
							</div>
						</li>	

						<li>
							<div>
								<a href="/admin/music_files/"><img src="{$THEME}/img/ic2.png"></a>
								<span><a href="/admin/music_files/">Музыкальные файлы</a></span>
								<p>Список музыкальных файлов</p>
							</div>
						</li>					

						<li>
							<div>
								<a href="/admin/adverts/"><img src="{$THEME}/img/ic1.png"></a>
								<span><a href="/admin/adverts/">Рекламные файлы</a></span>
								<p>Список рекламных файлов</p>
							</div>
						</li>	

						<li>
							<div>
								<a href="/admin/static/"><img src="{$THEME}/img/ic1.png"></a>
								<span><a href="/admin/static/">Страницы сайта</a></span>
								<p><a href="/admin/static/add/"><i class="icon-plus"></i>Добавить страницу</a></p>
							</div>
							<ul>
								{foreach from=$statics.items item=static}
									<li><a href="/admin/static/edit/{$static.id}/">{$static.title}</a></li>
								{/foreach}
							</ul>
						</li>

						<li>
							<div>
								<a href="/admin/users/"><img src="{$THEME}/img/ic3.png"></a>
								<span><a href="/admin/users/">Пользователи</a></span>
								<p><a href="/admin/users/create/"><i class="icon-plus"></i>Добавить пользователя</a></p>
							</div>
						</li>


					</ul>

					
				</div>
				
{/if}